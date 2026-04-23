@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.jobs.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors flex items-center w-fit mb-4">
        <i class="fas fa-arrow-left mr-2 text-xs"></i> Back to Jobs
    </a>
    <h2 class="text-2xl font-bold text-gray-900 leading-tight">Post New Job</h2>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-50 text-blue-500 mb-4 shadow-inner">
        <i class="fas fa-tools text-2xl"></i>
    </div>
    <h3 class="text-lg font-extrabold text-gray-900 tracking-tight">Form Component Under Construction</h3>
    <p class="text-sm text-gray-500 mt-2 max-w-sm mx-auto font-medium">The comprehensive job posting form is being built. System successfully loaded {{ count($companies) }} active companies and {{ count($categories) }} job categories.</p>
</div>
@endsection
