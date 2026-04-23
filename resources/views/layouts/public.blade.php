<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'CareerConnect') . ' — Find Your Dream Job')</title>
    <meta name="description" content="@yield('meta_description', 'CareerConnect — Discover top jobs, internships and companies. Apply in one click.')">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* ═══════════════════════════════════════════════════════
           GLOBAL DESIGN TOKEN SYSTEM — CareerConnect
        ═══════════════════════════════════════════════════════ */
        :root {
            --cc-font: 'Inter', system-ui, sans-serif;

            /* Brand palette */
            --cc-primary:       #2563eb;
            --cc-primary-dark:  #1d4ed8;
            --cc-accent:        #7c3aed;
            --cc-gradient:      linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
            --cc-gradient-soft: linear-gradient(135deg, #eff6ff 0%, #f5f3ff 100%);

            /* Surfaces */
            --cc-bg:            #f0f4ff;
            --cc-surface:       #ffffff;
            --cc-surface-2:     #f8faff;
            --cc-border:        #e2e8f0;

            /* Text */
            --cc-text:          #0f172a;
            --cc-text-muted:    #64748b;
            --cc-text-light:    #94a3b8;

            /* Status */
            --cc-success:       #16a34a;
            --cc-warning:       #d97706;
            --cc-danger:        #dc2626;

            /* Elevation */
            --cc-shadow-sm:     0 1px 8px rgba(0,0,0,.06);
            --cc-shadow:        0 4px 24px rgba(0,0,0,.09);
            --cc-shadow-lg:     0 12px 48px rgba(0,0,0,.14);
            --cc-shadow-glow:   0 8px 32px rgba(37,99,235,.22);

            /* Geometry */
            --cc-radius:        18px;
            --cc-radius-sm:     10px;
            --cc-radius-full:   999px;

            /* Motion */
            --cc-ease:          cubic-bezier(.4,0,.2,1);
            --cc-dur:           .2s;
        }

        /* ── DARK MODE TOKENS ── */
        [data-theme="dark"] {
            --cc-bg:         #0f172a;
            --cc-surface:    #1e293b;
            --cc-surface-2:  #0f172a;
            --cc-border:     #334155;
            --cc-text:       #f1f5f9;
            --cc-text-muted: #94a3b8;
            --cc-text-light: #64748b;
            --cc-shadow-sm:  0 1px 8px rgba(0,0,0,.4);
            --cc-shadow:     0 4px 24px rgba(0,0,0,.5);
            --cc-shadow-lg:  0 12px 48px rgba(0,0,0,.7);
        }

        /* ── RESET & BASE ── */
        *, *::before, *::after { box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--cc-font);
            background: var(--cc-bg);
            color: var(--cc-text);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            transition: background var(--cc-dur) var(--cc-ease),
                        color var(--cc-dur) var(--cc-ease);
            display: flex; flex-direction: column; min-height: 100vh;
        }

        main { flex: 1; }

        /* ── PAGE FADE-IN ── */
        @keyframes cc-fade-up {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        main { animation: cc-fade-up .45s var(--cc-ease) both; }

        /* ── SKELETON SHIMMER ── */
        @keyframes cc-shimmer {
            0%   { background-position: -600px 0; }
            100% { background-position:  600px 0; }
        }
        .cc-skeleton {
            background: linear-gradient(90deg,
                #e2e8f0 25%, #f1f5f9 50%, #e2e8f0 75%);
            background-size: 600px 100%;
            animation: cc-shimmer 1.4s infinite linear;
            border-radius: 8px;
        }
        [data-theme="dark"] .cc-skeleton {
            background: linear-gradient(90deg,
                #1e293b 25%, #334155 50%, #1e293b 75%);
            background-size: 600px 100%;
        }

        /* ── TOAST SYSTEM ── */
        #cc-toasts {
            position: fixed; bottom: 1.5rem; right: 1.5rem;
            z-index: 99999; display: flex; flex-direction: column; gap: .6rem;
            pointer-events: none;
        }
        .cc-toast {
            display: flex; align-items: center; gap: .75rem;
            background: #1e293b; color: #f1f5f9;
            padding: .8rem 1.2rem; border-radius: 14px;
            font-size: .875rem; font-weight: 600;
            box-shadow: 0 8px 32px rgba(0,0,0,.3);
            transform: translateX(110%); opacity: 0;
            transition: transform .35s cubic-bezier(.34,1.56,.64,1), opacity .3s;
            pointer-events: all; min-width: 240px; max-width: 340px;
            border-left: 4px solid #3b82f6;
        }
        .cc-toast.show   { transform: translateX(0); opacity: 1; }
        .cc-toast.success { border-color: #22c55e; }
        .cc-toast.error   { border-color: #ef4444; }
        .cc-toast.info    { border-color: #3b82f6; }
        .cc-toast i { font-size: 1rem; }
        .cc-toast.success i { color: #4ade80; }
        .cc-toast.error   i { color: #f87171; }
        .cc-toast.info    i { color: #60a5fa; }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
        [data-theme="dark"] ::-webkit-scrollbar-thumb { background: #475569; }

        /* ── SELECTION ── */
        ::selection { background: #bfdbfe; color: #1e40af; }
        [data-theme="dark"] ::selection { background: #1d4ed8; color: #fff; }

        /* ── UTILITY CLASSES ── */
        .cc-gradient-text {
            background: var(--cc-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .cc-btn {
            display: inline-flex; align-items: center; justify-content: center;
            gap: .5rem; font-weight: 600; border-radius: var(--cc-radius-sm);
            transition: all var(--cc-dur) var(--cc-ease);
            cursor: pointer; border: none; text-decoration: none;
            font-family: var(--cc-font);
        }
        .cc-btn:hover { transform: translateY(-2px); }
        .cc-btn:active { transform: translateY(0) scale(.98); }

        .cc-btn-primary {
            background: var(--cc-gradient);
            color: #fff;
            box-shadow: var(--cc-shadow-glow);
            padding: .65rem 1.4rem;
        }
        .cc-btn-primary:hover { box-shadow: 0 12px 40px rgba(37,99,235,.35); color:#fff; }

        .cc-btn-outline {
            background: transparent;
            border: 1.5px solid var(--cc-border);
            color: var(--cc-text);
            padding: .65rem 1.4rem;
        }
        .cc-btn-outline:hover {
            border-color: var(--cc-primary);
            color: var(--cc-primary);
            background: var(--cc-gradient-soft);
        }

        .cc-card {
            background: var(--cc-surface);
            border-radius: var(--cc-radius);
            box-shadow: var(--cc-shadow-sm);
            border: 1px solid var(--cc-border);
            transition: box-shadow var(--cc-dur) var(--cc-ease),
                        transform var(--cc-dur) var(--cc-ease);
        }
        .cc-card:hover {
            box-shadow: var(--cc-shadow);
            transform: translateY(-3px);
        }

        .cc-badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: var(--cc-radius-full);
            font-size: .72rem; font-weight: 600;
        }
        .cc-badge-blue   { background: #eff6ff; color: #2563eb; }
        .cc-badge-green  { background: #f0fdf4; color: #16a34a; }
        .cc-badge-amber  { background: #fffbeb; color: #b45309; }
        .cc-badge-purple { background: #f5f3ff; color: #7c3aed; }
        .cc-badge-red    { background: #fff1f2; color: #be123c; }
        .cc-badge-gray   { background: #f1f5f9; color: #475569; }

        [data-theme="dark"] .cc-badge-blue   { background: rgba(37,99,235,.15);  color: #93c5fd; }
        [data-theme="dark"] .cc-badge-green  { background: rgba(22,163,74,.15);  color: #86efac; }
        [data-theme="dark"] .cc-badge-amber  { background: rgba(217,119,6,.15);  color: #fcd34d; }
        [data-theme="dark"] .cc-badge-purple { background: rgba(124,58,237,.15); color: #c4b5fd; }
        [data-theme="dark"] .cc-badge-red    { background: rgba(220,38,38,.15);  color: #fca5a5; }
        [data-theme="dark"] .cc-badge-gray   { background: rgba(71,85,105,.3);   color: #94a3b8; }

        /* ── DARK SURFACE OVERRIDES ── */
        [data-theme="dark"] .cc-card { background: var(--cc-surface); border-color: var(--cc-border); }
    </style>
</head>

<body>
    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <!-- Toast Container -->
    <div id="cc-toasts"></div>

    <!-- Global JS -->
    <script>
        /* ── DARK MODE ── */
        (function() {
            const saved = localStorage.getItem('cc-theme') || 'light';
            document.documentElement.setAttribute('data-theme', saved);
        })();

        function ccToggleDark() {
            const root = document.documentElement;
            const next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            root.setAttribute('data-theme', next);
            localStorage.setItem('cc-theme', next);
            const btn = document.getElementById('darkToggleBtn');
            if (btn) {
                btn.innerHTML = next === 'dark'
                    ? '<i class="fas fa-sun"></i>'
                    : '<i class="fas fa-moon"></i>';
            }
        }

        /* ── TOAST ── */
        function showToast(msg, type = 'info', duration = 3500) {
            const icons = { success: 'fa-circle-check', error: 'fa-circle-xmark', info: 'fa-circle-info' };
            const wrap = document.getElementById('cc-toasts');
            const el = document.createElement('div');
            el.className = `cc-toast ${type}`;
            el.innerHTML = `<i class="fas ${icons[type] || icons.info}"></i><span>${msg}</span>`;
            wrap.appendChild(el);
            requestAnimationFrame(() => requestAnimationFrame(() => el.classList.add('show')));
            setTimeout(() => {
                el.classList.remove('show');
                setTimeout(() => el.remove(), 400);
            }, duration);
        }

        /* ── MOBILE NAV ── */
        function ccToggleMobileNav() {
            const drawer = document.getElementById('ccMobileDrawer');
            const overlay = document.getElementById('ccMobileOverlay');
            if (!drawer) return;
            const isOpen = drawer.classList.contains('cc-drawer-open');
            drawer.classList.toggle('cc-drawer-open', !isOpen);
            overlay.classList.toggle('cc-overlay-open', !isOpen);
            document.body.style.overflow = isOpen ? '' : 'hidden';
        }

        /* ── RECENTLY VIEWED JOBS ── */
        function ccTrackJobView(id, title, company, slug) {
            const key = 'cc-recent-jobs';
            let list = JSON.parse(localStorage.getItem(key) || '[]');
            list = list.filter(j => j.id !== id);
            list.unshift({ id, title, company, slug, ts: Date.now() });
            if (list.length > 6) list = list.slice(0, 6);
            localStorage.setItem(key, JSON.stringify(list));
        }

        /* ── BOOKMARK JOBS ── */
        function ccToggleBookmark(id, title, slug) {
            const key = 'cc-bookmarked-jobs';
            let saved = JSON.parse(localStorage.getItem(key) || '[]');
            const exists = saved.some(j => j.id === id);
            if (exists) {
                saved = saved.filter(j => j.id !== id);
                showToast('Removed from bookmarks', 'info');
            } else {
                saved.push({ id, title, slug, ts: Date.now() });
                showToast('Job bookmarked! ❤️', 'success');
            }
            localStorage.setItem(key, JSON.stringify(saved));
            return !exists;
        }

        function ccIsBookmarked(id) {
            const saved = JSON.parse(localStorage.getItem('cc-bookmarked-jobs') || '[]');
            return saved.some(j => j.id === id);
        }
    </script>
</body>
</html>
