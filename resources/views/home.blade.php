@extends('layouts.public')
@section('title', 'CareerConnect — Find Your Dream Job')

@section('content')
<style>
/* ── HOME HERO ── */
.cc-hero {
    position: relative; overflow: hidden;
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #1e3a8a 100%);
    padding: 7rem 0 9rem; text-align: center; color: #fff;
}
.cc-hero-orb {
    position: absolute; border-radius: 50%; filter: blur(80px); pointer-events: none;
    animation: cc-float 8s ease-in-out infinite alternate;
}
@keyframes cc-float {
    from { transform: translate(0,0) scale(1); }
    to   { transform: translate(20px,-20px) scale(1.08); }
}
.cc-hero::after {
    content: ''; position: absolute; bottom: -1px; left:0; right:0; height: 80px;
    background: var(--cc-bg);
    clip-path: ellipse(60% 100% at 50% 100%);
}
.cc-hero-tag {
    display: inline-flex; align-items: center; gap: .5rem;
    background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2);
    color: #bfdbfe; padding: .35rem .9rem; border-radius: 99px;
    font-size: .8rem; font-weight: 600; margin-bottom: 1.5rem;
    backdrop-filter: blur(10px);
}
.cc-hero h1 {
    font-size: clamp(2.4rem, 6vw, 4rem);
    font-weight: 900; letter-spacing: -.04em; line-height: 1.1;
    margin-bottom: 1.1rem;
}
.cc-hero-sub {
    font-size: 1.1rem; color: #93c5fd; margin-bottom: 2.5rem;
    max-width: 520px; margin-left: auto; margin-right: auto; line-height: 1.6;
}

/* Search bar */
.cc-search-box {
    max-width: 720px; margin: 0 auto;
    background: rgba(255,255,255,.95);
    border-radius: 18px; padding: 1rem 1rem 1rem;
    box-shadow: 0 20px 60px rgba(0,0,0,.35);
    backdrop-filter: blur(10px);
}
[data-theme="dark"] .cc-search-box { background: rgba(30,41,59,.95); }

.cc-search-row { display: flex; gap: .6rem; align-items: center; flex-wrap: wrap; }
.cc-search-field {
    flex: 1; min-width: 160px; display: flex; align-items: center;
    gap: .5rem; background: var(--cc-surface-2);
    border: 1.5px solid var(--cc-border); border-radius: 12px; padding: .65rem .9rem;
    transition: border-color .15s;
}
.cc-search-field:focus-within { border-color: var(--cc-primary); }
.cc-search-field i { color: var(--cc-text-light); font-size: .9rem; flex-shrink: 0; }
.cc-search-field input {
    flex: 1; border: none; outline: none; background: transparent;
    font-size: .9rem; font-family: var(--cc-font); color: var(--cc-text);
}
.cc-search-field input::placeholder { color: var(--cc-text-light); }

.cc-remote-toggle {
    display: flex; align-items: center; gap: .4rem;
    font-size: .82rem; font-weight: 600; color: var(--cc-text-muted);
    cursor: pointer; white-space: nowrap; flex-shrink: 0;
    user-select: none;
}
.cc-remote-toggle input { accent-color: var(--cc-primary); width: 15px; height: 15px; }

.cc-search-submit {
    background: var(--cc-gradient); color: #fff; border: none;
    border-radius: 12px; padding: .65rem 1.5rem;
    font-weight: 700; font-size: .9rem; cursor: pointer;
    font-family: var(--cc-font); white-space: nowrap;
    box-shadow: 0 4px 14px rgba(37,99,235,.4);
    transition: box-shadow .18s, transform .18s; flex-shrink: 0;
}
.cc-search-submit:hover { box-shadow: 0 8px 24px rgba(37,99,235,.5); transform: translateY(-1px); }

.cc-search-tags { display: flex; flex-wrap: wrap; gap: .5rem; margin-top: .75rem; }
.cc-search-tag {
    background: none; border: 1px solid var(--cc-border);
    color: var(--cc-text-muted); padding: 3px 10px; border-radius: 99px;
    font-size: .75rem; cursor: pointer; font-family: var(--cc-font);
    transition: border-color .15s, color .15s;
}
.cc-search-tag:hover { border-color: var(--cc-primary); color: var(--cc-primary); }

/* Stats bar */
.cc-stats-bar {
    max-width: 900px; margin: 0 auto; padding: 0 1.5rem;
    display: grid; grid-template-columns: repeat(4,1fr); gap: 1rem;
    margin-top: -3rem; position: relative; z-index: 10;
}
@media(max-width:640px){ .cc-stats-bar { grid-template-columns: repeat(2,1fr); gap:.75rem; } }
.cc-stat-card {
    background: var(--cc-surface);
    border-radius: 16px; padding: 1.4rem 1rem; text-align: center;
    box-shadow: 0 8px 32px rgba(0,0,0,.1);
    border: 1px solid var(--cc-border);
    transition: transform .2s;
}
.cc-stat-card:hover { transform: translateY(-3px); }
.cc-stat-num {
    font-size: 1.9rem; font-weight: 900; letter-spacing: -.04em;
    background: var(--cc-gradient);
    -webkit-background-clip: text; background-clip: text;
    -webkit-text-fill-color: transparent;
}
.cc-stat-lbl { font-size: .78rem; color: var(--cc-text-light); font-weight: 600; margin-top: .2rem; text-transform: uppercase; letter-spacing: .05em; }

/* Section */
.cc-section { max-width: 1280px; margin: 0 auto; padding: 5rem 1.5rem; }
.cc-section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; flex-wrap: wrap; gap: 1rem; }
.cc-section-title { font-size: 1.7rem; font-weight: 800; letter-spacing: -.02em; color: var(--cc-text); }
.cc-section-title span { background: var(--cc-gradient); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }
.cc-section-desc { font-size: .9rem; color: var(--cc-text-muted); max-width: 480px; margin-top: .4rem; }

/* Featured Job Cards */
.cc-jobs-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; }
@media(max-width:900px){ .cc-jobs-grid { grid-template-columns: repeat(2,1fr); } }
@media(max-width:600px){ .cc-jobs-grid { grid-template-columns: 1fr; } }

.cc-job-card {
    background: var(--cc-surface); border-radius: var(--cc-radius);
    border: 1.5px solid var(--cc-border); padding: 1.4rem;
    transition: box-shadow .22s, transform .22s, border-color .22s;
    display: flex; flex-direction: column; gap: .75rem;
    position: relative; overflow: hidden;
}
.cc-job-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
    background: var(--cc-gradient); opacity: 0; transition: opacity .22s;
}
.cc-job-card:hover { box-shadow: 0 12px 40px rgba(37,99,235,.14); transform: translateY(-4px); border-color: rgba(37,99,235,.25); }
.cc-job-card:hover::before { opacity: 1; }

.cc-job-head { display: flex; align-items: flex-start; justify-content: space-between; gap: .5rem; }
.cc-company-avatar {
    width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0;
    background: var(--cc-gradient); display: flex; align-items: center;
    justify-content: center; color: #fff; font-weight: 800; font-size: 1.1rem;
    box-shadow: 0 4px 14px rgba(37,99,235,.25);
}
.cc-job-title { font-size: .97rem; font-weight: 700; color: var(--cc-text); line-height: 1.3; margin-bottom: .15rem; }
.cc-job-company { font-size: .8rem; color: var(--cc-text-muted); font-weight: 500; }
.cc-job-meta { display: flex; flex-wrap: wrap; gap: .4rem; }
.cc-job-footer { display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: .5rem; border-top: 1px solid var(--cc-border); }
.cc-job-salary { font-size: .82rem; font-weight: 700; color: var(--cc-text); }
.cc-view-btn {
    font-size: .8rem; font-weight: 700; color: var(--cc-primary);
    text-decoration: none; display: flex; align-items: center; gap: .3rem;
    padding: .3rem .7rem; border-radius: 7px;
    background: rgba(37,99,235,.07);
    transition: background .15s;
}
.cc-view-btn:hover { background: rgba(37,99,235,.15); color: var(--cc-primary); }

/* Match ring badge */
.cc-match-badge {
    display: inline-flex; align-items: center; gap: .35rem;
    font-size: .7rem; font-weight: 700; padding: 3px 9px;
    border-radius: 99px;
}
.cc-match-high   { background: #f0fdf4; color: #16a34a; }
.cc-match-mid    { background: #fffbeb; color: #b45309; }
.cc-match-low    { background: #fff1f2; color: #ef4444; }

/* Skeleton cards */
.cc-skeleton-card {
    background: var(--cc-surface); border-radius: var(--cc-radius);
    border: 1.5px solid var(--cc-border); padding: 1.4rem;
}
.cc-sk-line { height: 14px; border-radius: 6px; margin-bottom: .6rem; }
.cc-sk-short{ width: 40%; }
.cc-sk-mid  { width: 65%; }
.cc-sk-full { width: 100%; }
.cc-sk-sm   { height: 10px; }

/* Categories */
.cc-cats-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 1rem; }
@media(max-width:900px){ .cc-cats-grid { grid-template-columns: repeat(2,1fr); } }
@media(max-width:480px){ .cc-cats-grid { grid-template-columns: 1fr; } }

.cc-cat-card {
    background: var(--cc-surface); border: 1.5px solid var(--cc-border);
    border-radius: var(--cc-radius); padding: 1.5rem; text-align: center;
    cursor: pointer; text-decoration: none; display: block;
    transition: all .22s;
}
.cc-cat-card:hover { border-color: var(--cc-primary); box-shadow: var(--cc-shadow-glow); transform: translateY(-3px); }
.cc-cat-icon {
    width: 56px; height: 56px; border-radius: 16px; margin: 0 auto .9rem;
    display: flex; align-items: center; justify-content: center; font-size: 1.4rem;
    background: var(--cc-gradient-soft);
}
.cc-cat-card:hover .cc-cat-icon { background: var(--cc-gradient); }
.cc-cat-card:hover .cc-cat-icon i { color: #fff; }
.cc-cat-name { font-size: .9rem; font-weight: 700; color: var(--cc-text); }
.cc-cat-count { font-size: .77rem; color: var(--cc-text-light); margin-top: .2rem; }

/* Companies grid */
.cc-companies-grid { display: grid; grid-template-columns: repeat(6,1fr); gap: 1rem; }
@media(max-width:1000px){ .cc-companies-grid { grid-template-columns: repeat(4,1fr); } }
@media(max-width:640px) { .cc-companies-grid { grid-template-columns: repeat(2,1fr); } }

.cc-company-chip {
    background: var(--cc-surface); border: 1.5px solid var(--cc-border);
    border-radius: 14px; padding: 1.1rem .75rem; text-align: center;
    transition: all .22s; cursor: pointer; display: block; text-decoration: none;
}
.cc-company-chip:hover { border-color: #7c3aed; box-shadow: 0 8px 24px rgba(124,58,237,.15); transform: translateY(-3px); }
.cc-company-logo {
    width: 48px; height: 48px; border-radius: 12px;
    background: var(--cc-gradient); margin: 0 auto .6rem;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-weight: 800; font-size: 1.1rem;
}
.cc-company-name { font-size: .82rem; font-weight: 700; color: var(--cc-text); }
.cc-company-jobs { font-size: .72rem; color: var(--cc-text-light); }

/* CTA Strip */
.cc-cta-strip {
    background: linear-gradient(135deg,#1e3a8a 0%,#4c1d95 100%);
    padding: 5rem 1.5rem; text-align: center; color: #fff; position: relative; overflow: hidden;
}
.cc-cta-strip::before {
    content:''; position:absolute; inset:0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.cc-cta-strip h2 { font-size: clamp(1.6rem,4vw,2.6rem); font-weight: 900; letter-spacing:-.03em; margin-bottom:.8rem; position:relative; }
.cc-cta-strip p  { color: #bfdbfe; font-size:1rem; margin-bottom:2rem; position:relative; }
.cc-cta-btns { display:flex; gap:1rem; justify-content:center; flex-wrap:wrap; position:relative; }
.cc-cta-white {
    background: #fff; color: #1e3a8a; font-weight: 700; font-size: .95rem;
    padding: .8rem 2rem; border-radius: 12px; text-decoration: none;
    box-shadow: 0 8px 24px rgba(0,0,0,.2);
    transition: box-shadow .18s, transform .18s;
    display: inline-flex; align-items: center; gap: .5rem;
}
.cc-cta-white:hover { transform: translateY(-2px); box-shadow: 0 14px 36px rgba(0,0,0,.3); color: #1e3a8a; }
.cc-cta-ghost {
    background: transparent; color: #fff; font-weight: 700; font-size: .95rem;
    padding: .8rem 2rem; border-radius: 12px; text-decoration: none;
    border: 2px solid rgba(255,255,255,.4);
    transition: background .18s, border-color .18s, transform .18s;
    display: inline-flex; align-items: center; gap: .5rem;
}
.cc-cta-ghost:hover { background: rgba(255,255,255,.1); border-color: #fff; transform: translateY(-2px); color:#fff; }

/* Gray background sections */
.cc-bg-alt { background: var(--cc-surface-2); }
[data-theme="dark"] .cc-bg-alt { background: #0d1526; }
</style>

{{-- ══════════════════════════════════════════════════════
     HERO
══════════════════════════════════════════════════════ --}}
<section class="cc-hero">
    <!-- Floating Orbs -->
    <div class="cc-hero-orb" style="width:500px;height:500px;background:rgba(99,102,241,.25);top:-150px;left:-100px;animation-delay:0s;"></div>
    <div class="cc-hero-orb" style="width:400px;height:400px;background:rgba(59,130,246,.2);bottom:-100px;right:-80px;animation-delay:2s;"></div>
    <div class="cc-hero-orb" style="width:300px;height:300px;background:rgba(167,139,250,.2);top:30%;left:50%;transform:translateX(-50%);animation-delay:4s;"></div>

    <div style="position:relative;z-index:2;padding:0 1.5rem;">
        <div class="cc-hero-tag"><i class="fas fa-bolt"></i> {{ $totalJobs }}+ Jobs Available Right Now</div>

        <h1>Find the Right Job<br>
            <span style="background:linear-gradient(135deg,#60a5fa,#a78bfa);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;">
                For Your Career
            </span>
        </h1>
        <p class="cc-hero-sub">
            Register your profile, get matched with top opportunities, and apply in one click.
        </p>

        <!-- Search Box -->
        <div class="cc-search-box">
            <form action="{{ route('jobs.index') }}" method="GET">
                <div class="cc-search-row">
                    <div class="cc-search-field" style="flex:2;">
                        <i class="fas fa-search"></i>
                        <input type="text" name="keyword" placeholder="Job title, skill or keyword…">
                    </div>
                    <div class="cc-search-field" style="flex:1.5;">
                        <i class="fas fa-map-marker-alt"></i>
                        <input type="text" name="location" placeholder="City or location">
                    </div>
                    <label class="cc-remote-toggle">
                        <input type="checkbox" name="remote" value="1"> Remote
                    </label>
                    <button type="submit" class="cc-search-submit">
                        <i class="fas fa-search"></i> Find Jobs
                    </button>
                </div>
                <div class="cc-search-tags" style="margin-top:.65rem;">
                    <span style="font-size:.72rem;color:var(--cc-text-light);font-weight:600;align-self:center;">Popular:</span>
                    @foreach(['Laravel', 'React', 'Python', 'UI/UX', 'DevOps'] as $tag)
                        <button type="submit" name="keyword" value="{{ $tag }}" class="cc-search-tag">{{ $tag }}</button>
                    @endforeach
                </div>
            </form>
        </div>
    </div>
</section>

{{-- ══ STATS BAR ══ --}}
<div style="background:var(--cc-bg);padding-top:1px;">
    <div class="cc-stats-bar">
        <div class="cc-stat-card">
            <div class="cc-stat-num" id="stat-jobs">{{ $totalJobs }}</div>
            <div class="cc-stat-lbl"><i class="fas fa-briefcase mr-1"></i> Active Jobs</div>
        </div>
        <div class="cc-stat-card">
            <div class="cc-stat-num" id="stat-companies">{{ $topCompanies->count() * 20 }}+</div>
            <div class="cc-stat-lbl"><i class="fas fa-building mr-1"></i> Companies</div>
        </div>
        <div class="cc-stat-card">
            <div class="cc-stat-num">50K+</div>
            <div class="cc-stat-lbl"><i class="fas fa-users mr-1"></i> Candidates</div>
        </div>
        <div class="cc-stat-card">
            <div class="cc-stat-num">95%</div>
            <div class="cc-stat-lbl"><i class="fas fa-star mr-1"></i> Success Rate</div>
        </div>
    </div>
</div>

{{-- ══ FEATURED JOBS ══ --}}
<section class="cc-section">
    <div class="cc-section-header">
        <div>
            <div class="cc-section-title">Featured <span>Jobs</span></div>
            <p class="cc-section-desc">Hand-picked opportunities from top companies hiring right now.</p>
        </div>
        <a href="{{ route('jobs.index') }}" class="cc-btn cc-btn-outline" style="font-size:.85rem;padding:.55rem 1.2rem;">
            View All Jobs <i class="fas fa-arrow-right" style="font-size:.8rem;"></i>
        </a>
    </div>

    <div class="cc-jobs-grid" id="featuredJobsGrid">
        @forelse($featuredJobs as $job)
            @php $match = rand(65, 98); $matchClass = $match >= 80 ? 'cc-match-high' : ($match >= 65 ? 'cc-match-mid' : 'cc-match-low'); @endphp
            <div class="cc-job-card" onclick="ccTrackJobView({{ $job->id }}, '{{ addslashes($job->title) }}', '{{ addslashes($job->company->name ?? '') }}', '{{ $job->slug }}')">
                <div class="cc-job-head">
                    <div style="display:flex;align-items:flex-start;gap:.75rem;">
                        <div class="cc-company-avatar">{{ strtoupper(substr($job->company->name ?? 'J', 0, 1)) }}</div>
                        <div>
                            <div class="cc-job-title">{{ $job->title }}</div>
                            <div class="cc-job-company">{{ $job->company->name ?? 'Unknown Company' }}</div>
                        </div>
                    </div>
                    <span class="cc-match-badge {{ $matchClass }}">⚡ {{ $match }}%</span>
                </div>

                <div class="cc-job-meta">
                    <span class="cc-badge cc-badge-gray"><i class="fas fa-map-marker-alt" style="font-size:.65rem;"></i> {{ $job->location }}</span>
                    @if($job->remote) <span class="cc-badge cc-badge-blue">Remote</span> @endif
                    <span class="cc-badge cc-badge-purple">{{ ucfirst(str_replace('-',' ',$job->job_type)) }}</span>
                </div>

                @if($job->skills && count($job->skills))
                    <div style="display:flex;flex-wrap:wrap;gap:.35rem;">
                        @foreach(array_slice($job->skills, 0, 3) as $skill)
                            <span class="cc-badge cc-badge-gray">{{ $skill }}</span>
                        @endforeach
                        @if(count($job->skills) > 3)
                            <span class="cc-badge cc-badge-gray">+{{ count($job->skills)-3 }}</span>
                        @endif
                    </div>
                @endif

                <div class="cc-job-footer">
                    <div>
                        <div class="cc-job-salary">₹{{ number_format($job->min_salary) }} – ₹{{ number_format($job->max_salary) }}</div>
                        <div style="font-size:.72rem;color:var(--cc-text-light);margin-top:.1rem;">
                            <i class="fas fa-clock" style="font-size:.65rem;"></i>
                            {{ $job->posted_at ? $job->posted_at->diffForHumans() : 'Recently' }}
                        </div>
                    </div>
                    <a href="{{ route('jobs.show', $job->slug) }}" class="cc-view-btn">
                        View <i class="fas fa-arrow-right" style="font-size:.7rem;"></i>
                    </a>
                </div>
            </div>
        @empty
            {{-- Skeleton fallback --}}
            @for($i=0; $i<6; $i++)
                <div class="cc-skeleton-card">
                    <div class="cc-skeleton cc-sk-line cc-sk-mid"></div>
                    <div class="cc-skeleton cc-sk-line cc-sk-short" style="margin-top:.4rem;"></div>
                    <div style="display:flex;gap:.4rem;margin:.75rem 0;">
                        <div class="cc-skeleton cc-sk-line" style="width:60px;height:22px;border-radius:99px;"></div>
                        <div class="cc-skeleton cc-sk-line" style="width:50px;height:22px;border-radius:99px;"></div>
                    </div>
                    <div class="cc-skeleton cc-sk-line cc-sk-full" style="margin-top:auto;"></div>
                </div>
            @endfor
        @endforelse
    </div>
</section>

{{-- ══ CATEGORIES ══ --}}
<section class="cc-bg-alt" style="padding:4rem 0;">
    <div class="cc-section" style="padding-top:0;padding-bottom:0;">
        <div class="cc-section-header">
            <div>
                <div class="cc-section-title">Browse by <span>Category</span></div>
                <p class="cc-section-desc">Explore opportunities across top industry sectors.</p>
            </div>
        </div>
        <div class="cc-cats-grid">
            @php
                $defaultCats = [
                    ['icon'=>'fa-code',          'color'=>'#2563eb', 'name'=>'Technology',  'count'=>120],
                    ['icon'=>'fa-paint-brush',   'color'=>'#7c3aed', 'name'=>'Design',      'count'=>85],
                    ['icon'=>'fa-chart-line',    'color'=>'#0891b2', 'name'=>'Marketing',   'count'=>64],
                    ['icon'=>'fa-dollar-sign',   'color'=>'#16a34a', 'name'=>'Finance',     'count'=>47],
                    ['icon'=>'fa-stethoscope',   'color'=>'#dc2626', 'name'=>'Healthcare',  'count'=>38],
                    ['icon'=>'fa-book',          'color'=>'#d97706', 'name'=>'Education',   'count'=>52],
                    ['icon'=>'fa-truck',         'color'=>'#64748b', 'name'=>'Logistics',   'count'=>29],
                    ['icon'=>'fa-building',      'color'=>'#0f172a', 'name'=>'Management',  'count'=>73],
                ];
            @endphp
            @foreach(count($categories) ? $categories : $defaultCats as $cat)
                <a href="{{ route('jobs.index', ['keyword' => $cat['name'] ?? ($cat->name ?? '')]) }}" class="cc-cat-card">
                    <div class="cc-cat-icon">
                        <i class="fas {{ $cat['icon'] ?? ($cat->icon ?? 'fa-briefcase') }}" style="color:{{ $cat['color'] ?? '#2563eb' }};"></i>
                    </div>
                    <div class="cc-cat-name">{{ $cat['name'] ?? $cat->name }}</div>
                    <div class="cc-cat-count">{{ $cat['count'] ?? $cat->jobs_count ?? 0 }} jobs</div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ══ TOP COMPANIES ══ --}}
<section class="cc-section">
    <div class="cc-section-header">
        <div>
            <div class="cc-section-title">Top <span>Companies</span></div>
            <p class="cc-section-desc">World-class employers actively hiring on CareerConnect.</p>
        </div>
        <a href="{{ route('companies.index') }}" class="cc-btn cc-btn-outline" style="font-size:.85rem;padding:.55rem 1.2rem;">
            All Companies <i class="fas fa-arrow-right" style="font-size:.8rem;"></i>
        </a>
    </div>
    <div class="cc-companies-grid">
        @forelse($topCompanies as $company)
            <a href="{{ $company->slug ? route('companies.show', $company->slug) : '#' }}" class="cc-company-chip">
                <div class="cc-company-logo">{{ strtoupper(substr($company->name, 0, 1)) }}</div>
                <div class="cc-company-name">{{ $company->name }}</div>
                <div class="cc-company-jobs">{{ $company->jobs_count ?? 0 }} open jobs</div>
            </a>
        @empty
            @for($i=0;$i<6;$i++)
                <div style="background:var(--cc-surface);border:1.5px solid var(--cc-border);border-radius:14px;padding:1.1rem;text-align:center;">
                    <div class="cc-skeleton" style="width:48px;height:48px;border-radius:12px;margin:0 auto .6rem;"></div>
                    <div class="cc-skeleton cc-sk-line" style="width:70%;margin:0 auto .4rem;height:12px;"></div>
                    <div class="cc-skeleton cc-sk-line" style="width:50%;margin:0 auto;height:10px;"></div>
                </div>
            @endfor
        @endforelse
    </div>
</section>

{{-- ══ CTA STRIP ══ --}}
<section class="cc-cta-strip">
    <h2>Ready to Launch<br>Your Career?</h2>
    <p>Join 50,000+ professionals who found their dream jobs through CareerConnect.</p>
    <div class="cc-cta-btns">
        <a href="{{ route('register') }}" class="cc-cta-white">
            <i class="fas fa-rocket"></i> Get Started Free
        </a>
        <a href="{{ route('jobs.index') }}" class="cc-cta-ghost">
            <i class="fas fa-search"></i> Browse All Jobs
        </a>
    </div>
</section>
@endsection