@extends('layouts.admin')
@section('title', 'Manage Skills')

@section('content')
<style>
/* ── Skill Management Specifics ── */
.sk-grid { display: grid; grid-template-columns: 320px 1fr; gap: 1.5rem; align-items: start; }
@media(max-width: 900px) { .sk-grid { grid-template-columns: 1fr; } }
.sk-form-group { margin-bottom: 1.1rem; }
.sk-label { display: block; font-size: .8rem; font-weight: 700; color: var(--adm-text); margin-bottom: .4rem; }

/* Filter bar */
.sk-filter-row {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 1.25rem; flex-wrap: wrap; gap: 1rem;
}
.sk-search-wrap {
    display: flex; align-items: center; gap: .5rem; flex: 1; max-width: 400px;
}
.sk-badge {
    display: inline-flex; align-items: center; gap: .35rem; font-size: .68rem; font-weight: 800;
    padding: 3px 9px; border-radius: 99px;
}

/* Color palettes */
.sk-c-blue   { background: rgba(59,130,246,.15); color: #93c5fd; border: 1px solid rgba(59,130,246,.25); }
.sk-c-purple { background: rgba(139,92,246,.15); color: #c4b5fd; border: 1px solid rgba(139,92,246,.25); }
.sk-c-green  { background: rgba(34,197,94,.15);  color: #86efac; border: 1px solid rgba(34,197,94,.25); }
.sk-c-cyan   { background: rgba(6,182,212,.15);  color: #67e8f9; border: 1px solid rgba(6,182,212,.25); }
.sk-c-rose   { background: rgba(244,63,94,.15);  color: #fda4af; border: 1px solid rgba(244,63,94,.25); }
.sk-c-amber  { background: rgba(245,158,11,.15); color: #fcd34d; border: 1px solid rgba(245,158,11,.25); }
.sk-c-gray   { background: rgba(255,255,255,.08);color: var(--adm-text-muted); border: 1px solid rgba(255,255,255,.15); }
</style>

{{-- Breadcrumb --}}
<div class="adm-breadcrumb">
    <a href="{{ route('admin.dashboard') }}"><i class="fas fa-house" style="font-size:.65rem;"></i></a>
    <span class="sep">/</span>
    <span class="active">Skills</span>
</div>

<div style="margin-bottom:1.5rem;">
    <h1 style="font-size:1.4rem;font-weight:900;letter-spacing:-.04em;color:#f1f5f9;margin:0;">
        Skills Management
    </h1>
    <p style="font-size:.83rem;color:var(--adm-text-muted);margin:.3rem 0 0;">
        Add and manage standardized skills used in jobs and candidate profiles.
    </p>
</div>

<div class="sk-grid">

    {{-- LEFT: Add Form --}}
    <div class="adm-card" style="position: sticky; top: 80px;">
        <div class="adm-card-header">
            <div>
                <div class="adm-card-title"><i class="fas fa-plus text-blue-400 mr-2"></i> Add New Skill</div>
            </div>
        </div>
        <div class="adm-card-body">
            @if ($errors->any())
                <div style="background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.25); color: #fca5a5; padding: .8rem; border-radius: 9px; margin-bottom: 1rem; font-size: .8rem;">
                    <ul style="margin: 0; padding-left: 1.2rem;">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.skills.store') }}" method="POST">
                @csrf
                <div class="sk-form-group">
                    <label class="sk-label">Skill Name <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="adm-input" required placeholder="e.g., Laravel, React, Photoshop">
                </div>

                <div class="sk-form-group">
                    <label class="sk-label">Category</label>
                    <select name="category" class="adm-input adm-select">
                        <option value="">No Category</option>
                        <option value="Frontend" {{ old('category') == 'Frontend' ? 'selected' : '' }}>Frontend</option>
                        <option value="Backend" {{ old('category') == 'Backend' ? 'selected' : '' }}>Backend</option>
                        <option value="Design" {{ old('category') == 'Design' ? 'selected' : '' }}>Design</option>
                        <option value="Database" {{ old('category') == 'Database' ? 'selected' : '' }}>Database</option>
                        <option value="DevOps" {{ old('category') == 'DevOps' ? 'selected' : '' }}>DevOps</option>
                        <option value="Soft Skill" {{ old('category') == 'Soft Skill' ? 'selected' : '' }}>Soft Skill</option>
                        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="sk-form-group">
                    <label class="sk-label">Icon Class (FontAwesome)</label>
                    <input type="text" name="icon" value="{{ old('icon') }}" class="adm-input" placeholder="e.g., fa-brands fa-laravel">
                </div>

                <div class="sk-form-group" style="margin-bottom: 1.5rem;">
                    <label class="sk-label">Theme Color</label>
                    <select name="color" class="adm-input adm-select">
                        <option value="gray"   {{ old('color') == 'gray' ? 'selected' : '' }}>Neutral Gray</option>
                        <option value="blue"   {{ old('color') == 'blue' ? 'selected' : '' }}>Blue (e.g. React)</option>
                        <option value="purple" {{ old('color') == 'purple' ? 'selected' : '' }}>Purple</option>
                        <option value="green"  {{ old('color') == 'green' ? 'selected' : '' }}>Green (e.g. Vue, Node)</option>
                        <option value="cyan"   {{ old('color') == 'cyan' ? 'selected' : '' }}>Cyan</option>
                        <option value="rose"   {{ old('color') == 'rose' ? 'selected' : '' }}>Rose (e.g. Laravel)</option>
                        <option value="amber"  {{ old('color') == 'amber' ? 'selected' : '' }}>Amber (e.g. JS, AWS)</option>
                    </select>
                </div>

                <button type="submit" class="adm-btn adm-btn-primary" style="width: 100%; justify-content: center;">
                    <i class="fas fa-save"></i> Save Skill
                </button>
            </form>
        </div>
    </div>

    {{-- RIGHT: Table & Filter --}}
    <div>
        <div class="sk-filter-row">
            <form action="{{ route('admin.skills.index') }}" method="GET" class="sk-search-wrap">
                <input type="text" name="search" value="{{ $search }}" class="adm-input" style="flex:1;" placeholder="Search skills...">
                <button type="submit" class="adm-btn adm-btn-primary adm-btn-sm" style="padding: .5rem .8rem;">Search</button>
                @if($search)
                    <a href="{{ route('admin.skills.index') }}" class="adm-btn adm-btn-ghost adm-btn-sm" style="color:#f87171;"><i class="fas fa-xmark"></i></a>
                @endif
            </form>
            <div style="font-size:.8rem; color:var(--adm-text-light);">
                Total: <strong>{{ $skills->total() }}</strong> skills
            </div>
        </div>

        <div class="adm-card">
            <div class="adm-tbl-wrap" style="overflow-x:auto;">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;">ID</th>
                            <th>Skill</th>
                            <th>Category</th>
                            <th>Date Added</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($skills as $skill)
                            @php
                                $badgeClass = match($skill->color) {
                                    'blue'   => 'sk-c-blue',
                                    'purple' => 'sk-c-purple',
                                    'green'  => 'sk-c-green',
                                    'cyan'   => 'sk-c-cyan',
                                    'rose'   => 'sk-c-rose',
                                    'amber'  => 'sk-c-amber',
                                    default  => 'sk-c-gray',
                                };
                            @endphp
                            <tr>
                                <td><span style="color:var(--adm-text-light);font-size:.75rem;">#{{ $skill->id }}</span></td>
                                <td>
                                    <span class="sk-badge {{ $badgeClass }}">
                                        @if($skill->icon) <i class="{{ $skill->icon }} w-3 text-center"></i> @endif
                                        {{ $skill->name }}
                                    </span>
                                </td>
                                <td>
                                    @if($skill->category)
                                        <span style="font-size: .75rem; color: var(--adm-text-muted); background: rgba(255,255,255,.05); padding: 3px 8px; border-radius: 6px;">{{ $skill->category }}</span>
                                    @else
                                        <span style="font-size: .75rem; color: var(--adm-text-light); font-style: italic;">None</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-size:.8rem;color:var(--adm-text-muted);">{{ $skill->created_at->format('M d, Y') }}</div>
                                </td>
                                <td style="text-align: right;">
                                    <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('Are you sure you want to delete this skill?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="adm-btn adm-btn-danger adm-btn-icon adm-btn-sm" title="Delete">
                                            <i class="fas fa-trash" style="font-size: .7rem;"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="adm-empty">
                                        <div class="adm-empty-icon"><i class="fas fa-code"></i></div>
                                        <h3>No skills found</h3>
                                        @if($search)
                                            <p>No skills matched your search "{{ $search }}".</p>
                                        @else
                                            <p>Your skills database is empty. Add your first skill using the form.</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($skills->hasPages())
                <div style="padding: 1rem; border-top: 1px solid var(--adm-border);">
                    {{ $skills->appends(['search' => request('search')])->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
