@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors flex items-center">
        <i class="fas fa-arrow-left mr-2 text-xs"></i> Back to Users
    </a>
    <div class="flex gap-2">
        <a href="{{ route('admin.users.edit', $user->id) }}" class="px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 shadow-sm transition-colors flex items-center tracking-wide">
            <i class="fas fa-pen mr-2 text-gray-400"></i> Edit Profile
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 auto-rows-min">
    <!-- Left Column: Primary Profile Card -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden relative">
            <div class="h-24 bg-[#0B0F19] border-b border-gray-800 absolute w-full inset-x-0 top-0">
                <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/20 to-transparent"></div>
            </div>
            
            <div class="px-6 pb-6 pt-12 relative z-10 flex flex-col items-center">
                <div class="w-24 h-24 rounded-full border-4 border-white shadow-md bg-white overflow-hidden mb-4 shrink-0">
                    <div class="w-full h-full bg-gradient-to-tr from-blue-500 to-indigo-600 text-white flex items-center justify-center text-3xl font-bold">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                </div>
                
                <h1 class="text-xl font-bold text-gray-900 mb-1 text-center">{{ $user->name }}</h1>
                <p class="text-sm text-gray-500 text-center mb-4 flex items-center"><i class="fas fa-envelope mr-1.5 text-gray-400"></i>{{ $user->email }}</p>
                
                @if($user->is_admin)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold leading-5 bg-purple-50 text-purple-700 uppercase tracking-widest border border-purple-200">
                        <i class="fas fa-shield-alt mr-1.5 opacity-70"></i> Administrator
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold leading-5 bg-gray-50 text-gray-700 uppercase tracking-widest border border-gray-200">
                        <i class="fas fa-user mr-1.5 opacity-70"></i> Standard User
                    </span>
                @endif
            </div>

            <div class="border-t border-gray-100 bg-gray-50/50 px-6 py-4">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-500 font-medium tracking-wide text-xs uppercase">Joined</span>
                    <span class="text-gray-900 font-semibold">{{ $user->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Stats & Data -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Key Metrics Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
             <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 pl-5 relative overflow-hidden group">
                <div class="absolute right-0 top-0 h-full w-12 bg-gradient-to-l from-green-50 to-transparent"></div>
                <div class="text-green-500 text-xl absolute right-4 top-1/2 transform -translate-y-1/2 opacity-20 group-hover:scale-110 group-hover:opacity-100 transition-all duration-300"><i class="fas fa-check-circle"></i></div>
                <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block relative z-10">Status</h4>
                <p class="text-xl font-black text-green-600 relative z-10 font-sans tracking-tight">Active</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 pl-5 relative overflow-hidden group">
                <div class="absolute right-0 top-0 h-full w-12 bg-gradient-to-l from-gray-50 to-transparent"></div>
                <div class="text-gray-400 text-xl absolute right-4 top-1/2 transform -translate-y-1/2 opacity-20 group-hover:scale-110 transition-all duration-300"><i class="fas fa-clock"></i></div>
                <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1 block relative z-10">Last Update</h4>
                <p class="text-[13px] font-semibold text-gray-800 relative z-10 mt-1.5">{{ $user->updated_at->diffForHumans() }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-history text-gray-400 mr-2 text-base"></i> Recent Activity Log
            </h3>
            
            <div class="text-center py-10 md:py-16 bg-gray-50 border border-gray-200 rounded-xl border-dashed">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-50 text-blue-500 text-lg shadow-inner mb-4 ring-8 ring-blue-50/50">
                    <i class="fas fa-stream"></i>
                </div>
                <p class="text-gray-900 font-semibold text-sm">Activity tracking module is pending integration.</p>
                <p class="text-gray-500 text-xs mt-1.5 max-w-sm mx-auto">Once the activity logging system is enabled in the settings, all actions performed by this user will be recorded and displayed right here.</p>
            </div>
        </div>
    </div>
</div>
@endsection
