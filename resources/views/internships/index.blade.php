@extends('layouts.public')
@section('title', 'Browse Internships — CareerConnect')

@section('content')
<style>
.cc-int-page { max-width:1280px; margin:0 auto; padding:2rem 1.5rem 4rem; display:flex; gap:1.5rem; align-items:flex-start; }
@media(max-width:900px){ .cc-int-page { flex-direction:column; } }

.cc-page-hero {
    background: linear-gradient(135deg,#064e3b 0%,#0f766e 50%,#0e7490 100%);
    padding:2.5rem 1.5rem 4rem; position:relative; overflow:hidden;
}
.cc-page-hero::after {
    content:''; position:absolute; bottom:-1px; left:0; right:0; height:70px;
    background:var(--cc-bg); clip-path:ellipse(60% 100% at 50% 100%);
}
.cc-page-hero-inner { max-width:1280px; margin:0 auto; position:relative; z-index:1; }
.cc-page-hero h1 { font-size:clamp(1.6rem,4vw,2.4rem); font-weight:900; color:#fff; letter-spacing:-.03em; margin-bottom:.4rem; }
.cc-page-hero p  { color:#a7f3d0; font-size:.95rem; }

/* Filter sidebar reuse */
.cc-filter-sidebar { width:280px; flex-shrink:0; position:sticky; top:80px; }
@media(max-width:900px){ .cc-filter-sidebar { width:100%; position:static; } }
.cc-filter-card { background:var(--cc-surface); border-radius:var(--cc-radius); border:1.5px solid var(--cc-border); overflow:hidden; box-shadow:var(--cc-shadow-sm); }
.cc-filter-head { padding:1rem 1.25rem; background:linear-gradient(135deg,#059669,#0891b2); display:flex; align-items:center; justify-content:space-between; }
.cc-filter-head span { color:#fff; font-weight:700; font-size:.9rem; }
.cc-filter-body { padding:1.25rem; display:flex; flex-direction:column; gap:1.25rem; }
.cc-filter-label { font-size:.75rem; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--cc-text-light); margin-bottom:.65rem; display:flex; align-items:center; gap:.4rem; }
.cc-filter-input { width:100%; background:var(--cc-surface-2); border:1.5px solid var(--cc-border); border-radius:10px; padding:.55rem .8rem; font-size:.85rem; color:var(--cc-text); font-family:var(--cc-font); outline:none; transition:border-color .15s; }
.cc-filter-input:focus { border-color:#059669; }
.cc-salary-display { display:flex; justify-content:space-between; font-size:.78rem; font-weight:700; color:var(--cc-text-muted); margin-bottom:.5rem; }
input[type="range"] { width:100%; accent-color:#059669; }
.cc-radio-group, .cc-check-group { display:flex; flex-direction:column; gap:.5rem; }
.cc-radio-item, .cc-check-item { display:flex; align-items:center; gap:.6rem; font-size:.85rem; color:var(--cc-text-muted); cursor:pointer; padding:.4rem .5rem; border-radius:8px; transition:background .13s; user-select:none; }
.cc-radio-item:hover, .cc-check-item:hover { background:#ecfdf5; color:#059669; }
.cc-radio-item input, .cc-check-item input { accent-color:#059669; width:15px; height:15px; flex-shrink:0; }
.cc-filter-actions { display:flex; gap:.6rem; }
.cc-int-submit { width:100%; background:linear-gradient(135deg,#059669,#0891b2); color:#fff; border:none; border-radius:10px; padding:.65rem; font-weight:700; font-size:.9rem; cursor:pointer; font-family:var(--cc-font); display:flex; align-items:center; justify-content:center; gap:.5rem; transition:opacity .15s; }
.cc-int-submit:hover { opacity:.88; }

/* Listing */
.cc-listings { flex:1; min-width:0; }
.cc-list-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem; flex-wrap:wrap; gap:.75rem; }
.cc-list-count { font-size:1rem; font-weight:700; color:var(--cc-text); }
.cc-list-count span { color:#059669; }
.cc-sort-select { background:var(--cc-surface); border:1.5px solid var(--cc-border); border-radius:10px; padding:.45rem .8rem; font-size:.83rem; color:var(--cc-text); font-family:var(--cc-font); outline:none; cursor:pointer; }

/* Internship card */
.cc-ic {
    background:var(--cc-surface); border-radius:var(--cc-radius); border:1.5px solid var(--cc-border);
    padding:1.4rem; margin-bottom:1rem;
    transition:box-shadow .22s, transform .22s, border-color .22s;
    position:relative; overflow:hidden; display:flex; gap:1rem; align-items:flex-start;
}
.cc-ic::before { content:''; position:absolute; left:0; top:0; bottom:0; width:3px; background:linear-gradient(135deg,#059669,#0891b2); transform:scaleY(0); transition:transform .22s; transform-origin:bottom; }
.cc-ic:hover { box-shadow:0 12px 40px rgba(5,150,105,.14); transform:translateX(4px); border-color:rgba(5,150,105,.3); }
.cc-ic:hover::before { transform:scaleY(1); }
.cc-ic-logo { width:52px; height:52px; border-radius:14px; flex-shrink:0; background:linear-gradient(135deg,#059669,#0891b2); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800; font-size:1.2rem; box-shadow:0 4px 14px rgba(5,150,105,.2); }
.cc-ic-body { flex:1; min-width:0; }
.cc-ic-top { display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:.5rem; margin-bottom:.5rem; }
.cc-ic-title { font-size:1rem; font-weight:700; color:var(--cc-text); text-decoration:none; }
.cc-ic-title:hover { color:#059669; }
.cc-ic-company { font-size:.82rem; color:var(--cc-text-muted); font-weight:500; }
.cc-ic-meta { display:flex; flex-wrap:wrap; gap:.4rem; margin:.55rem 0; }
.cc-ic-footer { display:flex; gap:.6rem; align-items:center; margin-top:.9rem; flex-wrap:wrap; }

.cc-amber-badge { display:inline-flex; align-items:center; gap:.35rem; font-size:.7rem; font-weight:700; padding:4px 9px; border-radius:99px; background:#fffbeb; color:#b45309; border:1px solid #fde68a; }

.cc-int-apply-btn { display:inline-flex; align-items:center; gap:.4rem; padding:.45rem 1.1rem; border-radius:9px; font-size:.83rem; font-weight:700; cursor:pointer; border:none; font-family:var(--cc-font); text-decoration:none; background:linear-gradient(135deg,#059669,#0891b2); color:#fff; box-shadow:0 4px 14px rgba(5,150,105,.25); transition:box-shadow .18s, transform .18s; }
.cc-int-apply-btn:hover { box-shadow:0 8px 24px rgba(5,150,105,.35); transform:translateY(-1px); color:#fff; }

.cc-empty-state { text-align:center; padding:4rem 2rem; background:var(--cc-surface); border-radius:var(--cc-radius); border:1.5px solid var(--cc-border); }
.cc-empty-icon { font-size:3rem; margin-bottom:1rem; opacity:.3; }
</style>

<div class="cc-page-hero">
    <div class="cc-page-hero-inner">
        <h1><i class="fas fa-graduation-cap" style="font-size:.85em;margin-right:.4rem;"></i>Browse Internships</h1>
        <p>Kickstart your career with {{ $internships->total() }}+ internship opportunities.</p>
    </div>
</div>

<div class="cc-int-page">

    {{-- FILTER SIDEBAR --}}
    <aside class="cc-filter-sidebar">
        <div class="cc-filter-card">
            <div class="cc-filter-head">
                <span><i class="fas fa-sliders-h mr-2"></i>Filters</span>
                <a href="{{ route('internships.index') }}" style="color:rgba(255,255,255,.7);font-size:.75rem;font-weight:600;text-decoration:none;">Reset</a>
            </div>
            <div class="cc-filter-body">
                <form action="{{ route('internships.index') }}" method="GET" id="intFilterForm">

                    <div>
                        <div class="cc-filter-label"><i class="fas fa-search"></i> Keyword</div>
                        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Role or skill…" class="cc-filter-input">
                    </div>

                    <div>
                        <div class="cc-filter-label"><i class="fas fa-map-marker-alt"></i> Location</div>
                        <input type="text" name="location" value="{{ request('location') }}" placeholder="City or remote" class="cc-filter-input">
                    </div>

                    <div>
                        <div class="cc-filter-label"><i class="fas fa-rupee-sign"></i> Stipend (₹/mo)</div>
                        <div class="cc-salary-display">
                            <span>₹<span id="intMinVal">{{ request('salary_min', 0) }}</span></span>
                            <span>₹<span id="intMaxVal">{{ request('salary_max', 50000) }}</span></span>
                        </div>
                        <input type="range" name="salary_min" min="0" max="50000" step="1000" value="{{ request('salary_min', 0) }}" oninput="document.getElementById('intMinVal').textContent=this.value">
                        <input type="range" name="salary_max" min="0" max="50000" step="1000" value="{{ request('salary_max', 50000) }}" oninput="document.getElementById('intMaxVal').textContent=this.value" style="margin-top:.3rem;">
                    </div>

                    <div>
                        <div class="cc-filter-label"><i class="fas fa-hourglass-half"></i> Duration</div>
                        <div class="cc-radio-group">
                            @foreach(['1 Month','2 Months','3 Months','6 Months','1 Year'] as $dur)
                                <label class="cc-radio-item">
                                    <input type="radio" name="duration" value="{{ $dur }}" {{ request('duration')==$dur?'checked':'' }}>
                                    {{ $dur }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <div class="cc-filter-label"><i class="fas fa-code"></i> Skills</div>
                        @php $selSkills = request('skills') ? (is_array(request('skills')) ? request('skills') : explode(',',request('skills'))) : []; @endphp
                        <div class="cc-check-group">
                            @foreach(['Laravel','React','Python','Java','UI/UX','WordPress','MySQL','DevOps'] as $sk)
                                <label class="cc-check-item">
                                    <input type="checkbox" name="skills[]" value="{{ $sk }}" {{ in_array($sk,$selSkills)?'checked':'' }}>
                                    {{ $sk }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <label class="cc-check-item" style="background:#ecfdf5;border-radius:10px;padding:.6rem .8rem;">
                        <input type="checkbox" name="remote" value="1" {{ request('remote')?'checked':'' }}>
                        <span style="font-weight:700;color:#059669;">🌍 Remote Only</span>
                    </label>

                    <button type="submit" class="cc-int-submit"><i class="fas fa-search"></i> Apply Filters</button>
                </form>
            </div>
        </div>
    </aside>

    {{-- LISTINGS --}}
    <div class="cc-listings">
        <div class="cc-list-header">
            <div class="cc-list-count"><span>{{ $internships->total() }}</span> Internships Found</div>
            <select class="cc-sort-select" form="intFilterForm" name="sort" onchange="document.getElementById('intFilterForm').submit()">
                <option value="latest"    {{ request('sort','latest')=='latest'    ?'selected':'' }}>Latest</option>
                <option value="stipend"   {{ request('sort')=='stipend'            ?'selected':'' }}>Stipend High</option>
                <option value="duration"  {{ request('sort')=='duration'           ?'selected':'' }}>Duration</option>
            </select>
        </div>

        @forelse($internships as $internship)
            @php
                $skillsArr = is_array($internship->skills) ? $internship->skills : (json_decode($internship->skills, true) ?? []);
            @endphp
            <div class="cc-ic">
                <div class="cc-ic-logo">{{ strtoupper(substr($internship->company->name ?? 'I', 0, 1)) }}</div>
                <div class="cc-ic-body">
                    <div class="cc-ic-top">
                        <div>
                            <a href="{{ route('internships.show', $internship->slug) }}" class="cc-ic-title">{{ $internship->title }}</a>
                            <div class="cc-ic-company">{{ $internship->company->name ?? 'Unknown Company' }}</div>
                        </div>
                        <span class="cc-amber-badge">🎓 Internship</span>
                    </div>

                    <div class="cc-ic-meta">
                        <span class="cc-badge cc-badge-gray"><i class="fas fa-map-marker-alt" style="font-size:.65rem;"></i> {{ $internship->location }}{{ $internship->remote ? ' (Remote)' : '' }}</span>
                        @if($internship->duration)
                            <span class="cc-badge cc-badge-amber"><i class="fas fa-hourglass-half" style="font-size:.65rem;"></i> {{ $internship->duration }}</span>
                        @endif
                        @if($internship->certificate_included)
                            <span class="cc-badge cc-badge-green"><i class="fas fa-certificate" style="font-size:.65rem;"></i> Certificate</span>
                        @endif
                    </div>

                    @if(count($skillsArr))
                        <div style="display:flex;flex-wrap:wrap;gap:.3rem;margin-bottom:.25rem;">
                            @foreach(array_slice($skillsArr, 0, 4) as $skill)
                                <span class="cc-badge cc-badge-blue">{{ $skill }}</span>
                            @endforeach
                            @if(count($skillsArr) > 4) <span class="cc-badge cc-badge-gray">+{{ count($skillsArr)-4 }}</span> @endif
                        </div>
                    @endif

                    <div class="cc-ic-footer">
                        @if($internship->min_salary || $internship->max_salary)
                            <div style="font-size:.85rem;font-weight:700;color:var(--cc-text);">
                                ₹{{ number_format($internship->min_salary) }}–₹{{ number_format($internship->max_salary) }}/mo
                            </div>
                        @endif
                        <div style="display:flex;gap:.5rem;align-items:center;margin-left:auto;">
                            <a href="{{ route('internships.show', $internship->slug) }}" class="cc-int-apply-btn">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                            <a href="{{ route('internships.show', $internship->slug) }}" class="cc-view-detail" style="border:1.5px solid var(--cc-border);border-radius:9px;padding:.45rem .9rem;font-size:.83rem;font-weight:600;color:var(--cc-text-muted);text-decoration:none;transition:all .15s;">
                                Apply Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="cc-empty-state">
                <div class="cc-empty-icon">🎓</div>
                <h3 style="font-size:1.1rem;font-weight:700;color:var(--cc-text);margin-bottom:.4rem;">No internships found</h3>
                <p style="font-size:.88rem;color:var(--cc-text-light);">Try adjusting your filters or search with different keywords.</p>
                <a href="{{ route('internships.index') }}" class="cc-int-submit" style="display:inline-flex;margin-top:1.25rem;width:auto;padding:.6rem 1.5rem;text-decoration:none;border-radius:10px;">Clear Filters</a>
            </div>
        @endforelse

        <div style="margin-top:1.5rem;">
            {{ $internships->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
