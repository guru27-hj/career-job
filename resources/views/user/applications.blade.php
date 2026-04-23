@extends('layouts.public')
@section('title', 'My Applications — CareerConnect')

@section('content')
<style>
/* Reuse shared pd-* sidebar/layout tokens from profile */
.pd-wrap {
    max-width: 1100px; margin: 0 auto;
    padding: 2rem 1.25rem 4rem;
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 1.5rem; align-items: start;
}
@media(max-width: 900px) { .pd-wrap { grid-template-columns: 1fr; } }

.pd-sidebar { position: sticky; top: 82px; display: flex; flex-direction: column; gap: 1rem; }
@media(max-width: 900px) { .pd-sidebar { position: static; } }

/* Profile card (same as profile page) */
.pd-profile-card { background: var(--cc-surface); border-radius: 20px; border: 1.5px solid var(--cc-border); overflow: hidden; box-shadow: var(--cc-shadow-sm); }
.pd-avatar-section { background: linear-gradient(135deg,#1e3a8a 0%,#4c1d95 60%,#2563eb 100%); padding: 2rem 1.25rem 1.5rem; text-align: center; }
.pd-avatar-ring { width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg,#60a5fa,#a78bfa); border: 3px solid rgba(255,255,255,.5); display: flex; align-items: center; justify-content: center; font-size: 1.9rem; font-weight: 900; color: #fff; margin: 0 auto 1rem; box-shadow: 0 8px 24px rgba(0,0,0,.3); }
.pd-name  { font-size: 1rem; font-weight: 800; color: #fff; margin-bottom: .2rem; }
.pd-email { font-size: .76rem; color: rgba(255,255,255,.65); }

.pd-nav { padding: .75rem; }
.pd-nav-link { display: flex; align-items: center; gap: .65rem; padding: .65rem .85rem; border-radius: 12px; font-size: .85rem; font-weight: 600; color: var(--cc-text-muted); text-decoration: none; transition: all .15s; margin-bottom: .2rem; }
.pd-nav-link i { width: 18px; text-align: center; font-size: .85rem; }
.pd-nav-link:hover { background: rgba(37,99,235,.07); color: var(--cc-primary); }
.pd-nav-link.active { background: linear-gradient(135deg,rgba(37,99,235,.12),rgba(124,58,237,.1)); color: var(--cc-primary); font-weight: 700; }
.pd-nav-link.danger { color: #ef4444; }
.pd-nav-link.danger:hover { background: #fff1f2; color: #dc2626; }
.pd-nav-divider { height: 1px; background: var(--cc-border); margin: .5rem 0; }

/* ── STATS CARDS ── */
.pd-stats-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 1rem; }
@media(max-width:500px){ .pd-stats-row { grid-template-columns: 1fr; } }

.pd-stat-chip {
    background: var(--cc-surface); border-radius: 16px;
    border: 1.5px solid var(--cc-border); padding: 1.25rem 1rem;
    text-align: center; transition: all .22s;
}
.pd-stat-chip:hover { box-shadow: var(--cc-shadow); transform: translateY(-3px); }
.pd-stat-chip-num { font-size: 2rem; font-weight: 900; letter-spacing: -.04em; margin-bottom: .25rem; }
.pd-stat-chip-lbl { font-size: .73rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--cc-text-light); }
.pd-stat-chip.total  { }
.pd-stat-chip.review { background: #fffbeb; border-color: #fde68a; }
.pd-stat-chip.selected { background: #f0fdf4; border-color: #bbf7d0; }
.pd-stat-chip.rejected { background: #fff1f2; border-color: #fecdd3; }

/* ── APPLICATION TABLE / CARDS ── */
.pd-apps-card {
    background: var(--cc-surface); border-radius: 20px;
    border: 1.5px solid var(--cc-border); overflow: hidden;
    box-shadow: var(--cc-shadow-sm);
}

/* Table header */
.pd-table-head {
    display: grid; grid-template-columns: 2fr 1.3fr 1fr 1fr auto;
    padding: .7rem 1.25rem;
    font-size: .7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .07em; color: var(--cc-text-light);
    background: var(--cc-surface-2); border-bottom: 1px solid var(--cc-border);
}
@media(max-width:700px) { .pd-table-head { display: none; } }

/* App row */
.pd-app-row {
    display: grid; grid-template-columns: 2fr 1.3fr 1fr 1fr auto;
    padding: 1rem 1.25rem; border-bottom: 1px solid var(--cc-border);
    align-items: center; gap: .5rem;
    transition: background .15s;
}
.pd-app-row:last-child  { border-bottom: none; }
.pd-app-row:hover { background: var(--cc-gradient-soft); }
@media(max-width:700px) {
    .pd-app-row { grid-template-columns: 1fr; gap: .5rem; }
    .pd-app-row > * { display: flex; align-items: center; gap: .5rem; }
    .pd-app-row > *::before { font-size:.68rem; font-weight:700; text-transform:uppercase; color:var(--cc-text-light); letter-spacing:.05em; min-width:70px; }
    .pd-app-col-job::before    { content: 'Position'; }
    .pd-app-col-comp::before   { content: 'Company'; }
    .pd-app-col-date::before   { content: 'Applied'; }
    .pd-app-col-status::before { content: 'Status'; }
}

/* Job title column */
.pd-app-col-job {}
.pd-app-job-title { font-size: .9rem; font-weight: 700; color: var(--cc-text); text-decoration: none; display: block; }
.pd-app-job-title:hover { color: var(--cc-primary); }
.pd-app-job-sub { font-size: .75rem; color: var(--cc-text-light); margin-top: .15rem; display: flex; align-items: center; gap: .3rem; }

/* Company */
.pd-app-col-comp { font-size: .85rem; font-weight: 600; color: var(--cc-text-muted); }
/* Date */
.pd-app-col-date { font-size: .8rem; color: var(--cc-text-light); }

/* Status badges */
.pd-status {
    display: inline-flex; align-items: center; gap: .45rem;
    padding: .3rem .85rem; border-radius: 99px; font-size: .74rem; font-weight: 700;
}
.pd-status-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
.pd-status.pending  { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
.pd-status.pending .pd-status-dot  { background: #f59e0b; animation: cc-pulse 1.5s ease infinite; }
.pd-status.selected { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
.pd-status.selected .pd-status-dot { background: #22c55e; animation: cc-pulse 1.5s ease infinite; }
.pd-status.rejected { background: #fff1f2; color: #9f1239; border: 1px solid #fecdd3; }
.pd-status.rejected .pd-status-dot { background: #ef4444; }
.pd-status.applied  { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }
.pd-status.applied .pd-status-dot  { background: #3b82f6; }

@keyframes cc-pulse {
    0%,100% { opacity: 1; } 50% { opacity: .35; }
}

/* Action column */
.pd-app-action a {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .3rem .75rem; border-radius: 8px;
    font-size: .75rem; font-weight: 700; text-decoration: none;
    border: 1.5px solid var(--cc-border); color: var(--cc-text-muted);
    transition: all .15s;
}
.pd-app-action a:hover { border-color: var(--cc-primary); color: var(--cc-primary); background: rgba(37,99,235,.06); }

/* Empty state */
.pd-empty {
    padding: 5rem 2rem; text-align: center;
}
.pd-empty-icon {
    width: 90px; height: 90px; border-radius: 24px; margin: 0 auto 1.5rem;
    background: var(--cc-gradient-soft);
    display: flex; align-items: center; justify-content: center; font-size: 2.2rem;
}
.pd-empty h3 { font-size: 1.2rem; font-weight: 800; color: var(--cc-text); margin-bottom: .5rem; }
.pd-empty p  { font-size: .88rem; color: var(--cc-text-light); max-width: 320px; margin: 0 auto 1.5rem; line-height: 1.65; }
.pd-empty-btn {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .8rem 1.75rem; border-radius: 12px;
    background: var(--cc-gradient); color: #fff;
    font-weight: 700; font-size: .9rem; text-decoration: none;
    box-shadow: 0 6px 20px rgba(37,99,235,.3);
    transition: box-shadow .18s, transform .18s;
}
.pd-empty-btn:hover { box-shadow: 0 12px 32px rgba(37,99,235,.4); transform: translateY(-2px); color:#fff; }

/* Page hero */
.pd-page-hero {
    background: linear-gradient(135deg,#1e293b 0%,#1e1b4b 100%);
    padding: 2rem 1.5rem 3.5rem; position: relative; overflow: hidden; margin-bottom: -2rem;
}
.pd-page-hero::after { content:''; position:absolute; bottom:-1px; left:0; right:0; height:50px; background:var(--cc-bg); clip-path:ellipse(55% 100% at 50% 100%); }
.pd-hero-orb { position:absolute; border-radius:50%; filter:blur(60px); pointer-events:none; }

/* Filter tabs */
.pd-filter-tabs { display: flex; gap: .5rem; flex-wrap: wrap; }
.pd-filter-tab {
    padding: .4rem .9rem; border-radius: 99px; font-size: .8rem; font-weight: 700;
    border: 1.5px solid var(--cc-border); background: var(--cc-surface);
    color: var(--cc-text-muted); cursor: pointer; transition: all .15s;
    text-decoration: none;
}
.pd-filter-tab:hover { border-color: var(--cc-primary); color: var(--cc-primary); }
.pd-filter-tab.active { background: var(--cc-gradient); color: #fff; border-color: transparent; }
</style>

{{-- Page Hero --}}
<div class="pd-page-hero">
    <div class="pd-hero-orb" style="width:280px;height:280px;background:rgba(124,58,237,.2);top:-80px;right:-40px;"></div>
    <div style="max-width:1100px;margin:0 auto;padding:0 1.25rem;">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
            <div style="display:flex;align-items:center;gap:.75rem;">
                <div style="width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,#2563eb,#7c3aed);display:flex;align-items:center;justify-content:center;font-size:1rem;color:#fff;flex-shrink:0;">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div>
                    <div style="font-size:1.3rem;font-weight:900;color:#fff;letter-spacing:-.03em;position:relative;z-index:1;">My Applications</div>
                    <div style="color:#94a3b8;font-size:.82rem;position:relative;z-index:1;">Track your job application pipeline</div>
                </div>
            </div>
            <a href="{{ route('jobs.index') }}" style="display:inline-flex;align-items:center;gap:.5rem;padding:.6rem 1.2rem;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);color:#fff;border-radius:10px;font-size:.83rem;font-weight:700;text-decoration:none;position:relative;z-index:1;transition:background .15s;" onmouseover="this.style.background='rgba(255,255,255,.18)';" onmouseout="this.style.background='rgba(255,255,255,.1)';">
                <i class="fas fa-search"></i> Find More Jobs
            </a>
        </div>
    </div>
</div>

<div class="pd-wrap">

    {{-- ═════════════ SIDEBAR ═════════════ --}}
    <aside class="pd-sidebar">
        <div class="pd-profile-card">
            <div class="pd-avatar-section">
                <div class="pd-avatar-ring">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                <div class="pd-name">{{ auth()->user()->name }}</div>
                <div class="pd-email">{{ auth()->user()->email }}</div>
            </div>
            <nav class="pd-nav">
                <a href="{{ route('candidate.profile') }}" class="pd-nav-link">
                    <i class="fas fa-user-edit"></i> Edit Profile
                </a>
                <a href="{{ route('candidate.applications') }}" class="pd-nav-link active">
                    <i class="fas fa-briefcase"></i> My Applications
                    <span style="margin-left:auto;background:linear-gradient(135deg,#2563eb,#7c3aed);color:#fff;font-size:.68rem;font-weight:800;padding:2px 7px;border-radius:99px;">{{ $applications->total() }}</span>
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

        {{-- Application breakdown --}}
        @php
            $allApps = auth()->user()->applications;
            $pendingC  = $allApps->where('status','pending')->count();
            $selectedC = $allApps->where('status','selected')->count();
            $rejectedC = $allApps->where('status','rejected')->count();
        @endphp
        <div style="background:var(--cc-surface);border-radius:16px;border:1.5px solid var(--cc-border);padding:1rem;">
            <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--cc-text-light);margin-bottom:.75rem;">Breakdown</div>
            @foreach([
                ['label'=>'Under Review', 'count'=>$pendingC,  'color'=>'#d97706', 'bg'=>'#fffbeb'],
                ['label'=>'Selected',     'count'=>$selectedC, 'color'=>'#16a34a', 'bg'=>'#f0fdf4'],
                ['label'=>'Rejected',     'count'=>$rejectedC, 'color'=>'#dc2626', 'bg'=>'#fff1f2'],
            ] as $item)
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.5rem;padding:.45rem .6rem;border-radius:9px;background:{{ $item['bg'] }};">
                    <span style="font-size:.8rem;font-weight:600;color:{{ $item['color'] }};">{{ $item['label'] }}</span>
                    <span style="font-size:.85rem;font-weight:900;color:{{ $item['color'] }};">{{ $item['count'] }}</span>
                </div>
            @endforeach
        </div>
    </aside>

    {{-- ═════════════ MAIN ═════════════ --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">

        {{-- Stats row --}}
        @php
            $total = $applications->total();
        @endphp
        <div class="pd-stats-row">
            <div class="pd-stat-chip total">
                <div class="pd-stat-chip-num" style="background:var(--cc-gradient);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;">{{ $total }}</div>
                <div class="pd-stat-chip-lbl">Total Applied</div>
            </div>
            <div class="pd-stat-chip review">
                <div class="pd-stat-chip-num" style="color:#d97706;">{{ $pendingC }}</div>
                <div class="pd-stat-chip-lbl" style="color:#92400e;">Under Review</div>
            </div>
            <div class="pd-stat-chip selected">
                <div class="pd-stat-chip-num" style="color:#16a34a;">{{ $selectedC }}</div>
                <div class="pd-stat-chip-lbl" style="color:#166534;">Selected 🎉</div>
            </div>
        </div>

        {{-- Applications card --}}
        <div class="pd-apps-card">

            {{-- Card header with filter tabs --}}
            <div style="padding:1rem 1.25rem;border-bottom:1px solid var(--cc-border);background:var(--cc-surface-2);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem;">
                <div style="font-size:.9rem;font-weight:800;color:var(--cc-text);">
                    <i class="fas fa-list-check" style="color:var(--cc-primary);margin-right:.5rem;"></i>
                    Application History
                </div>
                <div class="pd-filter-tabs">
                    <a href="#" class="pd-filter-tab active" onclick="filterApps(event,'all')">All</a>
                    <a href="#" class="pd-filter-tab" onclick="filterApps(event,'pending')">Reviewing</a>
                    <a href="#" class="pd-filter-tab" onclick="filterApps(event,'selected')">Selected</a>
                    <a href="#" class="pd-filter-tab" onclick="filterApps(event,'rejected')">Rejected</a>
                </div>
            </div>

            @if($applications->count() === 0)
                <div class="pd-empty">
                    <div class="pd-empty-icon">📋</div>
                    <h3>No Applications Yet</h3>
                    <p>Start applying for jobs that match your skills and interests. Your applications will appear here.</p>
                    <a href="{{ route('jobs.index') }}" class="pd-empty-btn">
                        <i class="fas fa-search"></i> Browse Open Positions
                    </a>
                </div>
            @else
                {{-- Table head --}}
                <div class="pd-table-head">
                    <div>Position</div>
                    <div>Company</div>
                    <div>Applied</div>
                    <div>Status</div>
                    <div></div>
                </div>

                {{-- Application rows --}}
                @foreach($applications as $app)
                    @php
                        $status = $app->status ?? 'applied';
                        $statusMap = [
                            'selected' => ['class'=>'selected', 'label'=>'Selected 🎉'],
                            'pending'  => ['class'=>'pending',  'label'=>'Under Review'],
                            'rejected' => ['class'=>'rejected', 'label'=>'Rejected'],
                        ];
                        $s = $statusMap[$status] ?? ['class'=>'applied', 'label'=>ucfirst($status)];
                    @endphp
                    <div class="pd-app-row" data-status="{{ $status }}">
                        {{-- Job Title --}}
                        <div class="pd-app-col-job">
                            <a href="{{ optional($app->job)->slug ? route('jobs.show', $app->job->slug) : '#' }}" class="pd-app-job-title">
                                {{ optional($app->job)->title ?? 'Job Removed' }}
                            </a>
                            <div class="pd-app-job-sub">
                                <i class="fas fa-map-marker-alt" style="font-size:.65rem;"></i>
                                {{ optional($app->job)->location ?? 'Remote' }}
                                @if(optional($app->job)->job_type)
                                    <span style="opacity:.4;">·</span>
                                    <span>{{ ucfirst(str_replace('-',' ', $app->job->job_type)) }}</span>
                                @endif
                            </div>
                        </div>

                        {{-- Company --}}
                        <div class="pd-app-col-comp">
                            <div style="display:flex;align-items:center;gap:.5rem;">
                                <div style="width:28px;height:28px;border-radius:7px;background:var(--cc-gradient);display:flex;align-items:center;justify-content:center;color:#fff;font-size:.7rem;font-weight:800;flex-shrink:0;">
                                    {{ strtoupper(substr(optional(optional($app->job)->company)->name ?? 'U', 0, 1)) }}
                                </div>
                                <span>{{ optional(optional($app->job)->company)->name ?? '—' }}</span>
                            </div>
                        </div>

                        {{-- Date --}}
                        <div class="pd-app-col-date">
                            <div>{{ $app->created_at->format('M d, Y') }}</div>
                            <div style="font-size:.7rem;color:var(--cc-text-light);margin-top:.1rem;">{{ $app->created_at->diffForHumans() }}</div>
                        </div>

                        {{-- Status --}}
                        <div class="pd-app-col-status">
                            <span class="pd-status {{ $s['class'] }}">
                                <span class="pd-status-dot"></span>
                                {{ $s['label'] }}
                            </span>
                        </div>

                        {{-- Action --}}
                        <div class="pd-app-action">
                            @if(optional($app->job)->slug)
                                <a href="{{ route('jobs.show', $app->job->slug) }}">
                                    <i class="fas fa-arrow-up-right-from-square" style="font-size:.68rem;"></i> View
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach

                {{-- Pagination --}}
                @if($applications->hasPages())
                    <div style="padding:1rem 1.25rem;border-top:1px solid var(--cc-border);background:var(--cc-surface-2);">
                        {{ $applications->links() }}
                    </div>
                @endif
            @endif
        </div>

        {{-- CTA if no recent jobs --}}
        @if($applications->count() < 3)
            <div style="background:linear-gradient(135deg,#eff6ff,#f5f3ff);border:1.5px solid #bfdbfe;border-radius:16px;padding:1.25rem 1.5rem;display:flex;align-items:center;gap:1rem;flex-wrap:wrap;">
                <div style="flex:1;min-width:200px;">
                    <div style="font-weight:800;color:var(--cc-text);font-size:.92rem;margin-bottom:.2rem;">💡 Boost your chances</div>
                    <div style="font-size:.82rem;color:var(--cc-text-muted);">Complete your profile and add skills to stand out to recruiters.</div>
                </div>
                <div style="display:flex;gap:.6rem;flex-shrink:0;">
                    <a href="{{ route('candidate.profile') }}" style="display:inline-flex;align-items:center;gap:.4rem;padding:.55rem 1.1rem;border-radius:10px;background:var(--cc-gradient);color:#fff;font-weight:700;font-size:.82rem;text-decoration:none;box-shadow:0 4px 14px rgba(37,99,235,.25);">
                        <i class="fas fa-user-edit"></i> Update Profile
                    </a>
                    <a href="{{ route('jobs.index') }}" style="display:inline-flex;align-items:center;gap:.4rem;padding:.55rem 1.1rem;border-radius:10px;background:var(--cc-surface);border:1.5px solid var(--cc-border);color:var(--cc-text);font-weight:700;font-size:.82rem;text-decoration:none;transition:all .15s;" onmouseover="this.style.borderColor='var(--cc-primary)';this.style.color='var(--cc-primary)';" onmouseout="this.style.borderColor='var(--cc-border)';this.style.color='var(--cc-text)';">
                        <i class="fas fa-search"></i> Browse Jobs
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
/* Filter tabs client-side */
function filterApps(e, status) {
    e.preventDefault();
    document.querySelectorAll('.pd-filter-tab').forEach(t => t.classList.remove('active'));
    e.currentTarget.classList.add('active');
    document.querySelectorAll('.pd-app-row').forEach(row => {
        row.style.display = (status === 'all' || row.dataset.status === status) ? '' : 'none';
    });
}
</script>
@endsection
