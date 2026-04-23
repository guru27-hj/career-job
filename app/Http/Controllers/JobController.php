<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::with('company');

        // Search by keyword
        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%')
                  ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        // Location filter
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Remote filter
        if ($request->has('remote') && $request->remote == '1') {
            $query->where('remote', true);
        }

        // Salary range (min and max)
        if ($request->filled('salary_min')) {
            $query->where('min_salary', '>=', $request->salary_min);
        }
        if ($request->filled('salary_max')) {
            $query->where('max_salary', '<=', $request->salary_max);
        }

        // Job type filter
        if ($request->filled('job_type')) {
            $query->where('job_type', $request->job_type);
        }

        // Skills filter (multiple skills, OR condition)
        if ($request->filled('skills')) {
            $skills = is_array($request->skills) ? $request->skills : explode(',', $request->skills);
            $query->where(function($q) use ($skills) {
                foreach ($skills as $skill) {
                    $q->orWhere('skills', 'like', '%"' . trim($skill) . '"%');
                }
            });
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'salary_high':
                $query->orderBy('max_salary', 'desc');
                break;
            case 'best_match':
                // For best match, we could use a relevance score, but for now fallback to latest
                $query->orderBy('posted_at', 'desc');
                break;
            default: // latest
                $query->orderBy('posted_at', 'desc');
                break;
        }

        $jobs = $query->paginate(10);

        // Get counts for total jobs
        $totalJobs = $query->count(); // after filters

        // Pass filter values back to view for persisting
        $filters = $request->only(['keyword', 'location', 'remote', 'salary_min', 'salary_max', 'job_type', 'skills', 'sort']);

        return view('jobs.index', compact('jobs', 'totalJobs', 'filters'));
    }

    public function show(Job $job)
    {
        $job->load('company');

        // Build similar jobs: same company OR overlapping skills, exclude current job
        $similarQuery = Job::with('company')
            ->where('id', '!=', $job->id)
            ->where('status', 'approved');

        if ($job->company_id) {
            $similarQuery->where(function ($q) use ($job) {
                $q->where('company_id', $job->company_id);
                if ($job->skills && count($job->skills)) {
                    foreach ($job->skills as $skill) {
                        $q->orWhere('skills', 'like', '%"' . $skill . '"%');
                    }
                }
            });
        } elseif ($job->skills && count($job->skills)) {
            $similarQuery->where(function ($q) use ($job) {
                foreach ($job->skills as $skill) {
                    $q->orWhere('skills', 'like', '%"' . $skill . '"%');
                }
            });
        }

        $similar = $similarQuery->latest('posted_at')->take(4)->get();

        $hasApplied = false;
        if (auth()->check()) {
            $hasApplied = JobApplication::where('job_id', $job->id)
                ->where('user_id', auth()->id())
                ->exists();
        }

        return view('jobs.show', compact('job', 'similar', 'hasApplied'));
    }
}
