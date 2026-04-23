<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.placeholder', ['title' => 'Analytics & Reports']);
    }

    public function export()
    {
        return redirect()->back()->with('success', 'Export initiated successfully.');
    }
}
