<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutSection;

class AboutController extends Controller
{
    public function index()
    {
        $sections = AboutSection::where('status', true)->get()->keyBy('section_key');
        return view('about.index', compact('sections'));
    }
}
