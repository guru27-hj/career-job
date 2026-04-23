@extends('layouts.public')
@section('title', 'Browse Jobs — CareerConnect')

@section('content')
<style>
/* ── JOBS PAGE ── */
.cc-jobs-page { max-width: 1280px; margin: 0 auto; padding: 2rem 1.5rem 4rem; display: flex; gap: 1.5rem; align-items: flex-start; }
@media(max-width:900px){ .cc-jobs-page { flex-direction: column; } }

/* ── PAGE HEADER ── */
.cc-page-hero {
    background: linear-gradient(135deg,#1e3a8a 0%,#4c1d95 100%);
    padding: 2.5rem 1.5rem 4rem; position: relative; overflow: hidden;
}
.cc-page-hero::after {
    content:''; position:absolute; bottom:-1px; left:0; right:0; height:70px;
    background: var(--cc-bg); clip-path: ellipse(60% 100% at 50% 100%);
}
.cc-page-hero-inner { max-width:1280px; margin:0 auto; position:relative; z-index:1; }
.cc-page-hero h1 { font-size:clamp(1.6rem,4vw,2.4rem); font-weight:900; color:#fff; letter-spacing:-.03em; margin-bottom:.4rem; }
.cc-page-hero p  { color:#bfdbfe; font-size:.95rem; }

/* ── FILTER SIDEBAR ── */
.cc-filter-sidebar {
    width: 280px; flex-shrink: 0;
    position: sticky; top: 80px;
}
@media(max-width:900px){ .cc-filter-sidebar { width:100%; position:static; } }

.cc-filter-card {
    background: var(--cc-surface); border-radius: var(--cc-radius);
    border: 1.5px solid var(--cc-border); overflow: hidden;
    box-shadow: var(--cc-shadow-sm);
}
.cc-filter-head {
    padding: 1rem 1.25rem; background: var(--cc-gradient);
    display: flex; align-items: center; justify-content: space-between;
}
.cc-filter-head span { color:#fff; font-weight:700; font-size:.9rem; }
.cc-filter-body { padding: 1.25rem; display: flex; flex-direction: column; gap: 1.25rem; }

.cc-filter-group {}
.cc-filter-label {
    font-size: .75rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .07em; color: var(--cc-text-light); margin-bottom: .65rem;
    display: flex; align-items: center; gap: .4rem;
}
.cc-filter-label i { font-size: .7rem; }

.cc-filter-input {
    width: 100%; background: var(--cc-surface-2);
    border: 1.5px solid var(--cc-border); border-radius: 10px;
    padding: .55rem .8rem; font-size: .85rem; color: var(--cc-text);
    font-family: var(--cc-font); outline: none;
    transition: border-color .15s;
}
.cc-filter-input:focus { border-color: var(--cc-primary); }

/* Salary range */
.cc-salary-display { display:flex; justify-content:space-between; font-size:.78rem; font-weight:700; color:var(--cc-text-muted); margin-bottom:.5rem; }
input[type="range"] { width:100%; accent-color: var(--cc-primary); }

/* Radio / Check */
.cc-radio-group, .cc-check-group { display:flex; flex-direction:column; gap:.5rem; }
.cc-radio-item, .cc-check-item {
    display: flex; align-items: center; gap: .6rem;
    font-size: .85rem; color: var(--cc-text-muted); cursor: pointer;
    padding: .4rem .5rem; border-radius: 8px; transition: background .13s;
    user-select: none;
}
.cc-radio-item:hover, .cc-check-item:hover { background: var(--cc-gradient-soft); color: var(--cc-primary); }
.cc-radio-item input, .cc-check-item input { accent-color: var(--cc-primary); width:15px; height:15px; flex-shrink:0; }

/* Filter actions */
.cc-filter-actions { display:flex; gap:.6rem; }

/* ── JOB LISTINGS ── */
.cc-listings { flex: 1; min-width: 0; }

.cc-list-header {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 1.25rem; flex-wrap: wrap; gap: .75rem;
}
.cc-list-count { font-size: 1rem; font-weight: 700; color: var(--cc-text); }
.cc-list-count span { color: var(--cc-primary); }

.cc-sort-select {
    background: var(--cc-surface); border: 1.5px solid var(--cc-border);
    border-radius: 10px; padding: .45rem .8rem; font-size: .83rem;
    color: var(--cc-text); font-family: var(--cc-font); outline: none;
    cursor: pointer; transition: border-color .15s;
}
.cc-sort-select:focus { border-color: var(--cc-primary); }

/* Job card */
.cc-jc {
    background: var(--cc-surface);
    border-radius: var(--cc-radius); border: 1.5px solid var(--cc-border);
    padding: 1.4rem; margin-bottom: 1rem;
    transition: box-shadow .22s, transform .22s, border-color .22s;
    position: relative; overflow: hidden;
    display: flex; gap: 1rem; align-items: flex-start;
}
.cc-jc::before {
    content:''; position:absolute; left:0; top:0; bottom:0; width:3px;
    background:var(--cc-gradient); transform:scaleY(0); transition:transform .22s;
    transform-origin: bottom;
}
.cc-jc:hover { box-shadow: var(--cc-shadow); transform: translateX(4px); border-color: rgba(37,99,235,.22); }
.cc-jc:hover::before { transform: scaleY(1); }

.cc-jc-logo {
    width: 52px; height: 52px; border-radius: 14px; flex-shrink: 0;
    background: var(--cc-gradient); display:flex; align-items:center; justify-content:center;
    color:#fff; font-weight:800; font-size:1.2rem;
    box-shadow: 0 4px 14px rgba(37,99,235,.2);
}
.cc-jc-body { flex: 1; min-width: 0; }
.cc-jc-top { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: .5rem; margin-bottom: .5rem; }
.cc-jc-title { font-size: 1rem; font-weight: 700; color: var(--cc-text); text-decoration:none; }
.cc-jc-title:hover { color: var(--cc-primary); }
.cc-jc-company { font-size:.82rem; color:var(--cc-text-muted); font-weight:500; }
.cc-jc-meta { display:flex; flex-wrap:wrap; gap:.4rem; margin:.55rem 0; }
.cc-jc-salary { font-size:.85rem; font-weight:700; color:var(--cc-text); }
.cc-jc-footer { display:flex; gap:.6rem; align-items:center; margin-top:.9rem; flex-wrap:wrap; }

/* Match badge ring */
.cc-ring {
    display: inline-flex; align-items: center; gap: .35rem;
    font-size: .72rem; font-weight: 700; padding: 4px 9px;
    border-radius: 99px; flex-shrink: 0;
}
.cc-ring-high   { background:#f0fdf4; color:#16a34a; border:1px solid #bbf7d0; }
.cc-ring-mid    { background:#fffbeb; color:#b45309; border:1px solid #fde68a; }
.cc-ring-low    { background:#fff1f2; color:#ef4444; border:1px solid #fecdd3; }

/* Apply btn */
.cc-apply-btn {
    display: inline-flex; align-items:center; gap:.4rem;
    padding: .45rem 1.1rem; border-radius: 9px;
    font-size: .83rem; font-weight: 700; cursor: pointer;
    border: none; font-family: var(--cc-font); text-decoration: none;
    background: var(--cc-gradient); color: #fff;
    box-shadow: 0 4px 14px rgba(37,99,235,.25);
    transition: box-shadow .18s, transform .18s;
}
.cc-apply-btn:hover { box-shadow: 0 8px 24px rgba(37,99,235,.35); transform: translateY(-1px); color:#fff; }
.cc-applied-btn {
    display:inline-flex; align-items:center; gap:.4rem;
    padding:.45rem 1.1rem; border-radius:9px; font-size:.83rem; font-weight:700;
    background:#f0fdf4; color:#16a34a; border:1.5px solid #bbf7d0; cursor:default;
}
.cc-view-detail {
    display: inline-flex; align-items:center; gap:.4rem;
    padding:.45rem 1rem; border-radius:9px; font-size:.83rem; font-weight:600;
    border:1.5px solid var(--cc-border); color:var(--cc-text-muted);
    text-decoration:none; transition:border-color .15s, color .15s, background .15s;
}
.cc-view-detail:hover { border-color:var(--cc-primary); color:var(--cc-primary); background:rgba(37,99,235,.06); }

.cc-bk-btn {
    background:none; border:1.5px solid var(--cc-border); border-radius:9px;
    width:34px; height:34px; display:inline-flex; align-items:center; justify-content:center;
    color:var(--cc-text-light); cursor:pointer; transition:all .15s; font-size:.9rem;
    flex-shrink:0;
}
.cc-bk-btn:hover { border-color:#ef4444; color:#ef4444; background:#fff1f2; }
.cc-bk-btn.bookmarked { border-color:#ef4444; color:#ef4444; background:#fff1f2; }

/* Posted time */
.cc-posted { font-size:.72rem; color:var(--cc-text-light); }

/* Empty state */
.cc-empty-state {
    text-align:center; padding:4rem 2rem;
    background:var(--cc-surface); border-radius:var(--cc-radius); border:1.5px solid var(--cc-border);
}
.cc-empty-icon { font-size:3rem; margin-bottom:1rem; opacity:.3; }
.cc-empty-state h3 { font-size:1.1rem; font-weight:700; color:var(--cc-text); margin-bottom:.4rem; }
.cc-empty-state p  { font-size:.88rem; color:var(--cc-text-light); }

/* Recently viewed strip */
.cc-recent-strip {
    background: var(--cc-surface); border: 1.5px solid var(--cc-border);
    border-radius: var(--cc-radius); padding: 1rem 1.25rem; margin-bottom: 1.25rem;
}
.cc-recent-title { font-size:.78rem; font-weight:700; color:var(--cc-text-light); text-transform:uppercase; letter-spacing:.06em; margin-bottom:.65rem; }
.cc-recent-list { display:flex; gap:.5rem; flex-wrap:wrap; }
.cc-recent-chip {
    background: var(--cc-surface-2); border:1px solid var(--cc-border); border-radius:8px;
    padding:.35rem .75rem; font-size:.78rem; font-weight:600; color:var(--cc-text-muted);
    text-decoration:none; transition:border-color .13s, color .13s;
}
.cc-recent-chip:hover { border-color:var(--cc-primary); color:var(--cc-primary); }

/* Skeleton shimmer rows */
.cc-jc-skeleton {
    background:var(--cc-surface); border-radius:var(--cc-radius); border:1.5px solid var(--cc-border);
    padding:1.4rem; margin-bottom:1rem; display:flex; gap:1rem;
}
.cc-sk-logo { width:52px; height:52px; border-radius:14px; flex-shrink:0; }
.cc-sk-body { flex:1; display:flex; flex-direction:column; gap:.55rem; }
</style>

{{-- ── PAGE HERO ── --}}
<div class="cc-page-hero">
    <div class="cc-page-hero-inner">
        <h1><i class="fas fa-briefcase" style="font-size:.85em;margin-right:.4rem;"></i>Browse Jobs</h1>
        <p>Find the perfect role from {{ $totalJobs }}+ opportunities across all industries.</p>
    </div>
</div>

<div class="cc-jobs-page">

    {{-- ═══════════════════════════════════════════════════
         LEFT — FILTER SIDEBAR
    ═══════════════════════════════════════════════════ --}}
    <aside class="cc-filter-sidebar">
        <div class="cc-filter-card">
            <div class="cc-filter-head">
                <span><i class="fas fa-sliders-h mr-2"></i>Filters</span>
                <a href="{{ route('jobs.index') }}" style="color:rgba(255,255,255,.7);font-size:.75rem;font-weight:600;text-decoration:none;">Reset All</a>
            </div>
            <div class="cc-filter-body">
                <form action="{{ route('jobs.index') }}" method="GET" id="filterForm">

                    {{-- Search --}}
                    <div class="cc-filter-group">
                        <div class="cc-filter-label"><i class="fas fa-search"></i> Keyword</div>
                        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Title or skill…" class="cc-filter-input">
                    </div>

                    {{-- Location --}}
                    <div class="cc-filter-group">
                        <div class="cc-filter-label"><i class="fas fa-map-marker-alt"></i> Location</div>
                        <input type="text" name="location" value="{{ request('location') }}" placeholder="City or remote" class="cc-filter-input">
                    </div>

                    {{-- Salary slider --}}
                    <div class="cc-filter-group">
                        <div class="cc-filter-label"><i class="fas fa-rupee-sign"></i> Salary Range</div>
                        <div class="cc-salary-display">
                            <span>₹<span id="minVal">{{ request('salary_min', 0) }}</span></span>
                            <span>₹<span id="maxVal">{{ request('salary_max', 150000) }}</span></span>
                        </div>
                        <input type="range" id="salMin" name="salary_min" min="0" max="150000" step="5000" value="{{ request('salary_min', 0) }}" oninput="document.getElementById('minVal').textContent=this.value">
                        <input type="range" id="salMax" name="salary_max" min="0" max="150000" step="5000" value="{{ request('salary_max', 150000) }}" oninput="document.getElementById('maxVal').textContent=this.value" style="margin-top:.3rem;">
                    </div>

                    {{-- Job Type --}}
                    <div class="cc-filter-group">
                        <div class="cc-filter-label"><i class="fas fa-briefcase"></i> Job Type</div>
                        <div class="cc-radio-group">
                            @foreach(['full-time'=>'Full-time','internship'=>'Internship','contract'=>'Contract','part-time'=>'Part-time'] as $val=>$lbl)
                                <label class="cc-radio-item">
                                    <input type="radio" name="job_type" value="{{ $val }}" {{ request('job_type')==$val?'checked':'' }}>
                                    {{ $lbl }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Skills --}}
                    <div class="cc-filter-group">
                        <div class="cc-filter-label"><i class="fas fa-code"></i> Skills</div>
                        @php $selSkills = request('skills') ? (is_array(request('skills')) ? request('skills') : explode(',',request('skills'))) : []; @endphp
                        <div class="cc-check-group">
                            @foreach(['Laravel','React','Vue.js','Python','Java','UI/UX','MySQL','Docker','DevOps'] as $sk)
                                <label class="cc-check-item">
                                    <input type="checkbox" name="skills[]" value="{{ $sk }}" {{ in_array($sk,$selSkills)?'checked':'' }}>
                                    {{ $sk }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Remote --}}
                    <div class="cc-filter-group">
                        <label class="cc-check-item" style="background:var(--cc-gradient-soft);border-radius:10px;padding:.6rem .8rem;">
                            <input type="checkbox" name="remote" value="1" {{ request('remote')?'checked':'' }}>
                            <span style="font-weight:700;color:var(--cc-primary);">🌍 Remote Only</span>
                        </label>
                    </div>

                    <div class="cc-filter-actions">
                        <button type="submit" class="cc-btn cc-btn-primary" style="flex:1;justify-content:center;padding:.65rem;">
                            <i class="fas fa-search"></i> Apply
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </aside>

    {{-- ═══════════════════════════════════════════════════
         RIGHT — LISTINGS
    ═══════════════════════════════════════════════════ --}}
    <div class="cc-listings">

        {{-- Recently Viewed --}}
        <div class="cc-recent-strip" id="recentStrip" style="display:none;">
            <div class="cc-recent-title"><i class="fas fa-clock mr-1"></i> Recently Viewed</div>
            <div class="cc-recent-list" id="recentList"></div>
        </div>

        {{-- Header --}}
        <div class="cc-list-header">
            <div class="cc-list-count"><span>{{ $totalJobs }}</span> Jobs Found</div>
            <div style="display:flex;align-items:center;gap:.5rem;">
                <label style="font-size:.82rem;color:var(--cc-text-light);font-weight:600;">Sort:</label>
                <select name="sort" form="filterForm" class="cc-sort-select" onchange="document.getElementById('filterForm').submit()">
                    <option value="latest"     {{ request('sort','latest')=='latest'     ?'selected':'' }}>Latest</option>
                    <option value="salary_high"{{ request('sort')=='salary_high'         ?'selected':'' }}>Salary High</option>
                    <option value="best_match" {{ request('sort')=='best_match'          ?'selected':'' }}>Best Match 🔥</option>
                </select>
            </div>
        </div>

        {{-- Job Cards --}}
        <div id="jobsList">
            @forelse($jobs as $job)
                @php
                    $match = rand(55,98);
                    $ringClass = $match>=80 ? 'cc-ring-high' : ($match>=65 ? 'cc-ring-mid' : 'cc-ring-low');
                    $hasApplied = auth()->check() ? \App\Models\JobApplication::where('job_id',$job->id)->where('user_id',auth()->id())->exists() : false;
                @endphp
                <div class="cc-jc" onclick="ccTrackJobView({{ $job->id }}, '{{ addslashes($job->title) }}', '{{ addslashes($job->company->name ?? '') }}', '{{ $job->slug }}')">
                    <div class="cc-jc-logo">{{ strtoupper(substr($job->company->name ?? 'J', 0, 1)) }}</div>
                    <div class="cc-jc-body">
                        <div class="cc-jc-top">
                            <div>
                                <a href="{{ route('jobs.show', $job->slug) }}" class="cc-jc-title">{{ $job->title }}</a>
                                <div class="cc-jc-company">
                                    <a href="{{ $job->company && $job->company->slug ? route('companies.show', $job->company->slug) : '#' }}" style="text-decoration:none;color:inherit;">
                                        {{ $job->company->name ?? 'Unknown Company' }}
                                    </a>
                                </div>
                            </div>
                            <div style="display:flex;flex-direction:column;align-items:flex-end;gap:.35rem;">
                                <span class="cc-ring {{ $ringClass }}">⚡ {{ $match }}% Match</span>
                                <span class="cc-posted"><i class="fas fa-clock" style="font-size:.63rem;"></i> {{ $job->posted_at?$job->posted_at->diffForHumans():'Recently' }}</span>
                            </div>
                        </div>

                        <div class="cc-jc-meta">
                            <span class="cc-badge cc-badge-gray"><i class="fas fa-map-marker-alt" style="font-size:.65rem;"></i> {{ $job->location }}</span>
                            @if($job->remote) <span class="cc-badge cc-badge-blue">Remote</span> @endif
                            <span class="cc-badge cc-badge-purple">{{ ucfirst(str_replace('-',' ',$job->job_type)) }}</span>
                        </div>

                        @if($job->skills && count($job->skills))
                            <div style="display:flex;flex-wrap:wrap;gap:.3rem;margin-bottom:.1rem;">
                                @foreach(array_slice($job->skills, 0, 4) as $skill)
                                    <span class="cc-badge cc-badge-gray">{{ $skill }}</span>
                                @endforeach
                                @if(count($job->skills) > 4) <span class="cc-badge cc-badge-gray">+{{ count($job->skills)-4 }}</span> @endif
                            </div>
                        @endif

                        <div class="cc-jc-footer">
                            <div class="cc-jc-salary">₹{{ number_format($job->min_salary) }} – ₹{{ number_format($job->max_salary) }}</div>
                            <div style="display:flex;gap:.5rem;align-items:center;margin-left:auto;">
                                @auth
                                    @if($hasApplied)
                                        <span class="cc-applied-btn"><i class="fas fa-check-circle"></i> Applied</span>
                                    @else
                                        <form action="{{ route('jobs.apply', $job->id) }}" method="POST" style="margin:0;">
                                            @csrf
                                            <button type="submit" class="cc-apply-btn"><i class="fas fa-paper-plane"></i> Apply</button>
                                        </form>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="cc-apply-btn"><i class="fas fa-right-to-bracket"></i> Login</a>
                                @endauth
                                <a href="{{ route('jobs.show', $job->slug) }}" class="cc-view-detail">Details</a>
                                <button class="cc-bk-btn" onclick="handleBookmark(this, {{ $job->id }}, '{{ addslashes($job->title) }}', '{{ $job->slug }}')" title="Bookmark">
                                    <i class="far fa-bookmark"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="cc-empty-state">
                    <div class="cc-empty-icon">🔍</div>
                    <h3>No jobs found</h3>
                    <p>Try adjusting your filters or search with different keywords.</p>
                    <a href="{{ route('jobs.index') }}" class="cc-btn cc-btn-primary" style="display:inline-flex;margin-top:1.25rem;padding:.6rem 1.4rem;">Clear Filters</a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div style="margin-top:1.5rem;">
            {{ $jobs->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    /* ── Recently Viewed ── */
    const recent = JSON.parse(localStorage.getItem('cc-recent-jobs') || '[]');
    if (recent.length) {
        const strip = document.getElementById('recentStrip');
        const list  = document.getElementById('recentList');
        strip.style.display = 'block';
        recent.forEach(j => {
            const a = document.createElement('a');
            a.className = 'cc-recent-chip';
            a.href = `/jobs/${j.slug}`;
            a.textContent = j.title;
            list.appendChild(a);
        });
    }

    /* ── Bookmark state restore ── */
    document.querySelectorAll('.cc-bk-btn').forEach(btn => {
        const id = parseInt(btn.dataset?.jobId || btn.getAttribute('onclick')?.match(/\d+/)?.[0]);
        if (id && ccIsBookmarked(id)) {
            btn.classList.add('bookmarked');
            btn.innerHTML = '<i class="fas fa-bookmark"></i>';
        }
    });
});

function handleBookmark(btn, id, title, slug) {
    const saved = ccToggleBookmark(id, title, slug);
    if (saved) {
        btn.classList.add('bookmarked');
        btn.innerHTML = '<i class="fas fa-bookmark"></i>';
    } else {
        btn.classList.remove('bookmarked');
        btn.innerHTML = '<i class="far fa-bookmark"></i>';
    }
}
</script>
@endsection