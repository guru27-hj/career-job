<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $companies = Company::approved()
            ->when($request->keyword, function($q) use ($request) {
                $q->where('name', 'like', "%{$request->keyword}%")
                  ->orWhere('industry', 'like', "%{$request->keyword}%");
            })
            ->paginate(12);

        return view('companies.index', compact('companies'));
    }

    public function show($slug)
    {
        
        $company = Company::with('jobs')
            ->where('slug', $slug)
            ->where('status', 'approved')
            ->firstOrFail();

        // Separate jobs and internships (only approved ones)
        $jobs = $company->jobs()
            ->where('job_type', 'full-time')
            ->where('status', 'approved')
            ->get();

        $internships = $company->jobs()
            ->where('job_type', 'internship')
            ->where('status', 'approved')
            ->get();

        $totalJobs = $jobs->count();
        $totalInternships = $internships->count();

        // Similar companies (same industry or location, exclude current)
        $similar = Company::approved()
            ->where('id', '!=', $company->id)
            ->where(function($q) use ($company) {
                $q->where('industry', $company->industry)
                  ->orWhere('location', $company->location);
            })
            ->limit(5)
            ->get();

        $isFollowing   = auth()->check() && $company->isFollowedBy(auth()->id());
        $followerCount = $company->followers()->count();

        return view('companies.show', compact(
            'company', 'jobs', 'internships',
            'totalJobs', 'totalInternships',
            'similar', 'isFollowing', 'followerCount'
        ));
    }
}
