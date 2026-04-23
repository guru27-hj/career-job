@extends('layouts.public')
@section('title', 'Top Companies — CareerConnect')

@section('content')
<style>
/* ── COMPANIES PAGE ── */
.cc-co-hero {
    background: linear-gradient(135deg,#0f172a 0%,#1e1b4b 40%,#1e3a8a 100%);
    padding: 3.5rem 1.5rem 5rem; position: relative; overflow: hidden; text-align:center;
}
.cc-co-hero::before {
    content:''; position:absolute; top:-80px; left:-80px; width:400px; height:400px;
    background:rgba(124,58,237,.2); border-radius:50%; filter:blur(80px);
}
.cc-co-hero::after {
    content:''; position:absolute; bottom:-1px; left:0; right:0; height:70px;
    background:var(--cc-bg); clip-path:ellipse(60% 100% at 50% 100%);
}
.cc-co-hero > * { position:relative; z-index:1; }
.cc-co-hero h1 { font-size:clamp(1.8rem,5vw,3rem); font-weight:900; color:#fff; letter-spacing:-.04em; margin-bottom:.7rem; }
.cc-co-hero p  { color:#bfdbfe; font-size:1rem; max-width:480px; margin:0 auto 1.8rem; }

/* Search bar */
.cc-co-search {
    max-width:560px; margin:0 auto;
    display:flex; background:#fff; border-radius:14px;
    overflow:hidden; box-shadow:0 16px 48px rgba(0,0,0,.3);
}
[data-theme="dark"] .cc-co-search { background:#1e293b; border:1px solid #334155; }
.cc-co-search input { flex:1; padding:.85rem 1.1rem; border:none; outline:none; font-size:.9rem; font-family:var(--cc-font); color:var(--cc-text); background:transparent; }
.cc-co-search input::placeholder { color:#94a3b8; }
.cc-co-search button { background:var(--cc-gradient); color:#fff; border:none; padding:.85rem 1.5rem; font-weight:700; font-size:.88rem; cursor:pointer; font-family:var(--cc-font); transition:opacity .15s; white-space:nowrap; }
.cc-co-search button:hover { opacity:.88; }

/* Stat chips */
.cc-co-stats { display:flex; gap:.75rem; justify-content:center; flex-wrap:wrap; margin-top:1.25rem; }
.cc-co-stat { background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15); color:#e0e7ff; padding:.3rem .9rem; border-radius:99px; font-size:.78rem; font-weight:600; }

/* Grid */
.cc-co-grid { max-width:1280px; margin:0 auto; padding:2.5rem 1.5rem 4rem; display:grid; grid-template-columns:repeat(4,1fr); gap:1.25rem; }
@media(max-width:1000px){ .cc-co-grid { grid-template-columns:repeat(3,1fr); } }
@media(max-width:700px) { .cc-co-grid { grid-template-columns:repeat(2,1fr); } }
@media(max-width:460px) { .cc-co-grid { grid-template-columns:1fr; } }

/* Company card */
.cc-co-card {
    background: var(--cc-surface); border-radius: var(--cc-radius);
    border: 1.5px solid var(--cc-border);
    transition: all .25s; overflow:hidden;
    display:flex; flex-direction:column;
}
.cc-co-card:hover { box-shadow:0 16px 48px rgba(124,58,237,.15); transform:translateY(-5px) scale(1.01); border-color:rgba(124,58,237,.3); }

/* Banner strip */
.cc-co-banner {
    height: 80px; position:relative;
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    overflow:hidden;
}
.cc-co-banner img { width:100%; height:100%; object-fit:cover; }
.cc-co-banner-default { width:100%; height:100%; opacity:.7; }

/* Logo float */
.cc-co-logo-wrap { position:relative; padding:0 1.25rem; margin-top:-28px; }
.cc-co-logo {
    width: 56px; height: 56px; border-radius: 14px;
    background: var(--cc-surface); border: 3px solid var(--cc-surface);
    box-shadow: 0 4px 16px rgba(0,0,0,.12);
    display:flex; align-items:center; justify-content:center;
    font-weight:800; font-size:1.3rem; color:#fff;
    background: linear-gradient(135deg,#2563eb,#7c3aed);
    overflow:hidden;
}
.cc-co-logo img { width:100%; height:100%; object-fit:cover; border-radius:11px; }

.cc-co-body { padding:.75rem 1.25rem 1.25rem; flex:1; display:flex; flex-direction:column; gap:.5rem; }
.cc-co-name { font-size:1rem; font-weight:800; color:var(--cc-text); line-height:1.2; }
.cc-co-industry { font-size:.77rem; color:var(--cc-text-light); font-weight:500; }
.cc-co-desc { font-size:.8rem; color:var(--cc-text-muted); line-height:1.55; flex:1;
    display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }

/* Footer row */
.cc-co-foot {
    display:flex; align-items:center; justify-content:space-between;
    padding:.85rem 1.25rem; border-top:1px solid var(--cc-border);
    gap:.5rem;
}
.cc-co-jobs-badge { font-size:.75rem; font-weight:700; color:var(--cc-primary); background:rgba(37,99,235,.08); padding:3px 9px; border-radius:99px; }
.cc-follow-btn {
    display:inline-flex; align-items:center; gap:.4rem;
    padding:.35rem .85rem; border-radius:9px; font-size:.78rem; font-weight:700;
    border:1.5px solid var(--cc-border); background:var(--cc-surface);
    color:var(--cc-text-muted); cursor:pointer; font-family:var(--cc-font);
    transition:all .18s;
}
.cc-follow-btn:hover { border-color:var(--cc-primary); color:var(--cc-primary); background:rgba(37,99,235,.07); }
.cc-follow-btn.following { border-color:#ef4444; color:#ef4444; background:#fff1f2; }

.cc-view-profile {
    font-size:.78rem; font-weight:700; color:var(--cc-primary);
    text-decoration:none;
    transition:color .15s;
}
.cc-view-profile:hover { text-decoration:underline; }

/* Empty state */
.cc-empty-state {
    grid-column:1/-1; text-align:center; padding:5rem 2rem;
    background:var(--cc-surface); border-radius:var(--cc-radius); border:1.5px solid var(--cc-border);
}

/* Pagination */
.cc-co-pagination { max-width:1280px; margin:0 auto; padding:0 1.5rem 3rem; }
</style>

{{-- HERO --}}
<div class="cc-co-hero">
    <h1>Discover Top <span style="background:linear-gradient(135deg,#a78bfa,#60a5fa);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;">Companies</span></h1>
    <p>Explore industry leaders and find your dream workplace from our curated list.</p>

    <form action="{{ route('companies.index') }}" method="GET">
        <div class="cc-co-search">
            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Search by company name or industry…">
            <button type="submit"><i class="fas fa-search mr-1"></i> Search</button>
        </div>
    </form>

    <div class="cc-co-stats">
        <span class="cc-co-stat"><i class="fas fa-building mr-1"></i> {{ $companies->total() }}+ Companies</span>
        <span class="cc-co-stat"><i class="fas fa-briefcase mr-1"></i> Hiring Now</span>
        <span class="cc-co-stat"><i class="fas fa-star mr-1"></i> Top Rated</span>
    </div>
</div>

{{-- GRID --}}
<div class="cc-co-grid">
    @forelse($companies as $company)
        <div class="cc-co-card">
            {{-- Banner --}}
            <div class="cc-co-banner">
                @if($company->banner)
                    <img src="{{ asset('storage/'.$company->banner) }}" alt="Banner">
                @else
                    <div class="cc-co-banner-default" style="background:linear-gradient(135deg,{{ ['#2563eb','#7c3aed','#059669','#0891b2','#db2777','#d97706'][array_rand(['#2563eb','#7c3aed','#059669','#0891b2','#db2777','#d97706'])] }},#0f172a);"></div>
                @endif
            </div>

            {{-- Logo --}}
            <div class="cc-co-logo-wrap">
                <div class="cc-co-logo">
                    @if($company->logo)
                        <img src="{{ asset('storage/'.$company->logo) }}" alt="{{ $company->name }}">
                    @else
                        {{ strtoupper(substr($company->name, 0, 1)) }}
                    @endif
                </div>
            </div>

            {{-- Body --}}
            <div class="cc-co-body">
                <div class="cc-co-name">{{ $company->name }}</div>
                <div class="cc-co-industry">
                    <i class="fas fa-industry" style="font-size:.7rem;margin-right:.3rem;"></i>
                    {{ $company->industry ?? 'General' }}
                    @if($company->location)
                        · <i class="fas fa-map-marker-alt" style="font-size:.7rem;margin-right:.2rem;"></i>{{ $company->location }}
                    @endif
                </div>
                @if($company->description)
                    <p class="cc-co-desc">{{ \Illuminate\Support\Str::limit(strip_tags($company->description), 90) }}</p>
                @endif
            </div>

            {{-- Footer --}}
            <div class="cc-co-foot">
                <div style="display:flex;align-items:center;gap:.6rem;">
                    <span class="cc-co-jobs-badge"><i class="fas fa-briefcase" style="font-size:.65rem;"></i> {{ $company->jobs_count ?? 0 }} Jobs</span>
                    <a href="{{ $company->slug ? route('companies.show', $company->slug) : '#' }}" class="cc-view-profile">View →</a>
                </div>
                <button class="cc-follow-btn" onclick="toggleFollow(this)">
                    <i class="fas fa-plus" style="font-size:.7rem;"></i> Follow
                </button>
            </div>
        </div>
    @empty
        <div class="cc-empty-state">
            <div style="font-size:4rem;margin-bottom:1rem;opacity:.25;">🏢</div>
            <h3 style="font-size:1.2rem;font-weight:800;color:var(--cc-text);margin-bottom:.5rem;">No Companies Found</h3>
            <p style="color:var(--cc-text-light);font-size:.9rem;margin-bottom:1.5rem;">Try a different keyword or browse all companies.</p>
            <a href="{{ route('companies.index') }}" style="display:inline-flex;align-items:center;gap:.5rem;padding:.65rem 1.5rem;background:var(--cc-gradient);color:#fff;border-radius:12px;font-weight:700;text-decoration:none;font-size:.9rem;">
                <i class="fas fa-undo"></i> Clear Search
            </a>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
<div class="cc-co-pagination">{{ $companies->links() }}</div>

<script>
function toggleFollow(btn) {
    const following = btn.classList.toggle('following');
    btn.innerHTML = following
        ? '<i class="fas fa-check" style="font-size:.7rem;"></i> Following'
        : '<i class="fas fa-plus" style="font-size:.7rem;"></i> Follow';
    showToast(following ? 'Company followed! 🏢' : 'Unfollowed company', following ? 'success' : 'info');
}
</script>
@endsection
