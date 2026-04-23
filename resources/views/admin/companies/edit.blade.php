@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Edit Company: {{ $company->name }}</h1>
        <a href="{{ route('admin.companies.index') }}" class="text-blue-600 hover:underline">Back to List</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.companies.update', $company) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Company Name *</label>
                    <input type="text" name="name" value="{{ old('name', $company->name) }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Slug *</label>
                    <input type="text" name="slug" value="{{ old('slug', $company->slug) }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    @error('slug') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <!-- Industry -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Industry</label>
                    <input type="text" name="industry" value="{{ old('industry', $company->industry) }}" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Location -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                    <input type="text" name="location" value="{{ old('location', $company->location) }}" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $company->email) }}" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $company->phone) }}" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Website -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Website URL</label>
                    <input type="url" name="website" value="{{ old('website', $company->website) }}" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
                
                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="pending" {{ $company->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $company->status == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $company->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <!-- Logo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                    @if($company->logo)
                        <div class="mb-2"><img src="{{ asset('storage/'.$company->logo) }}" class="h-16 rounded"></div>
                    @endif
                    <input type="file" name="logo" class="w-full">
                </div>

                <!-- Banner -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Banner Image</label>
                    @if($company->banner)
                        <div class="mb-2"><img src="{{ asset('storage/'.$company->banner) }}" class="h-16 rounded"></div>
                    @endif
                    <input type="file" name="banner" class="w-full">
                </div>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="4" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $company->description) }}</textarea>
            </div>

            @php
                $socials = is_string($company->social_links) ? json_decode($company->social_links, true) : ($company->social_links ?? []);
            @endphp
            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">LinkedIn URL</label>
                    <input type="url" name="social_links[linkedin]" value="{{ $socials['linkedin'] ?? '' }}" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Twitter URL</label>
                    <input type="url" name="social_links[twitter]" value="{{ $socials['twitter'] ?? '' }}" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Facebook URL</label>
                    <input type="url" name="social_links[facebook]" value="{{ $socials['facebook'] ?? '' }}" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700">Update Company</button>
            </div>
        </form>
    </div>
</div>
@endsection
