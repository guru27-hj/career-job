@extends('layouts.admin')

@section('content')

@php
    $statusClass = match($application->status) {
        'shortlisted' => 'bg-blue-900/30 text-blue-300 border-blue-700/40',
        'hired'       => 'bg-green-900/30 text-green-300 border-green-700/40',
        'rejected'    => 'bg-red-900/30 text-red-400 border-red-700/40',
        default       => 'bg-amber-900/30 text-amber-300 border-amber-700/40',
    };
    $statusIcon = match($application->status) {
        'shortlisted' => 'fa-star',
        'hired'       => 'fa-check-double',
        'rejected'    => 'fa-times-circle',
        default       => 'fa-clock',
    };

    // Match ring geometry (r=44, circumference=~276.46)
    $circ  = round(2 * M_PI * 44, 2);
    $dash  = round($circ * $matchPct / 100, 2);
    $ringColor = $matchPct >= 70 ? '#22c55e' : ($matchPct >= 40 ? '#f59e0b' : '#ef4444');
@endphp

<style>
.skill-pill { display:inline-flex;align-items:center;gap:4px;font-size:.7rem;font-weight:700;
              padding:3px 10px;border-radius:99px;margin:2px; }
.skill-matched { background:rgba(34,197,94,.12); color:#86efac; border:1px solid rgba(34,197,94,.22); }
.skill-missing  { background:rgba(239,68,68,.08); color:#fca5a5; border:1px solid rgba(239,68,68,.18); }
.sta-action { display:inline-flex;align-items:center;gap:.4rem;padding:.4rem 1rem;border-radius:9px;
              font-size:.75rem;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;
              border:none;transition:all .15s; }
</style>

{{-- Breadcrumb --}}
<div class="mb-6 flex items-center justify-between">
    <div class="flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('admin.applications.index') }}" class="hover:text-indigo-400 font-medium transition-colors">Applications</a>
        <i class="fas fa-chevron-right text-[9px] text-gray-600"></i>
        <span class="text-gray-200 font-semibold">Detail Review</span>
    </div>

    {{-- Status action buttons --}}
    <div class="flex items-center gap-2 flex-wrap">
        @if($application->status !== 'shortlisted')
        <form action="{{ route('admin.applications.shortlist', $application->id) }}" method="POST" class="m-0">
            @csrf
            <button class="sta-action" style="background:rgba(59,130,246,.15);border:1px solid rgba(59,130,246,.3);color:#93c5fd;">
                <i class="fas fa-star text-xs"></i> Shortlist
            </button>
        </form>
        @endif

        @if($application->status !== 'hired')
        <form action="{{ route('admin.applications.hire', $application->id) }}" method="POST" class="m-0">
            @csrf
            <button class="sta-action" style="background:rgba(34,197,94,.12);border:1px solid rgba(34,197,94,.25);color:#86efac;"
                    onclick="return confirm('Mark as Hired?')">
                <i class="fas fa-check-double text-xs"></i> Mark as Hired
            </button>
        </form>
        @endif

        @if($application->status !== 'rejected')
        <form action="{{ route('admin.applications.reject', $application->id) }}" method="POST" class="m-0">
            @csrf
            <button class="sta-action" style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2);color:#fca5a5;">
                <i class="fas fa-ban text-xs"></i> Reject
            </button>
        </form>
        @endif

        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl font-bold text-sm border {{ $statusClass }}">
            <i class="fas {{ $statusIcon }}"></i> {{ ucfirst($application->status) }}
        </span>
    </div>
</div>

@if(session('success'))
    <div class="mb-5 flex items-center gap-3 bg-green-900/30 border-l-4 border-green-500 text-green-300 px-5 py-3.5 rounded-r-xl text-sm font-medium">
        <i class="fas fa-check-circle text-green-400 text-base shrink-0"></i> {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- LEFT: Applicant Info + Resume --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- User Profile Card --}}
        <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-blue-500 px-6 py-5 flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur border-2 border-white/40 text-white flex items-center justify-center text-2xl font-black">
                    {{ strtoupper(substr(optional($application->user)->name ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-extrabold text-white tracking-tight">{{ optional($application->user)->name ?? 'Unknown Applicant' }}</h2>
                    <p class="text-indigo-200 text-sm mt-0.5">{{ optional($application->user)->email }}</p>
                </div>
            </div>

            <div class="p-6 space-y-5">
                {{-- Candidate Skills --}}
                <div>
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Technical Skills</h3>
                    @php $profileSkills = optional(optional($application->user)->profile)->skills ?? []; @endphp
                    <div class="flex flex-wrap gap-1">
                        @forelse(is_array($profileSkills) ? $profileSkills : json_decode($profileSkills, true) ?? [] as $skill)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-900/40 text-indigo-300 border border-indigo-700/30">
                                {{ $skill }}
                            </span>
                        @empty
                            <span class="text-sm text-gray-500 italic">No skills listed on profile.</span>
                        @endforelse
                    </div>
                </div>

                {{-- Bio --}}
                <div>
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Professional Summary</h3>
                    <div class="bg-white/5 rounded-xl border border-white/10 p-4 text-sm text-gray-400 leading-relaxed min-h-[56px]">
                        {{ optional(optional($application->user)->profile)->bio ?? 'This candidate did not provide a professional summary.' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Resume --}}
        <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-white/10 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-red-900/40 text-red-400 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-pdf text-sm"></i>
                    </div>
                    <h3 class="font-bold text-gray-200">Resume / CV</h3>
                </div>
                @if(optional(optional($application->user)->profile)->resume_path)
                    <a href="{{ Storage::url($application->user->profile->resume_path) }}" target="_blank"
                       class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-400 hover:text-indigo-300 bg-indigo-900/30 hover:bg-indigo-900/50 px-3 py-1.5 rounded-lg transition-colors">
                        <i class="fas fa-download"></i> Download PDF
                    </a>
                @endif
            </div>
            @php $resumePath = optional(optional($application->user)->profile)->resume_path; @endphp
            @if($resumePath)
                <div class="bg-black/20 p-2 h-[520px]">
                    <iframe src="{{ Storage::url($resumePath) }}" class="w-full h-full rounded-lg border border-white/10" frameborder="0"></iframe>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-14 text-center">
                    <div class="w-14 h-14 bg-gray-800 rounded-full flex items-center justify-center mb-3">
                        <i class="fas fa-file-slash text-xl text-gray-600"></i>
                    </div>
                    <p class="font-semibold text-gray-500 text-sm">No Resume Attached</p>
                    <p class="text-xs text-gray-600 mt-1">The candidate did not upload a resume document.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- RIGHT: Match + Job Info --}}
    <div class="space-y-5">

        {{-- ── Skill Match Ring ── --}}
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 text-center">
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Skill Match Score</h3>

            {{-- Ring SVG --}}
            <div class="relative w-32 h-32 mx-auto mb-4">
                <svg viewBox="0 0 100 100" width="128" height="128" style="transform:rotate(-90deg);">
                    <circle cx="50" cy="50" r="44" fill="none" stroke="rgba(255,255,255,.06)" stroke-width="8"/>
                    <circle cx="50" cy="50" r="44" fill="none"
                            stroke="{{ $ringColor }}"
                            stroke-width="8"
                            stroke-linecap="round"
                            stroke-dasharray="{{ $dash }} {{ $circ }}"
                            stroke-dashoffset="0"
                            style="transition:stroke-dashoffset .8s ease;"/>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-3xl font-black" style="color:{{ $ringColor }};">{{ $matchPct }}%</span>
                    <span class="text-xs text-gray-500 mt-0.5">match</span>
                </div>
            </div>

            {{-- Matched skills --}}
            @if(!empty($breakdown['matched']))
                <div class="mb-3">
                    <p class="text-xs text-gray-500 mb-1.5 font-semibold">✅ Matched ({{ count($breakdown['matched']) }})</p>
                    <div class="flex flex-wrap justify-center gap-1">
                        @foreach($breakdown['matched'] as $sk)
                            <span class="skill-pill skill-matched"><i class="fas fa-check" style="font-size:.5rem;"></i>{{ $sk }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Missing skills --}}
            @if(!empty($breakdown['missing']))
                <div>
                    <p class="text-xs text-gray-500 mb-1.5 font-semibold">❌ Missing ({{ count($breakdown['missing']) }})</p>
                    <div class="flex flex-wrap justify-center gap-1">
                        @foreach($breakdown['missing'] as $sk)
                            <span class="skill-pill skill-missing">{{ $sk }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(empty($breakdown['matched']) && empty($breakdown['missing']))
                <p class="text-xs text-gray-500 italic">No skills listed on job or profile.</p>
            @endif
        </div>

        {{-- Job Details --}}
        <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
            <div class="px-5 py-4 border-b border-white/10 flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-900/40 text-blue-400 rounded-lg flex items-center justify-center">
                    <i class="fas fa-briefcase text-sm"></i>
                </div>
                <h3 class="font-bold text-gray-200">Target Position</h3>
            </div>
            <div class="p-5">
                <div class="flex items-center gap-3 mb-4">
                    @if(optional(optional($application->job)->company)->logo)
                        <img src="{{ Storage::url($application->job->company->logo) }}" class="w-12 h-12 rounded-xl border border-white/10 object-contain bg-white p-1" alt="logo">
                    @else
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-900 to-indigo-900 flex items-center justify-center font-bold text-indigo-300 text-lg">
                            {{ substr(optional(optional($application->job)->company)->name ?? 'C', 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h4 class="font-bold text-gray-200 text-sm">{{ optional($application->job)->title ?? '—' }}</h4>
                        <p class="text-xs text-gray-500">{{ optional(optional($application->job)->company)->name ?? 'Unknown Company' }}</p>
                    </div>
                </div>
                <ul class="space-y-2.5 text-xs border-t border-white/10 pt-4">
                    <li class="flex items-center justify-between">
                        <span class="text-gray-500 font-medium">Location</span>
                        <span class="font-semibold text-gray-300">{{ optional($application->job)->location ?? 'Remote' }}</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="text-gray-500 font-medium">Type</span>
                        <span class="font-semibold text-gray-300 capitalize">{{ str_replace('-', ' ', optional($application->job)->job_type ?? '—') }}</span>
                    </li>
                    @if(optional($application->job)->min_salary)
                    <li class="flex items-center justify-between">
                        <span class="text-gray-500 font-medium">Salary</span>
                        <span class="font-semibold text-gray-300">₹{{ number_format($application->job->min_salary) }} – ₹{{ number_format($application->job->max_salary) }}</span>
                    </li>
                    @endif
                </ul>
                <a href="{{ route('admin.jobs.applicants', $application->job_id) }}"
                   class="mt-4 w-full block text-center bg-blue-900/20 hover:bg-blue-900/40 border border-blue-700/30 text-blue-400 py-2 rounded-xl transition font-semibold text-xs">
                    <i class="fas fa-users mr-1"></i> View All Applicants for this Job
                </a>
                <a href="{{ route('admin.jobs.show', $application->job_id) }}"
                   class="mt-2 w-full block text-center bg-white/5 hover:bg-white/10 border border-white/10 text-gray-400 py-2 rounded-xl transition font-semibold text-xs">
                    <i class="fas fa-external-link-alt mr-1"></i> View Full Job Listing
                </a>
            </div>
        </div>

        {{-- Application Metadata --}}
        <div class="bg-white/5 border border-white/10 rounded-2xl p-5">
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Application Metadata</h3>
            <ul class="space-y-2 text-xs">
                <li class="flex justify-between items-center py-2 border-b border-white/10">
                    <span class="text-gray-500 font-medium">App ID</span>
                    <span class="font-bold text-indigo-400">#{{ str_pad($application->id, 5, '0', STR_PAD_LEFT) }}</span>
                </li>
                <li class="flex justify-between items-center py-2 border-b border-white/10">
                    <span class="text-gray-500 font-medium">Submitted</span>
                    <span class="font-semibold text-gray-300">{{ $application->created_at->format('M d, Y') }}</span>
                </li>
                <li class="flex justify-between items-center py-2 border-b border-white/10">
                    <span class="text-gray-500 font-medium">Time</span>
                    <span class="font-semibold text-gray-300">{{ $application->created_at->format('h:i A') }}</span>
                </li>
                <li class="flex justify-between items-center py-2">
                    <span class="text-gray-500 font-medium">Status</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold
                        @if($application->status === 'hired') bg-green-900/40 text-green-400
                        @elseif($application->status === 'shortlisted') bg-blue-900/40 text-blue-400
                        @elseif($application->status === 'pending') bg-amber-900/40 text-amber-400
                        @else bg-red-900/40 text-red-400 @endif">
                        {{ ucfirst($application->status) }}
                    </span>
                </li>
            </ul>
        </div>

    </div>
</div>

@endsection
