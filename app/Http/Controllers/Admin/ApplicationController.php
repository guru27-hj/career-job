<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    // ── Index: list all applications with search + filter ─────────────
    public function index(Request $request)
    {
        $query = JobApplication::with(['user.profile', 'job.company'])->latest();

        // RBAC: Filter by logged-in company's jobs
        if (auth()->check() && auth()->user()->role === 'company' && auth()->user()->company) {
            $query->whereHas('job', function($q) {
                $q->where('company_id', auth()->user()->company->id);
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            if ($request->type === 'internship') {
                $query->forInternships();
            } elseif ($request->type === 'job') {
                $query->forJobs();
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('job', function ($jq) use ($search) {
                    $jq->where('title', 'like', "%{$search}%");
                });
            });
        }

        $applications = $query->paginate(15)->withQueryString();

        // Precompute skill match % for each application
        foreach ($applications as $app) {
            $jobSkills     = $app->job->skills ?? [];
            $profileSkills = optional(optional($app->user)->profile)->skills ?? [];
            $app->match_pct = JobApplication::computeMatchPercentage(
                is_array($jobSkills)     ? $jobSkills     : json_decode($jobSkills, true) ?? [],
                is_array($profileSkills) ? $profileSkills : json_decode($profileSkills, true) ?? []
            );
        }

        // ── Stats ──────────────────────────────────────────────────
        $statsQuery = JobApplication::query();
        if (auth()->check() && auth()->user()->role === 'company' && auth()->user()->company) {
            $statsQuery->whereHas('job', function($q) {
                $q->where('company_id', auth()->user()->company->id);
            });
        }

        $totalApps       = (clone $statsQuery)->count();
        $pendingApps     = (clone $statsQuery)->where('status', 'pending')->count();
        $shortlistedApps = (clone $statsQuery)->where('status', 'shortlisted')->count();
        $hiredApps       = (clone $statsQuery)->where('status', 'hired')->count();
        $rejectedApps    = (clone $statsQuery)->where('status', 'rejected')->count();
        $internshipApps  = (clone $statsQuery)->forInternships()->count();
        $jobApps         = (clone $statsQuery)->forJobs()->count();

        return view('admin.applications.index', compact(
            'applications',
            'totalApps', 'pendingApps', 'shortlistedApps', 'hiredApps', 'rejectedApps',
            'internshipApps', 'jobApps'
        ));
    }

    // ── Show single application ────────────────────────────────────────
    public function show(JobApplication $application)
    {
        // RBAC: Ensure company users can only view their own applications
        if (auth()->check() && auth()->user()->role === 'company' && auth()->user()->company) {
            if ($application->job->company_id !== auth()->user()->company->id) {
                abort(403, 'Unauthorized access to this application.');
            }
        }

        $application->load(['user.profile', 'job.company']);

        $jobSkills     = $application->job->skills ?? [];
        $profileSkills = optional($application->user->profile)->skills ?? [];

        $jobSkills     = is_array($jobSkills)     ? $jobSkills     : json_decode($jobSkills, true) ?? [];
        $profileSkills = is_array($profileSkills) ? $profileSkills : json_decode($profileSkills, true) ?? [];

        $matchPct  = JobApplication::computeMatchPercentage($jobSkills, $profileSkills);
        $breakdown = JobApplication::skillBreakdown($jobSkills, $profileSkills);

        return view('admin.applications.show', compact('application', 'matchPct', 'breakdown'));
    }

    // ── Quick status update (AJAX / form) ─────────────────────────────
    public function updateStatus(Request $request, JobApplication $application)
    {
        $request->validate([
            'status' => 'required|in:pending,shortlisted,hired,rejected',
        ]);

        $application->update(['status' => $request->status]);

        $this->notifyApplicant($application);

        if ($request->expectsJson()) {
            return response()->json(['status' => $application->status, 'message' => 'Status updated.']);
        }

        return back()->with('success', "Status updated to " . ucfirst($request->status) . ".");
    }

    // ── Shortlist ─────────────────────────────────────────────────────
    public function shortlist(JobApplication $application)
    {
        $application->update(['status' => 'shortlisted']);
        $this->notifyApplicant($application);
        return back()->with('success', "{$application->user->name} has been shortlisted.");
    }

    // ── Hire ──────────────────────────────────────────────────────────
    public function hire(JobApplication $application)
    {
        $application->update(['status' => 'hired']);
        $this->notifyApplicant($application);
        return back()->with('success', "{$application->user->name} has been marked as Hired! 🎉");
    }

    // ── Approve (alias for shortlist, backward compat) ────────────────
    public function approve(JobApplication $application)
    {
        return $this->shortlist($application);
    }

    // ── Reject ────────────────────────────────────────────────────────
    public function reject(JobApplication $application)
    {
        $application->update(['status' => 'rejected']);
        $this->notifyApplicant($application);
        return back()->with('success', "Application rejected — {$application->user->name} has been notified.");
    }

    // ── Destroy ───────────────────────────────────────────────────────
    public function destroy(JobApplication $application)
    {
        $application->delete();
        return back()->with('success', 'Application deleted successfully.');
    }

    // ── Private: notify applicant ─────────────────────────────────────
    private function notifyApplicant(JobApplication $application): void
    {
        try {
            \Illuminate\Support\Facades\Mail::to($application->user->email)
                ->send(new \App\Mail\ApplicationStatusUpdated($application));
        } catch (\Exception $e) {
            // Mail failure is non-fatal
        }
    }
}
