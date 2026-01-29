<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Intake extends Model
{
    protected $fillable = [
        'user_id',
        'created_by',
        'updated_by',
        'name',
        'primary_name',
        'primary_title',
        'primary_email',
        'primary_phone',
        'escalation_name',
        'escalation_title',
        'escalation_email',
        'escalation_phone',
        'other_name',
        'other_title',
        'other_email',
        'other_phone',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function vendorCoverages()
    {
        return $this->hasMany(VendorCoverage::class);
    }

    public function planDesignYears()
    {
        return $this->hasMany(PlanDesignYear::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
