<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Company;
use App\Models\Category;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $query = Job::with(['company', 'category'])->latest();
        
        // RBAC: Companies only see their own jobs
        if (auth()->check() && auth()->user()->role === 'company' && auth()->user()->company) {
            $query->where('company_id', auth()->user()->company->id);
        }

        if (request('status') && request('status') !== 'all') {
            $query->where('status', request('status'));
        }

        $jobs = $query->paginate(15);
        return view('admin.jobs.index', compact('jobs'));
    }

    public function create()
    {
        $companies = Company::where('status', 'approved')->get();
        $categories = Category::all();
        return view('admin.jobs.create', compact('companies', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|unique:jobs',
            'description' => 'required',
            'location' => 'nullable|string',
            'remote' => 'boolean',
            'min_salary' => 'nullable|integer',
            'max_salary' => 'nullable|integer',
            'job_type' => 'required|in:full-time,part-time,contract,internship',
            'skills' => 'nullable|array',
            'duration' => 'nullable|string',
            'experience_level' => 'nullable|string',
            'certificate_included' => 'boolean',
            'company_id' => 'required|exists:companies,id',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $validated['skills'] = json_encode($validated['skills'] ?? []);
        $validated['posted_at'] = now();

        Job::create($validated);

        return redirect()->route('admin.jobs.index')->with('success', 'Job created successfully.');
    }

    public function show(Job $job)
    {
        return view('admin.jobs.show', compact('job'));
    }

    /**
     * Per-job applicant dashboard with skill-match filtering.
     */
    public function applicants(Request $request, Job $job)
    {
        // RBAC: Companies can only view applicants for their own jobs
        if (auth()->check() && auth()->user()->role === 'company' && auth()->user()->company) {
            if ($job->company_id !== auth()->user()->company->id) {
                abort(403, 'Unauthorized access to this job dashboard.');
            }
        }

        $job->load('company');

        // Eager load applications → user → profile in one query
        $applications = $job->applications()
            ->with('user.profile')
            ->latest()
            ->get();

        $jobSkills = is_array($job->skills)
            ? $job->skills
            : (json_decode($job->skills, true) ?? []);

        // Attach computed fields
        $applications = $applications->map(function ($app) use ($jobSkills) {
            $profileSkills = optional(optional($app->user)->profile)->skills ?? [];
            $profileSkills = is_array($profileSkills)
                ? $profileSkills
                : (json_decode($profileSkills, true) ?? []);

            $app->match_pct = \App\Models\JobApplication::computeMatchPercentage($jobSkills, $profileSkills);
            $breakdown = \App\Models\JobApplication::skillBreakdown($jobSkills, $profileSkills);
            $app->matched_skills = $breakdown['matched'];
            $app->missing_skills = $breakdown['missing'];

            return $app;
        });

        // ── Filters (in-PHP, since skills are JSON) ───────────────
        if ($request->filled('status') && $request->status !== 'all') {
            $applications = $applications->filter(
                fn ($a) => $a->status === $request->status
            );
        }

        if ($request->filled('min_match')) {
            $min = (int) $request->min_match;
            $applications = $applications->filter(fn ($a) => $a->match_pct >= $min);
        }

        if ($request->filled('search')) {
            $s = strtolower($request->search);
            $applications = $applications->filter(function ($a) use ($s) {
                return str_contains(strtolower(optional($a->user)->name ?? ''), $s)
                    || str_contains(strtolower(optional($a->user)->email ?? ''), $s);
            });
        }

        // Sort by match % descending
        $applications = $applications->sortByDesc('match_pct')->values();

        $stats = [
            'total'       => $applications->count(),
            'pending'     => $applications->where('status', 'pending')->count(),
            'shortlisted' => $applications->where('status', 'shortlisted')->count(),
            'hired'       => $applications->where('status', 'hired')->count(),
            'rejected'    => $applications->where('status', 'rejected')->count(),
            'avg_match'   => $applications->count()
                ? (int) round($applications->avg('match_pct'))
                : 0,
        ];

        return view('admin.jobs.applicants', compact('job', 'applications', 'jobSkills', 'stats'));
    }

    public function edit(Job $job)
    {
        $companies = Company::where('status', 'approved')->get();
        $categories = Category::all();
        return view('admin.jobs.edit', compact('job', 'companies', 'categories'));
    }

    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|unique:jobs,slug,' . $job->id,
            'description' => 'required',
            'location' => 'nullable|string',
            'remote' => 'boolean',
            'min_salary' => 'nullable|integer',
            'max_salary' => 'nullable|integer',
            'job_type' => 'required|in:full-time,part-time,contract,internship',
            'skills' => 'nullable|array',
            'duration' => 'nullable|string',
            'experience_level' => 'nullable|string',
            'certificate_included' => 'boolean',
            'company_id' => 'required|exists:companies,id',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $validated['skills'] = json_encode($validated['skills'] ?? []);
        $job->update($validated);

        return redirect()->route('admin.jobs.index')->with('success', 'Job updated successfully.');
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('admin.jobs.index')->with('success', 'Job deleted successfully.');
    }

    public function approve(Job $job)
    {
        $job->update(['status' => 'approved']);
        return back()->with('success', 'Job approved.');
    }

    public function reject(Job $job)
    {
        $job->update(['status' => 'rejected']);
        return back()->with('success', 'Job rejected.');
    }
}
