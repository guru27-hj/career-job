<style>
/* ── NAV STYLES ── */
#ccNav {
    position: sticky; top: 0; z-index: 9000;
    background: rgba(255,255,255,.82);
    backdrop-filter: blur(20px) saturate(180%);
    -webkit-backdrop-filter: blur(20px) saturate(180%);
    border-bottom: 1px solid rgba(226,232,240,.8);
    transition: background .25s, box-shadow .25s;
}
[data-theme="dark"] #ccNav {
    background: rgba(15,23,42,.85);
    border-bottom-color: rgba(51,65,85,.8);
}
#ccNav.scrolled { box-shadow: 0 4px 24px rgba(0,0,0,.10); }
[data-theme="dark"] #ccNav.scrolled { box-shadow: 0 4px 24px rgba(0,0,0,.5); }

.cc-nav-inner {
    max-width: 1280px; margin: 0 auto;
    padding: 0 1.5rem;
    display: flex; align-items: center; height: 64px; gap: 1rem;
}

/* Logo */
.cc-logo {
    font-size: 1.3rem; font-weight: 900; letter-spacing: -.03em;
    text-decoration: none; white-space: nowrap;
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    -webkit-background-clip: text; background-clip: text;
    -webkit-text-fill-color: transparent;
    flex-shrink: 0;
}

/* Desktop nav links */
.cc-nav-links {
    display: none; align-items: center; gap: .2rem;
    flex: 1; justify-content: center;
}
@media(min-width: 768px) { .cc-nav-links { display: flex; } }

.cc-nav-link {
    position: relative; padding: .45rem .85rem;
    font-size: .88rem; font-weight: 600;
    color: var(--cc-text-muted);
    text-decoration: none; border-radius: 8px;
    transition: color .18s, background .18s;
    white-space: nowrap;
}
.cc-nav-link:hover { color: var(--cc-primary); background: rgba(37,99,235,.07); }
.cc-nav-link.active {
    color: var(--cc-primary);
    background: rgba(37,99,235,.1);
}
.cc-nav-link.active::after {
    content: ''; position: absolute; bottom: 4px; left: 50%;
    transform: translateX(-50%); width: 18px; height: 3px;
    background: var(--cc-gradient); border-radius: 99px;
}

/* Right actions */
.cc-nav-right { display: flex; align-items: center; gap: .6rem; margin-left: auto; flex-shrink: 0; }

/* Icon button */
.cc-icon-btn {
    width: 38px; height: 38px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    background: transparent; border: 1.5px solid var(--cc-border);
    color: var(--cc-text-muted); cursor: pointer;
    transition: all .18s; font-size: .95rem;
    flex-shrink: 0;
}
.cc-icon-btn:hover { border-color: var(--cc-primary); color: var(--cc-primary); background: rgba(37,99,235,.07); }

/* User avatar dropdown */
.cc-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg,#2563eb,#7c3aed);
    color: #fff; font-weight: 700; font-size: .8rem;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; flex-shrink: 0;
}

.cc-dropdown-wrap { position: relative; }
.cc-dropdown {
    position: absolute; right: 0; top: calc(100% + 10px);
    min-width: 200px; background: var(--cc-surface);
    border: 1px solid var(--cc-border); border-radius: 14px;
    box-shadow: 0 16px 48px rgba(0,0,0,.14);
    padding: .5rem; opacity: 0; pointer-events: none;
    transform: translateY(-8px) scale(.97);
    transition: all .2s cubic-bezier(.34,1.56,.64,1);
}
.cc-dropdown.open { opacity: 1; pointer-events: all; transform: translateY(0) scale(1); }
.cc-dropdown a, .cc-dropdown button {
    display: flex; align-items: center; gap: .6rem;
    width: 100%; padding: .55rem .85rem; border-radius: 9px;
    font-size: .85rem; font-weight: 500; color: var(--cc-text-muted);
    text-decoration: none; background: none; border: none; cursor: pointer;
    font-family: var(--cc-font); transition: background .15s, color .15s;
}
.cc-dropdown a:hover, .cc-dropdown button:hover { background: var(--cc-gradient-soft); color: var(--cc-primary); }
.cc-dropdown .divider { height: 1px; background: var(--cc-border); margin: .3rem 0; }
.cc-dropdown .danger { color: #dc2626 !important; }
.cc-dropdown .danger:hover { background: #fff1f2; color: #dc2626 !important; }

/* Auth buttons */
.cc-btn-login {
    font-size: .85rem; font-weight: 600; color: var(--cc-text-muted);
    text-decoration: none; padding: .45rem .8rem; border-radius: 8px;
    transition: color .15s;
}
.cc-btn-login:hover { color: var(--cc-primary); }

.cc-btn-register {
    font-size: .85rem; font-weight: 700; color: #fff;
    background: var(--cc-gradient); padding: .45rem 1.1rem;
    border-radius: 9px; text-decoration: none;
    box-shadow: 0 4px 14px rgba(37,99,235,.3);
    transition: box-shadow .18s, transform .18s;
}
.cc-btn-register:hover { box-shadow: 0 8px 24px rgba(37,99,235,.4); transform: translateY(-1px); color:#fff; }

/* Hamburger */
.cc-hamburger { display: flex; flex-direction: column; gap: 5px; cursor: pointer; padding: 4px; }
.cc-hamburger span { display: block; width: 22px; height: 2px; background: var(--cc-text); border-radius: 2px; transition: all .25s; }
@media(min-width: 768px) { .cc-hamburger { display: none; } }
.cc-hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.cc-hamburger.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
.cc-hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

/* Mobile Drawer */
#ccMobileOverlay {
    position: fixed; inset: 0; background: rgba(0,0,0,.45);
    z-index: 8998; opacity: 0; pointer-events: none;
    backdrop-filter: blur(3px); transition: opacity .25s;
}
#ccMobileOverlay.cc-overlay-open { opacity: 1; pointer-events: all; }

#ccMobileDrawer {
    position: fixed; top: 64px; left: 0; right: 0;
    background: var(--cc-surface);
    border-bottom: 1px solid var(--cc-border);
    z-index: 8999;
    padding: 1rem 1.5rem 1.5rem;
    transform: translateY(-110%);
    transition: transform .3s cubic-bezier(.4,0,.2,1);
    box-shadow: 0 16px 48px rgba(0,0,0,.15);
}
#ccMobileDrawer.cc-drawer-open { transform: translateY(0); }

.cc-mobile-link {
    display: flex; align-items: center; gap: .75rem;
    padding: .75rem .5rem; font-size: .95rem; font-weight: 600;
    color: var(--cc-text); text-decoration: none;
    border-bottom: 1px solid var(--cc-border);
    transition: color .15s, padding-left .15s;
}
.cc-mobile-link:last-child { border-bottom: none; }
.cc-mobile-link:hover { color: var(--cc-primary); padding-left: 1rem; }
.cc-mobile-link.active { color: var(--cc-primary); }
.cc-mobile-link i { width: 18px; text-align: center; color: var(--cc-text-muted); }
</style>

<nav id="ccNav">
    <div class="cc-nav-inner">

        <!-- Logo -->
        <a href="{{ route('home') }}" class="cc-logo">
            <i class="fas fa-briefcase" style="font-size:.9rem;margin-right:.3rem;"></i>CareerConnect
        </a>

        <!-- Desktop Nav Links -->
        <div class="cc-nav-links">
            @php
                $navLinks = [
                    ['route' => 'home',              'label' => 'Home',        'icon' => 'fa-house'],
                    ['route' => 'jobs.index',         'label' => 'Jobs',        'icon' => 'fa-briefcase'],
                    ['route' => 'internships.index',  'label' => 'Internships', 'icon' => 'fa-graduation-cap'],
                    ['route' => 'companies.index',    'label' => 'Companies',   'icon' => 'fa-building'],
                    ['route' => 'about',              'label' => 'About',       'icon' => 'fa-circle-info'],
                ];
            @endphp
            @foreach($navLinks as $link)
                <a href="{{ route($link['route']) }}"
                   class="cc-nav-link {{ request()->routeIs(rtrim($link['route'], '.index') . '*') ? 'active' : '' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>

        <!-- Right Actions -->
        <div class="cc-nav-right">

            <!-- Dark Mode Toggle -->
            <button id="darkToggleBtn" class="cc-icon-btn" onclick="ccToggleDark()" title="Toggle dark mode">
                <i class="fas fa-moon" id="darkModeIcon"></i>
            </button>

            @auth
                <!-- User Dropdown -->
                <div class="cc-dropdown-wrap" id="userDropdownWrap">
                    <button class="cc-avatar" onclick="ccToggleDropdown()" title="{{ Auth::user()->name }}">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </button>
                    <div class="cc-dropdown" id="userDropdown">
                        <div style="padding:.3rem .85rem .6rem; font-size:.8rem; color:var(--cc-text-light);">
                            <div style="font-weight:700;color:var(--cc-text);font-size:.9rem;">{{ Auth::user()->name }}</div>
                            <div>{{ Auth::user()->email }}</div>
                        </div>
                        <div class="divider"></div>
                        <a href="{{ route('candidate.profile') }}"><i class="fas fa-user-circle"></i> My Profile</a>
                        <a href="{{ route('candidate.applications') }}"><i class="fas fa-briefcase"></i> My Applications</a>
                        @if(auth()->user()->is_admin)
                            <div class="divider"></div>
                            <a href="{{ route('admin.dashboard') }}" style="color:#7c3aed;font-weight:700;">
                                <i class="fas fa-shield-alt"></i> Admin Panel
                            </a>
                        @endif
                        <div class="divider"></div>
                        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                            @csrf
                            <button type="submit" class="danger"><i class="fas fa-right-from-bracket"></i> Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="cc-btn-login">Login</a>
                <a href="{{ route('register') }}" class="cc-btn-register">Register</a>
            @endauth

            <!-- Hamburger (mobile) -->
            <button class="cc-hamburger" id="ccHamburger" onclick="ccToggleMobileNavBtn()" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>

<!-- Mobile Overlay -->
<div id="ccMobileOverlay" onclick="ccToggleMobileNavBtn()"></div>

<!-- Mobile Drawer -->
<div id="ccMobileDrawer">
    @foreach($navLinks as $link)
        <a href="{{ route($link['route']) }}"
           class="cc-mobile-link {{ request()->routeIs(rtrim($link['route'], '.index') . '*') ? 'active' : '' }}"
           onclick="ccToggleMobileNavBtn()">
            <i class="fas {{ $link['icon'] }}"></i> {{ $link['label'] }}
        </a>
    @endforeach
    @guest
        <div style="display:flex;gap:.75rem;margin-top:1rem;">
            <a href="{{ route('login') }}" class="cc-btn cc-btn-outline" style="flex:1;padding:.6rem;justify-content:center;">Login</a>
            <a href="{{ route('register') }}" class="cc-btn cc-btn-primary" style="flex:1;padding:.6rem;justify-content:center;">Register</a>
        </div>
    @endguest
</div>

<script>
    /* Dark mode icon sync on load */
    document.addEventListener('DOMContentLoaded', () => {
        const theme = localStorage.getItem('cc-theme') || 'light';
        const btn = document.getElementById('darkToggleBtn');
        if (btn) btn.innerHTML = theme === 'dark' ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
    });

    /* Navbar shadow on scroll */
    window.addEventListener('scroll', () => {
        document.getElementById('ccNav')?.classList.toggle('scrolled', window.scrollY > 10);
    });

    /* Mobile nav toggle */
    function ccToggleMobileNavBtn() {
        const ham = document.getElementById('ccHamburger');
        ham?.classList.toggle('open');
        ccToggleMobileNav();
    }

    /* User Dropdown */
    function ccToggleDropdown() {
        document.getElementById('userDropdown')?.classList.toggle('open');
    }
    document.addEventListener('click', e => {
        const wrap = document.getElementById('userDropdownWrap');
        if (wrap && !wrap.contains(e.target)) {
            document.getElementById('userDropdown')?.classList.remove('open');
        }
    });
</script>
