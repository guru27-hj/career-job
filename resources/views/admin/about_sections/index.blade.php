@extends('layouts.admin')
@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">About Page Sections</h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="p-3 text-sm font-semibold text-gray-600">Key</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Title</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Status</th>
                    <th class="p-3 text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($sections as $section)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 text-gray-800 font-medium">{{ $section->section_key }}</td>
                    <td class="p-3 text-gray-600">{{ $section->title }}</td>
                    <td class="p-3">
                        @if($section->status)
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full uppercase font-semibold">Active</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full uppercase font-semibold">Hidden</span>
                        @endif
                    </td>
                    <td class="p-3">
                        <a href="{{ route('admin.about_sections.edit', $section->id) }}" class="text-blue-600 hover:text-blue-800 mr-3 transition"><i class="fas fa-edit"></i> Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
