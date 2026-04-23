@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.jobs.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors flex items-center">
        <i class="fas fa-arrow-left mr-2 text-xs"></i> Back to Jobs
    </a>
    <div class="flex gap-2">
        <a href="{{ route('admin.jobs.edit', $job->id) }}" class="px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 shadow-sm transition-colors flex items-center tracking-wide">
            <i class="fas fa-pen mr-2 text-gray-400"></i> Edit Listing
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-50 text-indigo-500 mb-4 shadow-inner">
        <i class="fas fa-file-contract text-2xl"></i>
    </div>
    <h3 class="text-lg font-extrabold text-gray-900 tracking-tight">Job Analysis View Under Construction</h3>
    <p class="text-sm text-gray-500 mt-2 mx-auto font-medium">Viewing details for job ID: {{ $job->id }}</p>
</div>
@endsection
