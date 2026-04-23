<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'location', 'remote', 
        'min_salary', 'max_salary', 'job_type', 'skills', 
        'duration', 'experience_level', 'certificate_included',
        'posted_at', 'featured', 'company_id', 'category_id', 'status'
    ];

    protected $casts = [
        'skills' => 'array',
        'remote' => 'boolean',
        'featured' => 'boolean',
        'posted_at' => 'date',
        'certificate_included' => 'boolean',
        'status' => 'string'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * All applications for this job, with applicant profile pre-loaded.
     */
    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
