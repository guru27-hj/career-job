@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 leading-tight">Job Management</h2>
        <p class="text-sm text-gray-500 mt-1">Review, approve, and manage all job postings across the platform.</p>
    </div>
    
    <div class="flex items-center gap-3 w-full sm:w-auto">
        <form action="{{ route('admin.jobs.index') }}" method="GET" class="relative w-full sm:w-64">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search jobs by title..." class="w-full pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm transition-shadow">
            <i class="fas fa-search absolute left-3.5 top-2.5 text-gray-400"></i>
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
        </form>
        <a href="{{ route('admin.jobs.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow-sm transition-colors flex items-center shrink-0">
            <i class="fas fa-plus mr-2"></i> Post Job
        </a>
    </div>
</div>

<!-- Tabs/Filters Optional -->
<div class="mb-4 flex space-x-1 border-b border-gray-200">
    <a href="{{ route('admin.jobs.index') }}" class="px-4 py-2 text-sm font-medium {{ !request()->has('status') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500 hover:text-gray-700' }}">All Jobs</a>
    <a href="{{ route('admin.jobs.index', ['status' => 'pending']) }}" class="px-4 py-2 text-sm font-medium flex items-center {{ request('status') == 'pending' ? 'border-b-2 border-amber-500 text-amber-600' : 'text-gray-500 hover:text-gray-700' }}">Pending <span class="ml-1.5 bg-amber-100 text-amber-700 py-0.5 px-2 rounded-full text-[10px] font-bold">New</span></a>
    <a href="{{ route('admin.jobs.index', ['status' => 'approved']) }}" class="px-4 py-2 text-sm font-medium {{ request('status') == 'approved' ? 'border-b-2 border-green-500 text-green-600' : 'text-gray-500 hover:text-gray-700' }}">Approved</a>
    <a href="{{ route('admin.jobs.index', ['status' => 'rejected']) }}" class="px-4 py-2 text-sm font-medium {{ request('status') == 'rejected' ? 'border-b-2 border-red-500 text-red-600' : 'text-gray-500 hover:text-gray-700' }}">Rejected</a>
</div>

<!-- Main Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-4">Job Role</th>
                    <th class="px-6 py-4">Company</th>
                    <th class="px-6 py-4">Location & Type</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($jobs as $job)
                <tr class="hover:bg-blue-50/50 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900">{{ $job->title }}</div>
                        <div class="text-xs text-gray-500 mt-1 flex items-center">
                            <i class="far fa-clock mr-1 text-gray-400 block pb-0.5"></i> {{ $job->posted_at ? $job->posted_at->diffForHumans() : $job->created_at->diffForHumans() }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($job->company)
                            <div class="flex items-center">
                                @if($job->company->logo)
                                    <img src="{{ Storage::url($job->company->logo) }}" class="w-8 h-8 rounded-md border border-gray-200 object-cover mr-3 bg-white" alt="logo">
                                @else
                                    <div class="w-8 h-8 rounded-md bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold mr-3 border border-indigo-100 text-xs">
                                        {{ substr($job->company->name, 0, 1) }}
                                    </div>
                                @endif
                                <span class="font-semibold text-gray-800">{{ $job->company->name }}</span>
                            </div>
                        @else
                            <span class="text-gray-400 italic">No Company</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-gray-700 font-medium"><i class="fas fa-map-marker-alt text-gray-400 mr-1.5 w-3 text-center"></i>{{ $job->location ?? 'Remote' }}</div>
                        <div class="mt-1">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-600">
                                {{ str_replace('-', ' ', $job->job_type) }}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="status-badge-container">
                            @if(strtolower($job->status) === 'approved')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold leading-none bg-green-50 text-green-700 border border-green-200">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span> Approved
                                </span>
                            @elseif(strtolower($job->status) === 'pending')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold leading-none bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full mr-1.5"></span> Pending
                                </span>
                                <!-- Approve / Reject buttons securely visible underneath status badge -->
                                <div class="mt-2 flex items-center gap-1">
                                    <form action="{{ route('admin.jobs.approve', $job->id) }}" method="POST" class="inline ajax-job-action">
                                        @csrf
                                        <button type="submit" class="bg-green-100 text-green-700 hover:bg-green-200 text-[10px] font-bold px-2 py-1 rounded border border-green-200 transition-colors" title="Approve Job">
                                            Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.jobs.reject', $job->id) }}" method="POST" class="inline ajax-job-action">
                                        @csrf
                                        <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 text-[10px] font-bold px-2 py-1 rounded border border-red-200 transition-colors" title="Reject Job">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            @elseif(strtolower($job->status) === 'rejected')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold leading-none bg-red-50 text-red-700 border border-red-200">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span> Rejected
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <!-- Desktop Actions Reveal on Hover -->
                        <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">

                            <a href="{{ route('admin.jobs.show', $job->id) }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors" title="View details">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.jobs.edit', $job->id) }}" class="p-1.5 text-gray-400 hover:text-gray-900 hover:bg-gray-100 rounded transition-colors" title="Edit job">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('WARNING: Are you sure you want to delete this job posting?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors" title="Delete job">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                        
                        <!-- Mobile/Default Ellipsis -->
                        <div class="flex items-center justify-end gap-2 group-hover:hidden text-gray-300">
                           <i class="fas fa-ellipsis-h px-2"></i>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4 transform group-hover:scale-110 transition-transform">
                            <i class="fas fa-briefcase text-2xl text-gray-400"></i>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900">No jobs found</h3>
                        <p class="text-xs text-gray-500 mt-1">There are no jobs matching the current filters.</p>
                        @if(request('search') || request('status'))
                            <a href="{{ route('admin.jobs.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium mt-4 inline-block tracking-wide">Clear all filters &rarr;</a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($jobs->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
        {{ $jobs->appends(request()->query())->links() }}
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.ajax-job-action').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const btn = this.querySelector('button');
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            btn.disabled = true;

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.ok) {
                    const statusContainer = this.closest('.status-badge-container');
                    const isApprove = this.action.includes('approve');
                    
                    // Update status badge completely and erase the buttons underneath it safely
                    if (isApprove) {
                        statusContainer.innerHTML = `
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold leading-none bg-green-50 text-green-700 border border-green-200">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span> Approved
                            </span>
                        `;
                    } else {
                        statusContainer.innerHTML = `
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold leading-none bg-red-50 text-red-700 border border-red-200">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span> Rejected
                            </span>
                        `;
                    }

                } else {
                    btn.innerHTML = originalHtml;
                    btn.disabled = false;
                    alert('Error updating status.');
                }
            } catch (error) {
                btn.innerHTML = originalHtml;
                btn.disabled = false;
                alert('Connection error.');
            }
        });
    });
});
</script>
@endsection
