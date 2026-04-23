@extends('layouts.admin')
@section('title', 'Applicants — ' . $job->title)

@section('content')
<style>
/* ── Match Ring ── */
.match-ring { position:relative; width:52px; height:52px; flex-shrink:0; }
.match-ring svg { transform: rotate(-90deg); }
.match-ring-track { fill:none; stroke:rgba(255,255,255,.08); stroke-width:4; }
.match-ring-fill  { fill:none; stroke-width:4; stroke-linecap:round; transition: stroke-dashoffset .6s ease; }
.match-ring-label { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; font-size:.62rem; font-weight:900; }

/* ── Progress Bar ── */
.match-bar { height:5px; border-radius:99px; background:rgba(255,255,255,.08); overflow:hidden; margin-top:4px; }
.match-bar-fill { height:100%; border-radius:99px; transition:width .6s ease; }

/* ── Skill chips ── */
.skill-chip { display:inline-flex; align-items:center; font-size:.63rem; font-weight:700;
    padding:2px 8px; border-radius:99px; margin:2px; }
.skill-matched { background:rgba(34,197,94,.12); color:#86efac; border:1px solid rgba(34,197,94,.2); }
.skill-missing  { background:rgba(239,68,68,.08); color:#fca5a5; border:1px solid rgba(239,68,68,.15);
    text-decoration:line-through; opacity:.75; }

/* ── Status badge ── */
.sta { display:inline-flex; align-items:center; gap:.3rem; font-size:.68rem; font-weight:700;
       padding:3px 9px; border-radius:99px; }
.sta-pending     { background:rgba(245,158,11,.12); color:#fcd34d; border:1px solid rgba(245,158,11,.2); }
.sta-shortlisted { background:rgba(59,130,246,.12); color:#93c5fd; border:1px solid rgba(59,130,246,.2); }
.sta-hired       { background:rgba(34,197,94,.12);  color:#86efac; border:1px solid rgba(34,197,94,.2); }
.sta-rejected    { background:rgba(239,68,68,.1);   color:#fca5a5; border:1px solid rgba(239,68,68,.18); }

/* ── Card ── */
.app-card { background:var(--adm-surface); border:1px solid var(--adm-border); border-radius:14px;
            padding:1.1rem 1.25rem; display:flex; gap:1rem; align-items:flex-start;
            transition:border-color .18s, transform .18s; }
.app-card:hover { border-color:rgba(59,130,246,.3); transform:translateY(-1px); }
.app-avatar { width:40px; height:40px; border-radius:10px; flex-shrink:0;
              background:linear-gradient(135deg,#3b82f6,#8b5cf6);
              display:flex; align-items:center; justify-content:center;
              font-weight:900; font-size:.9rem; color:#fff; }

/* ── Filter ── */
.af-bar { display:flex; flex-wrap:wrap; gap:.6rem; background:var(--adm-surface);
          border:1px solid var(--adm-border); border-radius:12px; padding:.8rem 1rem;
          margin-bottom:1.25rem; align-items:center; }
.af-input { background:rgba(255,255,255,.05); border:1px solid var(--adm-border);
            border-radius:8px; padding:.45rem .8rem; font-size:.8rem;
            color:var(--adm-text); font-family:'Inter',sans-serif; outline:none; }
.af-input:focus { border-color:rgba(59,130,246,.5); }

/* ── Stat mini card ── */
.sm-stat { background:var(--adm-surface); border:1px solid var(--adm-border);
           border-radius:10px; padding:.75rem 1rem; text-align:center; flex:1; min-width:90px; }
.sm-stat-n { font-size:1.4rem; font-weight:900; letter-spacing:-.04em; }
.sm-stat-l { font-size:.62rem; font-weight:700; text-transform:uppercase;
             letter-spacing:.06em; color:var(--adm-text-light); }
</style>

{{-- Breadcrumb --}}
<div class="adm-breadcrumb">
    <a href="{{ route('admin.dashboard') }}"><i class="fas fa-house" style="font-size:.65rem;"></i></a>
    <span class="sep">/</span>
    <a href="{{ route('admin.jobs.index') }}">Jobs</a>
    <span class="sep">/</span>
    <span class="active">Applicants</span>
</div>

{{-- Page header --}}
<div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.4rem;font-weight:900;letter-spacing:-.04em;color:#f1f5f9;margin:0;">
            Applicants for <span style="color:#93c5fd;">{{ $job->title }}</span>
        </h1>
        <p style="font-size:.83rem;color:var(--adm-text-muted);margin:.3rem 0 0;">
            {{ $job->company->name ?? '' }} &middot; {{ ucfirst(str_replace('-',' ',$job->job_type)) }}
            @if($job->location) &middot; {{ $job->location }} @endif
        </p>
    </div>
    <a href="{{ route('admin.jobs.show', $job) }}" class="adm-btn adm-btn-ghost adm-btn-sm">
        <i class="fas fa-arrow-left"></i> Back to Job
    </a>
</div>

@if(session('success'))
    <div class="mb-4 flex items-center gap-3 bg-green-900/30 border border-green-700/40 text-green-300 px-4 py-3 rounded-xl text-sm">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

{{-- ══ STAT CARDS ══ --}}
<div style="display:flex;flex-wrap:wrap;gap:.75rem;margin-bottom:1.5rem;">
    <div class="sm-stat"><div class="sm-stat-n" style="background:var(--adm-gradient);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;">{{ $stats['total'] }}</div><div class="sm-stat-l">Total</div></div>
    <div class="sm-stat"><div class="sm-stat-n" style="color:#fcd34d;">{{ $stats['pending'] }}</div><div class="sm-stat-l">Pending</div></div>
    <div class="sm-stat"><div class="sm-stat-n" style="color:#93c5fd;">{{ $stats['shortlisted'] }}</div><div class="sm-stat-l">Shortlisted</div></div>
    <div class="sm-stat"><div class="sm-stat-n" style="color:#86efac;">{{ $stats['hired'] }}</div><div class="sm-stat-l">Hired</div></div>
    <div class="sm-stat"><div class="sm-stat-n" style="color:#fca5a5;">{{ $stats['rejected'] }}</div><div class="sm-stat-l">Rejected</div></div>
    <div class="sm-stat"><div class="sm-stat-n" style="color:#c4b5fd;">{{ $stats['avg_match'] }}%</div><div class="sm-stat-l">Avg Match</div></div>
</div>

{{-- Required Skills --}}
@if(!empty($jobSkills))
<div style="margin-bottom:1.25rem;">
    <span style="font-size:.7rem;font-weight:800;text-transform:uppercase;letter-spacing:.06em;color:var(--adm-text-light);margin-right:.5rem;">Required Skills:</span>
    @foreach($jobSkills as $sk)
        <span class="skill-chip" style="background:rgba(139,92,246,.12);color:#c4b5fd;border:1px solid rgba(139,92,246,.2);">{{ $sk }}</span>
    @endforeach
</div>
@endif

{{-- ══ FILTER BAR ══ --}}
<form method="GET" action="{{ route('admin.jobs.applicants', $job) }}">
<div class="af-bar">
    <input type="text" name="search" class="af-input" placeholder="Search name or email…"
           value="{{ request('search') }}" style="flex:1;min-width:180px;">

    <select name="status" class="af-input" onchange="this.form.submit()">
        <option value="">All Statuses</option>
        @foreach(['pending','shortlisted','hired','rejected'] as $s)
            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
        @endforeach
    </select>

    <select name="min_match" class="af-input" onchange="this.form.submit()">
        <option value="">Any Match %</option>
        <option value="25"  {{ request('min_match') == 25  ? 'selected' : '' }}>≥ 25%</option>
        <option value="50"  {{ request('min_match') == 50  ? 'selected' : '' }}>≥ 50%</option>
        <option value="75"  {{ request('min_match') == 75  ? 'selected' : '' }}>≥ 75%</option>
        <option value="100" {{ request('min_match') == 100 ? 'selected' : '' }}>100% Match</option>
    </select>

    <button type="submit" class="adm-btn adm-btn-primary adm-btn-sm"><i class="fas fa-filter"></i> Filter</button>
    @if(request()->hasAny(['search','status','min_match']))
        <a href="{{ route('admin.jobs.applicants', $job) }}" class="adm-btn adm-btn-ghost adm-btn-sm" style="color:#f87171;">
            <i class="fas fa-xmark"></i> Clear
        </a>
    @endif
    <span style="margin-left:auto;font-size:.75rem;color:var(--adm-text-light);">
        {{ $applications->count() }} applicant{{ $applications->count() !== 1 ? 's' : '' }}
    </span>
</div>
</form>

{{-- ══ APPLICANT CARDS ══ --}}
<div style="display:flex;flex-direction:column;gap:.85rem;">
    @forelse($applications as $app)
    @php
        $pct   = $app->match_pct;
        $color = $pct >= 70 ? '#22c55e' : ($pct >= 40 ? '#f59e0b' : '#ef4444');
        $circ  = 2 * M_PI * 22; // r=22 → circumference=~138.2
        $dash  = round($circ * $pct / 100, 2);
        $statusClass = match($app->status) {
            'shortlisted' => 'sta-shortlisted',
            'hired'       => 'sta-hired',
            'rejected'    => 'sta-rejected',
            default       => 'sta-pending',
        };
        $statusIcon = match($app->status) {
            'shortlisted' => 'fa-star',
            'hired'       => 'fa-check-double',
            'rejected'    => 'fa-ban',
            default       => 'fa-clock',
        };
    @endphp
    <div class="app-card">

        {{-- Avatar --}}
        <div class="app-avatar">{{ strtoupper(substr(optional($app->user)->name ?? 'U', 0, 2)) }}</div>

        {{-- Main info --}}
        <div style="flex:1;min-width:0;">
            <div style="display:flex;flex-wrap:wrap;align-items:center;gap:.5rem;margin-bottom:.35rem;">
                <span style="font-size:.92rem;font-weight:800;color:var(--adm-text);">
                    {{ optional($app->user)->name ?? 'Unknown' }}
                </span>
                <span class="sta {{ $statusClass }}">
                    <i class="fas {{ $statusIcon }}" style="font-size:.55rem;"></i>
                    {{ ucfirst($app->status) }}
                </span>
            </div>
            <div style="font-size:.75rem;color:var(--adm-text-light);margin-bottom:.5rem;">
                {{ optional($app->user)->email }}
                &nbsp;&middot;&nbsp;Applied {{ $app->created_at->diffForHumans() }}
            </div>

            {{-- Skill pills --}}
            <div>
                @foreach($app->matched_skills as $sk)
                    <span class="skill-chip skill-matched"><i class="fas fa-check" style="font-size:.5rem;margin-right:3px;"></i>{{ $sk }}</span>
                @endforeach
                @foreach($app->missing_skills as $sk)
                    <span class="skill-chip skill-missing">{{ $sk }}</span>
                @endforeach
                @if(empty($app->matched_skills) && empty($app->missing_skills))
                    <span style="font-size:.73rem;color:var(--adm-text-light);font-style:italic;">No skills on profile</span>
                @endif
            </div>

            {{-- Match progress bar --}}
            <div class="match-bar" style="margin-top:.6rem;">
                <div class="match-bar-fill" style="width:{{ $pct }}%;background:{{ $color }};"></div>
            </div>
        </div>

        {{-- Right: match ring + actions --}}
        <div style="display:flex;flex-direction:column;align-items:flex-end;gap:.6rem;flex-shrink:0;">

            {{-- Ring --}}
            <div class="match-ring" title="{{ $pct }}% skill match">
                <svg viewBox="0 0 52 52" width="52" height="52">
                    <circle class="match-ring-track" cx="26" cy="26" r="22"/>
                    <circle class="match-ring-fill"
                        cx="26" cy="26" r="22"
                        stroke="{{ $color }}"
                        stroke-dasharray="{{ $dash }} {{ $circ }}"
                        stroke-dashoffset="0"/>
                </svg>
                <div class="match-ring-label" style="color:{{ $color }};">{{ $pct }}%</div>
            </div>

            {{-- Action buttons --}}
            <div style="display:flex;gap:.35rem;flex-wrap:wrap;justify-content:flex-end;">
                <a href="{{ route('admin.applications.show', $app->id) }}"
                   class="adm-btn adm-btn-ghost adm-btn-icon adm-btn-sm" title="View detail">
                    <i class="fas fa-eye" style="font-size:.7rem;"></i>
                </a>

                @if($app->status !== 'shortlisted')
                <form action="{{ route('admin.applications.shortlist', $app->id) }}" method="POST" style="margin:0;">
                    @csrf
                    <button class="adm-btn adm-btn-sm" style="background:rgba(59,130,246,.15);border:1px solid rgba(59,130,246,.25);color:#93c5fd;font-size:.7rem;" title="Shortlist">
                        <i class="fas fa-star"></i> Shortlist
                    </button>
                </form>
                @endif

                @if($app->status !== 'hired')
                <form action="{{ route('admin.applications.hire', $app->id) }}" method="POST" style="margin:0;">
                    @csrf
                    <button class="adm-btn adm-btn-sm" style="background:rgba(34,197,94,.12);border:1px solid rgba(34,197,94,.2);color:#86efac;font-size:.7rem;" title="Hire"
                            onclick="return confirm('Mark {{ optional($app->user)->name }} as Hired?')">
                        <i class="fas fa-check-double"></i> Hire
                    </button>
                </form>
                @endif

                @if($app->status !== 'rejected')
                <form action="{{ route('admin.applications.reject', $app->id) }}" method="POST" style="margin:0;">
                    @csrf
                    <button class="adm-btn adm-btn-sm" style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.18);color:#fca5a5;font-size:.7rem;" title="Reject">
                        <i class="fas fa-ban"></i> Reject
                    </button>
                </form>
                @endif
            </div>

            {{-- Resume link --}}
            @if(optional(optional($app->user)->profile)->resume_path)
                <a href="{{ Storage::url($app->user->profile->resume_path) }}" target="_blank"
                   style="font-size:.68rem;color:#93c5fd;text-decoration:none;">
                    <i class="fas fa-file-pdf"></i> Resume
                </a>
            @endif
        </div>

    </div>
    @empty
    <div style="padding:4rem 2rem;text-align:center;">
        <div style="width:72px;height:72px;border-radius:18px;background:rgba(59,130,246,.08);border:1px solid rgba(59,130,246,.15);display:flex;align-items:center;justify-content:center;font-size:1.8rem;margin:0 auto 1rem;">📭</div>
        <div style="font-weight:800;color:var(--adm-text);font-size:1rem;margin-bottom:.4rem;">No applicants found</div>
        <div style="font-size:.83rem;color:var(--adm-text-muted);">
            @if(request()->hasAny(['search','status','min_match']))
                Try adjusting your filters.
            @else
                No one has applied for this position yet.
            @endif
        </div>
    </div>
    @endforelse
</div>

@endsection
