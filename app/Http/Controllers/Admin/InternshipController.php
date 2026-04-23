<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function index()
    {
        return view('admin.placeholder', ['title' => 'Internship Management']);
    }

    public function create() { return view('admin.placeholder', ['title' => 'Add Internship']); }
    public function show($id) { return view('admin.placeholder', ['title' => 'View Internship']); }
    
    public function approve($id)
    {
        return redirect()->back()->with('success', 'Internship approved successfully.');
    }

    public function reject($id)
    {
        return redirect()->back()->with('error', 'Internship rejected.');
    }
}
