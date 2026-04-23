<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Job;
use App\Models\JobApplication;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalJobs = Job::where('job_type', '!=', 'internship')->count();
        $totalInternships = Job::where('job_type', 'internship')->count();
        $totalApplications = JobApplication::count();

        $jobData = array_fill(0, 12, 0);
        $userData = array_fill(0, 12, 0);
        $appData = array_fill(0, 12, 0);

        $jobs = Job::whereYear('created_at', date('Y'))->get();
        foreach ($jobs as $job) {
            $jobData[$job->created_at->month - 1]++;
        }

        $users = User::whereYear('created_at', date('Y'))->get();
        foreach ($users as $user) {
            $userData[$user->created_at->month - 1]++;
        }

        $apps = JobApplication::whereYear('created_at', date('Y'))->get();
        foreach ($apps as $app) {
            $appData[$app->created_at->month - 1]++;
        }

        return view('admin.dashboard', compact(
            'totalUsers', 'totalJobs', 'totalInternships', 'totalApplications',
            'jobData', 'userData', 'appData'
        ));
    }
}
