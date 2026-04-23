<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use Illuminate\Http\Request;

class AboutSectionController extends Controller
{
    public function index()
    {
        $sections = AboutSection::all();
        return view('admin.about_sections.index', compact('sections'));
    }

    public function edit(AboutSection $aboutSection)
    {
        return view('admin.about_sections.edit', compact('aboutSection'));
    }

    public function update(Request $request, AboutSection $aboutSection)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'status' => 'boolean',
        ]);

        if (isset($data['content'])) {
            $decoded = json_decode($data['content'], true);
            if(json_last_error() === JSON_ERROR_NONE) {
                $data['content'] = $decoded;
            } else {
                return back()->withErrors(['content' => 'Invalid JSON format.']);
            }
        } else {
            $data['content'] = [];
        }

        $data['status'] = $request->has('status');

        $aboutSection->update($data);

        return redirect()->route('admin.about_sections.index')->with('success', 'Section updated successfully.');
    }
}
