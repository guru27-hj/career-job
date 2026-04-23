@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 leading-tight">{{ $title ?? 'System Module' }}</h2>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-50 text-blue-500 mb-4 shadow-inner">
        <i class="fas fa-hammer text-2xl"></i>
    </div>
    <h3 class="text-lg font-extrabold text-gray-900 tracking-tight">Under Construction</h3>
    <p class="text-sm text-gray-500 mt-2 max-w-sm mx-auto font-medium">This module is currently scheduled for development. You have successfully accessed the page, but the data grid is pending.</p>
    
    <div class="mt-8">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
            <i class="fas fa-arrow-left mr-2"></i> Return to Dashboard
        </a>
    </div>
</div>
@endsection
