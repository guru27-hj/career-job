@extends('layouts.public')
@section('title', 'About Us — CareerConnect')

@section('content')

@php
    $hero     = $sections->get('hero');
    $story    = $sections->get('story');
    $mission  = $sections->get('mission_vision');
    $stats    = $sections->get('stats');
    $team     = $sections->get('team');
    $features = $sections->get('features');
    $cta      = $sections->get('cta');
@endphp

<style>
/* ── ABOUT PAGE ── */
.cc-about-hero {
    background: linear-gradient(135deg,#0f172a 0%,#1e1b4b 40%,#1e3a8a 100%);
    padding: 5rem 1.5rem 7rem; text-align:center; color:#fff; position:relative; overflow:hidden;
}
.cc-about-hero::after {
    content:''; position:absolute; bottom:-1px; left:0; right:0;
    height:80px; background:var(--cc-bg); clip-path:ellipse(60% 100% at 50% 100%);
}
.cc-about-orb {
    position:absolute; border-radius:50%; filter:blur(80px); pointer-events:none;
}
.cc-about-hero h1 { font-size:clamp(2rem,5vw,3.5rem); font-weight:900; letter-spacing:-.04em; margin-bottom:1rem; position:relative; z-index:1; }
.cc-about-hero p  { color:#bfdbfe; font-size:1.1rem; max-width:560px; margin:0 auto 2rem; position:relative; z-index:1; line-height:1.65; }
.cc-about-cta-btn {
    display:inline-flex; align-items:center; gap:.5rem;
    background:#fff; color:#1e3a8a; font-weight:800; font-size:.95rem;
    padding:.9rem 2.2rem; border-radius:14px; text-decoration:none;
    box-shadow:0 12px 36px rgba(0,0,0,.25);
    transition:box-shadow .18s, transform .18s; position:relative; z-index:1;
}
.cc-about-cta-btn:hover { box-shadow:0 20px 48px rgba(0,0,0,.35); transform:translateY(-2px); color:#1e3a8a; }

/* Sections */
.cc-about-sec { max-width:1100px; margin:0 auto; padding:5rem 1.5rem; }
.cc-about-sec-title {
    text-align:center; font-size:clamp(1.5rem,4vw,2rem); font-weight:900;
    letter-spacing:-.03em; color:var(--cc-text); margin-bottom:.6rem;
}
.cc-about-sec-title span { background:var(--cc-gradient); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; }
.cc-about-sec-sub { text-align:center; color:var(--cc-text-muted); font-size:.95rem; margin-bottom:3rem; max-width:480px; margin-left:auto; margin-right:auto; }
.cc-divider { width:48px; height:4px; background:var(--cc-gradient); border-radius:99px; margin:.9rem auto 2.5rem; }

/* Story */
.cc-story-card {
    background:var(--cc-surface); border-radius:var(--cc-radius); border:1.5px solid var(--cc-border);
    padding:2.5rem; text-align:center;
    box-shadow:var(--cc-shadow-sm);
}
.cc-story-card p { font-size:1rem; line-height:1.8; color:var(--cc-text-muted); max-width:700px; margin:0 auto; }

/* Mission/Vision */
.cc-mv-grid { display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; }
@media(max-width:650px){ .cc-mv-grid { grid-template-columns:1fr; } }
.cc-mv-card {
    border-radius:var(--cc-radius); padding:2rem; border:1.5px solid var(--cc-border);
    transition:box-shadow .22s, transform .22s;
    position:relative; overflow:hidden;
}
.cc-mv-card::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; }
.cc-mv-card.mission::before { background:linear-gradient(90deg,#2563eb,#7c3aed); }
.cc-mv-card.vision::before  { background:linear-gradient(90deg,#059669,#0891b2); }
.cc-mv-card:hover { box-shadow:var(--cc-shadow); transform:translateY(-4px); }
.cc-mv-icon {
    width:56px; height:56px; border-radius:16px; margin-bottom:1.25rem;
    display:flex; align-items:center; justify-content:center; font-size:1.4rem;
}
.cc-mv-card.mission .cc-mv-icon { background:linear-gradient(135deg,#2563eb,#7c3aed); color:#fff; }
.cc-mv-card.vision  .cc-mv-icon { background:linear-gradient(135deg,#059669,#0891b2); color:#fff; }
.cc-mv-card h3 { font-size:1.15rem; font-weight:800; color:var(--cc-text); margin-bottom:.8rem; }
.cc-mv-card p  { font-size:.9rem; color:var(--cc-text-muted); line-height:1.7; }

/* Stats */
.cc-stats-grid {
    display:grid; grid-template-columns:repeat(4,1fr); gap:1rem;
    background:var(--cc-surface); border-radius:var(--cc-radius);
    border:1.5px solid var(--cc-border); overflow:hidden;
    box-shadow:var(--cc-shadow-sm);
}
@media(max-width:700px){ .cc-stats-grid { grid-template-columns:repeat(2,1fr); } }
.cc-about-stat {
    padding:2rem 1rem; text-align:center; border-right:1px solid var(--cc-border);
    transition:background .18s;
}
.cc-about-stat:last-child { border-right:none; }
@media(max-width:700px){ .cc-about-stat:nth-child(2) { border-right:none; } .cc-about-stat:nth-child(odd){ border-bottom:1px solid var(--cc-border); } }
.cc-about-stat:hover { background:var(--cc-gradient-soft); }
.cc-about-stat-num { font-size:2.2rem; font-weight:900; letter-spacing:-.05em; background:var(--cc-gradient); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; margin-bottom:.4rem; }
.cc-about-stat-lbl { font-size:.78rem; font-weight:600; color:var(--cc-text-light); text-transform:uppercase; letter-spacing:.06em; }
.cc-about-stat i { display:block; font-size:1.2rem; color:var(--cc-primary); margin-bottom:.4rem; }

/* Team */
.cc-team-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:1.5rem; }
@media(max-width:800px){ .cc-team-grid { grid-template-columns:repeat(2,1fr); } }
@media(max-width:500px){ .cc-team-grid { grid-template-columns:1fr; } }

.cc-team-card {
    background:var(--cc-surface); border-radius:var(--cc-radius);
    border:1.5px solid var(--cc-border); overflow:hidden; text-align:center;
    transition:all .25s; position:relative;
}
.cc-team-card:hover { box-shadow:var(--cc-shadow); transform:translateY(-5px); }
.cc-team-banner { height:80px; background:linear-gradient(135deg,#1e3a8a,#4c1d95); position:relative; }
.cc-team-avatar {
    width:80px; height:80px; border-radius:50%; border:4px solid var(--cc-surface);
    margin:0 auto; position:relative; top:-40px; overflow:hidden;
    box-shadow:0 4px 16px rgba(0,0,0,.15); background:var(--cc-gradient);
    display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.8rem; font-weight:800;
}
.cc-team-avatar img { width:100%; height:100%; object-fit:cover; }
.cc-team-body { padding:0 1.25rem 1.5rem; margin-top:-30px; }
.cc-team-name { font-size:1rem; font-weight:800; color:var(--cc-text); }
.cc-team-role { font-size:.8rem; color:var(--cc-primary); font-weight:600; margin:.25rem 0 .9rem; }
.cc-team-social { display:flex; gap:.6rem; justify-content:center; }
.cc-team-social a { width:32px; height:32px; border-radius:8px; border:1.5px solid var(--cc-border); display:flex; align-items:center; justify-content:center; color:var(--cc-text-light); font-size:.85rem; text-decoration:none; transition:all .15s; }
.cc-team-social a:hover { border-color:var(--cc-primary); color:var(--cc-primary); background:rgba(37,99,235,.07); }

/* Features */
.cc-features-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1.25rem; }
@media(max-width:900px){ .cc-features-grid { grid-template-columns:repeat(2,1fr); } }
@media(max-width:500px){ .cc-features-grid { grid-template-columns:1fr; } }
.cc-feat-card {
    background:var(--cc-surface); border:1.5px solid var(--cc-border);
    border-radius:var(--cc-radius); padding:1.75rem 1.25rem; text-align:center;
    transition:all .22s;
}
.cc-feat-card:hover { box-shadow:var(--cc-shadow-glow); border-color:rgba(37,99,235,.3); transform:translateY(-4px); }
.cc-feat-icon { width:56px; height:56px; border-radius:16px; background:var(--cc-gradient-soft); margin:0 auto 1rem; display:flex; align-items:center; justify-content:center; font-size:1.3rem; transition:all .22s; }
.cc-feat-card:hover .cc-feat-icon { background:var(--cc-gradient); }
.cc-feat-card:hover .cc-feat-icon i { color:#fff; }
.cc-feat-card h3 { font-size:.9rem; font-weight:700; color:var(--cc-text); }

/* CTA */
.cc-about-cta-section {
    background:linear-gradient(135deg,#1e3a8a 0%,#4c1d95 100%);
    padding:5rem 1.5rem; text-align:center; color:#fff; position:relative; overflow:hidden;
}
.cc-about-cta-section::before { content:''; position:absolute; top:-100px; left:-100px; width:400px; height:400px; background:rgba(124,58,237,.2); border-radius:50%; filter:blur(80px); }
.cc-about-cta-section::after  { content:''; position:absolute; bottom:-100px; right:-100px; width:400px; height:400px; background:rgba(37,99,235,.2); border-radius:50%; filter:blur:80px; }
.cc-about-cta-section > * { position:relative; z-index:1; }
.cc-about-cta-section h2 { font-size:clamp(1.6rem,4vw,2.5rem); font-weight:900; letter-spacing:-.03em; margin-bottom:.8rem; }
.cc-about-cta-section p  { color:#bfdbfe; font-size:1rem; margin-bottom:2.5rem; }
.cc-about-cta-btns { display:flex; gap:1rem; justify-content:center; flex-wrap:wrap; }
</style>

{{-- ══ HERO ══ --}}
@if($hero)
    <div class="cc-about-hero">
        <div class="cc-about-orb" style="width:500px;height:500px;background:rgba(99,102,241,.2);top:-150px;left:-100px;"></div>
        <div class="cc-about-orb" style="width:350px;height:350px;background:rgba(59,130,246,.18);bottom:-80px;right:-60px;"></div>
        <h1>{{ $hero->title }}</h1>
        <p>{{ $hero->content['subtitle'] ?? 'Connecting talent with opportunity, one career at a time.' }}</p>
        <a href="{{ $hero->content['button_link'] ?? route('jobs.index') }}" class="cc-about-cta-btn">
            <i class="fas fa-rocket"></i> {{ $hero->content['button_text'] ?? 'Explore Jobs' }}
        </a>
    </div>
@else
    <div class="cc-about-hero">
        <div class="cc-about-orb" style="width:500px;height:500px;background:rgba(99,102,241,.2);top:-150px;left:-100px;"></div>
        <h1>About <span style="background:linear-gradient(135deg,#60a5fa,#a78bfa);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;">CareerConnect</span></h1>
        <p>We're on a mission to connect ambitious professionals with world-class career opportunities.</p>
        <a href="{{ route('jobs.index') }}" class="cc-about-cta-btn"><i class="fas fa-rocket"></i> Explore Jobs</a>
    </div>
@endif

{{-- ══ STORY ══ --}}
@if($story)
    <section class="cc-about-sec" style="padding-bottom:2rem;">
        <div class="cc-about-sec-title">Our <span>Story</span></div>
        <div class="cc-divider"></div>
        <div class="cc-story-card">
            <p>{{ $story->content['text'] ?? '' }}</p>
        </div>
    </section>
@endif

{{-- ══ MISSION & VISION ══ --}}
@if($mission)
    <section class="cc-about-sec" style="padding-top:3rem;padding-bottom:3rem;">
        <div class="cc-about-sec-title">Mission & <span>Vision</span></div>
        <div class="cc-divider"></div>
        <div class="cc-mv-grid">
            <div class="cc-mv-card mission">
                <div class="cc-mv-icon"><i class="fas fa-bullseye"></i></div>
                <h3>Our Mission</h3>
                <p>{{ $mission->content['mission_text'] ?? 'To democratize access to career opportunities for every skilled professional across India and beyond.' }}</p>
            </div>
            <div class="cc-mv-card vision">
                <div class="cc-mv-icon"><i class="fas fa-eye"></i></div>
                <h3>Our Vision</h3>
                <p>{{ $mission->content['vision_text'] ?? 'To become the most trusted career platform connecting 10 million professionals with purpose-driven companies.' }}</p>
            </div>
        </div>
    </section>
@endif

{{-- ══ STATS ══ --}}
@if($stats)
    <section class="cc-about-sec" style="padding-top:2rem;padding-bottom:3rem;">
        <div class="cc-about-sec-title">Our <span>Numbers</span></div>
        <div class="cc-divider"></div>
        <div class="cc-stats-grid" x-data="statsCounter()">
            <div class="cc-about-stat">
                <i class="fas fa-user-graduate"></i>
                <div class="cc-about-stat-num" x-text="Math.floor(students).toLocaleString() + '+'">0+</div>
                <div class="cc-about-stat-lbl">Students</div>
            </div>
            <div class="cc-about-stat">
                <i class="fas fa-building"></i>
                <div class="cc-about-stat-num" x-text="Math.floor(companies).toLocaleString() + '+'">0+</div>
                <div class="cc-about-stat-lbl">Companies</div>
            </div>
            <div class="cc-about-stat">
                <i class="fas fa-briefcase"></i>
                <div class="cc-about-stat-num" x-text="Math.floor(jobs).toLocaleString() + '+'">0+</div>
                <div class="cc-about-stat-lbl">Jobs Posted</div>
            </div>
            <div class="cc-about-stat">
                <i class="fas fa-graduation-cap"></i>
                <div class="cc-about-stat-num" x-text="Math.floor(internships).toLocaleString() + '+'">0+</div>
                <div class="cc-about-stat-lbl">Internships</div>
            </div>
        </div>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('statsCounter', () => ({
                    students: 0, companies: 0, jobs: 0, internships: 0,
                    init() {
                        const targets = {
                            students: {{ $stats->content['students'] ?? 10000 }},
                            companies: {{ $stats->content['companies'] ?? 500 }},
                            jobs: {{ $stats->content['jobs'] ?? 2000 }},
                            internships: {{ $stats->content['internships'] ?? 1200 }},
                        };
                        const dur = 2000, frames = 60;
                        const incs = Object.fromEntries(Object.entries(targets).map(([k,v]) => [k, v/frames]));
                        const iv = setInterval(() => {
                            Object.keys(targets).forEach(k => {
                                this[k] = Math.min(this[k] + incs[k], targets[k]);
                            });
                            if (this.students >= targets.students) { Object.assign(this, targets); clearInterval(iv); }
                        }, dur/frames);
                    }
                }));
            });
        </script>
    </section>
@endif

{{-- ══ FEATURES ══ --}}
@if($features && !empty($features->content['points']))
    <section style="background:var(--cc-surface-2);padding:4rem 0;">
        <div class="cc-about-sec" style="padding-top:0;padding-bottom:0;">
            <div class="cc-about-sec-title">{{ $features->title ?? 'Why Choose Us' }}</div>
            <div class="cc-divider"></div>
            <div class="cc-features-grid">
                @foreach($features->content['points'] as $point)
                    <div class="cc-feat-card">
                        <div class="cc-feat-icon">
                            <i class="{{ $point['icon'] ?? 'fas fa-star' }}" style="color:var(--cc-primary);"></i>
                        </div>
                        <h3>{{ $point['title'] ?? '' }}</h3>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@else
    {{-- Default features when no CMS data --}}
    <section style="background:var(--cc-surface-2);padding:4rem 0;">
        <div class="cc-about-sec" style="padding-top:0;padding-bottom:0;">
            <div class="cc-about-sec-title">Why Choose <span>CareerConnect</span></div>
            <div class="cc-divider"></div>
            <div class="cc-features-grid">
                @foreach([
                    ['icon'=>'fa-bolt','title'=>'Instant Matching'],
                    ['icon'=>'fa-shield-alt','title'=>'Verified Jobs'],
                    ['icon'=>'fa-chart-line','title'=>'Career Insights'],
                    ['icon'=>'fa-headset','title'=>'24/7 Support'],
                ] as $f)
                    <div class="cc-feat-card">
                        <div class="cc-feat-icon"><i class="fas {{ $f['icon'] }}" style="color:var(--cc-primary);"></i></div>
                        <h3>{{ $f['title'] }}</h3>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- ══ TEAM ══ --}}
@if($team && !empty($team->content['members']))
    <section class="cc-about-sec">
        <div class="cc-about-sec-title">Meet the <span>Team</span></div>
        <div class="cc-divider"></div>
        <div class="cc-team-grid">
            @foreach($team->content['members'] as $member)
                <div class="cc-team-card">
                    <div class="cc-team-banner"></div>
                    <div class="cc-team-avatar">
                        @if(!empty($member['photo']))
                            <img src="{{ asset('storage/'.$member['photo']) }}" alt="{{ $member['name'] }}">
                        @else
                            {{ strtoupper(substr($member['name'], 0, 1)) }}
                        @endif
                    </div>
                    <div class="cc-team-body">
                        <div class="cc-team-name">{{ $member['name'] }}</div>
                        <div class="cc-team-role">{{ $member['role'] }}</div>
                        <div class="cc-team-social">
                            @if(!empty($member['linkedin']))
                                <a href="{{ $member['linkedin'] }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                            @endif
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif

{{-- ══ CTA ══ --}}
<section class="cc-about-cta-section">
    <h2>{{ $cta->title ?? 'Start Your Career Journey Today' }}</h2>
    <p>{{ $cta->content['subtitle'] ?? 'Join thousands of professionals who landed their dream jobs through CareerConnect.' }}</p>
    <div class="cc-about-cta-btns">
        <a href="{{ $cta->content['register_link'] ?? route('register') }}"
           style="background:#fff;color:#1e3a8a;font-weight:800;font-size:.95rem;padding:.8rem 2rem;border-radius:12px;text-decoration:none;box-shadow:0 8px 24px rgba(0,0,0,.2);display:inline-flex;align-items:center;gap:.5rem;transition:all .18s;"
           onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='';">
            <i class="fas fa-rocket"></i> {{ $cta->content['register_text'] ?? 'Get Started Free' }}
        </a>
        <a href="{{ $cta->content['browse_link'] ?? route('jobs.index') }}"
           style="background:transparent;border:2px solid rgba(255,255,255,.4);color:#fff;font-weight:700;font-size:.95rem;padding:.8rem 2rem;border-radius:12px;text-decoration:none;display:inline-flex;align-items:center;gap:.5rem;transition:all .18s;"
           onmouseover="this.style.background='rgba(255,255,255,.1)';" onmouseout="this.style.background='transparent';">
            <i class="fas fa-search"></i> {{ $cta->content['browse_text'] ?? 'Browse Jobs' }}
        </a>
    </div>
</section>

@endsection
