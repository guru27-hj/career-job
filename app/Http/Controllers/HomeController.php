<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredJobs = Job::with('company')
            ->where('featured', true)
            ->latest('posted_at')
            ->take(6)
            ->get();

        $categories = Category::withCount('jobs')->take(8)->get();

        $topCompanies = Company::withCount('jobs')
            ->orderBy('jobs_count', 'desc')
            ->take(6)
            ->get();

        $totalJobs = Job::count();

        return view('home', compact('featuredJobs', 'categories', 'topCompanies', 'totalJobs'));
    }
}
