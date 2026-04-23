<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-admin-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — CareerConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
/* ══════════════════════════════════════════════════════════
   CAREERCONNECT ADMIN — Premium Design System
══════════════════════════════════════════════════════════ */
*, *::before, *::after { box-sizing: border-box; }
html, body { height: 100%; }
body {
    font-family: 'Inter', system-ui, sans-serif;
    background: #0f172a;
    color: #e2e8f0;
    -webkit-font-smoothing: antialiased;
    margin: 0;
}
[x-cloak] { display: none !important; }

/* ── CSS TOKENS ── */
:root {
    --adm-sidebar-w:   260px;
    --adm-topbar-h:    64px;
    --adm-bg:          #0f172a;
    --adm-surface:     #1e293b;
    --adm-surface-2:   #162032;
    --adm-border:      rgba(255,255,255,.07);
    --adm-text:        #e2e8f0;
    --adm-text-muted:  #94a3b8;
    --adm-text-light:  #64748b;
    --adm-primary:     #3b82f6;
    --adm-accent:      #8b5cf6;
    --adm-gradient:    linear-gradient(135deg, #3b82f6, #8b5cf6);
    --adm-shadow:      0 4px 24px rgba(0,0,0,.4);
    --adm-radius:      14px;
    --adm-ease:        cubic-bezier(.4,0,.2,1);
}

/* ── SCROLLBAR ── */
::-webkit-scrollbar { width: 5px; height: 5px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: #334155; border-radius: 99px; }
::-webkit-scrollbar-thumb:hover { background: #475569; }

/* ══════════════ SIDEBAR ══════════════ */
#adminSidebar {
    position: fixed; top: 0; left: 0; bottom: 0;
    width: var(--adm-sidebar-w);
    z-index: 9000;
    display: flex; flex-direction: column;

    /* Glassmorphism */
    background: rgba(15,23,42,.92);
    backdrop-filter: blur(24px) saturate(180%);
    -webkit-backdrop-filter: blur(24px) saturate(180%);
    border-right: 1px solid var(--adm-border);
    transition: transform .3s var(--adm-ease);
    box-shadow: 4px 0 32px rgba(0,0,0,.4);
}
@media(max-width:1024px) {
    #adminSidebar { transform: translateX(-100%); }
    #adminSidebar.open { transform: translateX(0); }
}

/* Logo */
.adm-logo {
    height: var(--adm-topbar-h); flex-shrink: 0;
    display: flex; align-items: center; padding: 0 1.25rem;
    border-bottom: 1px solid var(--adm-border);
    gap: .75rem;
}
.adm-logo-icon {
    width: 34px; height: 34px; border-radius: 10px;
    background: var(--adm-gradient);
    display: flex; align-items: center; justify-content: center;
    font-size: .9rem; color: #fff; flex-shrink: 0;
    box-shadow: 0 4px 14px rgba(59,130,246,.4);
}
.adm-logo-text {
    font-size: .95rem; font-weight: 800; letter-spacing: -.03em; color: #fff;
}
.adm-logo-badge {
    margin-left: auto; font-size: .6rem; font-weight: 700;
    background: rgba(59,130,246,.2); color: #93c5fd;
    border: 1px solid rgba(59,130,246,.3);
    padding: 2px 7px; border-radius: 99px; text-transform: uppercase; letter-spacing: .06em;
}

/* Nav */
.adm-nav { flex: 1; overflow-y: auto; padding: .75rem .75rem; }
.adm-nav-section { margin-bottom: .25rem; }
.adm-nav-section-label {
    font-size: .66rem; font-weight: 700; color: var(--adm-text-light);
    text-transform: uppercase; letter-spacing: .1em;
    padding: .85rem .85rem .4rem; display: block;
}

/* Nav item */
.adm-nav-item {
    display: flex; align-items: center; gap: .75rem;
    padding: .6rem .9rem; border-radius: 10px;
    font-size: .83rem; font-weight: 600; color: var(--adm-text-muted);
    text-decoration: none; cursor: pointer;
    transition: all .18s var(--adm-ease);
    position: relative; overflow: hidden;
    background: none; border: none; width: 100%;
    font-family: 'Inter', sans-serif;
}
.adm-nav-item:before {
    content: ''; position: absolute; inset: 0;
    background: var(--adm-gradient); opacity: 0;
    transition: opacity .18s;
    border-radius: 10px;
}
.adm-nav-item:hover { color: #fff; }
.adm-nav-item:hover:before { opacity: .12; }

.adm-nav-item.active { color: #fff; }
.adm-nav-item.active::before { opacity: 1; }
.adm-nav-item.active i { color: #fff !important; }
.adm-nav-item.active span { color: #fff !important; }

.adm-nav-item i { width: 16px; text-align: center; font-size: .85rem; color: var(--adm-text-light); flex-shrink: 0; position: relative; z-index: 1; transition: color .18s; }
.adm-nav-item span { position: relative; z-index: 1; flex: 1; text-align: left; }
.adm-nav-item:hover i { color: #93c5fd; }

/* Nav badge */
.adm-nav-badge {
    position: relative; z-index: 1;
    font-size: .62rem; font-weight: 800;
    background: rgba(239,68,68,.2); color: #fca5a5;
    border: 1px solid rgba(239,68,68,.3);
    padding: 1px 6px; border-radius: 99px;
    margin-left: auto;
}
.adm-nav-item.active .adm-nav-badge { background: rgba(255,255,255,.2); color: #fff; border-color: rgba(255,255,255,.3); }

/* Submenu */
.adm-submenu { padding-left: 1.25rem; margin-top: .2rem; display: flex; flex-direction: column; gap: .15rem; }
.adm-submenu-link {
    display: flex; align-items: center; gap: .5rem;
    padding: .45rem .85rem; border-radius: 8px;
    font-size: .78rem; font-weight: 500; color: var(--adm-text-light);
    text-decoration: none; transition: all .15s;
}
.adm-submenu-link:hover { background: rgba(255,255,255,.06); color: #e2e8f0; }
.adm-submenu-link.active { background: rgba(59,130,246,.12); color: #93c5fd; font-weight: 700; }
.adm-submenu-link::before { content: ''; width: 4px; height: 4px; border-radius: 50%; background: currentColor; flex-shrink: 0; opacity: .6; }

/* Chevron */
.adm-chevron { transition: transform .2s; font-size: .65rem; position: relative; z-index: 1; color: var(--adm-text-light); }
.adm-chevron.open { transform: rotate(180deg); }

/* Sidebar footer */
.adm-sidebar-foot {
    border-top: 1px solid var(--adm-border);
    padding: .9rem 1rem; display: flex; align-items: center; gap: .75rem;
}
.adm-foot-avatar {
    width: 34px; height: 34px; border-radius: 50%;
    background: var(--adm-gradient); color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: .85rem; flex-shrink: 0;
}
.adm-foot-name { font-size: .8rem; font-weight: 700; color: var(--adm-text); }
.adm-foot-role { font-size: .7rem; color: var(--adm-text-light); }

/* ══════════════ TOPBAR ══════════════ */
#adminTopbar {
    position: fixed; top: 0; right: 0; left: var(--adm-sidebar-w);
    height: var(--adm-topbar-h); z-index: 8000;
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 1.5rem; gap: 1rem;
    background: rgba(15,23,42,.9);
    backdrop-filter: blur(20px) saturate(160%);
    -webkit-backdrop-filter: blur(20px) saturate(160%);
    border-bottom: 1px solid var(--adm-border);
    transition: left .3s var(--adm-ease);
}
@media(max-width:1024px) { #adminTopbar { left: 0; } }

/* Hamburger */
.adm-ham {
    display: none; background: none; border: none; color: var(--adm-text-muted);
    font-size: 1.1rem; cursor: pointer; padding: .4rem; border-radius: 8px;
    transition: background .15s; font-family: inherit;
}
.adm-ham:hover { background: rgba(255,255,255,.07); color: #fff; }
@media(max-width:1024px) { .adm-ham { display: flex; align-items: center; } }

/* Global search */
.adm-search {
    flex: 1; max-width: 380px;
    display: flex; align-items: center; gap: .6rem;
    background: rgba(255,255,255,.05);
    border: 1px solid var(--adm-border);
    border-radius: 10px; padding: .55rem .9rem;
    transition: border-color .18s, background .18s;
}
.adm-search:focus-within { border-color: rgba(59,130,246,.5); background: rgba(59,130,246,.05); }
.adm-search i { color: var(--adm-text-light); font-size: .85rem; flex-shrink: 0; }
.adm-search input {
    flex: 1; background: transparent; border: none; outline: none;
    font-size: .83rem; color: var(--adm-text); font-family: 'Inter', sans-serif;
}
.adm-search input::placeholder { color: var(--adm-text-light); }
.adm-search-kbd {
    background: rgba(255,255,255,.07); border: 1px solid var(--adm-border);
    color: var(--adm-text-light); font-size: .62rem; font-weight: 700;
    padding: 2px 6px; border-radius: 5px; flex-shrink: 0;
}

/* Topbar right */
.adm-topbar-right { display: flex; align-items: center; gap: .5rem; }

.adm-icon-btn {
    width: 36px; height: 36px; border-radius: 9px;
    background: rgba(255,255,255,.05); border: 1px solid var(--adm-border);
    display: flex; align-items: center; justify-content: center;
    color: var(--adm-text-muted); cursor: pointer; font-size: .9rem;
    transition: all .15s; position: relative;
}
.adm-icon-btn:hover { background: rgba(255,255,255,.1); color: var(--adm-text); border-color: rgba(255,255,255,.15); }
.adm-notif-dot {
    position: absolute; top: 6px; right: 6px;
    width: 8px; height: 8px; border-radius: 50%;
    background: #ef4444; border: 2px solid var(--adm-bg);
    animation: adm-pulse 2s ease infinite;
}
@keyframes adm-pulse { 0%,100%{opacity:1;} 50%{opacity:.5;} }

/* Admin profile btn */
.adm-profile-btn {
    display: flex; align-items: center; gap: .6rem;
    background: rgba(255,255,255,.05); border: 1px solid var(--adm-border);
    border-radius: 10px; padding: .4rem .75rem .4rem .4rem;
    cursor: pointer; transition: all .15s;
}
.adm-profile-btn:hover { background: rgba(255,255,255,.1); border-color: rgba(255,255,255,.15); }
.adm-profile-avatar {
    width: 28px; height: 28px; border-radius: 50%;
    background: var(--adm-gradient); color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: .72rem;
}
.adm-profile-name { font-size: .78rem; font-weight: 700; color: var(--adm-text); }
.adm-profile-name small { display: block; font-size: .65rem; font-weight: 500; color: var(--adm-text-light); }

/* Profile dropdown */
.adm-dropdown {
    position: absolute; right: 0; top: calc(100% + 10px);
    min-width: 210px; background: #1e293b;
    border: 1px solid var(--adm-border); border-radius: 14px;
    box-shadow: 0 20px 60px rgba(0,0,0,.5);
    padding: .4rem; z-index: 9999;
    opacity: 0; pointer-events: none;
    transform: translateY(-8px) scale(.97);
    transition: all .2s cubic-bezier(.34,1.56,.64,1);
}
.adm-dropdown.open { opacity: 1; pointer-events: all; transform: translateY(0) scale(1); }
.adm-dropdown-head {
    padding: .65rem .85rem .75rem; border-bottom: 1px solid var(--adm-border); margin-bottom: .3rem;
}
.adm-dropdown-name { font-size: .85rem; font-weight: 800; color: var(--adm-text); }
.adm-dropdown-email { font-size: .72rem; color: var(--adm-text-light); margin-top: .1rem; }
.adm-dd-link {
    display: flex; align-items: center; gap: .65rem;
    padding: .55rem .85rem; border-radius: 9px; font-size: .82rem;
    font-weight: 600; color: var(--adm-text-muted); text-decoration: none;
    background: none; border: none; width: 100%; cursor: pointer;
    font-family: 'Inter', sans-serif; transition: background .13s, color .13s;
}
.adm-dd-link:hover { background: rgba(255,255,255,.06); color: #fff; }
.adm-dd-link i { width: 16px; text-align: center; font-size: .8rem; }
.adm-dd-link.danger { color: #f87171; }
.adm-dd-link.danger:hover { background: rgba(239,68,68,.1); color: #ef4444; }
.adm-dd-divider { height: 1px; background: var(--adm-border); margin: .3rem 0; }

/* ══════════════ MAIN CONTENT ══════════════ */
#adminMain {
    margin-left: var(--adm-sidebar-w);
    margin-top: var(--adm-topbar-h);
    min-height: calc(100vh - var(--adm-topbar-h));
    background: #0f172a;
    padding: 2rem;
    transition: margin-left .3s var(--adm-ease);
}
@media(max-width:1024px) { #adminMain { margin-left: 0; } }
@media(max-width:640px)  { #adminMain { padding: 1rem; } }

/* ══════════════ ADMIN CARDS ══════════════ */
.adm-card {
    background: var(--adm-surface);
    border-radius: var(--adm-radius);
    border: 1px solid var(--adm-border);
    box-shadow: 0 4px 24px rgba(0,0,0,.2);
    transition: box-shadow .22s, transform .22s;
}
.adm-card:hover { box-shadow: 0 8px 40px rgba(0,0,0,.35); transform: translateY(-2px); }

.adm-card-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1.1rem 1.4rem; border-bottom: 1px solid var(--adm-border);
}
.adm-card-title { font-size: .92rem; font-weight: 800; color: var(--adm-text); }
.adm-card-sub   { font-size: .75rem; color: var(--adm-text-light); margin-top: .15rem; }
.adm-card-body  { padding: 1.4rem; }

/* ══════════════ STAT CARDS ══════════════ */
.adm-stat-card {
    background: var(--adm-surface); border-radius: var(--adm-radius);
    border: 1px solid var(--adm-border);
    padding: 1.4rem; position: relative; overflow: hidden;
    transition: all .22s; cursor: default;
}
.adm-stat-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
    background: var(--adm-gradient); opacity: 0; transition: opacity .22s;
}
.adm-stat-card:hover { transform: translateY(-3px); box-shadow: 0 12px 40px rgba(0,0,0,.35); }
.adm-stat-card:hover::before { opacity: 1; }

.adm-stat-glow {
    position: absolute; top: -24px; right: -24px;
    width: 80px; height: 80px; border-radius: 50%;
    opacity: .12; transition: opacity .22s; pointer-events: none;
}
.adm-stat-card:hover .adm-stat-glow { opacity: .22; }

.adm-stat-icon {
    width: 44px; height: 44px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.05rem; margin-bottom: 1rem;
}
.adm-stat-num {
    font-size: 2rem; font-weight: 900; letter-spacing: -.06em;
    color: var(--adm-text); line-height: 1;
}
.adm-stat-lbl { font-size: .78rem; font-weight: 600; color: var(--adm-text-light); margin-top: .35rem; text-transform: uppercase; letter-spacing: .06em; }
.adm-stat-trend {
    display: inline-flex; align-items: center; gap: .3rem;
    font-size: .72rem; font-weight: 700; margin-top: .8rem;
    padding: 3px 8px; border-radius: 99px;
}
.adm-trend-up   { background: rgba(34,197,94,.15); color: #4ade80; }
.adm-trend-down { background: rgba(239,68,68,.15);  color: #f87171; }

/* ══════════════ TABLE ══════════════ */
.adm-table { width: 100%; border-collapse: collapse; }
.adm-table th {
    font-size: .68rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .08em; color: var(--adm-text-light);
    padding: .75rem 1.1rem; border-bottom: 1px solid var(--adm-border);
    text-align: left; white-space: nowrap;
}
.adm-table td {
    padding: .85rem 1.1rem; border-bottom: 1px solid rgba(255,255,255,.04);
    font-size: .83rem; color: var(--adm-text-muted);
    vertical-align: middle;
}
.adm-table tr:last-child td { border-bottom: none; }
.adm-table tbody tr { transition: background .13s; }
.adm-table tbody tr:hover { background: rgba(255,255,255,.03); }

/* ══════════════ BADGES / STATUS ══════════════ */
.adm-badge {
    display: inline-flex; align-items: center; gap: .35rem;
    font-size: .7rem; font-weight: 700; padding: 3px 9px;
    border-radius: 99px;
}
.adm-badge-blue   { background: rgba(59,130,246,.15); color: #93c5fd; border: 1px solid rgba(59,130,246,.2); }
.adm-badge-purple { background: rgba(139,92,246,.15); color: #c4b5fd; border: 1px solid rgba(139,92,246,.2); }
.adm-badge-green  { background: rgba(34,197,94,.15);  color: #86efac; border: 1px solid rgba(34,197,94,.2); }
.adm-badge-amber  { background: rgba(245,158,11,.15); color: #fcd34d; border: 1px solid rgba(245,158,11,.2); }
.adm-badge-red    { background: rgba(239,68,68,.15);  color: #fca5a5; border: 1px solid rgba(239,68,68,.2); }
.adm-badge-gray   { background: rgba(100,116,139,.15);color: #94a3b8; border: 1px solid rgba(100,116,139,.2); }

/* ══════════════ BUTTONS ══════════════ */
.adm-btn {
    display: inline-flex; align-items: center; gap: .45rem;
    font-size: .82rem; font-weight: 700; border-radius: 9px;
    padding: .5rem 1rem; cursor: pointer; border: none;
    font-family: 'Inter', sans-serif; text-decoration: none;
    transition: all .18s; white-space: nowrap;
}
.adm-btn:hover { transform: translateY(-1px); }
.adm-btn:active{ transform: translateY(0) scale(.98); }
.adm-btn-primary { background: var(--adm-gradient); color: #fff; box-shadow: 0 4px 14px rgba(59,130,246,.3); }
.adm-btn-primary:hover { box-shadow: 0 8px 24px rgba(59,130,246,.45); }
.adm-btn-ghost { background: rgba(255,255,255,.06); border: 1px solid var(--adm-border); color: var(--adm-text-muted); }
.adm-btn-ghost:hover { background: rgba(255,255,255,.1); color: var(--adm-text); }
.adm-btn-danger { background: rgba(239,68,68,.15); border: 1px solid rgba(239,68,68,.25); color: #f87171; }
.adm-btn-danger:hover { background: rgba(239,68,68,.25); color: #ef4444; }
.adm-btn-sm { padding: .35rem .75rem; font-size: .75rem; }
.adm-btn-icon { width: 32px; height: 32px; padding: 0; justify-content: center; }

/* ══════════════ FORM INPUTS ══════════════ */
.adm-input {
    background: rgba(255,255,255,.05); border: 1px solid var(--adm-border);
    border-radius: 9px; padding: .55rem .9rem; font-size: .83rem;
    color: var(--adm-text); font-family: 'Inter', sans-serif; outline: none;
    transition: border-color .15s, background .15s; width: 100%;
}
.adm-input:focus { border-color: rgba(59,130,246,.5); background: rgba(59,130,246,.06); }
.adm-input::placeholder { color: var(--adm-text-light); }
.adm-select { appearance: none; cursor: pointer; }

/* ══════════════ ACTIVITY FEED ══════════════ */
.adm-feed { display: flex; flex-direction: column; gap: .1rem; }
.adm-feed-item {
    display: flex; align-items: flex-start; gap: .85rem;
    padding: .75rem; border-radius: 10px; transition: background .13s;
}
.adm-feed-item:hover { background: rgba(255,255,255,.04); }
.adm-feed-dot {
    width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: .8rem;
}
.adm-feed-title { font-size: .82rem; font-weight: 700; color: var(--adm-text); }
.adm-feed-sub   { font-size: .75rem; color: var(--adm-text-muted); margin-top: .15rem; }
.adm-feed-time  { font-size: .68rem; color: var(--adm-text-light); margin-top: .3rem; font-weight: 600; }

/* ══════════════ TOAST SYSTEM ══════════════ */
#adminToasts {
    position: fixed; bottom: 1.5rem; right: 1.5rem;
    z-index: 99999; display: flex; flex-direction: column; gap: .5rem;
    pointer-events: none;
}
.adm-toast {
    display: flex; align-items: center; gap: .75rem;
    background: #1e293b; color: var(--adm-text);
    border: 1px solid var(--adm-border); border-radius: 12px;
    padding: .8rem 1.1rem; min-width: 260px; max-width: 360px;
    box-shadow: 0 12px 40px rgba(0,0,0,.4);
    transform: translateX(110%); opacity: 0;
    transition: transform .3s cubic-bezier(.34,1.56,.64,1), opacity .25s;
    pointer-events: all; font-size: .83rem; font-weight: 600;
    border-left: 4px solid #3b82f6;
}
.adm-toast.show  { transform: translateX(0); opacity: 1; }
.adm-toast.success { border-left-color: #22c55e; }
.adm-toast.error   { border-left-color: #ef4444; }
.adm-toast.success i { color: #4ade80; }
.adm-toast.error   i { color: #f87171; }

/* ══════════════ OVERLAY ══════════════ */
#adminOverlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,.6); backdrop-filter: blur(3px);
    z-index: 8999;
}
#adminOverlay.open { display: block; }

/* ══════════════ MODAL ══════════════ */
.adm-modal-wrap {
    position: fixed; inset: 0; z-index: 99000;
    display: flex; align-items: center; justify-content: center; padding: 1rem;
    background: rgba(0,0,0,.7); backdrop-filter: blur(6px);
    opacity: 0; pointer-events: none; transition: opacity .25s;
}
.adm-modal-wrap.open { opacity: 1; pointer-events: all; }
.adm-modal {
    background: #1e293b; border: 1px solid var(--adm-border);
    border-radius: 20px; box-shadow: 0 32px 80px rgba(0,0,0,.6);
    width: 100%; max-width: 540px; max-height: 90vh;
    transform: scale(.95) translateY(20px); transition: transform .3s cubic-bezier(.34,1.56,.64,1);
    overflow: hidden; display: flex; flex-direction: column;
}
.adm-modal-wrap.open .adm-modal { transform: scale(1) translateY(0); }
.adm-modal-head { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--adm-border); display: flex; align-items: center; justify-content: space-between; }
.adm-modal-title { font-size: 1rem; font-weight: 800; color: var(--adm-text); }
.adm-modal-body { padding: 1.5rem; overflow-y: auto; }

/* ══════════════ SKELETON SHIMMER ══════════════ */
@keyframes adm-shimmer { 0%{background-position:-600px 0} 100%{background-position:600px 0} }
.adm-skeleton {
    background: linear-gradient(90deg, #1e293b 25%, #293548 50%, #1e293b 75%);
    background-size: 600px 100%; animation: adm-shimmer 1.5s infinite linear;
    border-radius: 7px;
}

/* ══════════════ EMPTY STATE ══════════════ */
.adm-empty { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 4rem 2rem; text-align: center; }
.adm-empty-icon { width: 80px; height: 80px; border-radius: 20px; background: rgba(59,130,246,.1); border: 1px solid rgba(59,130,246,.2); display: flex; align-items: center; justify-content: center; font-size: 2rem; margin-bottom: 1.25rem; }
.adm-empty h3 { font-size: 1.1rem; font-weight: 800; color: var(--adm-text); margin-bottom: .4rem; }
.adm-empty p  { font-size: .85rem; color: var(--adm-text-muted); max-width: 280px; }

/* ══════════════ BREADCRUMB ══════════════ */
.adm-breadcrumb { display: flex; align-items: center; gap: .4rem; font-size: .75rem; color: var(--adm-text-light); margin-bottom: 1.5rem; }
.adm-breadcrumb a { color: var(--adm-text-light); text-decoration: none; transition: color .13s; }
.adm-breadcrumb a:hover { color: var(--adm-primary); }
.adm-breadcrumb .active { color: var(--adm-text-muted); }
.adm-breadcrumb .sep { opacity: .4; }

/* Chart wrapper */
.adm-chart-wrap { position: relative; }

/* Pagination */
.adm-pagination { display: flex; align-items: center; justify-content: center; gap: .4rem; flex-wrap: wrap; }
.adm-page-btn {
    width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center;
    font-size: .78rem; font-weight: 700; text-decoration: none; cursor: pointer;
    background: rgba(255,255,255,.05); border: 1px solid var(--adm-border); color: var(--adm-text-muted);
    transition: all .15s;
}
.adm-page-btn:hover { background: rgba(59,130,246,.15); color: #93c5fd; border-color: rgba(59,130,246,.3); }
.adm-page-btn.active { background: var(--adm-gradient); color: #fff; border-color: transparent; }
</style>
</head>
<body x-data="{ sidebarOpen: false }">

<!-- Mobile overlay -->
<div id="adminOverlay" :class="sidebarOpen ? 'open' : ''" @click="sidebarOpen = false"></div>

<!-- ══ SIDEBAR ══ -->
<aside id="adminSidebar" :class="sidebarOpen ? 'open' : ''" x-data="{
    active: '{{ explode('.', Route::currentRouteName())[1] ?? 'dashboard' }}',
    openMenu: '{{ explode('.', Route::currentRouteName())[1] ?? '' }}'
}">
    <!-- Logo -->
    <div class="adm-logo">
        <div class="adm-logo-icon"><i class="fas fa-briefcase"></i></div>
        <div class="adm-logo-text">CareerConnect</div>
        <span class="adm-logo-badge">Admin</span>
    </div>

    <!-- Nav -->
    <nav class="adm-nav">
        <!-- Main -->
        <div class="adm-nav-section">
            <a href="{{ route('admin.dashboard') }}" class="adm-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-gauge-high"></i><span>Dashboard</span>
            </a>
        </div>

        <span class="adm-nav-section-label">Management</span>

        @if(auth()->check() && auth()->user()->role === 'admin')
        <!-- Users -->
        <div class="adm-nav-section" x-data="{ open: active === 'users' }">
            <button class="adm-nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}" @click="open=!open" style="cursor:pointer;">
                <i class="fas fa-users"></i><span>Users</span>
                <i class="fas fa-chevron-down adm-chevron" :class="open?'open':''"></i>
            </button>
            <div class="adm-submenu" x-show="open" x-collapse>
                <a href="{{ route('admin.users.index') }}" class="adm-submenu-link {{ request()->routeIs('admin.users.index') && !request()->has('role') ? 'active' : '' }}">All Users</a>
                <a href="{{ route('admin.users.index', ['role'=>'student']) }}" class="adm-submenu-link {{ request('role')=='student' ? 'active' : '' }}">Students</a>
                <a href="{{ route('admin.users.create') }}" class="adm-submenu-link {{ request()->routeIs('admin.users.create') ? 'active' : '' }}">Add User</a>
            </div>
        </div>

        <!-- Companies -->
        <div class="adm-nav-section" x-data="{ open: active === 'companies' }">
            <button class="adm-nav-item {{ request()->routeIs('admin.companies*') ? 'active' : '' }}" @click="open=!open">
                <i class="fas fa-building"></i><span>Companies</span>
                <i class="fas fa-chevron-down adm-chevron" :class="open?'open':''"></i>
            </button>
            <div class="adm-submenu" x-show="open" x-collapse>
                <a href="{{ route('admin.companies.index') }}" class="adm-submenu-link">All Companies</a>
                <a href="{{ route('admin.companies.index', ['status'=>'pending']) }}" class="adm-submenu-link">Pending</a>
                <a href="{{ route('admin.companies.create') }}" class="adm-submenu-link">Add Company</a>
            </div>
        </div>
        @endif

        <!-- Jobs -->
        <div class="adm-nav-section" x-data="{ open: active === 'jobs' }">
            <button class="adm-nav-item {{ request()->routeIs('admin.jobs*') ? 'active' : '' }}" @click="open=!open">
                <i class="fas fa-briefcase"></i><span>Jobs</span>
                <i class="fas fa-chevron-down adm-chevron" :class="open?'open':''"></i>
            </button>
            <div class="adm-submenu" x-show="open" x-collapse>
                <a href="{{ route('admin.jobs.index') }}" class="adm-submenu-link">All Jobs</a>
                <a href="{{ route('admin.jobs.index', ['status'=>'pending']) }}" class="adm-submenu-link">Pending</a>
                <a href="{{ route('admin.jobs.index', ['status'=>'approved']) }}" class="adm-submenu-link">Approved</a>
            </div>
        </div>

        @if(auth()->check() && auth()->user()->role === 'admin')
        <!-- Internships -->
        <div class="adm-nav-section" x-data="{ open: active === 'internships' }">
            <button class="adm-nav-item {{ request()->routeIs('admin.internships*') ? 'active' : '' }}" @click="open=!open">
                <i class="fas fa-graduation-cap"></i><span>Internships</span>
                <i class="fas fa-chevron-down adm-chevron" :class="open?'open':''"></i>
            </button>
            <div class="adm-submenu" x-show="open" x-collapse>
                <a href="{{ route('admin.internships.index') }}" class="adm-submenu-link">All</a>
                <a href="{{ route('admin.internships.index', ['status'=>'pending']) }}" class="adm-submenu-link">Pending</a>
            </div>
        </div>
        @endif

        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'company']))
        <!-- Applications -->
        <div class="adm-nav-section" x-data="{ open: active === 'applications' }">
            <button class="adm-nav-item {{ request()->routeIs('admin.applications*') ? 'active' : '' }}" @click="open=!open">
                <i class="fas fa-file-lines"></i><span>Applications</span>
                <i class="fas fa-chevron-down adm-chevron" :class="open?'open':''"></i>
            </button>
            <div class="adm-submenu" x-show="open" x-collapse>
                <a href="{{ route('admin.applications.index') }}" class="adm-submenu-link">All Applications</a>
                <a href="{{ route('admin.applications.index', ['status'=>'status-wise']) }}" class="adm-submenu-link">Status Wise</a>
            </div>
        </div>
        @endif

        @if(auth()->check() && auth()->user()->role === 'admin')
        <!-- Skills -->
        <div class="adm-nav-section" x-data="{ open: active === 'skills' }">
            <button class="adm-nav-item {{ request()->routeIs('admin.skills*') ? 'active' : '' }}" @click="open=!open">
                <i class="fas fa-code"></i><span>Skills</span>
                <i class="fas fa-chevron-down adm-chevron" :class="open?'open':''"></i>
            </button>
            <div class="adm-submenu" x-show="open" x-collapse>
                <a href="{{ route('admin.skills.index') }}" class="adm-submenu-link">Manage Skills</a>
                <a href="{{ route('admin.skills.create') }}" class="adm-submenu-link">Add Skill</a>
            </div>
        </div>

        <span class="adm-nav-section-label">System</span>

        <div class="adm-nav-section" x-data="{ open: false }">
            <button class="adm-nav-item {{ request()->routeIs('admin.reports*') ? 'active' : '' }}" @click="open=!open">
                <i class="fas fa-chart-area"></i><span>Analytics</span>
                <i class="fas fa-chevron-down adm-chevron" :class="open?'open':''"></i>
            </button>
            <div class="adm-submenu" x-show="open" x-collapse>
                <a href="{{ route('admin.reports.index') }}" class="adm-submenu-link">User Growth</a>
                <a href="{{ route('admin.reports.index', ['type'=>'jobs']) }}" class="adm-submenu-link">Job Stats</a>
                <a href="{{ route('admin.reports.index', ['type'=>'applications']) }}" class="adm-submenu-link">Applications</a>
            </div>
        </div>

        <div class="adm-nav-section" x-data="{ open: false }">
            <button class="adm-nav-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}" @click="open=!open">
                <i class="fas fa-gear"></i><span>Settings</span>
                <i class="fas fa-chevron-down adm-chevron" :class="open?'open':''"></i>
            </button>
            <div class="adm-submenu" x-show="open" x-collapse>
                <a href="{{ route('admin.settings.index') }}" class="adm-submenu-link">Website Settings</a>
                <a href="{{ route('admin.about_sections.index') }}" class="adm-submenu-link">About Page</a>
            </div>
        </div>
        @endif
    </nav>

    <!-- Footer -->
    <div class="adm-sidebar-foot">
        <div class="adm-foot-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}</div>
        <div style="flex:1;min-width:0;">
            <div class="adm-foot-name">{{ auth()->user()->name ?? 'Admin' }}</div>
            <div class="adm-foot-role">Super Admin</div>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="adm-icon-btn" style="border:none;" title="Logout">
                <i class="fas fa-right-from-bracket" style="font-size:.8rem;"></i>
            </button>
        </form>
    </div>
</aside>

<!-- ══ TOPBAR ══ -->
<header id="adminTopbar">
    <!-- Hamburger (mobile) -->
    <button class="adm-ham" @click="sidebarOpen = !sidebarOpen">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Global search -->
    <div class="adm-search" style="display:flex;">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Search everything… (Ctrl+K)" id="adminGlobalSearch">
        <span class="adm-search-kbd">⌘K</span>
    </div>

    <!-- Right actions -->
    <div class="adm-topbar-right">
        <!-- View site -->
        <a href="{{ route('home') }}" target="_blank" class="adm-icon-btn" title="View Site" style="text-decoration:none;">
            <i class="fas fa-arrow-up-right-from-square" style="font-size:.75rem;"></i>
        </a>

        <!-- Notifications -->
        <div style="position:relative;" x-data="{ openNotif: false }">
            <button class="adm-icon-btn" title="Notifications" @click="openNotif = !openNotif" @click.away="openNotif = false">
                <i class="fas fa-bell"></i>
                <span id="bellCount" style="display:none; position:absolute; top:-2px; right:-2px; background:#ef4444; color:#fff; font-size:.55rem; font-weight:900; border-radius:99px; padding:2px 5px; border:2px solid var(--adm-surface); line-height:1;">0</span>
            </button>
            <div class="adm-dropdown" :class="openNotif ? 'open' : ''" style="width: 320px; right: 0; padding:0; overflow:hidden;">
                <div class="adm-dropdown-head" style="display:flex; justify-content:space-between; align-items:center; padding: 1rem; border-bottom: 1px solid var(--adm-border);">
                    <div class="adm-dropdown-name" style="margin:0;">Notifications</div>
                    <button onclick="markAllNotificationsAsRead()" style="background:none; border:none; color:var(--adm-text-light); font-size:.7rem; cursor:pointer; font-weight:600;">Mark all read</button>
                </div>
                <div id="notifList" style="max-height: 320px; overflow-y: auto;">
                    <div style="padding: 1.5rem; text-align:center; color:var(--adm-text-muted); font-size:.75rem;">
                        <i class="fas fa-spinner fa-spin"></i> Loading...
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Profile -->
        <div style="position:relative;" x-data="{open:false}">
            <button class="adm-profile-btn" @click="open=!open" @click.away="open=false">
                <div class="adm-profile-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}</div>
                <div class="adm-profile-name">
                    {{ Str::words(auth()->user()->name ?? 'Admin', 1, '') }}
                    <small>Administrator</small>
                </div>
                <i class="fas fa-chevron-down" style="font-size:.6rem;color:var(--adm-text-light);"></i>
            </button>
            <div class="adm-dropdown" :class="open?'open':''">
                <div class="adm-dropdown-head">
                    <div class="adm-dropdown-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div class="adm-dropdown-email">{{ auth()->user()->email ?? 'admin@example.com' }}</div>
                </div>
                <a href="{{ route('profile.edit') }}" class="adm-dd-link"><i class="fas fa-user-circle"></i> My Profile</a>
                <a href="{{ route('admin.settings.index') }}" class="adm-dd-link"><i class="fas fa-gear"></i> Settings</a>
                <a href="{{ route('home') }}" target="_blank" class="adm-dd-link"><i class="fas fa-globe"></i> View Site</a>
                <div class="adm-dd-divider"></div>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="adm-dd-link danger"><i class="fas fa-right-from-bracket"></i> Logout</button>
                </form>
            </div>
        </div>
    </div>
</header>

<!-- ══ MAIN CONTENT ══ -->
<main id="adminMain">
    <!-- Session toasts -->
    @if(session('success'))
        <script>document.addEventListener('DOMContentLoaded',()=>adminToast('{{ addslashes(session('success')) }}','success'));</script>
    @endif
    @if(session('error'))
        <script>document.addEventListener('DOMContentLoaded',()=>adminToast('{{ addslashes(session('error')) }}','error'));</script>
    @endif

    @yield('content')
</main>

<!-- Toast container -->
<div id="adminToasts"></div>

<!-- ══ GLOBAL JS ══ -->
<script>
// Toast
function adminToast(msg, type='info', dur=3500) {
    const icons = { success:'fa-circle-check', error:'fa-circle-xmark', info:'fa-circle-info' };
    const wrap = document.getElementById('adminToasts');
    const el = document.createElement('div');
    el.className = `adm-toast ${type}`;
    el.innerHTML = `<i class="fas ${icons[type]||icons.info}" style="font-size:.9rem;"></i><span>${msg}</span>`;
    wrap.appendChild(el);
    requestAnimationFrame(()=>requestAnimationFrame(()=>el.classList.add('show')));
    setTimeout(()=>{ el.classList.remove('show'); setTimeout(()=>el.remove(),350); }, dur);
}

// Global search Ctrl+K
document.addEventListener('keydown', e => {
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        document.getElementById('adminGlobalSearch')?.focus();
    }
});

// ══════════════ NOTIFICATIONS ══════════════ //
const csrfToken = '{{ csrf_token() }}';

async function fetchNotifications() {
    try {
        const response = await fetch('/api/notifications', {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (!response.ok) return;

        const data = await response.json();
        
        // Update badge
        const badge = document.getElementById('bellCount');
        if (data.count > 0) {
            badge.textContent = data.count > 99 ? '99+' : data.count;
            badge.style.display = 'block';
        } else {
            badge.style.display = 'none';
        }

        // Render List
        const listContainer = document.getElementById('notifList');
        if (data.notifications.length === 0) {
            listContainer.innerHTML = '<div style="padding:2rem;text-align:center;color:var(--adm-text-light);font-size:.75rem;"><i class="fas fa-bell-slash text-2xl mb-2 opacity-50 block"></i> No new notifications</div>';
            return;
        }

        let html = '';
        data.notifications.forEach(notif => {
            const dataObj = notif.data;
            const icon = dataObj.icon || 'fas fa-info-circle';
            const url = dataObj.url || '#';
            html += `
                <div style="padding: .85rem 1rem; border-bottom: 1px solid var(--adm-border); display:flex; gap:.85rem; align-items:flex-start; transition: background .15s;" class="hover:bg-slate-800/10 dark:hover:bg-white/5">
                    <div style="width:32px; height:32px; border-radius:50%; background:rgba(59,130,246,.1); color:#3b82f6; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="${icon} text-xs"></i>
                    </div>
                    <div style="flex:1;">
                        <a href="${url}" onclick="markNotificationAsRead('${notif.id}', event)" style="text-decoration:none;">
                            <div style="font-size:.8rem; font-weight:700; color:var(--adm-text);">${dataObj.title || 'Notification'}</div>
                            <div style="font-size:.75rem; color:var(--adm-text-muted); margin-top:.2rem; line-height:1.3;">${dataObj.message || ''}</div>
                        </a>
                        <div style="font-size:.65rem; color:var(--adm-text-light); margin-top:.35rem; display:flex; justify-content:space-between;">
                            <span>${notif.created_at}</span>
                            <button onclick="markNotificationAsRead('${notif.id}')" style="background:none;border:none;color:#3b82f6;cursor:pointer;font-size:.65rem;">Mark read</button>
                        </div>
                    </div>
                </div>
            `;
        });
        listContainer.innerHTML = html;
    } catch (e) {
        console.error('Notification Polling Failed', e);
    }
}

async function markNotificationAsRead(id, event = null) {
    if(event && !event.target.closest('button')) {
        // Just let the link navigation happen naturally, but fire the read request in background
    }
    try {
        await fetch('/api/notifications/' + id + '/read', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
        });
        fetchNotifications();
    } catch(e) {}
}

async function markAllNotificationsAsRead() {
    try {
        await fetch('/api/notifications/read-all', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
        });
        fetchNotifications();
    } catch(e) {}
}

// Initial fetch & set interval (every 5 seconds)
document.addEventListener('DOMContentLoaded', () => {
    fetchNotifications();
    setInterval(fetchNotifications, 5000);
});
</script>
</body>
</html>
