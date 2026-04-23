<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Company extends Model
{
    protected $fillable = [
        'user_id', 'name', 'slug', 'logo', 'banner', 'description', 'industry',
        'location', 'headquarters', 'employees', 'founded_year',
        'website', 'email', 'phone', 'social_links', 'status'
    ];

    protected $casts = [
        'social_links' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($company) {
            if (empty($company->slug)) {
                $company->slug = Str::slug($company->name);
            }
        });

        static::updating(function ($company) {
            if ($company->isDirty('name')) {
                $company->slug = Str::slug($company->name);
            }
        });
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    /**
     * Get the user that owns this company record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Users who follow this company.
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'company_follows')
                    ->withTimestamps()
                    ->withPivot('followed_at');
    }

    /**
     * Check if a given user follows this company.
     */
    public function isFollowedBy(int $userId): bool
    {
        return $this->followers()->where('user_id', $userId)->exists();
    }

    // Scope for approved companies
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
