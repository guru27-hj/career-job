@extends('layouts.admin')
@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow-sm border border-gray-100 p-6">
    <div class="mb-6 border-b pb-4 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Edit Section: {{ $aboutSection->section_key }}</h2>
        <a href="{{ route('admin.about_sections.index') }}" class="text-gray-500 hover:text-gray-700">&larr; Back</a>
    </div>

    @if($errors->any())
        <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-6">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.about_sections.update', $aboutSection->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Title</label>
            <input type="text" name="title" value="{{ old('title', $aboutSection->title) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Content (JSON Format)</label>
            <div class="text-xs text-gray-500 mb-2 bg-gray-50 p-2 rounded">
                This section uses JSON. Make sure you use valid JSON syntax (double quotes for keys/values).
            </div>
            <textarea name="content" rows="15" class="w-full font-mono text-sm border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none bg-gray-50">{{ old('content', json_encode($aboutSection->content, JSON_PRETTY_PRINT)) }}</textarea>
        </div>

        <div class="mb-8 flex items-center">
            <input type="hidden" name="status" value="0">
            <input type="checkbox" name="status" id="status" value="1" {{ old('status', $aboutSection->status) ? 'checked' : '' }} class="w-5 h-5 text-blue-600 rounded border-gray-300">
            <label for="status" class="ml-2 text-gray-800 font-medium">Active (Visible on frontend)</label>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">Save Changes</button>
        </div>
    </form>
</div>
@endsection
