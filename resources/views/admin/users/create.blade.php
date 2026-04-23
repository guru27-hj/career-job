@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors flex items-center w-fit mb-4">
        <i class="fas fa-arrow-left mr-2 text-xs"></i> Back to Users
    </a>
    <h2 class="text-2xl font-bold text-gray-900 leading-tight">Create New User</h2>
    <p class="text-sm text-gray-500 mt-1">Add a new user manually to the system and assign their privileges.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 max-w-4xl">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="p-6 sm:p-8 space-y-8">
            <!-- Account Details -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-100 pb-2">Account Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. John Doe" class="w-full bg-gray-50 border @error('name') border-red-300 focus:border-red-500 ring-red-500 @else border-gray-200 focus:border-blue-500 focus:ring-blue-500 @enderror rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 transition-colors" required>
                        @error('name') <p class="text-red-500 text-xs mt-1.5 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="e.g. john@example.com" class="w-full bg-gray-50 border @error('email') border-red-300 focus:border-red-500 ring-red-500 @else border-gray-200 focus:border-blue-500 focus:ring-blue-500 @enderror rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 transition-colors" required>
                        @error('email') <p class="text-red-500 text-xs mt-1.5 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Security details -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-100 pb-2">Security</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" placeholder="Min. 8 characters" class="w-full bg-gray-50 border @error('password') border-red-300 focus:border-red-500 ring-red-500 @else border-gray-200 focus:border-blue-500 focus:ring-blue-500 @enderror rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 transition-colors" required>
                        @error('password') <p class="text-red-500 text-xs mt-1.5 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Confirm Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" placeholder="Repeat password" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" required>
                    </div>
                </div>
            </div>

            <!-- Role & Permissions -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-100 pb-2">Role & Permissions</h3>
                <label class="relative flex items-start p-4 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50/30">
                    <div class="flex items-center h-5 mt-0.5">
                        <input type="hidden" name="is_admin" value="0">
                        <input type="checkbox" name="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    </div>
                    <div class="ml-3 text-sm">
                        <span class="font-semibold text-gray-900 block mb-0.5">Administrator Access</span>
                        <span class="text-gray-500">Grant this user full access to the admin dashboard, including deleting records and modifying system settings.</span>
                    </div>
                </label>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex justify-end gap-3 rounded-b-xl">
            <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-colors shadow-sm">
                Cancel
            </a>
            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors flex items-center shadow-md">
                <i class="fas fa-check mr-2"></i> Create User
            </button>
        </div>
    </form>
</div>
@endsection
