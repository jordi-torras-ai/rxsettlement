<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorCoverage extends Model
{
    protected $fillable = [
        'user_id',
        'intake_id',
        'vendor_name',
        'vendor_year',
        'vendor_contact_name',
        'vendor_contact_email',
        'insurance_type',
        'plan_year_start_date',
        'plan_year_end_date',
    ];

    protected $casts = [
        'plan_year_start_date' => 'date',
        'plan_year_end_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function intake(): BelongsTo
    {
        return $this->belongsTo(Intake::class);
    }
}
