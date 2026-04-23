<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class InternshipApplicationController extends Controller
{
    /**
     * Apply for an internship (AJAX-ready).
     * Internships are stored in the `jobs` table with job_type = 'internship'.
     * Applications are stored in `job_applications` — same table as job applications.
     */
    public function store(Request $request, $slug)
    {
        // ── Auth guard ──────────────────────────────────────────────
        if (! auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status'   => 'unauthenticated',
                    'message'  => 'Please log in to apply for internships.',
                    'redirect' => route('login'),
                ], 401);
            }
            return redirect()->route('login')
                ->with('error', 'Please log in to apply for internships.');
        }

        // ── Resolve internship (via slug) ───────────────────────────
        $internship = Job::where('slug', $slug)
            ->where('job_type', 'internship')
            ->firstOrFail();

        // ── Profile completeness check ──────────────────────────────
        $profile = auth()->user()->profile;
        $incomplete = ! $profile
            || empty($profile->resume_path)
            || empty($profile->skills);

        if ($incomplete) {
            $msg = 'Your profile is incomplete. Please add your skills and upload a resume before applying.';
            if ($request->expectsJson()) {
                return response()->json([
                    'status'   => 'incomplete_profile',
                    'message'  => $msg,
                    'redirect' => route('candidate.profile'),
                ], 422);
            }
            return redirect()->route('candidate.profile')->with('error', $msg);
        }

        // ── Duplicate application guard ─────────────────────────────
        $exists = JobApplication::where('job_id', $internship->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($exists) {
            $msg = 'You have already applied for this internship.';
            if ($request->expectsJson()) {
                return response()->json([
                    'status'  => 'already_applied',
                    'message' => $msg,
                ], 409);
            }
            return back()->with('error', $msg);
        }

        // ── Create application ──────────────────────────────────────
        $application = JobApplication::create([
            'job_id'  => $internship->id,
            'user_id' => auth()->id(),
            'status'  => 'pending',
        ]);

        $company = $internship->company->name ?? 'the company';
        $msg = "Your application to {$company} was submitted successfully! 🎉";

        if ($request->expectsJson()) {
            return response()->json([
                'status'         => 'applied',
                'message'        => $msg,
                'application_id' => $application->id,
            ], 201);
        }

        return back()->with('success', $msg);
    }

    /**
     * Check if the current user has already applied (AJAX poll).
     */
    public function check($slug)
    {
        $internship = Job::where('slug', $slug)
            ->where('job_type', 'internship')
            ->firstOrFail();

        $applied = auth()->check()
            ? JobApplication::where('job_id', $internship->id)
                ->where('user_id', auth()->id())
                ->exists()
            : false;

        return response()->json(['applied' => $applied]);
    }
}
