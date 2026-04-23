<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.placeholder', ['title' => 'System Settings']);
    }

    public function update(Request $request)
    {
        return redirect()->back()->with('success', 'Settings updated.');
    }
}
