<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function store(Request $request, Job $job)
    {
        // Ensure user is logged in
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must log in to submit a career application.');
        }

        // Validate Profile Completeness
        $profile = auth()->user()->profile;
        if (!$profile || empty($profile->resume_path) || empty($profile->skills)) {
            return redirect()->route('candidate.profile')->with('error', 'Profile Incomplete: You must provide a Bio, Skills, and upload a Resume PDF before applying for positions.');
        }

        // Prevent Duplicate Applications
        $exists = JobApplication::where('job_id', $job->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($exists) {
            return back()->with('error', 'You have already submitted an application for this position.');
        }

        // Establish Database Record
        $application = JobApplication::create([
            'job_id' => $job->id,
            'user_id' => auth()->id(),
            'status' => 'pending'
        ]);

        // Send Notification to Company Owner
        if ($job->company && $job->company->user) {
            $job->company->user->notify(new \App\Notifications\NewJobApplicationNotification(
                $application->id,
                $job->title,
                auth()->user()->name
            ));
        }

        $companyName = $job->company ? $job->company->name : 'the hiring team';

        return back()->with('success', 'Your application was successfully submitted to ' . $companyName . '!');
    }
}
