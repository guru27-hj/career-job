<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;

class CandidateController extends Controller
{
    public function profile()
    {
        $profile = auth()->user()->profile ?? new Profile(['skills' => []]);
        return view('user.profile', compact('profile'));
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'bio'      => 'nullable|string|max:1000',
            'skills'   => 'nullable',          // accepts string or array
            'resume'   => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $profile = auth()->user()->profile ?? new Profile(['user_id' => auth()->id()]);

        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resumes', 'public');
            $profile->resume_path = $path;
        }

        $profile->bio = $validated['bio'] ?? null;

        // Accept skills as: array (multi-select/tag-input), or comma-separated string
        $raw = $request->input('skills');
        if (is_array($raw)) {
            $profile->skills = array_values(array_filter(array_map('trim', $raw)));
        } elseif (is_string($raw) && strlen(trim($raw)) > 0) {
            $profile->skills = array_values(array_filter(array_map('trim', explode(',', $raw))));
        } else {
            $profile->skills = [];
        }

        $profile->save();

        return back()->with('success', 'Your candidate profile has been updated successfully.');
    }

    public function applications()
    {
        $applications = auth()->user()->applications()
            ->with(['job', 'job.company'])
            ->latest()
            ->paginate(10);

        // Compute match % for each application in candidate's own view
        foreach ($applications as $app) {
            $jobSkills     = $app->job->skills ?? [];
            $profileSkills = auth()->user()->profile->skills ?? [];
            $jobSkills     = is_array($jobSkills)     ? $jobSkills     : (json_decode($jobSkills, true) ?? []);
            $profileSkills = is_array($profileSkills) ? $profileSkills : (json_decode($profileSkills, true) ?? []);
            $app->match_pct = \App\Models\JobApplication::computeMatchPercentage($jobSkills, $profileSkills);
        }

        return view('user.applications', compact('applications'));
    }
}
