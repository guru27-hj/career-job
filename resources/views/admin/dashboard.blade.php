@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<style>
.adm-stats-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 1rem; margin-bottom: 1.75rem; }
@media(max-width:900px) { .adm-stats-grid { grid-template-columns: repeat(2,1fr); } }
@media(max-width:500px) { .adm-stats-grid { grid-template-columns: 1fr; } }

.adm-charts-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.75rem; }
@media(max-width:900px) { .adm-charts-row { grid-template-columns: 1fr; } }

.adm-bottom-row { display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; }
@media(max-width:900px) { .adm-bottom-row { grid-template-columns: 1fr; } }
</style>

<!-- Breadcrumb -->
<div class="adm-breadcrumb">
    <a href="{{ route('admin.dashboard') }}"><i class="fas fa-house" style="font-size:.65rem;"></i></a>
    <span class="sep">/</span>
    <span class="active">Dashboard</span>
</div>

<!-- Page Title -->
<div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem;">
    <div>
        <h1 style="font-size:1.5rem;font-weight:900;letter-spacing:-.04em;color:#f1f5f9;margin:0;">
            Dashboard Overview
        </h1>
        <p style="font-size:.83rem;color:var(--adm-text-muted);margin:.3rem 0 0;">
            Welcome back, <strong style="color:#93c5fd;">{{ auth()->user()->name ?? 'Admin' }}</strong> — here's what's happening today.
        </p>
    </div>
    <div style="display:flex;gap:.5rem;">
        <button class="adm-btn adm-btn-ghost adm-btn-sm" onclick="location.reload()">
            <i class="fas fa-rotate-right"></i> Refresh
        </button>
        <a href="{{ route('admin.reports.index') }}" class="adm-btn adm-btn-primary adm-btn-sm">
            <i class="fas fa-chart-area"></i> Full Report
        </a>
    </div>
</div>

<!-- ══ STAT CARDS ══ -->
<div class="adm-stats-grid">
    @php
        $stats = [
            ['label'=>'Total Users',        'value'=>$totalUsers,        'icon'=>'fa-users',          'color'=>'#3b82f6', 'bg'=>'rgba(59,130,246,.15)',  'trend'=>'+12%', 'up'=>true],
            ['label'=>'Total Jobs',          'value'=>$totalJobs,         'icon'=>'fa-briefcase',      'color'=>'#8b5cf6', 'bg'=>'rgba(139,92,246,.15)', 'trend'=>'+8%',  'up'=>true],
            ['label'=>'Internships',         'value'=>$totalInternships,  'icon'=>'fa-graduation-cap', 'color'=>'#22c55e', 'bg'=>'rgba(34,197,94,.15)',  'trend'=>'+24%', 'up'=>true],
            ['label'=>'Applications',        'value'=>$totalApplications, 'icon'=>'fa-file-lines',     'color'=>'#f59e0b', 'bg'=>'rgba(245,158,11,.15)', 'trend'=>'-3%',  'up'=>false],
        ];
    @endphp
    @foreach($stats as $s)
        <div class="adm-stat-card">
            <div class="adm-stat-glow" style="background:{{ $s['color'] }};"></div>
            <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                <div class="adm-stat-icon" style="background:{{ $s['bg'] }};color:{{ $s['color'] }};">
                    <i class="fas {{ $s['icon'] }}"></i>
                </div>
                <span class="adm-stat-trend {{ $s['up'] ? 'adm-trend-up' : 'adm-trend-down' }}">
                    <i class="fas {{ $s['up'] ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }}" style="font-size:.65rem;"></i>
                    {{ $s['trend'] }}
                </span>
            </div>
            <div class="adm-stat-num" style="margin-top:.85rem;">{{ number_format($s['value']) }}</div>
            <div class="adm-stat-lbl">{{ $s['label'] }}</div>
            <div style="height:3px;border-radius:99px;background:rgba(255,255,255,.06);margin-top:.85rem;overflow:hidden;">
                <div style="height:100%;width:{{ min(100, (int)($s['value']*100/max(1,$totalUsers))) }}%;background:{{ $s['color'] }};border-radius:99px;"></div>
            </div>
        </div>
    @endforeach
</div>

<!-- ══ CHARTS ROW 1 ══ -->
<div class="adm-charts-row">
    <!-- Monthly Job Postings -->
    <div class="adm-card">
        <div class="adm-card-header">
            <div>
                <div class="adm-card-title">Monthly Job Postings</div>
                <div class="adm-card-sub">{{ date('Y') }} overview</div>
            </div>
            <span class="adm-badge adm-badge-blue">Line Chart</span>
        </div>
        <div class="adm-card-body">
            <div class="adm-chart-wrap" style="height:240px;">
                <canvas id="jobsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Applications Trend -->
    <div class="adm-card">
        <div class="adm-card-header">
            <div>
                <div class="adm-card-title">Applications Trend</div>
                <div class="adm-card-sub">Monthly submissions</div>
            </div>
            <span class="adm-badge adm-badge-green">Bar Chart</span>
        </div>
        <div class="adm-card-body">
            <div class="adm-chart-wrap" style="height:240px;">
                <canvas id="applicationsChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- ══ CHARTS ROW 2 + ACTIVITY ══ -->
<div class="adm-bottom-row">
    <!-- User Growth (wide) -->
    <div class="adm-card">
        <div class="adm-card-header">
            <div>
                <div class="adm-card-title">User Growth</div>
                <div class="adm-card-sub">New registrations per month — {{ date('Y') }}</div>
            </div>
            <div style="display:flex;background:rgba(255,255,255,.05);border:1px solid var(--adm-border);border-radius:8px;overflow:hidden;">
                <button class="adm-btn adm-btn-sm" style="background:var(--adm-gradient);color:#fff;border:none;border-radius:0;" id="chartYearBtn">Year</button>
                <button class="adm-btn adm-btn-sm adm-btn-ghost" style="border:none;border-radius:0;" id="chartMonthBtn">Month</button>
            </div>
        </div>
        <div class="adm-card-body">
            <div class="adm-chart-wrap" style="height:280px;">
                <canvas id="usersChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Activity Feed -->
    <div class="adm-card" style="display:flex;flex-direction:column;">
        <div class="adm-card-header">
            <div class="adm-card-title">Recent Activity</div>
            <a href="#" style="font-size:.72rem;font-weight:700;color:#93c5fd;text-decoration:none;padding:3px 9px;background:rgba(59,130,246,.1);border-radius:99px;">View All</a>
        </div>
        <div style="padding:1rem;flex:1;overflow-y:auto;max-height:340px;">
            <div class="adm-feed">
                @php
                    $activities = [
                        ['icon'=>'fa-user-plus',    'color'=>'rgba(59,130,246,.15)',  'ic'=>'#93c5fd', 'title'=>'New Registration',     'sub'=>'A new user joined as a student.',          'time'=>'10 mins ago'],
                        ['icon'=>'fa-briefcase',    'color'=>'rgba(34,197,94,.15)',   'ic'=>'#86efac', 'title'=>'Job Posted',            'sub'=>'Frontend Developer role — TechCorp Ltd.',  'time'=>'35 mins ago'],
                        ['icon'=>'fa-building',     'color'=>'rgba(139,92,246,.15)',  'ic'=>'#c4b5fd', 'title'=>'Company Registered',   'sub'=>'InnovateX submitted for approval.',         'time'=>'2 hrs ago'],
                        ['icon'=>'fa-file-lines',   'color'=>'rgba(245,158,11,.15)',  'ic'=>'#fcd34d', 'title'=>'Application Submitted', 'sub'=>'Sarah applied for UX Designer internship.', 'time'=>'5 hrs ago'],
                        ['icon'=>'fa-shield-check', 'color'=>'rgba(34,197,94,.15)',   'ic'=>'#86efac', 'title'=>'Job Approved',          'sub'=>'DevOps Engineer role was approved.',        'time'=>'Yesterday'],
                        ['icon'=>'fa-trash',        'color'=>'rgba(239,68,68,.15)',   'ic'=>'#fca5a5', 'title'=>'User Removed',          'sub'=>'Spam account was deleted.',                'time'=>'Yesterday'],
                    ];
                @endphp
                @foreach($activities as $act)
                    <div class="adm-feed-item">
                        <div class="adm-feed-dot" style="background:{{ $act['color'] }};color:{{ $act['ic'] }};">
                            <i class="fas {{ $act['icon'] }}" style="font-size:.8rem;"></i>
                        </div>
                        <div>
                            <div class="adm-feed-title">{{ $act['title'] }}</div>
                            <div class="adm-feed-sub">{{ $act['sub'] }}</div>
                            <div class="adm-feed-time"><i class="fas fa-clock" style="font-size:.6rem;margin-right:.25rem;"></i>{{ $act['time'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- ══ CHART JS ══ -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Common dark theme config
    const palette = { blue:'#3b82f6', purple:'#8b5cf6', green:'#22c55e', amber:'#f59e0b' };
    Chart.defaults.color = '#64748b';
    Chart.defaults.font.family = "'Inter', system-ui, sans-serif";

    const baseOpts = {
        responsive: true, maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#0f172a', borderColor: 'rgba(255,255,255,.1)', borderWidth: 1,
                padding: 12, cornerRadius: 10, displayColors: false,
                titleFont: { size: 12, weight: 'bold' },
                bodyFont:  { size: 11, weight: '500' },
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(255,255,255,.04)', drawBorder: false },
                border: { display: false },
                ticks: { color: '#475569', padding: 10, font: { size: 10 } },
            },
            x: {
                grid: { display: false },
                border: { display: false },
                ticks: { color: '#475569', padding: 8, font: { size: 10 } },
            }
        },
        interaction: { intersect: false, mode: 'index' },
        elements: { point: { hoverRadius: 6 } },
    };

    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

    // Jobs chart
    function makeGradient(ctx, h, color) {
        const g = ctx.createLinearGradient(0, 0, 0, h);
        g.addColorStop(0, color.replace(')',', 0.35)').replace('rgb','rgba'));
        g.addColorStop(1, color.replace(')',', 0)').replace('rgb','rgba'));
        return g;
    }

    const jobCtx = document.getElementById('jobsChart').getContext('2d');
    new Chart(jobCtx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                data: {{ json_encode(array_values($jobData)) }},
                borderColor: palette.blue,
                backgroundColor: (ctx) => { const g = ctx.chart.ctx.createLinearGradient(0,0,0,240); g.addColorStop(0,'rgba(59,130,246,.25)'); g.addColorStop(1,'rgba(59,130,246,0)'); return g; },
                borderWidth: 2.5, fill: true, tension: 0.45,
                pointBackgroundColor: '#0f172a', pointBorderColor: palette.blue,
                pointBorderWidth: 2, pointRadius: 3,
            }]
        },
        options: baseOpts
    });

    // Applications chart
    const appCtx = document.getElementById('applicationsChart').getContext('2d');
    new Chart(appCtx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                data: {{ json_encode(array_values($appData)) }},
                backgroundColor: (ctx) => { const v = ctx.raw; const max = Math.max(...{{ json_encode(array_values($appData)) }}); const alpha = 0.3 + (v/max)*0.6; return `rgba(34,197,94,${alpha})`; },
                borderRadius: 7, borderSkipped: false,
                hoverBackgroundColor: palette.green,
            }]
        },
        options: { ...baseOpts,
            scales: { ...baseOpts.scales,
                x: { ...baseOpts.scales.x, categoryPercentage: 0.7, barPercentage: 0.7 }
            }
        }
    });

    // User growth chart
    const userCtx = document.getElementById('usersChart').getContext('2d');
    new Chart(userCtx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                data: {{ json_encode(array_values($userData)) }},
                borderColor: palette.purple,
                backgroundColor: (ctx) => { const g = ctx.chart.ctx.createLinearGradient(0,0,0,280); g.addColorStop(0,'rgba(139,92,246,.3)'); g.addColorStop(1,'rgba(139,92,246,0)'); return g; },
                borderWidth: 2.5, fill: true, tension: 0.45,
                pointBackgroundColor: '#0f172a', pointBorderColor: palette.purple,
                pointBorderWidth: 2, pointRadius: 3,
            }]
        },
        options: baseOpts
    });
});
</script>
@endsection
