<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id', 'competition_id', 'type', 'status', 'applicant_name', 'personal_number',
        'address', 'phone', 'email', 'project_name', 'funding_amount', 'program',
        'project_start_date', 'project_end_date', 'project_description', 'evaluation_criteria',
        'relevant_experience', 'project_stages', 'total_budget', 'requested_amount',
        'self_funding', 'expenses', 'agreements', 'documents', 'admin_notes', 'submitted_at',
        'form_data'
    ];

    protected $casts = [
        'project_start_date' => 'date',
        'project_end_date' => 'date',
        'project_stages' => 'array',
        'expenses' => 'array',
        'agreements' => 'array',
        'documents' => 'array',
        'form_data' => 'array',
        'submitted_at' => 'datetime',
        'funding_amount' => 'decimal:2',
        'total_budget' => 'decimal:2',
        'requested_amount' => 'decimal:2',
        'self_funding' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
    }
}
