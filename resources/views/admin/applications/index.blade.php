@extends('layouts.admin')
@section('title', 'Applications')

@section('content')
<style>
/* ── Applications Page Extras ── */
.adm-apps-stats { display: grid; grid-template-columns: repeat(6,1fr); gap: .75rem; margin-bottom: 1.5rem; }
@media(max-width:1100px){ .adm-apps-stats { grid-template-columns: repeat(3,1fr); } }
@media(max-width:600px) { .adm-apps-stats { grid-template-columns: repeat(2,1fr); } }

.adm-mini-stat {
    display: block; text-decoration: none;
    background: var(--adm-surface); border: 1px solid var(--adm-border);
    border-radius: 12px; padding: .9rem 1rem; text-align: center;
    transition: all .18s; cursor: pointer; position: relative; overflow: hidden;
}
.adm-mini-stat::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; opacity:0; transition: opacity .18s; }
.adm-mini-stat:hover, .adm-mini-stat.active { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(0,0,0,.3); }
.adm-mini-stat:hover::before, .adm-mini-stat.active::before { opacity: 1; }
.adm-mini-stat.all::before     { background: linear-gradient(90deg,#3b82f6,#8b5cf6); }
.adm-mini-stat.pending::before { background: #f59e0b; }
.adm-mini-stat.selected::before{ background: #22c55e; }
.adm-mini-stat.rejected::before{ background: #ef4444; }
.adm-mini-stat.intern::before  { background: #06b6d4; }
.adm-mini-stat.job::before     { background: #8b5cf6; }
.adm-mini-stat-num { font-size: 1.5rem; font-weight: 900; letter-spacing: -.04em; }
.adm-mini-stat-lbl { font-size: .66rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--adm-text-light); margin-top: .15rem; }

/* Filter bar */
.adm-filter-row {
    display: flex; align-items: center; flex-wrap: wrap; gap: .6rem;
    background: var(--adm-surface); border: 1px solid var(--adm-border);
    border-radius: 12px; padding: .85rem 1.1rem; margin-bottom: 1.25rem;
}

/* Search field */
.adm-sf {
    display: flex; align-items: center; gap: .5rem;
    background: rgba(255,255,255,.05); border: 1px solid var(--adm-border);
    border-radius: 9px; padding: .5rem .9rem; flex: 1; min-width: 220px;
    transition: border-color .15s;
}
.adm-sf:focus-within { border-color: rgba(59,130,246,.5); }
.adm-sf i { color: var(--adm-text-light); font-size: .82rem; }
.adm-sf input {
    background: transparent; border: none; outline: none;
    font-size: .83rem; color: var(--adm-text); font-family:'Inter',sans-serif; flex: 1;
}
.adm-sf input::placeholder { color: var(--adm-text-light); }

/* Select filter */
.adm-fsel {
    background: rgba(255,255,255,.05); border: 1px solid var(--adm-border);
    border-radius: 9px; padding: .5rem .9rem; font-size: .8rem;
    color: var(--adm-text-muted); font-family:'Inter',sans-serif; outline: none;
    cursor: pointer; transition: border-color .15s;
}
.adm-fsel:focus { border-color: rgba(59,130,246,.5); }

/* Filter chip */
.adm-fchip {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .45rem .9rem; border-radius: 9px; font-size: .78rem; font-weight: 700;
    background: rgba(255,255,255,.05); border: 1px solid var(--adm-border);
    color: var(--adm-text-muted); cursor: pointer; transition: all .15s;
    text-decoration: none;
}
.adm-fchip:hover { background: rgba(59,130,246,.1); border-color: rgba(59,130,246,.3); color: #93c5fd; }
.adm-fchip.on   { background: rgba(59,130,246,.15); border-color: rgba(59,130,246,.35); color: #93c5fd; }

/* Applicant cell */
.adm-app-user { display: flex; align-items: center; gap: .65rem; }
.adm-app-avatar {
    width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0;
    background: linear-gradient(135deg,#3b82f6,#8b5cf6);
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: .85rem; color: #fff;
}
.adm-app-name  { font-size: .85rem; font-weight: 700; color: var(--adm-text); }
.adm-app-email { font-size: .72rem; color: var(--adm-text-light); margin-top: 1px; }

/* Job/Internship label */
.adm-type-chip {
    display: inline-flex; font-size: .62rem; font-weight: 800;
    padding: 2px 7px; border-radius: 99px; margin-bottom: 3px;
}
.adm-type-internship { background: rgba(6,182,212,.12); color: #67e8f9; border: 1px solid rgba(6,182,212,.2); }
.adm-type-job        { background: rgba(139,92,246,.12); color: #c4b5fd; border: 1px solid rgba(139,92,246,.2); }

/* Status pill */
.adm-app-status {
    display: inline-flex; align-items: center; gap: .4rem;
    font-size: .72rem; font-weight: 700; padding: 4px 10px; border-radius: 99px;
}
.adm-s-pending     { background: rgba(245,158,11,.12); color: #fcd34d; border: 1px solid rgba(245,158,11,.2); }
.adm-s-shortlisted { background: rgba(59,130,246,.12); color: #93c5fd; border: 1px solid rgba(59,130,246,.2); }
.adm-s-hired       { background: rgba(34,197,94,.12);  color: #86efac; border: 1px solid rgba(34,197,94,.2); }
.adm-s-rejected    { background: rgba(239,68,68,.12);  color: #fca5a5; border: 1px solid rgba(239,68,68,.2); }
.adm-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
.adm-s-pending .adm-dot     { background: #f59e0b; animation: adm-pulse 1.5s infinite; }
.adm-s-shortlisted .adm-dot { background: #3b82f6; animation: adm-pulse 1.5s infinite; }
.adm-s-hired .adm-dot       { background: #22c55e; }
.adm-s-rejected .adm-dot    { background: #ef4444; }

/* Match % badge */
.adm-match { display:inline-flex;align-items:center;gap:.3rem;font-size:.68rem;font-weight:800;
             padding:3px 8px;border-radius:99px; }
.adm-match-hi  { background:rgba(34,197,94,.1);  color:#86efac; border:1px solid rgba(34,197,94,.18); }
.adm-match-mid { background:rgba(245,158,11,.1); color:#fcd34d; border:1px solid rgba(245,158,11,.18); }
.adm-match-lo  { background:rgba(239,68,68,.1);  color:#fca5a5; border:1px solid rgba(239,68,68,.18); }

/* Action buttons */
.adm-app-actions { display: flex; align-items: center; gap: .35rem; justify-content: flex-end; }
.adm-app-approve {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .35rem .75rem; border-radius: 8px; font-size: .73rem; font-weight: 700;
    background: rgba(34,197,94,.12); border: 1px solid rgba(34,197,94,.2); color: #86efac;
    cursor: pointer; border: none; font-family:'Inter',sans-serif; transition: all .15s;
}
.adm-app-approve:hover { background: rgba(34,197,94,.22); color: #4ade80; }
.adm-app-reject {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .35rem .75rem; border-radius: 8px; font-size: .73rem; font-weight: 700;
    background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.2); color: #fca5a5;
    cursor: pointer; font-family:'Inter',sans-serif; transition: all .15s;
}
.adm-app-reject:hover { background: rgba(239,68,68,.2); color: #ef4444; }

/* Table container */
.adm-tbl-wrap { overflow-x: auto; }

/* empty state */
.adm-apps-empty { padding: 4rem 2rem; text-align: center; }
.adm-apps-empty-icon { width: 72px; height: 72px; border-radius: 18px; background: rgba(59,130,246,.08); border: 1px solid rgba(59,130,246,.15); display: flex; align-items: center; justify-content: center; font-size: 1.7rem; margin: 0 auto 1.1rem; }
</style>

<!-- Breadcrumb -->
<div class="adm-breadcrumb">
    <a href="{{ route('admin.dashboard') }}"><i class="fas fa-house" style="font-size:.65rem;"></i></a>
    <span class="sep">/</span>
    <span class="active">Applications</span>
</div>

<!-- Page header -->
<div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1.25rem;flex-wrap:wrap;gap:1rem;">
    <div>
        <h1 style="font-size:1.4rem;font-weight:900;letter-spacing:-.04em;color:#f1f5f9;margin:0;">
            Application Management
        </h1>
        <p style="font-size:.83rem;color:var(--adm-text-muted);margin:.3rem 0 0;">
            All job &amp; internship applications — review, approve, or reject them here.
        </p>
    </div>
    <a href="{{ route('admin.applications.index') }}" class="adm-btn adm-btn-ghost adm-btn-sm">
        <i class="fas fa-rotate-right"></i> Refresh
    </a>
</div>

<!-- ══ STATS ROW ══ -->
<div class="adm-apps-stats">
    <a href="{{ route('admin.applications.index', ['status' => '', 'search' => request('search')]) }}" class="adm-mini-stat all {{ request('status') == '' ? 'active' : '' }}">
        <div class="adm-mini-stat-num" style="background:var(--adm-gradient);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;">{{ $totalApps }}</div>
        <div class="adm-mini-stat-lbl">Total</div>
    </a>
    <a href="{{ route('admin.applications.index', ['status' => 'pending', 'search' => request('search')]) }}" class="adm-mini-stat pending {{ request('status') == 'pending' ? 'active' : '' }}">
        <div class="adm-mini-stat-num" style="color:#fcd34d;">{{ $pendingApps }}</div>
        <div class="adm-mini-stat-lbl">Pending</div>
    </a>
    <a href="{{ route('admin.applications.index', ['status' => 'shortlisted', 'search' => request('search')]) }}" class="adm-mini-stat {{ request('status') == 'shortlisted' ? 'active' : '' }}" style="border-color:rgba(59,130,246,.15);">
        <div class="adm-mini-stat-num" style="color:#93c5fd;">{{ $shortlistedApps }}</div>
        <div class="adm-mini-stat-lbl">Shortlisted</div>
    </a>
    <a href="{{ route('admin.applications.index', ['status' => 'hired', 'search' => request('search')]) }}" class="adm-mini-stat selected {{ request('status') == 'hired' ? 'active' : '' }}">
        <div class="adm-mini-stat-num" style="color:#86efac;">{{ $hiredApps }}</div>
        <div class="adm-mini-stat-lbl">Hired</div>
    </a>
    <a href="{{ route('admin.applications.index', ['status' => 'rejected', 'search' => request('search')]) }}" class="adm-mini-stat rejected {{ request('status') == 'rejected' ? 'active' : '' }}">
        <div class="adm-mini-stat-num" style="color:#fca5a5;">{{ $rejectedApps }}</div>
        <div class="adm-mini-stat-lbl">Rejected</div>
    </a>
    <a href="{{ route('admin.applications.index', ['type' => 'internship', 'search' => request('search')]) }}" class="adm-mini-stat intern {{ request('type') == 'internship' ? 'active' : '' }}">
        <div class="adm-mini-stat-num" style="color:#67e8f9;">{{ $internshipApps }}</div>
        <div class="adm-mini-stat-lbl">Internships</div>
    </a>
</div>

<!-- ══ FILTER BAR ══ -->
<form action="{{ route('admin.applications.index') }}" method="GET" id="filterForm">
<div class="adm-filter-row">
    <!-- Search -->
    <div class="adm-sf">
        <i class="fas fa-search"></i>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search by user, email, or role title…"
               oninput="document.getElementById('filterForm').submit()">
    </div>

    <!-- Status filter -->
    <select name="status" class="adm-fsel" onchange="this.form.submit()">
        <option value="">All Statuses</option>
        <option value="pending"     {{ request('status')=='pending'     ? 'selected' : '' }}>⏳ Pending</option>
        <option value="shortlisted" {{ request('status')=='shortlisted' ? 'selected' : '' }}>⭐ Shortlisted</option>
        <option value="hired"       {{ request('status')=='hired'       ? 'selected' : '' }}>✅ Hired</option>
        <option value="rejected"    {{ request('status')=='rejected'    ? 'selected' : '' }}>❌ Rejected</option>
    </select>

    <!-- Type filter -->
    <select name="type" class="adm-fsel" onchange="this.form.submit()">
        <option value="">All Types</option>
        <option value="internship" {{ request('type')=='internship' ? 'selected' : '' }}>🎓 Internships</option>
        <option value="job"        {{ request('type')=='job'        ? 'selected' : '' }}>💼 Jobs</option>
    </select>

    <!-- Clear -->
    @if(request('search') || request('status') || request('type'))
        <a href="{{ route('admin.applications.index') }}" class="adm-fchip" style="color:#f87171;border-color:rgba(239,68,68,.2);">
            <i class="fas fa-xmark"></i> Clear
        </a>
    @endif

    <span style="margin-left:auto;font-size:.75rem;color:var(--adm-text-light);">
        {{ $applications->total() }} result{{ $applications->total() !== 1 ? 's' : '' }}
    </span>
</div>
</form>

<!-- ══ TABLE CARD ══ -->
<div class="adm-card">
    <div class="adm-tbl-wrap">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Applicant</th>
                    <th>Position</th>
                    <th>Company</th>
                    <th>Match</th>
                    <th>Status</th>
                    <th>Applied</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                    @php
                        $isInternship = optional($app->job)->job_type === 'internship';
                        $statusClass  = match($app->status) {
                            'shortlisted' => 'adm-s-shortlisted',
                            'hired'       => 'adm-s-hired',
                            'rejected'    => 'adm-s-rejected',
                            default       => 'adm-s-pending',
                        };
                        $statusLabel = match($app->status) {
                            'shortlisted' => '⭐ Shortlisted',
                            'hired'       => '✅ Hired',
                            'rejected'    => 'Rejected',
                            default       => 'Under Review',
                        };
                        $pct = $app->match_pct ?? 0;
                        $matchClass = $pct >= 70 ? 'adm-match-hi' : ($pct >= 40 ? 'adm-match-mid' : 'adm-match-lo');
                    @endphp
                    <tr>
                        <!-- # -->
                        <td style="color:var(--adm-text-light);font-size:.78rem;font-weight:700;">
                            #{{ $app->id }}
                        </td>

                        <!-- Applicant -->
                        <td>
                            <div class="adm-app-user">
                                <div class="adm-app-avatar">{{ strtoupper(substr($app->user->name ?? 'U', 0, 2)) }}</div>
                                <div>
                                    <div class="adm-app-name">{{ $app->user->name ?? '—' }}</div>
                                    <div class="adm-app-email">{{ $app->user->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Position -->
                        <td>
                            <span class="adm-type-chip {{ $isInternship ? 'adm-type-internship' : 'adm-type-job' }}">
                                <i class="fas {{ $isInternship ? 'fa-graduation-cap' : 'fa-briefcase' }}" style="font-size:.55rem;"></i>
                                {{ $isInternship ? 'Internship' : 'Job' }}
                            </span>
                            <div style="font-size:.84rem;font-weight:700;color:var(--adm-text);">
                                {{ optional($app->job)->title ?? 'Position Removed' }}
                            </div>
                            @if(optional($app->job)->location)
                                <div style="font-size:.72rem;color:var(--adm-text-light);">
                                    <i class="fas fa-map-marker-alt" style="font-size:.6rem;margin-right:.2rem;"></i>
                                    {{ $app->job->location }}
                                </div>
                            @endif
                        </td>

                        <!-- Company -->
                        <td>
                            <div style="font-size:.83rem;font-weight:600;color:var(--adm-text-muted);">
                                {{ optional(optional($app->job)->company)->name ?? '—' }}
                            </div>
                        </td>

                        <!-- Match % -->
                        <td>
                            <span class="adm-match {{ $matchClass }}">{{ $pct }}%</span>
                        </td>

                        <!-- Status -->
                        <td>
                            <span class="adm-app-status {{ $statusClass }}">
                                <span class="adm-dot"></span>
                                {{ $statusLabel }}
                            </span>
                        </td>

                        <!-- Applied Date -->
                        <td>
                            <div style="font-size:.8rem;color:var(--adm-text-muted);">{{ $app->created_at->format('M d, Y') }}</div>
                            <div style="font-size:.7rem;color:var(--adm-text-light);">{{ $app->created_at->diffForHumans() }}</div>
                        </td>

                        <!-- Actions -->
                        <td>
                            <div class="adm-app-actions">
                                {{-- View --}}
                                <a href="{{ route('admin.applications.show', $app->id) }}"
                                   class="adm-btn adm-btn-ghost adm-btn-icon adm-btn-sm" title="View">
                                    <i class="fas fa-eye" style="font-size:.75rem;"></i>
                                </a>

                                {{-- Shortlist --}}
                                @if($app->status !== 'shortlisted')
                                    <form action="{{ route('admin.applications.shortlist', $app->id) }}" method="POST" style="margin:0;">
                                        @csrf
                                        <button type="submit" class="adm-app-approve" style="background:rgba(59,130,246,.12);color:#93c5fd;" title="Shortlist">
                                            <i class="fas fa-star" style="font-size:.7rem;"></i> Shortlist
                                        </button>
                                    </form>
                                @endif

                                {{-- Hire --}}
                                @if($app->status !== 'hired')
                                    <form action="{{ route('admin.applications.hire', $app->id) }}" method="POST" style="margin:0;">
                                        @csrf
                                        <button type="submit" class="adm-app-approve" title="Hire"
                                                onclick="return confirm('Mark as Hired?')">
                                            <i class="fas fa-check-double" style="font-size:.7rem;"></i> Hire
                                        </button>
                                    </form>
                                @endif

                                {{-- Reject --}}
                                @if($app->status !== 'rejected')
                                    <form action="{{ route('admin.applications.reject', $app->id) }}" method="POST" style="margin:0;">
                                        @csrf
                                        <button type="submit" class="adm-app-reject" title="Reject">
                                            <i class="fas fa-ban" style="font-size:.7rem;"></i> Reject
                                        </button>
                                    </form>
                                @endif

                                {{-- Delete --}}
                                <form action="{{ route('admin.applications.destroy', $app->id) }}" method="POST" style="margin:0;">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="adm-btn adm-btn-danger adm-btn-icon adm-btn-sm"
                                            title="Delete"
                                            onclick="return confirm('Permanently delete this application?')">
                                        <i class="fas fa-trash" style="font-size:.7rem;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="adm-apps-empty">
                                <div class="adm-apps-empty-icon">📋</div>
                                <div style="font-weight:800;color:var(--adm-text);font-size:1rem;margin-bottom:.4rem;">
                                    No applications found
                                </div>
                                <div style="font-size:.83rem;color:var(--adm-text-muted);margin-bottom:1rem;">
                                    @if(request('search') || request('status') || request('type'))
                                        Try adjusting your search filters.
                                    @else
                                        No applications have been submitted yet.
                                    @endif
                                </div>
                                @if(request('search') || request('status') || request('type'))
                                    <a href="{{ route('admin.applications.index') }}" class="adm-btn adm-btn-ghost adm-btn-sm">
                                        <i class="fas fa-xmark"></i> Clear filters
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($applications->hasPages())
        <div style="padding:1rem 1.25rem;border-top:1px solid var(--adm-border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.5rem;">
            <div style="font-size:.75rem;color:var(--adm-text-light);">
                Showing {{ $applications->firstItem() }}–{{ $applications->lastItem() }} of {{ $applications->total() }} applications
            </div>
            <div>
                {{ $applications->appends(request()->query())->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
