<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SkillController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        
        $skills = Skill::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('category', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.skills.index', compact('skills', 'search'));
    }

    public function create()
    {
        // the creation form is attached to the index view
        return redirect()->route('admin.skills.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:skills',
            'category' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:20',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        
        Skill::create($validated);

        return redirect()->route('admin.skills.index')->with('success', 'Skill added successfully!');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return redirect()->route('admin.skills.index')->with('success', 'Skill deleted successfully!');
    }
}
