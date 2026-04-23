@extends('layouts.admin')
@section('title', 'User Management')

@section('content')
<style>
/* ── User table extras ── */
.adm-user-avatar {
    width: 38px; height: 38px; border-radius: 10px;
    background: linear-gradient(135deg,#3b82f6,#8b5cf6);
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: .9rem; color: #fff; flex-shrink: 0;
}
.adm-resume-btn {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .3rem .75rem; border-radius: 7px;
    font-size: .72rem; font-weight: 700; text-decoration: none; cursor: pointer;
    border: none; font-family: 'Inter', sans-serif; transition: all .15s;
}
.adm-resume-view { background: rgba(59,130,246,.15); color: #93c5fd; border: 1px solid rgba(59,130,246,.2); }
.adm-resume-view:hover { background: rgba(59,130,246,.25); color: #60a5fa; }
.adm-resume-dl { background: rgba(34,197,94,.12); color: #86efac; border: 1px solid rgba(34,197,94,.2); margin-left: .3rem; }
.adm-resume-dl:hover { background: rgba(34,197,94,.22); color: #4ade80; }

/* Filter bar */
.adm-filter-bar {
    display: flex; gap: .6rem; flex-wrap: wrap; align-items: center;
    background: var(--adm-surface); border: 1px solid var(--adm-border);
    border-radius: 12px; padding: .85rem 1.1rem; margin-bottom: 1.25rem;
}
.adm-filter-bar form { display: contents; }

/* Search input override */
.adm-search-field {
    display: flex; align-items: center; gap: .5rem;
    background: rgba(255,255,255,.05); border: 1px solid var(--adm-border);
    border-radius: 9px; padding: .5rem .85rem; flex: 1; min-width: 200px;
    transition: border-color .15s;
}
.adm-search-field:focus-within { border-color: rgba(59,130,246,.5); }
.adm-search-field input { background:transparent; border:none; outline:none; font-size:.83rem; color:var(--adm-text); font-family:'Inter',sans-serif; flex:1; }
.adm-search-field input::placeholder { color:var(--adm-text-light); }
.adm-search-field i { color:var(--adm-text-light); font-size:.82rem; }

.adm-filter-chip {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .45rem .9rem; border-radius: 9px; font-size: .78rem; font-weight: 700;
    background: rgba(255,255,255,.05); border: 1px solid var(--adm-border);
    color: var(--adm-text-muted); cursor: pointer; transition: all .15s;
    text-decoration: none;
}
.adm-filter-chip:hover { background: rgba(59,130,246,.1); border-color: rgba(59,130,246,.3); color: #93c5fd; }
.adm-filter-chip.active { background: rgba(59,130,246,.15); border-color: rgba(59,130,246,.35); color: #93c5fd; }

.adm-filter-select {
    background: rgba(255,255,255,.05); border: 1px solid var(--adm-border);
    border-radius: 9px; padding: .5rem .85rem; font-size: .78rem;
    color: var(--adm-text-muted); font-family:'Inter',sans-serif; outline:none;
    cursor: pointer; transition: border-color .15s;
}
.adm-filter-select:focus { border-color: rgba(59,130,246,.5); }

/* Skill tags in table */
.adm-skill-pill {
    display: inline-flex; padding: 2px 7px;
    background: rgba(139,92,246,.12); color: #c4b5fd;
    border: 1px solid rgba(139,92,246,.2);
    border-radius: 99px; font-size: .65rem; font-weight: 700;
    margin: 1px;
}

/* Table container */
.adm-table-wrap { overflow-x: auto; }

/* Actions reveal */
.adm-row-actions { display: flex; align-items: center; gap: .35rem; justify-content: flex-end; }

/* PDF Modal */
.adm-pdf-modal { max-width: 700px; }
#pdfFrame { width: 100%; height: 500px; border: none; border-radius: 8px; background: #fff; }

/* Empty search results */
.adm-table-empty { padding: 3.5rem 2rem; text-align: center; }
.adm-table-empty-icon { width: 64px; height: 64px; border-radius: 16px; background: rgba(59,130,246,.08); border:1px solid rgba(59,130,246,.15); display:flex; align-items:center; justify-content:center; font-size:1.5rem; margin:0 auto 1rem; }

/* Stats mini-row */
.adm-user-stats { display: flex; gap: 1rem; margin-bottom: 1.25rem; flex-wrap: wrap; }
.adm-user-stat-chip { background: var(--adm-surface); border: 1px solid var(--adm-border); border-radius: 10px; padding: .7rem 1.25rem; display:flex; align-items:center; gap:.7rem; }
.adm-user-stat-chip .num { font-size: 1.3rem; font-weight: 900; color: var(--adm-text); }
.adm-user-stat-chip .lbl { font-size: .72rem; color: var(--adm-text-light); font-weight: 600; text-transform: uppercase; letter-spacing: .05em; }
</style>

<!-- Breadcrumb -->
<div class="adm-breadcrumb">
    <a href="{{ route('admin.dashboard') }}"><i class="fas fa-house" style="font-size:.65rem;"></i></a>
    <span class="sep">/</span>
    <span class="active">User Management</span>
</div>

<!-- Page header -->
<div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem;">
    <div>
        <h1 style="font-size:1.4rem;font-weight:900;letter-spacing:-.04em;color:#f1f5f9;margin:0;">User Management</h1>
        <p style="font-size:.83rem;color:var(--adm-text-muted);margin:.3rem 0 0;">Manage all registered users — view resumes, skills, and statuses.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="adm-btn adm-btn-primary">
        <i class="fas fa-plus"></i> Add User
    </a>
</div>

<!-- Mini stats -->
<div class="adm-user-stats">
    <div class="adm-user-stat-chip">
        <div style="width:34px;height:34px;border-radius:9px;background:rgba(59,130,246,.15);display:flex;align-items:center;justify-content:center;font-size:.9rem;color:#93c5fd;"><i class="fas fa-users"></i></div>
        <div><div class="num">{{ $users->total() }}</div><div class="lbl">Total Users</div></div>
    </div>
    <div class="adm-user-stat-chip">
        <div style="width:34px;height:34px;border-radius:9px;background:rgba(34,197,94,.12);display:flex;align-items:center;justify-content:center;font-size:.9rem;color:#86efac;"><i class="fas fa-file-pdf"></i></div>
        <div>
            <div class="num">{{ $users->getCollection()->filter(fn($u)=>optional($u->profile)->resume_path)->count() }}</div>
            <div class="lbl">Resumes</div>
        </div>
    </div>
    <div class="adm-user-stat-chip">
        <div style="width:34px;height:34px;border-radius:9px;background:rgba(139,92,246,.12);display:flex;align-items:center;justify-content:center;font-size:.9rem;color:#c4b5fd;"><i class="fas fa-shield-alt"></i></div>
        <div>
            <div class="num">{{ $users->getCollection()->where('is_admin', true)->count() }}</div>
            <div class="lbl">Admins</div>
        </div>
    </div>
</div>

<!-- Filter bar -->
<div class="adm-filter-bar">
    <form action="{{ route('admin.users.index') }}" method="GET" style="display:contents;">
        <div class="adm-search-field">
            <i class="fas fa-search"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email…">
        </div>
        @if(request('role')) <input type="hidden" name="role" value="{{ request('role') }}"> @endif
        <button type="submit" class="adm-btn adm-btn-primary adm-btn-sm">
            <i class="fas fa-search"></i> Search
        </button>
    </form>

    <a href="{{ route('admin.users.index') }}"
       class="adm-filter-chip {{ !request('role') && !request('resume') ? 'active' : '' }}">
        <i class="fas fa-list"></i> All
    </a>
    <a href="{{ route('admin.users.index', ['role'=>'student']) }}"
       class="adm-filter-chip {{ request('role')=='student' ? 'active' : '' }}">
        <i class="fas fa-user-graduate"></i> Students Only
    </a>
    <a href="{{ route('admin.users.index', ['resume'=>'1']) }}"
       class="adm-filter-chip {{ request('resume')=='1' ? 'active' : '' }}">
        <i class="fas fa-file-pdf"></i> With Resume
    </a>

    @if(request('search') || request('role') || request('resume'))
        <a href="{{ route('admin.users.index') }}" class="adm-filter-chip" style="color:#f87171;border-color:rgba(239,68,68,.2);">
            <i class="fas fa-xmark"></i> Clear
        </a>
    @endif
</div>

<!-- Users table -->
<div class="adm-card">
    <div class="adm-table-wrap">
        <table class="adm-table">
            <thead>
                <tr>
                    <th># / User</th>
                    <th>Skills</th>
                    <th>Resume</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    @php
                        $profile = optional($user->profile);
                        $skills  = is_array($profile->skills) ? $profile->skills : (json_decode($profile->skills, true) ?? []);
                        $resume  = $profile->resume_path;
                    @endphp
                    <tr>
                        <!-- User -->
                        <td>
                            <div style="display:flex;align-items:center;gap:.75rem;">
                                <div class="adm-user-avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                                <div>
                                    <div style="font-weight:700;color:var(--adm-text);font-size:.85rem;">{{ $user->name }}</div>
                                    <div style="font-size:.73rem;color:var(--adm-text-light);">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Skills -->
                        <td style="max-width:220px;">
                            @if(count($skills))
                                <div style="display:flex;flex-wrap:wrap;gap:2px;">
                                    @foreach(array_slice($skills, 0, 4) as $sk)
                                        <span class="adm-skill-pill">{{ $sk }}</span>
                                    @endforeach
                                    @if(count($skills) > 4)
                                        <span class="adm-skill-pill">+{{ count($skills)-4 }}</span>
                                    @endif
                                </div>
                            @else
                                <span style="color:var(--adm-text-light);font-size:.75rem;font-style:italic;">No skills</span>
                            @endif
                        </td>

                        <!-- Resume -->
                        <td>
                            @if($resume)
                                <div style="display:flex;align-items:center;gap:.3rem;">
                                    <span class="adm-badge adm-badge-green" style="font-size:.63rem;padding:2px 7px;">
                                        <i class="fas fa-circle-check" style="font-size:.55rem;"></i> PDF
                                    </span>
                                    <button
                                        class="adm-resume-btn adm-resume-view"
                                        onclick="openPdfModal('{{ Storage::url($resume) }}', '{{ $user->name }}')"
                                        title="Preview">
                                        <i class="fas fa-eye" style="font-size:.65rem;"></i> View
                                    </button>
                                    <a href="{{ Storage::url($resume) }}" download class="adm-resume-btn adm-resume-dl" title="Download">
                                        <i class="fas fa-download" style="font-size:.65rem;"></i>
                                    </a>
                                </div>
                            @else
                                <span class="adm-badge adm-badge-gray" style="font-size:.63rem;padding:2px 8px;">
                                    <i class="fas fa-circle-minus" style="font-size:.55rem;"></i> None
                                </span>
                            @endif
                        </td>

                        <!-- Role -->
                        <td>
                            @if($user->is_admin)
                                <span class="adm-badge adm-badge-purple">
                                    <i class="fas fa-shield-alt" style="font-size:.6rem;"></i> Admin
                                </span>
                            @else
                                <span class="adm-badge adm-badge-gray">
                                    <i class="fas fa-user" style="font-size:.6rem;"></i> User
                                </span>
                            @endif
                        </td>

                        <!-- Joined -->
                        <td>
                            <div style="font-size:.8rem;color:var(--adm-text-muted);">{{ $user->created_at->format('M d, Y') }}</div>
                            <div style="font-size:.7rem;color:var(--adm-text-light);">{{ $user->created_at->diffForHumans() }}</div>
                        </td>

                        <!-- Actions -->
                        <td>
                            <div class="adm-row-actions">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="adm-btn adm-btn-ghost adm-btn-icon adm-btn-sm" title="View">
                                    <i class="fas fa-eye" style="font-size:.75rem;"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="adm-btn adm-btn-ghost adm-btn-icon adm-btn-sm" title="Edit">
                                    <i class="fas fa-pen" style="font-size:.72rem;"></i>
                                </a>
                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="margin:0;"
                                          onsubmit="return confirm('Delete this user permanently?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="adm-btn adm-btn-danger adm-btn-icon adm-btn-sm" title="Delete">
                                            <i class="fas fa-trash" style="font-size:.7rem;"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="adm-table-empty">
                                <div class="adm-table-empty-icon">🔍</div>
                                <div style="font-weight:800;color:var(--adm-text);margin-bottom:.4rem;">No users found</div>
                                <div style="font-size:.83rem;color:var(--adm-text-muted);">Try adjusting your search or filters.</div>
                                @if(request('search') || request('role') || request('resume'))
                                    <a href="{{ route('admin.users.index') }}" class="adm-btn adm-btn-ghost adm-btn-sm" style="display:inline-flex;margin-top:1rem;">Clear filters</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
        <div style="padding:1rem 1.25rem;border-top:1px solid var(--adm-border);">
            {{ $users->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- ══ PDF MODAL ══ -->
<div class="adm-modal-wrap" id="pdfModalWrap" onclick="closePdfModal(event)">
    <div class="adm-modal adm-pdf-modal">
        <div class="adm-modal-head">
            <div>
                <div class="adm-modal-title" id="pdfModalTitle">Resume Preview</div>
                <div style="font-size:.73rem;color:var(--adm-text-muted);margin-top:.15rem;">PDF document</div>
            </div>
            <div style="display:flex;gap:.4rem;">
                <a id="pdfDownloadBtn" href="#" download class="adm-btn adm-btn-primary adm-btn-sm">
                    <i class="fas fa-download"></i> Download
                </a>
                <button onclick="closePdfModal()" class="adm-btn adm-btn-ghost adm-btn-sm">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>
        </div>
        <div class="adm-modal-body" style="padding:1rem;">
            <iframe id="pdfFrame" src="" title="Resume PDF"></iframe>
        </div>
    </div>
</div>

<script>
function openPdfModal(url, name) {
    document.getElementById('pdfFrame').src = url;
    document.getElementById('pdfDownloadBtn').href = url;
    document.getElementById('pdfModalTitle').textContent = name + ' — Resume';
    document.getElementById('pdfModalWrap').classList.add('open');
}
function closePdfModal(e) {
    if (!e || e.target === document.getElementById('pdfModalWrap') || e.currentTarget?.tagName === 'BUTTON') {
        document.getElementById('pdfModalWrap').classList.remove('open');
        document.getElementById('pdfFrame').src = '';
    }
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closePdfModal(); });
</script>
@endsection
