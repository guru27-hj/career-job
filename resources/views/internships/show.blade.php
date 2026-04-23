@extends('layouts.public')

@section('content')

{{-- ── PAGE-SCOPED STYLES ──────────────────────────────────────────────── --}}
<style>
  /* Google Font */
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

  .cc-page { font-family: 'Inter', sans-serif; background: #f4f6fb; min-height: 100vh; }

  /* ── Hero banner ── */
  .cc-hero {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 60%, #06b6d4 100%);
    padding: 2.5rem 0 4rem;
    position: relative;
    overflow: hidden;
  }
  .cc-hero::after {
    content: '';
    position: absolute;
    bottom: -1px; left: 0; right: 0;
    height: 60px;
    background: #f4f6fb;
    clip-path: ellipse(55% 100% at 50% 100%);
  }
  .cc-hero-inner { position: relative; z-index: 1; }

  /* ── Cards ── */
  .cc-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 16px rgba(0,0,0,.07);
    padding: 1.75rem;
    transition: box-shadow .2s;
  }
  .cc-card:hover { box-shadow: 0 6px 28px rgba(0,0,0,.11); }

  /* ── Badge pills ── */
  .cc-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 13px; border-radius: 999px; font-size: .78rem; font-weight: 600;
  }
  .cc-badge-gray  { background: #f1f5f9; color: #475569; }
  .cc-badge-blue  { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
  .cc-badge-green { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
  .cc-badge-red   { background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
  .cc-badge-amber { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }

  /* ── Section heading ── */
  .cc-section-title {
    font-size: 1.05rem; font-weight: 700; color: #1e293b;
    display: flex; align-items: center; gap: 8px;
    padding-bottom: 10px; border-bottom: 2px solid #f1f5f9; margin-bottom: 1rem;
  }
  .cc-section-title i { color: #3b82f6; font-size: .95rem; }

  /* ── Numbered list ── */
  .cc-list { list-style: none; padding: 0; margin: 0; }
  .cc-list li {
    padding: 8px 0 8px 28px; position: relative;
    color: #475569; font-size: .9rem; line-height: 1.6;
    border-bottom: 1px solid #f8fafc;
  }
  .cc-list li:last-child { border-bottom: none; }
  .cc-list li::before {
    content: ''; position: absolute; left: 6px; top: 50%;
    transform: translateY(-50%);
    width: 7px; height: 7px; border-radius: 50%;
    background: #3b82f6;
  }

  /* ── Detail grid ── */
  .cc-meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; }
  @media(max-width:500px){ .cc-meta-grid { grid-template-columns: 1fr; } }
  .cc-meta-item {
    background: #f8fafc; border: 1px solid #e2e8f0;
    border-radius: 12px; padding: 12px 14px;
    display: flex; align-items: flex-start; gap: 10px;
  }
  .cc-meta-item i { color: #3b82f6; margin-top: 2px; font-size: .9rem; min-width: 16px; text-align: center; }
  .cc-meta-label { font-size: .7rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; }
  .cc-meta-val   { font-size: .88rem; font-weight: 600; color: #1e293b; margin-top: 2px; }

  /* ── Primary button ── */
  .cc-btn-primary {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 13px 20px; border-radius: 12px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff; font-weight: 700; font-size: .92rem;
    border: none; cursor: pointer;
    box-shadow: 0 4px 14px rgba(37,99,235,.35);
    transition: transform .15s, box-shadow .15s, background .15s;
  }
  .cc-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(37,99,235,.45); background: linear-gradient(135deg,#1d4ed8,#1e40af); color:#fff; }
  .cc-btn-primary:active { transform: translateY(0); }

  /* ── Secondary / outline button ── */
  .cc-btn-outline {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 11px 20px; border-radius: 12px;
    background: #fff; color: #374151;
    border: 1.5px solid #e2e8f0; font-weight: 600; font-size: .9rem;
    cursor: pointer; transition: border-color .15s, background .15s, color .15s, transform .15s;
  }
  .cc-btn-outline:hover { border-color: #3b82f6; color: #2563eb; background: #eff6ff; transform: translateY(-1px); }
  .cc-btn-outline.saved { border-color: #ef4444; color: #ef4444; background: #fff1f2; }
  .cc-btn-outline.saved i { color: #ef4444; }

  /* ── Share ghost button ── */
  .cc-btn-ghost {
    display: flex; align-items: center; justify-content: center; gap: 7px;
    width: 100%; padding: 9px 16px; border-radius: 10px;
    background: none; border: none; color: #64748b; font-weight: 600; font-size: .88rem;
    cursor: pointer; transition: background .15s, color .15s;
  }
  .cc-btn-ghost:hover { background: #f1f5f9; color: #2563eb; }

  /* ── Progress bar ── */
  .cc-progress-track {
    background: #e2e8f0; border-radius: 999px; height: 8px; overflow: hidden;
  }
  .cc-progress-fill {
    height: 100%; border-radius: 999px;
    background: linear-gradient(90deg, #22c55e, #16a34a);
    width: 0%;
    transition: width 1.1s cubic-bezier(.4,0,.2,1);
  }

  /* ── Similar cards ── */
  .cc-sim-card {
    display: block; padding: 13px 14px; border-radius: 12px;
    border: 1.5px solid #e2e8f0; text-decoration: none;
    transition: border-color .15s, box-shadow .15s, transform .15s;
  }
  .cc-sim-card:hover { border-color: #93c5fd; box-shadow: 0 4px 14px rgba(59,130,246,.12); transform: translateY(-2px); }
  .cc-sim-title { font-size: .9rem; font-weight: 700; color: #1e293b; }
  .cc-sim-company { font-size: .78rem; color: #64748b; margin-top: 3px; }

  /* ── SHARE MODAL ── */
  .cc-modal-overlay {
    position: fixed; inset: 0; z-index: 9998;
    background: rgba(15,23,42,.55); backdrop-filter: blur(4px);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; pointer-events: none;
    transition: opacity .25s;
  }
  .cc-modal-overlay.open { opacity: 1; pointer-events: all; }

  .cc-modal {
    background: #fff; border-radius: 20px;
    padding: 2rem; width: 92%; max-width: 420px;
    box-shadow: 0 24px 60px rgba(0,0,0,.2);
    transform: translateY(20px) scale(.97);
    transition: transform .3s cubic-bezier(.34,1.56,.64,1), opacity .25s;
  }
  .cc-modal-overlay.open .cc-modal { transform: translateY(0) scale(1); }

  .cc-modal-header {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 1.4rem;
  }
  .cc-modal-title { font-size: 1.1rem; font-weight: 700; color: #1e293b; }
  .cc-modal-close {
    background: #f1f5f9; border: none; border-radius: 50%;
    width: 34px; height: 34px; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: #64748b; transition: background .15s, color .15s;
  }
  .cc-modal-close:hover { background: #e2e8f0; color: #1e293b; }

  .cc-share-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: .75rem; }
  .cc-share-btn {
    display: flex; flex-direction: column; align-items: center; gap: 7px;
    padding: 14px 8px; border-radius: 14px; border: 1.5px solid #e2e8f0;
    background: #fff; cursor: pointer; text-decoration: none;
    font-size: .72rem; font-weight: 600; color: #475569;
    transition: transform .15s, box-shadow .15s, border-color .15s;
  }
  .cc-share-btn:hover { transform: translateY(-3px); box-shadow: 0 6px 16px rgba(0,0,0,.1); border-color: transparent; }
  .cc-share-btn i { font-size: 1.3rem; }
  .cc-share-btn.wa  { --c:#25d366; }
  .cc-share-btn.fb  { --c:#1877f2; }
  .cc-share-btn.tw  { --c:#000; }
  .cc-share-btn.cp  { --c:#6366f1; }
  .cc-share-btn:hover i { color: var(--c); }
  .cc-share-btn:hover { border-color: var(--c); background: color-mix(in srgb, var(--c) 6%, white); }

  /* copy link input */
  .cc-copy-wrap {
    display: flex; margin-top: 1.1rem; border-radius: 10px;
    border: 1.5px solid #e2e8f0; overflow: hidden;
  }
  .cc-copy-wrap input {
    flex: 1; padding: 9px 12px; font-size: .82rem; color: #475569;
    border: none; outline: none; background: #f8fafc;
  }
  .cc-copy-wrap button {
    padding: 9px 16px; background: #2563eb; color: #fff;
    border: none; font-size: .8rem; font-weight: 700; cursor: pointer;
    transition: background .15s;
  }
  .cc-copy-wrap button:hover { background: #1d4ed8; }

  /* ── TOAST ── */
  .cc-toast-wrap {
    position: fixed; bottom: 28px; right: 28px; z-index: 9999;
    display: flex; flex-direction: column; gap: 10px; pointer-events: none;
  }
  .cc-toast {
    display: flex; align-items: center; gap: 10px;
    background: #1e293b; color: #fff;
    padding: 12px 18px; border-radius: 12px;
    font-size: .88rem; font-weight: 600;
    box-shadow: 0 8px 24px rgba(0,0,0,.25);
    transform: translateX(100px); opacity: 0;
    transition: transform .35s cubic-bezier(.34,1.56,.64,1), opacity .3s;
    pointer-events: all; max-width: 320px;
  }
  .cc-toast.show { transform: translateX(0); opacity: 1; }
  .cc-toast i { font-size: 1rem; }
  .cc-toast.success i { color: #4ade80; }
  .cc-toast.info    i { color: #60a5fa; }
  .cc-toast.error   i { color: #f87171; }
</style>

<div class="cc-page">

  {{-- ── HERO BANNER ──────────────────────────────────────────────────── --}}
  <div class="cc-hero">
    <div class="container mx-auto px-4 cc-hero-inner">
      {{-- Breadcrumb --}}
      <nav class="text-blue-200 text-sm mb-5 flex items-center gap-2">
        <a href="{{ route('internships.index') }}" class="hover:text-white transition">Internships</a>
        <i class="fas fa-chevron-right text-xs opacity-60"></i>
        <span class="text-white font-medium truncate max-w-xs">{{ $internship->title }}</span>
      </nav>

      <div class="flex flex-wrap items-start gap-5">
        {{-- Company logo avatar --}}
        @php $companyName = $internship->company->name ?? 'Unknown'; @endphp
        <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center text-white text-2xl font-bold shadow-lg flex-shrink-0">
          {{ strtoupper(substr($companyName, 0, 1)) }}
        </div>

        <div class="flex-1 min-w-0">
          <h1 class="text-2xl md:text-3xl font-extrabold text-white leading-tight mb-1">
            {{ $internship->title }}
          </h1>
          <p class="text-blue-100 text-base font-medium flex items-center gap-2 flex-wrap">
            <i class="fas fa-building text-blue-300 text-sm"></i>
            {{ $companyName }}
            <span class="opacity-40">·</span>
            <i class="fas fa-map-marker-alt text-blue-300 text-sm"></i>
            {{ $internship->location }}
            @if($internship->remote)
              <span class="cc-badge" style="background:rgba(255,255,255,.15);color:#fff;font-size:.7rem;">Remote</span>
            @endif
          </p>

          {{-- Quick badges --}}
          <div class="flex flex-wrap gap-2 mt-3">
            @if($internship->min_salary || $internship->max_salary)
              <span class="cc-badge" style="background:rgba(255,255,255,.18);color:#fff;">
                <i class="fas fa-rupee-sign text-xs"></i>
                ₹{{ number_format($internship->min_salary) }} – ₹{{ number_format($internship->max_salary) }}/mo
              </span>
            @endif
            @if($internship->duration)
              <span class="cc-badge" style="background:rgba(255,255,255,.18);color:#fff;">
                <i class="fas fa-clock text-xs"></i> {{ $internship->duration }}
              </span>
            @endif
            @if(isset($internship->match_percentage) && $internship->match_percentage)
              <span class="cc-badge" style="background:#fef9c3;color:#713f12;">
                🔥 {{ $internship->match_percentage }}% Match
              </span>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ── MAIN CONTENT ────────────────────────────────────────────────── --}}
  <div class="container mx-auto px-4 pb-12" style="margin-top: -2.5rem;">
    <div class="flex flex-col lg:flex-row gap-6 items-start">

      {{-- ════════════════════════════════════════════════════════════
           LEFT COLUMN – Details
      ════════════════════════════════════════════════════════════ --}}
      <div class="w-full lg:w-[63%] space-y-5">

        {{-- Overview card --}}
        <div class="cc-card">
          <h2 class="cc-section-title"><i class="fas fa-align-left"></i> Internship Overview</h2>
          <p class="text-gray-600 text-sm leading-relaxed">{!! nl2br(e($internship->description)) !!}</p>
        </div>

        {{-- Responsibilities --}}
        <div class="cc-card">
          <h2 class="cc-section-title"><i class="fas fa-tasks"></i> Responsibilities</h2>
          <ul class="cc-list">
            <li>Assist in development of web applications and features</li>
            <li>Collaborate with cross-functional team members daily</li>
            <li>Write clean, maintainable, and testable code</li>
            <li>Participate in code reviews and sprint planning</li>
            <li>Document technical processes and solutions</li>
          </ul>
        </div>

        {{-- Requirements --}}
        <div class="cc-card">
          <h2 class="cc-section-title"><i class="fas fa-clipboard-check"></i> Requirements</h2>
          <ul class="cc-list">
            <li>Knowledge of relevant technologies listed in skills</li>
            <li>Good verbal and written communication skills</li>
            <li>Ability to work effectively in a team environment</li>
            <li>Basic understanding of version control (Git)</li>
            <li>Eagerness to learn and adapt quickly</li>
          </ul>
        </div>

        {{-- Skills --}}
        @php
          $skillsArray = is_array($internship->skills)
            ? $internship->skills
            : (json_decode($internship->skills, true) ?? []);
        @endphp
        @if(count($skillsArray))
          <div class="cc-card">
            <h2 class="cc-section-title"><i class="fas fa-code"></i> Skills Required</h2>
            <div class="flex flex-wrap gap-2">
              @foreach($skillsArray as $skill)
                <span class="cc-badge cc-badge-blue">{{ $skill }}</span>
              @endforeach
            </div>
          </div>
        @endif

        {{-- Additional Info --}}
        <div class="cc-card">
          <h2 class="cc-section-title"><i class="fas fa-info-circle"></i> Additional Details</h2>
          <div class="cc-meta-grid">
            <div class="cc-meta-item">
              <i class="fas fa-calendar-check"></i>
              <div><div class="cc-meta-label">Start Date</div><div class="cc-meta-val">Immediate</div></div>
            </div>
            <div class="cc-meta-item">
              <i class="fas fa-hourglass-half"></i>
              <div><div class="cc-meta-label">Duration</div><div class="cc-meta-val">{{ $internship->duration ?? 'Standard' }}</div></div>
            </div>
            <div class="cc-meta-item">
              <i class="fas fa-laptop-house"></i>
              <div><div class="cc-meta-label">Work Mode</div><div class="cc-meta-val">{{ $internship->remote ? 'Remote' : 'On-Site' }}</div></div>
            </div>
            <div class="cc-meta-item">
              <i class="fas fa-certificate"></i>
              <div><div class="cc-meta-label">Certificate</div><div class="cc-meta-val">{{ $internship->certificate_included ? 'Yes, Provided' : 'Not Provided' }}</div></div>
            </div>
            <div class="cc-meta-item">
              <i class="fas fa-graduation-cap"></i>
              <div><div class="cc-meta-label">Experience Level</div><div class="cc-meta-val">{{ $internship->experience_level ?? 'Any Level' }}</div></div>
            </div>
            @if($internship->company)
              <div class="cc-meta-item">
                <i class="fas fa-building"></i>
                <div>
                  <div class="cc-meta-label">Company</div>
                  <div class="cc-meta-val">
                    @if($internship->company->slug)
                      <a href="{{ route('companies.show', $internship->company->slug) }}" class="text-blue-600 hover:underline">{{ $internship->company->name }}</a>
                    @else
                      {{ $internship->company->name }}
                    @endif
                  </div>
                </div>
              </div>
            @endif
          </div>
        </div>

      </div>

      {{-- ════════════════════════════════════════════════════════════
           RIGHT COLUMN – Action Panel (sticky)
      ════════════════════════════════════════════════════════════ --}}
      <div class="w-full lg:w-[37%] space-y-5 lg:sticky lg:top-24 self-start">

        {{-- ── ACTION CARD ──────────────────────────────────────── --}}
        <div class="cc-card">
          <h3 class="text-base font-bold text-gray-800 mb-4">Apply for this Internship</h3>

          @auth
            {{-- CSRF meta for AJAX --}}
            <meta name="csrf-token" content="{{ csrf_token() }}">

            @php
              $alreadyApplied = auth()->user()
                ->applications()
                ->where('job_id', $internship->id)
                ->exists();
            @endphp

            {{-- Submit Application Button --}}
            <button
              id="applyBtn"
              onclick="handleApply()"
              class="cc-btn-primary mb-3"
              @if($alreadyApplied) disabled style="background:linear-gradient(135deg,#16a34a,#15803d);cursor:not-allowed;" @endif>
              @if($alreadyApplied)
                <i class="fas fa-circle-check"></i> Already Applied
              @else
                <i class="fas fa-paper-plane"></i> Submit Application
              @endif
            </button>

            @if($alreadyApplied)
              <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:.75rem 1rem;margin-bottom:.75rem;display:flex;align-items:center;gap:.55rem;font-size:.82rem;font-weight:600;color:#166534;">
                <i class="fas fa-circle-check" style="color:#16a34a;"></i>
                Application submitted — we'll notify you of updates.
              </div>
            @endif

          @else
            {{-- Not logged in —  redirect to login --}}
            <a href="{{ route('login') }}" class="cc-btn-primary mb-3" style="text-decoration:none;">
              <i class="fas fa-right-to-bracket"></i> Login to Apply
            </a>
          @endauth

          {{-- Save --}}
          <button
            id="saveBtn"
            onclick="toggleSave()"
            class="cc-btn-outline mb-3">
            <i id="heartIcon" class="far fa-heart"></i>
            <span id="saveLabel">Save Internship</span>
          </button>

          {{-- Share --}}
          <button
            onclick="openShareModal()"
            class="cc-btn-ghost">
            <i class="fas fa-share-nodes"></i> Share this listing
          </button>
        </div>

        {{-- ── MATCH ANALYSIS ───────────────────────────────────── --}}
        @if(isset($internship->match_percentage))
          <div class="cc-card">
            <h3 class="cc-section-title" style="border:none;padding-bottom:0;margin-bottom:.75rem;">
              <i class="fas fa-chart-line"></i> Match Analysis
            </h3>
            <div class="flex justify-between items-center text-sm mb-2">
              <span class="text-gray-500">Your profile match</span>
              <span class="font-bold text-gray-800" id="matchPct">{{ $internship->match_percentage }}%</span>
            </div>
            <div class="cc-progress-track mb-3">
              <div class="cc-progress-fill" id="progressBar" data-width="{{ $internship->match_percentage }}"></div>
            </div>

            @php
              $userSkills = session('user_skills', ['HTML', 'CSS', 'Laravel']);
              $missing = array_diff($skillsArray, $userSkills);
              $matched = array_intersect($skillsArray, $userSkills);
            @endphp

            @if(count($matched))
              <p class="text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">Matched skills</p>
              <div class="flex flex-wrap gap-1.5 mb-3">
                @foreach($matched as $s)
                  <span class="cc-badge cc-badge-green" style="font-size:.7rem;">
                    <i class="fas fa-check text-xs"></i> {{ $s }}
                  </span>
                @endforeach
              </div>
            @endif

            @if(count($missing))
              <p class="text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">Missing skills</p>
              <div class="flex flex-wrap gap-1.5">
                @foreach($missing as $s)
                  <span class="cc-badge cc-badge-red" style="font-size:.7rem;">{{ $s }}</span>
                @endforeach
              </div>
            @else
              <p class="text-sm text-green-700 bg-green-50 border border-green-100 rounded-xl px-3 py-2 font-semibold">
                <i class="fas fa-circle-check mr-1.5"></i> You have all required skills!
              </p>
            @endif
          </div>
        @endif

        {{-- ── SIMILAR INTERNSHIPS ──────────────────────────────── --}}
        @if(isset($similar) && $similar->count() > 0)
          <div class="cc-card">
            <h3 class="cc-section-title" style="border:none;padding-bottom:0;margin-bottom:.9rem;">
              <i class="fas fa-layer-group"></i> Similar Internships
            </h3>
            <div class="space-y-3">
              @foreach($similar as $sim)
                <a href="{{ route('internships.show', $sim->slug) }}" class="cc-sim-card">
                  <p class="cc-sim-title">{{ $sim->title }}</p>
                  <p class="cc-sim-company">{{ $sim->company->name ?? 'Unknown Company' }}</p>
                  <div class="flex flex-wrap items-center gap-2 mt-2">
                    @if($sim->min_salary)
                      <span class="cc-badge cc-badge-gray" style="font-size:.67rem;">
                        ₹{{ number_format($sim->min_salary) }}/mo
                      </span>
                    @endif
                    @if($sim->duration)
                      <span class="cc-badge cc-badge-gray" style="font-size:.67rem;">
                        <i class="fas fa-clock text-xs"></i> {{ $sim->duration }}
                      </span>
                    @endif
                    @if(isset($sim->match_percentage) && $sim->match_percentage > 0)
                      <span class="cc-badge cc-badge-green" style="font-size:.67rem;">
                        {{ $sim->match_percentage }}% Match
                      </span>
                    @endif
                  </div>
                </a>
              @endforeach
            </div>
          </div>
        @endif

      </div>{{-- end right --}}
    </div>{{-- end row --}}
  </div>{{-- end container --}}
</div>{{-- end .cc-page --}}

{{-- ═══════════════════════════════════════════════════════════════════
     SHARE MODAL
════════════════════════════════════════════════════════════════════ --}}
<div class="cc-modal-overlay" id="shareModal" onclick="closeShareOnBackdrop(event)">
  <div class="cc-modal" role="dialog" aria-modal="true" aria-label="Share Internship">
    <div class="cc-modal-header">
      <span class="cc-modal-title"><i class="fas fa-share-nodes text-blue-500 mr-2"></i>Share this Internship</span>
      <button class="cc-modal-close" onclick="closeShareModal()" aria-label="Close">
        <i class="fas fa-xmark"></i>
      </button>
    </div>

    <p class="text-sm text-gray-500 mb-4">Share via your favourite platform</p>

    <div class="cc-share-grid">
      {{-- WhatsApp --}}
      <a href="https://wa.me/?text={{ urlencode($internship->title . ' at ' . ($internship->company->name ?? '') . ' — ' . url()->current()) }}"
         target="_blank" class="cc-share-btn wa">
        <i class="fab fa-whatsapp" style="color:#25d366;"></i>
        WhatsApp
      </a>
      {{-- Facebook --}}
      <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
         target="_blank" class="cc-share-btn fb">
        <i class="fab fa-facebook-f" style="color:#1877f2;"></i>
        Facebook
      </a>
      {{-- Twitter / X --}}
      <a href="https://twitter.com/intent/tweet?text={{ urlencode('Apply for ' . $internship->title . ' at ' . ($internship->company->name ?? '') . url()->current()) }}"
         target="_blank" class="cc-share-btn tw">
        <i class="fab fa-x-twitter" style="color:#000;"></i>
        Twitter
      </a>
      {{-- Copy Link --}}
      <button class="cc-share-btn cp" onclick="copyLink()">
        <i class="fas fa-link" style="color:#6366f1;"></i>
        Copy Link
      </button>
    </div>

    {{-- URL copy bar --}}
    <div class="cc-copy-wrap">
      <input type="text" id="shareLinkInput" value="{{ url()->current() }}" readonly>
      <button onclick="copyLink()"><i class="fas fa-copy mr-1"></i> Copy</button>
    </div>
  </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════════
     TOAST CONTAINER
════════════════════════════════════════════════════════════════════ --}}
<div class="cc-toast-wrap" id="toastWrap"></div>

{{-- ═══════════════════════════════════════════════════════════════════
     SCRIPTS
════════════════════════════════════════════════════════════════════ --}}
<script>
  /* ── Animated progress bar on load ── */
  document.addEventListener('DOMContentLoaded', () => {
    const bar = document.getElementById('progressBar');
    if (bar) {
      const target = bar.dataset.width || 0;
      setTimeout(() => { bar.style.width = target + '%'; }, 300);
    }
  });

  /* ── Toast helper ── */
  function showToast(msg, type = 'success', icon = 'fa-circle-check') {
    const wrap = document.getElementById('toastWrap');
    const t = document.createElement('div');
    t.className = `cc-toast ${type}`;
    t.innerHTML = `<i class="fas ${icon}"></i><span>${msg}</span>`;
    wrap.appendChild(t);
    requestAnimationFrame(() => { requestAnimationFrame(() => { t.classList.add('show'); }); });
    setTimeout(() => {
      t.classList.remove('show');
      setTimeout(() => t.remove(), 400);
    }, 3500);
  }

  /* ── Apply (AJAX) ── */
  const APPLY_URL  = '{{ route('internships.apply', $internship->slug) }}';
  const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content
                     || '{{ csrf_token() }}';
  const IS_AUTH    = {{ auth()->check() ? 'true' : 'false' }};
  const LOGIN_URL  = '{{ route('login') }}';
  const PROFILE_URL= '{{ route('candidate.profile') }}';

  function setAppliedState() {
    const btn = document.getElementById('applyBtn');
    if (!btn) return;
    btn.disabled = true;
    btn.style.background = 'linear-gradient(135deg,#16a34a,#15803d)';
    btn.style.cursor = 'not-allowed';
    btn.innerHTML = '<i class="fas fa-circle-check"></i> Already Applied';
  }

  async function handleApply() {
    if (!IS_AUTH) {
      window.location.href = LOGIN_URL;
      return;
    }

    const btn = document.getElementById('applyBtn');
    if (btn.disabled) return;

    // Loading state
    btn.disabled = true;
    const original = btn.innerHTML;
    btn.innerHTML  = '<i class="fas fa-spinner fa-spin"></i> Submitting…';

    try {
      const res  = await fetch(APPLY_URL, {
        method:  'POST',
        headers: {
          'Content-Type':     'application/json',
          'Accept':           'application/json',
          'X-CSRF-TOKEN':     CSRF_TOKEN,
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({}),
      });

      const data = await res.json();

      if (res.status === 201) {
        // Success
        setAppliedState();
        showToast(data.message || 'Application submitted! 🎉', 'success', 'fa-circle-check');
        // Inject confirmation banner
        const card = btn.closest('.cc-card');
        if (card && !card.querySelector('.applied-banner')) {
          const banner = document.createElement('div');
          banner.className = 'applied-banner';
          banner.style.cssText = 'background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:.75rem 1rem;margin-top:.75rem;display:flex;align-items:center;gap:.55rem;font-size:.82rem;font-weight:600;color:#166534;';
          banner.innerHTML = '<i class="fas fa-circle-check" style="color:#16a34a;"></i> Application submitted — we\'ll notify you of updates.';
          card.appendChild(banner);
        }
      } else if (res.status === 409) {
        // Already applied
        setAppliedState();
        showToast(data.message || 'Already applied!', 'info', 'fa-circle-info');
      } else if (res.status === 422) {
        // Incomplete profile
        btn.disabled = false;
        btn.innerHTML = original;
        showToast(data.message || 'Please complete your profile first.', 'error', 'fa-triangle-exclamation');
        setTimeout(() => { window.location.href = PROFILE_URL; }, 1800);
      } else if (res.status === 401) {
        // Unauthenticated
        showToast('Please log in to apply.', 'error', 'fa-lock');
        setTimeout(() => { window.location.href = data.redirect || LOGIN_URL; }, 1500);
      } else {
        btn.disabled = false;
        btn.innerHTML = original;
        showToast(data.message || 'Something went wrong. Please try again.', 'error', 'fa-circle-xmark');
      }
    } catch (err) {
      btn.disabled = false;
      btn.innerHTML = original;
      showToast('Network error. Please check your connection.', 'error', 'fa-wifi');
    }
  }

  /* ── Save / Unsave ── */
  let saved = false;
  function toggleSave() {
    saved = !saved;
    const btn  = document.getElementById('saveBtn');
    const icon = document.getElementById('heartIcon');
    const lbl  = document.getElementById('saveLabel');
    if (saved) {
      btn.classList.add('saved');
      icon.classList.replace('far', 'fas');
      lbl.textContent = 'Saved!';
      showToast('Internship saved to your list ❤️', 'success', 'fa-heart');
    } else {
      btn.classList.remove('saved');
      icon.classList.replace('fas', 'far');
      lbl.textContent = 'Save Internship';
      showToast('Removed from saved list', 'info', 'fa-heart-crack');
    }
  }

  /* ── Share modal ── */
  function openShareModal()  { document.getElementById('shareModal').classList.add('open'); }
  function closeShareModal() { document.getElementById('shareModal').classList.remove('open'); }
  function closeShareOnBackdrop(e) {
    if (e.target === document.getElementById('shareModal')) closeShareModal();
  }
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeShareModal(); });

  /* ── Copy link ── */
  function copyLink() {
    const input = document.getElementById('shareLinkInput');
    navigator.clipboard.writeText(input.value).then(() => {
      showToast('Link copied to clipboard! 🔗', 'info', 'fa-link');
    }).catch(() => {
      input.select(); document.execCommand('copy');
      showToast('Link copied!', 'info', 'fa-link');
    });
  }
</script>

@endsection
