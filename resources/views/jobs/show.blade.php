@extends('layouts.public')

@section('content')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

        .cc-page {
            font-family: 'Inter', sans-serif;
            background: #f4f6fb;
            min-height: 100vh;
        }

        /* ── Hero banner ── */
        .cc-hero {
            background: linear-gradient(135deg, #1e293b 0%, #1e40af 60%, #2563eb 100%);
            padding: 2.5rem 0 4rem;
            position: relative;
            overflow: hidden;
        }

        .cc-hero::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 60px;
            background: #f4f6fb;
            clip-path: ellipse(55% 100% at 50% 100%);
        }

        .cc-hero-inner {
            position: relative;
            z-index: 1;
        }

        .cc-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 16px rgba(0, 0, 0, .07);
            padding: 1.75rem;
            transition: box-shadow .2s;
        }

        .cc-card:hover {
            box-shadow: 0 6px 28px rgba(0, 0, 0, .11);
        }

        .cc-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 13px;
            border-radius: 999px;
            font-size: .78rem;
            font-weight: 600;
        }

        .cc-badge-gray {
            background: #f1f5f9;
            color: #475569;
        }

        .cc-badge-blue {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
        }

        .cc-badge-green {
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        .cc-badge-red {
            background: #fff1f2;
            color: #be123c;
            border: 1px solid #fecdd3;
        }

        .cc-badge-indigo {
            background: #eef2ff;
            color: #4338ca;
            border: 1px solid #c7d2fe;
        }

        .cc-section-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 8px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f1f5f9;
            margin-bottom: 1rem;
        }

        .cc-section-title i {
            color: #2563eb;
            font-size: .95rem;
        }

        .cc-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .cc-list li {
            padding: 8px 0 8px 28px;
            position: relative;
            color: #475569;
            font-size: .9rem;
            line-height: 1.6;
            border-bottom: 1px solid #f8fafc;
        }

        .cc-list li:last-child {
            border-bottom: none;
        }

        .cc-list li::before {
            content: '';
            position: absolute;
            left: 6px;
            top: 50%;
            transform: translateY(-50%);
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #2563eb;
        }

        .cc-meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .75rem;
        }

        @media(max-width:500px) {
            .cc-meta-grid {
                grid-template-columns: 1fr;
            }
        }

        .cc-meta-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 14px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .cc-meta-item i {
            color: #2563eb;
            margin-top: 2px;
            font-size: .9rem;
            min-width: 16px;
            text-align: center;
        }

        .cc-meta-label {
            font-size: .7rem;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .cc-meta-val {
            font-size: .88rem;
            font-weight: 600;
            color: #1e293b;
            margin-top: 2px;
        }

        /* Buttons */
        .cc-btn-primary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 13px 20px;
            border-radius: 12px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            font-weight: 700;
            font-size: .92rem;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(37, 99, 235, .35);
            transition: transform .15s, box-shadow .15s, background .15s;
            text-decoration: none;
        }

        .cc-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(37, 99, 235, .45);
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
            color: #fff;
        }

        .cc-btn-outline {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 11px 20px;
            border-radius: 12px;
            background: #fff;
            color: #374151;
            border: 1.5px solid #e2e8f0;
            font-weight: 600;
            font-size: .9rem;
            cursor: pointer;
            transition: border-color .15s, background .15s, color .15s, transform .15s;
        }

        .cc-btn-outline:hover {
            border-color: #2563eb;
            color: #2563eb;
            background: #eff6ff;
            transform: translateY(-1px);
        }

        .cc-btn-outline.saved {
            border-color: #ef4444;
            color: #ef4444;
            background: #fff1f2;
        }

        .cc-btn-outline.applied-state {
            border-color: #22c55e;
            color: #16a34a;
            background: #f0fdf4;
            cursor: default;
        }

        .cc-btn-ghost {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            width: 100%;
            padding: 9px 16px;
            border-radius: 10px;
            background: none;
            border: none;
            color: #64748b;
            font-weight: 600;
            font-size: .88rem;
            cursor: pointer;
            transition: background .15s, color .15s;
        }

        .cc-btn-ghost:hover {
            background: #f1f5f9;
            color: #2563eb;
        }

        /* Progress bar */
        .cc-progress-track {
            background: #e2e8f0;
            border-radius: 999px;
            height: 8px;
            overflow: hidden;
        }

        .cc-progress-fill {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, #22c55e, #16a34a);
            width: 0%;
            transition: width 1.1s cubic-bezier(.4, 0, .2, 1);
        }

        /* Similar cards */
        .cc-sim-card {
            display: block;
            padding: 13px 14px;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            text-decoration: none;
            transition: border-color .15s, box-shadow .15s, transform .15s;
        }

        .cc-sim-card:hover {
            border-color: #93c5fd;
            box-shadow: 0 4px 14px rgba(59, 130, 246, .12);
            transform: translateY(-2px);
        }

        /* Share Modal */
        .cc-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 9998;
            background: rgba(15, 23, 42, .55);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity .25s;
        }

        .cc-modal-overlay.open {
            opacity: 1;
            pointer-events: all;
        }

        .cc-modal {
            background: #fff;
            border-radius: 20px;
            padding: 2rem;
            width: 92%;
            max-width: 420px;
            box-shadow: 0 24px 60px rgba(0, 0, 0, .2);
            transform: translateY(20px) scale(.97);
            transition: transform .3s cubic-bezier(.34, 1.56, .64, 1), opacity .25s;
        }

        .cc-modal-overlay.open .cc-modal {
            transform: translateY(0) scale(1);
        }

        .cc-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.4rem;
        }

        .cc-modal-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
        }

        .cc-modal-close {
            background: #f1f5f9;
            border: none;
            border-radius: 50%;
            width: 34px;
            height: 34px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            transition: background .15s;
        }

        .cc-modal-close:hover {
            background: #e2e8f0;
        }

        .cc-share-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: .75rem;
        }

        .cc-share-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 7px;
            padding: 14px 8px;
            border-radius: 14px;
            border: 1.5px solid #e2e8f0;
            background: #fff;
            cursor: pointer;
            text-decoration: none;
            font-size: .72rem;
            font-weight: 600;
            color: #475569;
            transition: transform .15s, box-shadow .15s, border-color .15s;
        }

        .cc-share-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, .1);
        }

        .cc-share-btn i {
            font-size: 1.3rem;
        }

        .cc-share-btn.wa {
            --c: #25d366;
        }

        .cc-share-btn.wa:hover {
            border-color: var(--c);
            background: #f0fdf4;
        }

        .cc-share-btn.fb {
            --c: #1877f2;
        }

        .cc-share-btn.fb:hover {
            border-color: var(--c);
            background: #eff6ff;
        }

        .cc-share-btn.tw {
            --c: #000;
        }

        .cc-share-btn.tw:hover {
            border-color: var(--c);
            background: #f8fafc;
        }

        .cc-share-btn.cp {
            --c: #6366f1;
        }

        .cc-share-btn.cp:hover {
            border-color: var(--c);
            background: #eef2ff;
        }

        .cc-copy-wrap {
            display: flex;
            margin-top: 1.1rem;
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            overflow: hidden;
        }

        .cc-copy-wrap input {
            flex: 1;
            padding: 9px 12px;
            font-size: .82rem;
            color: #475569;
            border: none;
            outline: none;
            background: #f8fafc;
        }

        .cc-copy-wrap button {
            padding: 9px 16px;
            background: #2563eb;
            color: #fff;
            border: none;
            font-size: .8rem;
            font-weight: 700;
            cursor: pointer;
            transition: background .15s;
        }

        .cc-copy-wrap button:hover {
            background: #1d4ed8;
        }

        /* Toast */
        .cc-toast-wrap {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        }

        .cc-toast {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #1e293b;
            color: #fff;
            padding: 12px 18px;
            border-radius: 12px;
            font-size: .88rem;
            font-weight: 600;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .25);
            transform: translateX(100px);
            opacity: 0;
            transition: transform .35s cubic-bezier(.34, 1.56, .64, 1), opacity .3s;
            pointer-events: all;
            max-width: 320px;
        }

        .cc-toast.show {
            transform: translateX(0);
            opacity: 1;
        }

        .cc-toast i {
            font-size: 1rem;
        }

        .cc-toast.success i {
            color: #4ade80;
        }

        .cc-toast.info i {
            color: #60a5fa;
        }
    </style>

    <div class="cc-page">

        {{-- ── HERO ─────────────────────────────────────────────────────────── --}}
        <div class="cc-hero">
            <div class="container mx-auto px-4 cc-hero-inner">
                <nav class="text-blue-200 text-sm mb-5 flex items-center gap-2">
                    <a href="{{ route('jobs.index') }}" class="hover:text-white transition">Jobs</a>
                    <i class="fas fa-chevron-right text-xs opacity-60"></i>
                    <span class="text-white font-medium truncate max-w-xs">{{ $job->title }}</span>
                </nav>

                <div class="flex flex-wrap items-start gap-5">
                    {{-- Logo avatar --}}
                    @php $companyName = $job->company->name ?? 'Unknown'; @endphp
                    <div
                        class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center text-white text-2xl font-bold shadow-lg flex-shrink-0">
                        {{ strtoupper(substr($companyName, 0, 1)) }}
                    </div>

                    <div class="flex-1 min-w-0">
                        <h1 class="text-2xl md:text-3xl font-extrabold text-white leading-tight mb-1">{{ $job->title }}</h1>
                        <p class="text-blue-100 text-base font-medium flex items-center gap-2 flex-wrap">
                            <i class="fas fa-building text-blue-300 text-sm"></i>
                            @if($job->company && $job->company->slug)
                                <a href="{{ route('companies.show', $job->company->slug) }}"
                                    class="hover:text-white transition">{{ $companyName }}</a>
                            @else
                                {{ $companyName }}
                            @endif
                            <span class="opacity-40">·</span>
                            <i class="fas fa-map-marker-alt text-blue-300 text-sm"></i>
                            {{ $job->location }}
                            @if($job->remote)
                                <span class="cc-badge"
                                    style="background:rgba(255,255,255,.15);color:#fff;font-size:.7rem;">Remote</span>
                            @endif
                        </p>
                        <div class="flex flex-wrap gap-2 mt-3">
                            <span class="cc-badge" style="background:rgba(255,255,255,.18);color:#fff;">
                                <i class="fas fa-rupee-sign text-xs"></i>
                                ₹{{ number_format($job->min_salary) }} – ₹{{ number_format($job->max_salary) }}
                            </span>
                            <span class="cc-badge" style="background:rgba(255,255,255,.18);color:#fff;">
                                <i class="fas fa-briefcase text-xs"></i>
                                {{ ucfirst(str_replace('-', ' ', $job->job_type)) }}
                            </span>
                            @if($job->experience_level)
                                <span class="cc-badge" style="background:rgba(255,255,255,.18);color:#fff;">
                                    <i class="fas fa-graduation-cap text-xs"></i> {{ $job->experience_level }}
                                </span>
                            @endif
                            @if($job->featured)
                                <span class="cc-badge" style="background:#fef9c3;color:#713f12;">🔥 Featured</span>
                            @endif
                        </div>
                        @if($job->posted_at)
                            <p class="text-blue-200 text-xs mt-3">
                                <i class="far fa-clock mr-1"></i> Posted {{ $job->posted_at->diffForHumans() }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ── BODY ─────────────────────────────────────────────────────────── --}}
        <div class="container mx-auto px-4 pb-12" style="margin-top:-2.5rem;">
            <div class="flex flex-col lg:flex-row gap-6 items-start">

                {{-- LEFT COLUMN --}}
                <div class="w-full lg:w-[63%] space-y-5">

                    {{-- Overview --}}
                    <div class="cc-card">
                        <h2 class="cc-section-title"><i class="fas fa-align-left"></i> Job Overview</h2>
                        <p class="text-gray-600 text-sm leading-relaxed">{!! nl2br(e($job->description)) !!}</p>
                    </div>

                    {{-- Responsibilities --}}
                    <div class="cc-card">
                        <h2 class="cc-section-title"><i class="fas fa-tasks"></i> Responsibilities</h2>
                        <ul class="cc-list">
                            <li>Drive end-to-end feature development and delivery</li>
                            <li>Collaborate with designers, PMs, and other engineers</li>
                            <li>Write clean, testable, and well-documented code</li>
                            <li>Participate in code reviews and architectural discussions</li>
                            <li>Troubleshoot and resolve production incidents promptly</li>
                        </ul>
                    </div>

                    {{-- Requirements --}}
                    <div class="cc-card">
                        <h2 class="cc-section-title"><i class="fas fa-clipboard-check"></i> Requirements</h2>
                        <ul class="cc-list">
                            <li>Proficiency in the required skills listed below</li>
                            <li>Strong communication and problem-solving skills</li>
                            <li>Experience with version control (Git / GitHub)</li>
                            <li>Ability to work in an agile, fast-paced environment</li>
                            <li>{{ $job->experience_level ? $job->experience_level . ' level experience' : 'Open to all experience levels' }}
                            </li>
                        </ul>
                    </div>

                    {{-- Skills --}}
                    @if($job->skills && count($job->skills))
                        <div class="cc-card">
                            <h2 class="cc-section-title"><i class="fas fa-code"></i> Skills Required</h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach($job->skills as $skill)
                                    <span class="cc-badge cc-badge-blue">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Details grid --}}
                    <div class="cc-card">
                        <h2 class="cc-section-title"><i class="fas fa-info-circle"></i> Job Details</h2>
                        <div class="cc-meta-grid">
                            <div class="cc-meta-item">
                                <i class="fas fa-briefcase"></i>
                                <div>
                                    <div class="cc-meta-label">Job Type</div>
                                    <div class="cc-meta-val">{{ ucfirst(str_replace('-', ' ', $job->job_type)) }}</div>
                                </div>
                            </div>
                            <div class="cc-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <div>
                                    <div class="cc-meta-label">Location</div>
                                    <div class="cc-meta-val">{{ $job->location }} {{ $job->remote ? '(Remote)' : '' }}</div>
                                </div>
                            </div>
                            <div class="cc-meta-item">
                                <i class="fas fa-money-bill-wave"></i>
                                <div>
                                    <div class="cc-meta-label">Salary Range</div>
                                    <div class="cc-meta-val">₹{{ number_format($job->min_salary) }} –
                                        ₹{{ number_format($job->max_salary) }}</div>
                                </div>
                            </div>
                            <div class="cc-meta-item">
                                <i class="fas fa-graduation-cap"></i>
                                <div>
                                    <div class="cc-meta-label">Experience Level</div>
                                    <div class="cc-meta-val">{{ $job->experience_level ?? 'Any Level' }}</div>
                                </div>
                            </div>
                            @if($job->posted_at)
                                <div class="cc-meta-item">
                                    <i class="fas fa-calendar-alt"></i>
                                    <div>
                                        <div class="cc-meta-label">Posted</div>
                                        <div class="cc-meta-val">{{ $job->posted_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                            @endif
                            @if($job->company)
                                <div class="cc-meta-item">
                                    <i class="fas fa-building"></i>
                                    <div>
                                        <div class="cc-meta-label">Company</div>
                                        <div class="cc-meta-val">
                                            @if($job->company->slug)
                                                <a href="{{ route('companies.show', $job->company->slug) }}"
                                                    class="text-blue-600 hover:underline">{{ $job->company->name }}</a>
                                            @else
                                                {{ $job->company->name }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>{{-- end left --}}

                {{-- RIGHT COLUMN --}}
                <div class="w-full lg:w-[37%] space-y-5 lg:sticky lg:top-24 self-start">

                    {{-- Action card --}}
                    <div class="cc-card">
                        <h3 class="text-base font-bold text-gray-800 mb-4">Apply for this Job</h3>

                        @auth
                            @if($hasApplied)
                                <button disabled class="cc-btn-outline applied-state mb-3" id="applyBtn">
                                    <i class="fas fa-circle-check"></i> Already Applied
                                </button>
                            @else
                                <form action="{{ route('jobs.apply', $job->id) }}" method="POST" id="applyForm">
                                    @csrf
                                    <button type="button" id="applyBtn" onclick="handleApply()" class="cc-btn-primary mb-3">
                                        <i class="fas fa-paper-plane"></i> Submit Application
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="cc-btn-primary mb-3">
                                <i class="fas fa-right-to-bracket"></i> Login to Apply
                            </a>
                            <p class="text-xs text-center text-gray-400 mb-3">
                                No account? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Register
                                    free</a>
                            </p>
                        @endauth

                        <button id="saveBtn" onclick="toggleSave()" class="cc-btn-outline mb-3">
                            <i id="heartIcon" class="far fa-heart"></i>
                            <span id="saveLabel">Save Job</span>
                        </button>

                        <button onclick="openShareModal()" class="cc-btn-ghost">
                            <i class="fas fa-share-nodes"></i> Share this listing
                        </button>
                    </div>

                    {{-- Company card --}}
                    @if($job->company)
                        <div class="cc-card">
                            <h3 class="cc-section-title" style="border:none;padding-bottom:0;margin-bottom:.75rem;">
                                <i class="fas fa-building"></i> About the Company
                            </h3>
                            <div class="flex items-center gap-3 mb-3">
                                @if($job->company->logo)
                                    <img src="{{ asset('storage/' . $job->company->logo) }}" alt="{{ $job->company->name }}"
                                        class="w-12 h-12 object-contain rounded-xl border border-gray-100">
                                @else
                                    <div
                                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center">
                                        <span
                                            class="text-white font-bold text-lg">{{ strtoupper(substr($job->company->name, 0, 1)) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $job->company->name }}</p>
                                    @if($job->company->location)
                                        <p class="text-xs text-gray-400"><i
                                                class="fas fa-map-marker-alt mr-1"></i>{{ $job->company->location }}</p>
                                    @endif
                                </div>
                            </div>
                            @if($job->company->description)
                                <p class="text-sm text-gray-600 leading-relaxed line-clamp-3">{{ $job->company->description }}</p>
                            @endif
                            @if($job->company->slug)
                                <a href="{{ route('companies.show', $job->company->slug) }}"
                                    class="mt-3 block text-center text-sm text-blue-600 hover:underline font-semibold">
                                    View Company Profile →
                                </a>
                            @endif
                        </div>
                    @endif

                    {{-- Similar jobs --}}
                    @if($similar->count() > 0)
                        <div class="cc-card">
                            <h3 class="cc-section-title" style="border:none;padding-bottom:0;margin-bottom:.9rem;">
                                <i class="fas fa-layer-group"></i> Similar Jobs
                            </h3>
                            <div class="space-y-3">
                                @foreach($similar as $sim)
                                    <a href="{{ route('jobs.show', $sim->slug) }}" class="cc-sim-card">
                                        <p class="font-bold text-sm text-gray-900">{{ $sim->title }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $sim->company->name ?? 'Unknown Company' }}</p>
                                        <div class="flex flex-wrap items-center gap-2 mt-2">
                                            <span class="cc-badge cc-badge-gray" style="font-size:.67rem;">
                                                ₹{{ number_format($sim->min_salary) }}–₹{{ number_format($sim->max_salary) }}
                                            </span>
                                            <span class="cc-badge cc-badge-indigo" style="font-size:.67rem;">
                                                {{ ucfirst(str_replace('-', ' ', $sim->job_type)) }}
                                            </span>
                                            @if($sim->remote)
                                                <span class="cc-badge cc-badge-green" style="font-size:.67rem;">Remote</span>
                                            @endif
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                            <a href="{{ route('jobs.index') }}"
                                class="mt-4 block text-center text-sm text-blue-600 hover:underline font-semibold">
                                Browse all jobs →
                            </a>
                        </div>
                    @endif

                </div>{{-- end right --}}
            </div>
        </div>
    </div>

    {{-- ── SHARE MODAL ──────────────────────────────────────────────────── --}}
    <div class="cc-modal-overlay" id="shareModal" onclick="closeShareOnBackdrop(event)">
        <div class="cc-modal" role="dialog" aria-modal="true">
            <div class="cc-modal-header">
                <span class="cc-modal-title"><i class="fas fa-share-nodes text-blue-500 mr-2"></i>Share this Job</span>
                <button class="cc-modal-close" onclick="closeShareModal()"><i class="fas fa-xmark"></i></button>
            </div>
            <p class="text-sm text-gray-500 mb-4">Share via your favourite platform</p>
            <div class="cc-share-grid">
                <a href="https://wa.me/?text={{ urlencode($job->title . ' at ' . ($job->company->name ?? '') . ' — ' . url()->current()) }}"
                    target="_blank" class="cc-share-btn wa">
                    <i class="fab fa-whatsapp" style="color:#25d366;"></i> WhatsApp
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"
                    class="cc-share-btn fb">
                    <i class="fab fa-facebook-f" style="color:#1877f2;"></i> Facebook
                </a>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode('Check out: ' . $job->title . ' at ' . ($job->company->name ?? '')) }}&url={{ urlencode(url()->current()) }}"
                    target="_blank" class="cc-share-btn tw">
                    <i class="fab fa-x-twitter" style="color:#000;"></i> Twitter
                </a>
                <button class="cc-share-btn cp" onclick="copyLink()">
                    <i class="fas fa-link" style="color:#6366f1;"></i> Copy Link
                </button>
            </div>
            <div class="cc-copy-wrap">
                <input type="text" id="shareLinkInput" value="{{ url()->current() }}" readonly>
                <button onclick="copyLink()"><i class="fas fa-copy mr-1"></i> Copy</button>
            </div>
        </div>
    </div>

    {{-- ── TOAST CONTAINER ─────────────────────────────────────────────── --}}
    <div class="cc-toast-wrap" id="toastWrap"></div>

    <script>
        /* Animated progress */
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.cc-progress-fill').forEach(bar => {
                const w = bar.dataset.width || 0;
                setTimeout(() => { bar.style.width = w + '%'; }, 300);
            });
        });

        /* Toast */
        function showToast(msg, type = 'success', icon = 'fa-circle-check') {
            const wrap = document.getElementById('toastWrap');
            const t = document.createElement('div');
            t.className = `cc-toast ${type}`;
            t.innerHTML = `<i class="fas ${icon}"></i><span>${msg}</span>`;
            wrap.appendChild(t);
            requestAnimationFrame(() => requestAnimationFrame(() => t.classList.add('show')));
            setTimeout(() => { t.classList.remove('show'); setTimeout(() => t.remove(), 400); }, 3500);
        }

        /* Apply */
        function handleApply() {
            const btn = document.getElementById('applyBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting…';
            setTimeout(() => {
                document.getElementById('applyForm')?.submit();
            }, 800);
        }

        /* Save toggle */
        let saved = false;
        function toggleSave() {
            saved = !saved;
            const btn = document.getElementById('saveBtn');
            const icon = document.getElementById('heartIcon');
            const lbl = document.getElementById('saveLabel');
            if (saved) {
                btn.classList.add('saved'); icon.classList.replace('far', 'fas'); lbl.textContent = 'Saved!';
                showToast('Job saved to your list ❤️', 'success', 'fa-heart');
            } else {
                btn.classList.remove('saved'); icon.classList.replace('fas', 'far'); lbl.textContent = 'Save Job';
                showToast('Removed from saved list', 'info', 'fa-heart-crack');
            }
        }

        /* Share modal */
        function openShareModal() { document.getElementById('shareModal').classList.add('open'); }
        function closeShareModal() { document.getElementById('shareModal').classList.remove('open'); }
        function closeShareOnBackdrop(e) { if (e.target.id === 'shareModal') closeShareModal(); }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeShareModal(); });

        /* Copy link */
        function copyLink() {
            const input = document.getElementById('shareLinkInput');
            navigator.clipboard.writeText(input.value)
                .then(() => showToast('Link copied to clipboard! 🔗', 'info', 'fa-link'))
                .catch(() => { input.select(); document.execCommand('copy'); showToast('Link copied!', 'info', 'fa-link'); });
        }
    </script>

@endsection