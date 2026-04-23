@extends('layouts.public')
@section('title', 'My Profile — CareerConnect')

@section('content')
<style>
/* ══════════════════════════════════════════════════════════
   PROFILE DASHBOARD — Design Tokens
══════════════════════════════════════════════════════════ */
.pd-wrap {
    max-width: 1100px; margin: 0 auto;
    padding: 2rem 1.25rem 4rem;
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 1.5rem;
    align-items: start;
}
@media(max-width: 900px) { .pd-wrap { grid-template-columns: 1fr; } }

/* ── SIDEBAR ── */
.pd-sidebar {
    position: sticky; top: 82px;
    display: flex; flex-direction: column; gap: 1rem;
}
@media(max-width: 900px) { .pd-sidebar { position: static; } }

.pd-profile-card {
    background: var(--cc-surface);
    border-radius: 20px;
    border: 1.5px solid var(--cc-border);
    overflow: hidden;
    box-shadow: var(--cc-shadow-sm);
}

/* Hero gradient header */
.pd-avatar-section {
    background: linear-gradient(135deg, #1e3a8a 0%, #4c1d95 60%, #2563eb 100%);
    padding: 2rem 1.25rem 1.5rem;
    text-align: center; position: relative;
}
.pd-avatar-ring {
    width: 80px; height: 80px; border-radius: 50%;
    background: linear-gradient(135deg, #60a5fa, #a78bfa);
    border: 3px solid rgba(255,255,255,.5);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.9rem; font-weight: 900; color: #fff;
    margin: 0 auto 1rem;
    box-shadow: 0 8px 24px rgba(0,0,0,.3);
    position: relative;
    cursor: pointer; transition: transform .2s;
}
.pd-avatar-ring:hover { transform: scale(1.05); }
.pd-avatar-edit {
    position: absolute; bottom: 0; right: 0;
    width: 24px; height: 24px; border-radius: 50%;
    background: #fff; color: #1e3a8a;
    display: flex; align-items: center; justify-content: center;
    font-size: .65rem; box-shadow: 0 2px 8px rgba(0,0,0,.2);
}
.pd-name { font-size: 1rem; font-weight: 800; color: #fff; margin-bottom: .2rem; }
.pd-email { font-size: .76rem; color: rgba(255,255,255,.65); }
.pd-status-pill {
    display: inline-flex; align-items: center; gap: .4rem;
    margin-top: .85rem; padding: .3rem .9rem; border-radius: 99px;
    font-size: .72rem; font-weight: 700; border: 1px solid rgba(255,255,255,.25);
}
.pd-status-complete   { background: rgba(34,197,94,.2); color: #86efac; }
.pd-status-incomplete { background: rgba(239,68,68,.2);  color: #fca5a5; }

/* Profile completion bar */
.pd-completion-bar-wrap {
    padding: .9rem 1.25rem; border-bottom: 1px solid var(--cc-border);
    background: var(--cc-surface-2);
}
.pd-completion-label { font-size: .72rem; font-weight: 700; color: var(--cc-text-muted); text-transform: uppercase; letter-spacing: .06em; margin-bottom: .5rem; display:flex; justify-content:space-between; }
.pd-completion-track { height: 6px; background: var(--cc-border); border-radius: 99px; overflow: hidden; }
.pd-completion-fill  { height: 100%; border-radius: 99px; background: linear-gradient(90deg, #22c55e, #16a34a); transition: width 1s cubic-bezier(.4,0,.2,1); }

/* Sidebar Nav */
.pd-nav { padding: .75rem; }
.pd-nav-link {
    display: flex; align-items: center; gap: .65rem;
    padding: .65rem .85rem; border-radius: 12px;
    font-size: .85rem; font-weight: 600; color: var(--cc-text-muted);
    text-decoration: none; transition: all .15s; margin-bottom: .2rem;
}
.pd-nav-link i { width: 18px; text-align: center; font-size: .85rem; }
.pd-nav-link:hover { background: rgba(37,99,235,.07); color: var(--cc-primary); }
.pd-nav-link.active { background: linear-gradient(135deg, rgba(37,99,235,.12), rgba(124,58,237,.1)); color: var(--cc-primary); font-weight: 700; }
.pd-nav-link.danger:hover { background: #fff1f2; color: #dc2626; }
.pd-nav-link.danger { color: #ef4444; }
.pd-nav-divider { height: 1px; background: var(--cc-border); margin: .5rem 0; }

/* Quick stats sidebar */
.pd-quick-stats {
    background: var(--cc-surface); border-radius: 16px;
    border: 1.5px solid var(--cc-border); padding: 1rem;
    display: grid; grid-template-columns: 1fr 1fr; gap: .6rem;
}
.pd-qs-item { background: var(--cc-surface-2); border-radius: 10px; padding: .7rem; text-align: center; }
.pd-qs-num { font-size: 1.3rem; font-weight: 900; background: var(--cc-gradient); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }
.pd-qs-lbl { font-size: .68rem; color: var(--cc-text-light); font-weight: 600; text-transform: uppercase; letter-spacing: .04em; margin-top: .15rem; }

/* ── MAIN CONTENT ── */
.pd-main { display: flex; flex-direction: column; gap: 1.25rem; }

/* Page header */
.pd-page-header {
    display: flex; justify-content: space-between; align-items: flex-start;
    flex-wrap: wrap; gap: 1rem;
}
.pd-page-title { font-size: 1.5rem; font-weight: 900; letter-spacing: -.03em; color: var(--cc-text); }
.pd-page-sub   { font-size: .85rem; color: var(--cc-text-muted); margin-top: .2rem; }

/* Incomplete alert */
.pd-alert {
    display: flex; align-items: flex-start; gap: .85rem;
    padding: 1rem 1.25rem; border-radius: 14px; font-size: .875rem;
}
.pd-alert-warn { background: #fffbeb; border: 1.5px solid #fde68a; color: #92400e; }
.pd-alert-success { background: #f0fdf4; border: 1.5px solid #bbf7d0; color: #166534; }
.pd-alert i { margin-top: 1px; flex-shrink: 0; }

/* Form section cards */
.pd-section-card {
    background: var(--cc-surface);
    border-radius: 20px;
    border: 1.5px solid var(--cc-border);
    overflow: hidden;
    box-shadow: var(--cc-shadow-sm);
    transition: box-shadow .22s, transform .22s;
}
.pd-section-card:hover { box-shadow: var(--cc-shadow); }

.pd-card-header {
    padding: 1rem 1.4rem;
    display: flex; align-items: center; gap: .75rem;
    border-bottom: 1px solid var(--cc-border);
    background: var(--cc-surface-2);
}
.pd-card-icon {
    width: 36px; height: 36px; border-radius: 10px;
    background: var(--cc-gradient);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: .9rem; flex-shrink: 0;
}
.pd-card-title { font-size: .9rem; font-weight: 800; color: var(--cc-text); }
.pd-card-sub   { font-size: .75rem; color: var(--cc-text-light); }
.pd-card-body  { padding: 1.5rem; }

/* Form labels & inputs */
.pd-label {
    display: block; font-size: .8rem; font-weight: 700;
    color: var(--cc-text); margin-bottom: .55rem;
    text-transform: uppercase; letter-spacing: .05em;
}
.pd-label span { color: var(--cc-text-light); font-weight: 500; text-transform: none; letter-spacing: 0; font-size: .76rem; }

.pd-input {
    width: 100%; background: var(--cc-surface-2);
    border: 1.5px solid var(--cc-border); border-radius: 12px;
    padding: .75rem 1rem; font-size: .9rem; color: var(--cc-text);
    font-family: var(--cc-font); outline: none;
    transition: border-color .18s, box-shadow .18s;
}
.pd-input:focus {
    border-color: var(--cc-primary);
    box-shadow: 0 0 0 4px rgba(37,99,235,.1);
}
.pd-input::placeholder { color: var(--cc-text-light); }

/* Bio textarea with counter */
.pd-bio-wrap { position: relative; }
.pd-bio { resize: none; min-height: 130px; line-height: 1.65; }
.pd-char-counter {
    position: absolute; bottom: .7rem; right: .9rem;
    font-size: .7rem; font-weight: 700; color: var(--cc-text-light);
    background: var(--cc-surface-2); padding: 2px 7px; border-radius: 6px;
    pointer-events: none;
}
.pd-char-counter.warn  { color: #d97706; }
.pd-char-counter.error { color: #dc2626; }

/* ── SKILL TAG INPUT ── */
.pd-skill-box {
    background: var(--cc-surface-2); border: 1.5px solid var(--cc-border);
    border-radius: 12px; padding: .6rem .75rem;
    display: flex; flex-wrap: wrap; gap: .5rem; align-items: center;
    cursor: text; transition: border-color .18s, box-shadow .18s;
    min-height: 52px;
}
.pd-skill-box.focused {
    border-color: var(--cc-primary);
    box-shadow: 0 0 0 4px rgba(37,99,235,.1);
}
.pd-skill-tag {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .3rem .75rem; border-radius: 99px;
    background: linear-gradient(135deg, rgba(37,99,235,.12), rgba(124,58,237,.1));
    border: 1px solid rgba(37,99,235,.25);
    color: var(--cc-primary); font-size: .78rem; font-weight: 700;
    animation: cc-tag-in .2s cubic-bezier(.34,1.56,.64,1) both;
}
@keyframes cc-tag-in { from { transform: scale(.6); opacity: 0; } to { transform: scale(1); opacity: 1; } }
.pd-tag-remove {
    background: none; border: none; cursor: pointer;
    color: var(--cc-primary); font-size: .75rem; padding: 0;
    line-height: 1; opacity: .6; transition: opacity .15s;
}
.pd-tag-remove:hover { opacity: 1; }
.pd-skill-input {
    flex: 1; min-width: 120px; background: transparent;
    border: none; outline: none; font-size: .87rem;
    color: var(--cc-text); font-family: var(--cc-font);
}
.pd-skill-input::placeholder { color: var(--cc-text-light); }
.pd-skill-hint { font-size: .74rem; color: var(--cc-text-light); margin-top: .5rem; }

/* ── RESUME UPLOAD ── */
.pd-upload-zone {
    border: 2px dashed var(--cc-border); border-radius: 16px;
    padding: 2.5rem 1.5rem; text-align: center; cursor: pointer;
    transition: border-color .2s, background .2s, transform .2s;
    position: relative; overflow: hidden;
}
.pd-upload-zone:hover, .pd-upload-zone.drag-over {
    border-color: var(--cc-primary);
    background: rgba(37,99,235,.04);
    transform: scale(1.01);
}
.pd-upload-zone.drag-over { border-style: solid; background: rgba(37,99,235,.08); }
.pd-upload-icon {
    width: 64px; height: 64px; border-radius: 18px; margin: 0 auto .85rem;
    background: linear-gradient(135deg, rgba(37,99,235,.12), rgba(124,58,237,.1));
    display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
    color: var(--cc-primary); transition: transform .2s;
}
.pd-upload-zone:hover .pd-upload-icon { transform: translateY(-4px) scale(1.08); }
.pd-upload-title  { font-size: .95rem; font-weight: 700; color: var(--cc-text); margin-bottom: .35rem; }
.pd-upload-hint   { font-size: .8rem; color: var(--cc-text-light); }
.pd-upload-input  { display: none; }
.pd-browse-link   { color: var(--cc-primary); font-weight: 700; cursor: pointer; }

/* File preview */
.pd-file-preview {
    display: flex; align-items: center; gap: .85rem;
    background: #f0fdf4; border: 1.5px solid #bbf7d0;
    border-radius: 12px; padding: .85rem 1rem;
    margin-top: .85rem; animation: cc-tag-in .3s cubic-bezier(.34,1.56,.64,1) both;
}
.pd-file-icon { width: 40px; height: 40px; border-radius: 10px; background: #dcfce7; display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:1rem; color:#16a34a; }
.pd-file-name { font-size: .85rem; font-weight: 700; color: #166534; flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.pd-file-size { font-size: .72rem; color: #22c55e; }
.pd-file-actions { display: flex; gap: .5rem; }
.pd-file-btn { background: none; border: 1px solid #16a34a; color: #16a34a; border-radius: 7px; padding: .25rem .6rem; font-size: .72rem; font-weight: 700; cursor: pointer; font-family: var(--cc-font); text-decoration: none; transition: all .15s; display: inline-flex; align-items: center; gap: .3rem; }
.pd-file-btn:hover { background: #16a34a; color: #fff; }

/* Error messages */
.pd-error { font-size: .78rem; color: #dc2626; margin-top: .45rem; display: flex; align-items: center; gap: .35rem; }
.pd-error i { font-size: .72rem; }

/* ── SAVE BUTTON ── */
.pd-save-btn {
    width: 100%; padding: .9rem 1.5rem; border-radius: 14px;
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    color: #fff; font-size: .95rem; font-weight: 800;
    border: none; cursor: pointer; font-family: var(--cc-font);
    display: flex; align-items: center; justify-content: center; gap: .6rem;
    box-shadow: 0 6px 20px rgba(37,99,235,.35);
    transition: box-shadow .2s, transform .2s;
    position: relative; overflow: hidden;
}
.pd-save-btn::before {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,.15), transparent);
    opacity: 0; transition: opacity .2s;
}
.pd-save-btn:hover { box-shadow: 0 12px 32px rgba(37,99,235,.45); transform: translateY(-2px); }
.pd-save-btn:hover::before { opacity: 1; }
.pd-save-btn:active { transform: translateY(0) scale(.99); }
.pd-save-btn:disabled { opacity: .65; cursor: not-allowed; transform: none; }

/* Spinner */
@keyframes spin { to { transform: rotate(360deg); } }
.pd-spinner { animation: spin .7s linear infinite; }

/* Section divider */
.pd-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
@media(max-width:600px){ .pd-form-row { grid-template-columns: 1fr; } }

/* Page hero strip */
.pd-page-hero {
    background: linear-gradient(135deg, #1e293b 0%, #1e1b4b 100%);
    padding: 2rem 1.5rem 3.5rem; position: relative; overflow: hidden;
    margin-bottom: -2rem;
}
.pd-page-hero::after {
    content:''; position:absolute; bottom:-1px; left:0; right:0;
    height:50px; background:var(--cc-bg); clip-path:ellipse(55% 100% at 50% 100%);
}
.pd-page-hero h1 { position: relative; z-index:1; font-size:1.4rem; font-weight:900; color:#fff; letter-spacing:-.03em; }
.pd-page-hero p  { position: relative; z-index:1; color:#94a3b8; font-size:.88rem; margin-top:.25rem; }
.pd-hero-orb {
    position:absolute; border-radius:50%; filter:blur(60px); pointer-events:none;
}
</style>

{{-- Page Hero --}}
<div class="pd-page-hero">
    <div class="pd-hero-orb" style="width:300px;height:300px;background:rgba(99,102,241,.2);top:-100px;right:-50px;"></div>
    <div style="max-width:1100px;margin:0 auto;padding:0 1.25rem;">
        <div style="display:flex;align-items:center;gap:.75rem;">
            <div style="width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,#2563eb,#7c3aed);display:flex;align-items:center;justify-content:center;font-size:1rem;color:#fff;flex-shrink:0;">
                <i class="fas fa-user-circle"></i>
            </div>
            <div>
                <h1 class="pd-page-hero" style="background:none;padding:0;margin:0;">Profile Settings</h1>
                <p style="color:#94a3b8;font-size:.83rem;margin:0;">Complete your profile to get matched with top opportunities.</p>
            </div>
        </div>
    </div>
</div>

<div class="pd-wrap">

    {{-- ═══════════════════ SIDEBAR ═══════════════════ --}}
    <aside class="pd-sidebar">

        {{-- Profile Card --}}
        <div class="pd-profile-card">
            <div class="pd-avatar-section">
                <div class="pd-avatar-ring" title="Edit photo">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    <div class="pd-avatar-edit"><i class="fas fa-pen"></i></div>
                </div>
                <div class="pd-name">{{ auth()->user()->name }}</div>
                <div class="pd-email">{{ auth()->user()->email }}</div>
                @if($profile->resume_path && count($profile->skills ?? []))
                    <span class="pd-status-pill pd-status-complete">
                        <i class="fas fa-circle-check"></i> Profile Complete
                    </span>
                @else
                    <span class="pd-status-pill pd-status-incomplete">
                        <i class="fas fa-circle-exclamation"></i> Incomplete
                    </span>
                @endif
            </div>

            {{-- Completion bar --}}
            @php
                $completionSteps = 0;
                if($profile->bio)         $completionSteps++;
                if(count($profile->skills ?? [])) $completionSteps++;
                if($profile->resume_path) $completionSteps++;
                $completionPct = round(($completionSteps / 3) * 100);
            @endphp
            <div class="pd-completion-bar-wrap">
                <div class="pd-completion-label">
                    <span>Profile Strength</span>
                    <span style="color:{{ $completionPct==100 ? '#16a34a' : 'inherit' }};">{{ $completionPct }}%</span>
                </div>
                <div class="pd-completion-track">
                    <div class="pd-completion-fill" id="completionFill" data-width="{{ $completionPct }}" style="width:0%"></div>
                </div>
            </div>

            {{-- Nav --}}
            <nav class="pd-nav">
                <a href="{{ route('candidate.profile') }}" class="pd-nav-link active">
                    <i class="fas fa-user-edit"></i> Edit Profile
                </a>
                <a href="{{ route('candidate.applications') }}" class="pd-nav-link">
                    <i class="fas fa-briefcase"></i> My Applications
                    @auth
                        @php $appCount = auth()->user()->applications()->count(); @endphp
                        @if($appCount)
                            <span style="margin-left:auto;background:rgba(37,99,235,.1);color:var(--cc-primary);font-size:.68rem;font-weight:800;padding:2px 7px;border-radius:99px;">{{ $appCount }}</span>
                        @endif
                    @endauth
                </a>
                <a href="{{ route('jobs.index') }}" class="pd-nav-link">
                    <i class="fas fa-search"></i> Browse Jobs
                </a>
                <a href="{{ route('home') }}" class="pd-nav-link">
                    <i class="fas fa-house"></i> Home
                </a>
                <div class="pd-nav-divider"></div>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="pd-nav-link danger" style="width:100%;text-align:left;background:none;border:none;cursor:pointer;font-family:var(--cc-font);">
                        <i class="fas fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </nav>
        </div>

        {{-- Quick Stats --}}
        <div class="pd-quick-stats">
            <div class="pd-qs-item">
                <div class="pd-qs-num">{{ auth()->user()->applications()->count() }}</div>
                <div class="pd-qs-lbl">Applied</div>
            </div>
            <div class="pd-qs-item">
                <div class="pd-qs-num">{{ count($profile->skills ?? []) }}</div>
                <div class="pd-qs-lbl">Skills</div>
            </div>
            <div class="pd-qs-item">
                <div class="pd-qs-num">{{ $profile->resume_path ? '✓' : '—' }}</div>
                <div class="pd-qs-lbl">Resume</div>
            </div>
            <div class="pd-qs-item">
                <div class="pd-qs-num">{{ $completionPct }}%</div>
                <div class="pd-qs-lbl">Complete</div>
            </div>
        </div>
    </aside>

    {{-- ═══════════════════ MAIN ═══════════════════ --}}
    <div class="pd-main">

        {{-- Alert Banner --}}
        @if(session('success'))
            <div class="pd-alert pd-alert-success">
                <i class="fas fa-circle-check" style="color:#16a34a;margin-top:1px;"></i>
                <div>
                    <div style="font-weight:800;font-size:.88rem;">Profile Updated ✓</div>
                    <div style="font-size:.82rem;margin-top:.15rem;opacity:.85;">{{ session('success') }}</div>
                </div>
            </div>
        @endif

        @if(!$profile->resume_path || empty($profile->skills))
            <div class="pd-alert pd-alert-warn">
                <i class="fas fa-triangle-exclamation" style="color:#d97706;"></i>
                <div>
                    <div style="font-weight:800;font-size:.88rem;">Profile Incomplete</div>
                    <div style="font-size:.82rem;margin-top:.2rem;">
                        Add your <strong>Skills</strong>
                        @if(!$profile->resume_path) and upload a <strong>Resume PDF</strong> @endif
                        to start applying for jobs.
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('candidate.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
            @csrf

            {{-- ── SECTION 1: Professional Bio ── --}}
            <div class="pd-section-card" style="margin-bottom:1.25rem;">
                <div class="pd-card-header">
                    <div class="pd-card-icon"><i class="fas fa-align-left"></i></div>
                    <div>
                        <div class="pd-card-title">Professional Bio</div>
                        <div class="pd-card-sub">Tell recruiters about yourself</div>
                    </div>
                </div>
                <div class="pd-card-body">
                    <label class="pd-label" for="bioField">About You <span>(max 1000 characters)</span></label>
                    <div class="pd-bio-wrap">
                        <textarea
                            id="bioField"
                            name="bio"
                            rows="5"
                            class="pd-input pd-bio"
                            placeholder="Write a compelling professional summary — your experience, skills, career goals, and what makes you stand out…"
                            maxlength="1000"
                            oninput="updateBioCounter(this)">{{ old('bio', $profile->bio) }}</textarea>
                        <span class="pd-char-counter" id="bioCounter">0/1000</span>
                    </div>
                    @error('bio')
                        <div class="pd-error"><i class="fas fa-circle-xmark"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- ── SECTION 2: Core Skills ── --}}
            <div class="pd-section-card" style="margin-bottom:1.25rem;">
                <div class="pd-card-header">
                    <div class="pd-card-icon" style="background:linear-gradient(135deg,#059669,#0891b2);"><i class="fas fa-code"></i></div>
                    <div>
                        <div class="pd-card-title">Core Skills</div>
                        <div class="pd-card-sub">Add skills to improve job matches</div>
                    </div>
                </div>
                <div class="pd-card-body">
                    <label class="pd-label">Your Skills <span>(type & press Enter or comma to add)</span></label>

                    {{-- Hidden input that stores skills JSON for form submission --}}
                    <input type="hidden" name="skills" id="skillsHidden" value="{{ old('skills', is_array($profile->skills) ? implode(', ', $profile->skills) : '') }}">

                    <div class="pd-skill-box" id="skillBox" onclick="document.getElementById('skillInput').focus()">
                        <div id="tagContainer" style="display:contents;">
                            {{-- Tags will be rendered by JS --}}
                        </div>
                        <input
                            type="text"
                            id="skillInput"
                            class="pd-skill-input"
                            placeholder="e.g. Laravel, React…"
                            autocomplete="off">
                    </div>
                    <div class="pd-skill-hint">
                        <i class="fas fa-lightbulb" style="color:#d97706;font-size:.7rem;"></i>
                        Press <kbd style="background:var(--cc-border);padding:1px 5px;border-radius:4px;font-size:.7rem;">Enter</kbd> or
                        <kbd style="background:var(--cc-border);padding:1px 5px;border-radius:4px;font-size:.7rem;">,</kbd> to add a skill. Click × to remove.
                    </div>

                    @error('skills')
                        <div class="pd-error"><i class="fas fa-circle-xmark"></i> {{ $message }}</div>
                    @enderror

                    {{-- Suggested skills --}}
                    <div style="margin-top:.9rem;">
                        <div style="font-size:.72rem;font-weight:700;color:var(--cc-text-light);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.45rem;">Suggested</div>
                        <div style="display:flex;flex-wrap:wrap;gap:.4rem;" id="suggestedSkills">
                            @foreach(['Laravel','React','Vue.js','Python','Java','UI/UX','MySQL','Docker','Node.js','TypeScript','PHP','WordPress'] as $sugg)
                                <button type="button" onclick="addSuggestedSkill('{{ $sugg }}')"
                                    class="pd-skill-sugg"
                                    style="background:var(--cc-surface-2);border:1px solid var(--cc-border);color:var(--cc-text-muted);padding:3px 10px;border-radius:99px;font-size:.74rem;font-weight:600;cursor:pointer;font-family:var(--cc-font);transition:all .15s;"
                                    onmouseover="this.style.borderColor='var(--cc-primary)';this.style.color='var(--cc-primary)';"
                                    onmouseout="this.style.borderColor='var(--cc-border)';this.style.color='var(--cc-text-muted)';">
                                    + {{ $sugg }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── SECTION 3: Resume Upload ── --}}
            <div class="pd-section-card" style="margin-bottom:1.25rem;">
                <div class="pd-card-header">
                    <div class="pd-card-icon" style="background:linear-gradient(135deg,#dc2626,#be123c);"><i class="fas fa-file-pdf"></i></div>
                    <div>
                        <div class="pd-card-title">Resume / CV</div>
                        <div class="pd-card-sub">PDF format only, max 5MB</div>
                    </div>
                </div>
                <div class="pd-card-body">

                    {{-- Current resume --}}
                    @if($profile->resume_path)
                        <div class="pd-file-preview" id="existingResume">
                            <div class="pd-file-icon"><i class="fas fa-file-pdf"></i></div>
                            <div style="flex:1;min-width:0;">
                                <div class="pd-file-name">resume_{{ auth()->user()->id }}.pdf</div>
                                <div class="pd-file-size">Currently active</div>
                            </div>
                            <div class="pd-file-actions">
                                <a href="{{ Storage::url($profile->resume_path) }}" target="_blank" class="pd-file-btn">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </div>
                        </div>
                        <div style="font-size:.77rem;color:var(--cc-text-light);text-align:center;margin:.65rem 0;">or upload a new version</div>
                    @endif

                    {{-- Upload zone --}}
                    <div class="pd-upload-zone" id="uploadZone" onclick="document.getElementById('resumeInput').click()">
                        <div class="pd-upload-icon"><i class="fas fa-cloud-arrow-up"></i></div>
                        <div class="pd-upload-title">
                            Drag & drop your resume or
                            <span class="pd-browse-link">browse files</span>
                        </div>
                        <div class="pd-upload-hint">Supported: .pdf · Max size: 5MB</div>
                        <input type="file" name="resume" id="resumeInput" class="pd-upload-input" accept=".pdf">
                    </div>

                    {{-- New file preview --}}
                    <div id="newFilePreview" style="display:none;"></div>

                    @error('resume')
                        <div class="pd-error"><i class="fas fa-circle-xmark"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- ── SAVE BUTTON ── --}}
            <button type="submit" class="pd-save-btn" id="saveBtn">
                <i class="fas fa-floppy-disk"></i> Save Profile Changes
            </button>

        </form>
    </div>
</div>

<script>
/* ══════════════════════════════════════════════════
   PROFILE PAGE JS
══════════════════════════════════════════════════ */

/* ── Bio character counter ── */
function updateBioCounter(el) {
    const len = el.value.length;
    const counter = document.getElementById('bioCounter');
    counter.textContent = `${len}/1000`;
    counter.className = 'pd-char-counter' + (len > 900 ? ' warn' : '') + (len >= 1000 ? ' error' : '');
}
// Init on load
document.addEventListener('DOMContentLoaded', () => {
    const bio = document.getElementById('bioField');
    if (bio) updateBioCounter(bio);

    // Animate completion bar
    const fill = document.getElementById('completionFill');
    if (fill) setTimeout(() => fill.style.width = fill.dataset.width + '%', 400);

    // Init skill tags from hidden input
    const existing = document.getElementById('skillsHidden').value;
    if (existing) {
        existing.split(',').map(s => s.trim()).filter(Boolean).forEach(addTag);
    }
});

/* ── Skill Tag System ── */
let skills = [];

function syncSkillsHidden() {
    document.getElementById('skillsHidden').value = skills.join(', ');
}

function addTag(skill) {
    const s = skill.trim();
    if (!s || skills.includes(s)) return;
    skills.push(s);
    renderTags();
    syncSkillsHidden();
}

function removeTag(skill) {
    skills = skills.filter(s => s !== skill);
    renderTags();
    syncSkillsHidden();
}

function renderTags() {
    const container = document.getElementById('tagContainer');
    container.innerHTML = '';
    skills.forEach(skill => {
        const tag = document.createElement('span');
        tag.className = 'pd-skill-tag';
        tag.innerHTML = `${skill} <button type="button" class="pd-tag-remove" onclick="removeTag('${skill.replace(/'/g, "\\'")}')"><i class="fas fa-xmark"></i></button>`;
        container.appendChild(tag);
    });
}

// Skill input events
document.addEventListener('DOMContentLoaded', () => {
    const skillBox   = document.getElementById('skillBox');
    const skillInput = document.getElementById('skillInput');

    skillInput.addEventListener('focus', () => skillBox.classList.add('focused'));
    skillInput.addEventListener('blur',  () => skillBox.classList.remove('focused'));

    skillInput.addEventListener('keydown', e => {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            addTag(skillInput.value);
            skillInput.value = '';
        } else if (e.key === 'Backspace' && skillInput.value === '' && skills.length) {
            removeTag(skills[skills.length - 1]);
        }
    });
    skillInput.addEventListener('blur', () => {
        if (skillInput.value.trim()) {
            addTag(skillInput.value);
            skillInput.value = '';
        }
    });
});

function addSuggestedSkill(s) { addTag(s); }

/* ── Resume Upload / Drag & Drop ── */
document.addEventListener('DOMContentLoaded', () => {
    const zone  = document.getElementById('uploadZone');
    const input = document.getElementById('resumeInput');

    ['dragenter','dragover'].forEach(evt => {
        zone.addEventListener(evt, e => { e.preventDefault(); zone.classList.add('drag-over'); });
    });
    ['dragleave','drop'].forEach(evt => {
        zone.addEventListener(evt, e => {
            e.preventDefault(); zone.classList.remove('drag-over');
        });
    });
    zone.addEventListener('drop', e => {
        const file = e.dataTransfer.files[0];
        if (file) showFilePreview(file);
    });
    input.addEventListener('change', () => {
        if (input.files[0]) showFilePreview(input.files[0]);
    });
});

function showFilePreview(file) {
    if (!file.name.endsWith('.pdf')) {
        showToast('Only PDF files are accepted!', 'error'); return;
    }
    if (file.size > 5 * 1024 * 1024) {
        showToast('File too large — max 5MB!', 'error'); return;
    }
    const sizeMB = (file.size / (1024*1024)).toFixed(2);
    const preview = document.getElementById('newFilePreview');
    preview.style.display = 'block';
    preview.innerHTML = `
        <div class="pd-file-preview">
            <div class="pd-file-icon"><i class="fas fa-file-pdf"></i></div>
            <div style="flex:1;min-width:0;">
                <div class="pd-file-name">${file.name}</div>
                <div class="pd-file-size">${sizeMB} MB · Ready to upload</div>
            </div>
            <div class="pd-file-actions">
                <button type="button" class="pd-file-btn"
                    onclick="document.getElementById('newFilePreview').style.display='none';document.getElementById('resumeInput').value='';">
                    <i class="fas fa-xmark"></i> Remove
                </button>
            </div>
        </div>`;
    showToast('Resume ready to upload!', 'success');
}

/* ── Save button loading state ── */
document.getElementById('profileForm').addEventListener('submit', function(e) {
    const btn = document.getElementById('saveBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-circle-notch pd-spinner"></i> Saving…';
});

/* ── Session success toast ── */
@if(session('success'))
    document.addEventListener('DOMContentLoaded', () => {
        showToast('{{ session('success') }}', 'success');
    });
@endif
</script>
@endsection
