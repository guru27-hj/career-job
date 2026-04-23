<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $companies = Company::when($request->search, function($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('industry', 'like', "%{$search}%");
            })
            ->when($request->status, function($query, $status) {
                $query->where('status', $status);
            })
            ->paginate(10);

        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|unique:companies,slug',
            'logo' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'industry' => 'nullable|string',
            'location' => 'nullable|string',
            'headquarters' => 'nullable|string',
            'employees' => 'nullable|integer',
            'founded_year' => 'nullable|integer',
            'website' => 'nullable|url',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'social_links' => 'nullable|array',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('company-logos', 'public');
        }
        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('company-banners', 'public');
        }

        $validated['social_links'] = json_encode($validated['social_links'] ?? []);

        Company::create($validated);

        return redirect()->route('admin.companies.index')->with('success', 'Company created successfully.');
    }

    public function show(Company $company)
    {
        return view('admin.companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        $company->social_links = is_string($company->social_links) ? json_decode($company->social_links, true) : $company->social_links;
        return view('admin.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|unique:companies,slug,' . $company->id,
            'logo' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'industry' => 'nullable|string',
            'location' => 'nullable|string',
            'headquarters' => 'nullable|string',
            'employees' => 'nullable|integer',
            'founded_year' => 'nullable|integer',
            'website' => 'nullable|url',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'social_links' => 'nullable|array',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        if ($request->hasFile('logo')) {
            if ($company->logo) Storage::disk('public')->delete($company->logo);
            $validated['logo'] = $request->file('logo')->store('company-logos', 'public');
        }
        if ($request->hasFile('banner')) {
            if ($company->banner) Storage::disk('public')->delete($company->banner);
            $validated['banner'] = $request->file('banner')->store('company-banners', 'public');
        }

        $validated['social_links'] = json_encode($validated['social_links'] ?? []);

        $company->update($validated);

        return redirect()->route('admin.companies.index')->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        if ($company->logo) Storage::disk('public')->delete($company->logo);
        if ($company->banner) Storage::disk('public')->delete($company->banner);
        $company->delete();
        return redirect()->route('admin.companies.index')->with('success', 'Company deleted successfully.');
    }
}
