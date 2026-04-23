@extends('layouts.app')

@section('content')

@php
    $socialLinks = is_array($company->social_links)
        ? $company->social_links
        : (json_decode($company->social_links, true) ?? []);
    $hasSocial = !empty(array_filter($socialLinks));
@endphp

{{-- ═══════════════════════════════════════════════════════
     HERO / BANNER
═══════════════════════════════════════════════════════ --}}
<div class="relative w-full h-56 sm:h-72 bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700 overflow-hidden">

    {{-- Banner image --}}
    @if($company->banner)
        <img src="{{ asset('storage/' . $company->banner) }}"
             alt="Banner"
             class="absolute inset-0 w-full h-full object-cover opacity-60">
    @endif

    {{-- Decorative overlay pattern --}}
    <div class="absolute inset-0 opacity-10"
         style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 28px 28px;">
    </div>

    {{-- Dark gradient at bottom for text readability --}}
    <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-black/40 to-transparent"></div>
</div>

{{-- ═══════════════════════════════════════════════════════
     PROFILE CARD (overlapping the banner)
═══════════════════════════════════════════════════════ --}}
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-10">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 sm:p-8">
        <div class="flex flex-col sm:flex-row sm:items-end gap-5">

            {{-- Logo --}}
            <div class="flex-shrink-0">
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl border-4 border-white shadow-lg overflow-hidden bg-gray-100 flex items-center justify-center">
                    @if($company->logo)
                        <img src="{{ asset('storage/' . $company->logo) }}"
                             alt="{{ $company->name }}"
                             class="w-full h-full object-cover">
                    @else
                        <span class="text-4xl text-gray-400 font-extrabold select-none">
                            {{ strtoupper(substr($company->name, 0, 1)) }}
                        </span>
                    @endif
                </div>
            </div>

            {{-- Meta --}}
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 leading-tight truncate">
                    {{ $company->name }}
                </h1>
                <p class="mt-0.5 text-gray-500 text-sm sm:text-base">
                    {{ $company->industry ?? 'Company' }}
                    @if($company->founded_year)
                        &middot; Est. {{ $company->founded_year }}
                    @endif
                </p>

                <div class="mt-2 flex flex-wrap gap-3 text-sm text-gray-500">
                    @if($company->location)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $company->location }}
                        </span>
                    @endif
                    @if($company->employees)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ number_format($company->employees) }} employees
                        </span>
                    @endif
                    @if($company->website)
                        <a href="{{ $company->website }}" target="_blank" class="flex items-center gap-1 text-blue-600 hover:underline">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            {{ parse_url($company->website, PHP_URL_HOST) ?? $company->website }}
                        </a>
                    @endif
                </div>
            </div>

            {{-- CTA Buttons --}}
            <div class="flex flex-wrap gap-3 sm:flex-shrink-0">
                @if($company->website)
                    <a href="{{ $company->website }}" target="_blank"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow transition-all duration-200 hover:shadow-md hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/>
                        </svg>
                        Visit Website
                    </a>
                @endif

                {{-- ── Follow / Unfollow Button ── --}}
                @auth
                    <div x-data="{
                            following: {{ $isFollowing ? 'true' : 'false' }},
                            count: {{ $followerCount }},
                            loading: false,
                            toast: '',
                            showToast: false,
                            async toggle() {
                                if (this.loading) return;
                                this.loading = true;
                                try {
                                    const res = await fetch('{{ route('companies.follow', $company) }}', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                            'Accept': 'application/json',
                                            'Content-Type': 'application/json',
                                        },
                                    });
                                    const data = await res.json();
                                    this.following = data.following;
                                    this.count = data.follower_count;
                                    this.toast = data.message;
                                    this.showToast = true;
                                    setTimeout(() => this.showToast = false, 3000);
                                } catch(e) {
                                    this.toast = 'Something went wrong. Please try again.';
                                    this.showToast = true;
                                    setTimeout(() => this.showToast = false, 3000);
                                } finally {
                                    this.loading = false;
                                }
                            }
                        }"
                         class="relative">

                        {{-- Button --}}
                        <button @click="toggle()"
                                :disabled="loading"
                                :class="following
                                    ? 'bg-gray-100 text-gray-700 border-2 border-gray-300 hover:bg-red-50 hover:border-red-400 hover:text-red-600'
                                    : 'border-2 border-blue-600 text-blue-600 hover:bg-blue-50'"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 hover:-translate-y-0.5 disabled:opacity-60 disabled:cursor-not-allowed min-w-[130px] justify-center">

                            {{-- Spinner --}}
                            <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>

                            {{-- Following state --}}
                            <template x-if="!loading && following">
                                <span class="inline-flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Following
                                </span>
                            </template>

                            {{-- Not following state --}}
                            <template x-if="!loading && !following">
                                <span class="inline-flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Follow
                                </span>
                            </template>
                        </button>

                        {{-- Follower count badge --}}
                        <span x-show="count > 0"
                              class="absolute -top-2 -right-2 bg-blue-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center shadow"
                              x-text="count > 999 ? '999+' : count">
                        </span>

                        {{-- Toast notification --}}
                        <div x-show="showToast"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute top-14 right-0 z-50 bg-gray-900 text-white text-xs rounded-xl px-4 py-2.5 shadow-xl whitespace-nowrap"
                             x-text="toast">
                        </div>
                    </div>
                @else
                    {{-- Guest: redirect to login --}}
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border-2 border-blue-600 text-blue-600 hover:bg-blue-50 text-sm font-semibold transition-all duration-200 hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Follow
                    </a>
                @endauth
            </div>
        </div>

        {{-- Social Links row --}}
        @if($hasSocial)
            <div class="mt-5 pt-5 border-t border-gray-100 flex items-center gap-4">
                <span class="text-xs text-gray-400 uppercase tracking-wider font-medium">Connect</span>
                @if(!empty($socialLinks['linkedin']))
                    <a href="{{ $socialLinks['linkedin'] }}" target="_blank"
                       class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-200">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                @endif
                @if(!empty($socialLinks['twitter']))
                    <a href="{{ $socialLinks['twitter'] }}" target="_blank"
                       class="w-8 h-8 flex items-center justify-center rounded-full bg-sky-50 text-sky-500 hover:bg-sky-500 hover:text-white transition-all duration-200">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                @endif
                @if(!empty($socialLinks['facebook']))
                    <a href="{{ $socialLinks['facebook'] }}" target="_blank"
                       class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-50 text-blue-700 hover:bg-blue-700 hover:text-white transition-all duration-200">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     MAIN CONTENT  (2 columns on lg+)
═══════════════════════════════════════════════════════ --}}
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- ─── LEFT / MAIN COLUMN ─── --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- ── 1. About ── --}}
        @if($company->description)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                <span class="w-1 h-6 rounded-full bg-blue-600 inline-block"></span>
                About {{ $company->name }}
            </h2>
            <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed text-sm sm:text-base">
                {!! nl2br(e($company->description)) !!}
            </div>
        </div>
        @endif

        {{-- ── 2. Why Join Us ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                <span class="w-1 h-6 rounded-full bg-blue-600 inline-block"></span>
                Why Join Us
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                {{-- Card 1 --}}
                <div class="group p-5 rounded-xl border border-gray-100 bg-gradient-to-br from-blue-50 to-indigo-50 hover:shadow-md transition-all duration-200 hover:-translate-y-1 text-center">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-3 group-hover:bg-blue-600 transition-colors duration-200">
                        <svg class="w-6 h-6 text-blue-600 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 text-sm mb-1">Flexible Hours</h3>
                    <p class="text-xs text-gray-500">Work-life balance that actually works</p>
                </div>
                {{-- Card 2 --}}
                <div class="group p-5 rounded-xl border border-gray-100 bg-gradient-to-br from-green-50 to-emerald-50 hover:shadow-md transition-all duration-200 hover:-translate-y-1 text-center">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-3 group-hover:bg-green-600 transition-colors duration-200">
                        <svg class="w-6 h-6 text-green-600 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 text-sm mb-1">Health Benefits</h3>
                    <p class="text-xs text-gray-500">Comprehensive health & wellness plans</p>
                </div>
                {{-- Card 3 --}}
                <div class="group p-5 rounded-xl border border-gray-100 bg-gradient-to-br from-purple-50 to-pink-50 hover:shadow-md transition-all duration-200 hover:-translate-y-1 text-center">
                    <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-3 group-hover:bg-purple-600 transition-colors duration-200">
                        <svg class="w-6 h-6 text-purple-600 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 text-sm mb-1">Fast Growth</h3>
                    <p class="text-xs text-gray-500">Clear career advancement paths</p>
                </div>
            </div>
        </div>

        {{-- ── 3. Open Positions (Tabs) ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                <span class="w-1 h-6 rounded-full bg-blue-600 inline-block"></span>
                Open Positions
            </h2>

            {{-- Tab container using Alpine.js --}}
            <div x-data="{ activeTab: 'jobs' }">

                {{-- Tabs --}}
                <div class="flex gap-1 p-1 bg-gray-100 rounded-xl mb-6 w-fit">
                    <button @click="activeTab = 'jobs'"
                            :class="activeTab === 'jobs' ? 'bg-white text-blue-600 shadow-sm font-semibold' : 'text-gray-500 hover:text-gray-700'"
                            class="px-5 py-2 rounded-lg text-sm font-medium transition-all duration-200 cursor-pointer">
                        Jobs
                        <span class="ml-1.5 px-2 py-0.5 rounded-full text-xs"
                              :class="activeTab === 'jobs' ? 'bg-blue-100 text-blue-600' : 'bg-gray-200 text-gray-500'">
                            {{ $totalJobs }}
                        </span>
                    </button>
                    <button @click="activeTab = 'internships'"
                            :class="activeTab === 'internships' ? 'bg-white text-blue-600 shadow-sm font-semibold' : 'text-gray-500 hover:text-gray-700'"
                            class="px-5 py-2 rounded-lg text-sm font-medium transition-all duration-200 cursor-pointer">
                        Internships
                        <span class="ml-1.5 px-2 py-0.5 rounded-full text-xs"
                              :class="activeTab === 'internships' ? 'bg-blue-100 text-blue-600' : 'bg-gray-200 text-gray-500'">
                            {{ $totalInternships }}
                        </span>
                    </button>
                </div>

                {{-- Jobs Tab --}}
                <div x-show="activeTab === 'jobs'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                    @if($jobs->count())
                        <div class="space-y-4">
                            @foreach($jobs as $job)
                                <div class="group flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-5 rounded-xl border border-gray-100 hover:border-blue-200 hover:shadow-md transition-all duration-200 hover:bg-blue-50/30">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-wrap items-center gap-2 mb-1">
                                            <h3 class="font-semibold text-gray-900 text-base group-hover:text-blue-600 transition-colors">{{ $job->title }}</h3>
                                            @if($job->remote)
                                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Remote</span>
                                            @endif
                                            @if($job->featured)
                                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Featured</span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-500 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            {{ $job->location ?? 'Location not specified' }}
                                        </p>
                                        <div class="flex flex-wrap gap-1.5 mt-2">
                                            @if($job->min_salary && $job->max_salary)
                                                <span class="px-2.5 py-1 rounded-lg bg-gray-100 text-gray-600 text-xs font-medium">
                                                    ₹{{ number_format($job->min_salary/1000) }}k – ₹{{ number_format($job->max_salary/1000) }}k
                                                </span>
                                            @endif
                                            @if($job->experience_level)
                                                <span class="px-2.5 py-1 rounded-lg bg-blue-50 text-blue-600 text-xs font-medium capitalize">{{ $job->experience_level }}</span>
                                            @endif
                                            @foreach(($job->skills ?? []) as $skill)
                                                <span class="px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-600 text-xs">{{ $skill }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <a href="{{ route('jobs.show', $job->slug) }}"
                                       class="flex-shrink-0 inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition-all duration-200 hover:shadow-md">
                                        Apply Now
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <p class="text-gray-500 font-medium">No job openings right now</p>
                            <p class="text-gray-400 text-sm mt-1">Check back soon for new opportunities.</p>
                        </div>
                    @endif
                </div>

                {{-- Internships Tab --}}
                <div x-show="activeTab === 'internships'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                    @if($internships->count())
                        <div class="space-y-4">
                            @foreach($internships as $intern)
                                <div class="group flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-5 rounded-xl border border-gray-100 hover:border-purple-200 hover:shadow-md transition-all duration-200 hover:bg-purple-50/30">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-wrap items-center gap-2 mb-1">
                                            <h3 class="font-semibold text-gray-900 text-base group-hover:text-purple-700 transition-colors">{{ $intern->title }}</h3>
                                            @if($intern->remote)
                                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Remote</span>
                                            @endif
                                            @if($intern->certificate_included)
                                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Certificate</span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-500 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            {{ $intern->location ?? 'Location not specified' }}
                                        </p>
                                        <div class="flex flex-wrap gap-1.5 mt-2">
                                            @if($intern->min_salary && $intern->max_salary)
                                                <span class="px-2.5 py-1 rounded-lg bg-gray-100 text-gray-600 text-xs font-medium">
                                                    ₹{{ number_format($intern->min_salary) }}–₹{{ number_format($intern->max_salary) }}/mo
                                                </span>
                                            @endif
                                            @if($intern->duration)
                                                <span class="px-2.5 py-1 rounded-lg bg-purple-50 text-purple-600 text-xs font-medium">{{ $intern->duration }}</span>
                                            @endif
                                            @foreach(($intern->skills ?? []) as $skill)
                                                <span class="px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-600 text-xs">{{ $skill }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <a href="{{ route('internships.show', $intern->slug) }}"
                                       class="flex-shrink-0 inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold transition-all duration-200 hover:shadow-md">
                                        Apply Now
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            <p class="text-gray-500 font-medium">No internships available yet</p>
                            <p class="text-gray-400 text-sm mt-1">Stay tuned for upcoming openings.</p>
                        </div>
                    @endif
                </div>

            </div>{{-- end x-data --}}
        </div>

    </div>{{-- end main col --}}

    {{-- ─── RIGHT / SIDEBAR ─── --}}
    <div class="space-y-5">

        {{-- ── Stats Card ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-bold text-gray-900 mb-4">Hiring at a Glance</h3>
            <div class="grid grid-cols-2 gap-3">
                <div class="p-4 rounded-xl bg-blue-50 text-center">
                    <p class="text-2xl font-extrabold text-blue-600">{{ $totalJobs }}</p>
                    <p class="text-xs text-gray-500 mt-1 font-medium">Open Jobs</p>
                </div>
                <div class="p-4 rounded-xl bg-purple-50 text-center">
                    <p class="text-2xl font-extrabold text-purple-600">{{ $totalInternships }}</p>
                    <p class="text-xs text-gray-500 mt-1 font-medium">Internships</p>
                </div>
                @if($company->employees)
                    <div class="col-span-2 p-4 rounded-xl bg-green-50 text-center">
                        <p class="text-2xl font-extrabold text-green-600">{{ number_format($company->employees) }}</p>
                        <p class="text-xs text-gray-500 mt-1 font-medium">Team Members</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── Company Info ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-bold text-gray-900 mb-4">Company Info</h3>
            <ul class="space-y-3 text-sm">
                @if($company->industry)
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Industry</p>
                            <p class="text-gray-700 font-medium">{{ $company->industry }}</p>
                        </div>
                    </li>
                @endif
                @if($company->headquarters)
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Headquarters</p>
                            <p class="text-gray-700 font-medium">{{ $company->headquarters }}</p>
                        </div>
                    </li>
                @endif
                @if($company->founded_year)
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Founded</p>
                            <p class="text-gray-700 font-medium">{{ $company->founded_year }}</p>
                        </div>
                    </li>
                @endif
            </ul>
        </div>

        {{-- ── Contact ── --}}
        @if($company->email || $company->phone || $company->website)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-bold text-gray-900 mb-4">Contact</h3>
            <ul class="space-y-3 text-sm">
                @if($company->email)
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <a href="mailto:{{ $company->email }}" class="text-blue-600 hover:underline truncate">{{ $company->email }}</a>
                    </li>
                @endif
                @if($company->phone)
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <a href="tel:{{ $company->phone }}" class="text-gray-700 hover:text-blue-600">{{ $company->phone }}</a>
                    </li>
                @endif
                @if($company->website)
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/></svg>
                        </div>
                        <a href="{{ $company->website }}" target="_blank" class="text-blue-600 hover:underline truncate">
                            {{ parse_url($company->website, PHP_URL_HOST) ?? $company->website }}
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        @endif

        {{-- ── Similar Companies ── --}}
        @if($similar->count())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-bold text-gray-900 mb-4">Similar Companies</h3>
            <div class="space-y-3">
                @foreach($similar as $sim)
                    <a href="{{ $sim->slug ? route('companies.show', $sim->slug) : '#' }}"
                       class="flex items-center gap-3 p-2 -mx-2 rounded-xl hover:bg-gray-50 transition-all duration-150 group">
                        <div class="w-10 h-10 rounded-xl bg-gray-100 overflow-hidden flex items-center justify-center flex-shrink-0">
                            @if($sim->logo)
                                <img src="{{ asset('storage/' . $sim->logo) }}" alt="{{ $sim->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-gray-400 font-bold text-sm">{{ strtoupper(substr($sim->name, 0, 1)) }}</span>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="font-semibold text-gray-800 text-sm truncate group-hover:text-blue-600 transition-colors">{{ $sim->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $sim->industry ?? $sim->location ?? '' }}</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-blue-500 flex-shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>{{-- end sidebar --}}

</div>
</div>

@endsection
