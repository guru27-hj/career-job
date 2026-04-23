<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class JobApplication extends Model
{
    protected $fillable = [
        'job_id',
        'user_id',
        'resume',
        'cover_letter',
        'status',
    ];

    // ── Relationships ────────────────────────────────────────────

    /** The related job (or internship — both live in the jobs table). */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    /** Alias for semantic clarity when dealing with internship applications. */
    public function internship()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    /** The applicant. */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Skill Match Helper ───────────────────────────────────────

    /**
     * Compute the skill match percentage between a job's required skills
     * and a candidate's profile skills.
     *
     * @param  array  $jobSkills      Required skills from the job
     * @param  array  $profileSkills  Skills the candidate listed
     * @return int    0–100 percentage
     */
    public static function computeMatchPercentage(array $jobSkills, array $profileSkills): int
    {
        if (empty($jobSkills)) return 100; // No requirements = 100% match

        $normalize = fn(array $skills) => array_map(
            fn($s) => strtolower(trim($s)),
            array_filter($skills)
        );

        $required  = $normalize($jobSkills);
        $candidate = $normalize($profileSkills);

        $matched = count(array_intersect($required, $candidate));

        return (int) round(($matched / count($required)) * 100);
    }

    /**
     * Return matched and missing skills as arrays.
     *
     * @return array{matched: array, missing: array}
     */
    public static function skillBreakdown(array $jobSkills, array $profileSkills): array
    {
        $normalize = fn(array $skills) => array_map(
            fn($s) => strtolower(trim($s)),
            array_filter($skills)
        );

        $required  = $normalize($jobSkills);
        $candidate = $normalize($profileSkills);

        return [
            'matched' => array_values(array_intersect($required, $candidate)),
            'missing' => array_values(array_diff($required, $candidate)),
        ];
    }

    // ── Helpers ─────────────────────────────────────────────────

    /** True when this application is for an internship. */
    public function getIsInternshipAttribute(): bool
    {
        return optional($this->job)->job_type === 'internship';
    }

    /** Human-readable type label. */
    public function getTypeAttribute(): string
    {
        return $this->is_internship ? 'Internship' : 'Job';
    }

    // ── Scopes ──────────────────────────────────────────────────

    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeForJobs(Builder $query): Builder
    {
        return $query->whereHas('job', fn ($q) => $q->where('job_type', '!=', 'internship'));
    }

    public function scopeForInternships(Builder $query): Builder
    {
        return $query->whereHas('job', fn ($q) => $q->where('job_type', 'internship'));
    }
}
