<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PepmAdminFeeGroup extends Model
{
    protected $fillable = [
        'plan_design_year_id',
        'admin_fee_group',
        'aso',
        'hsa_hra_admin',
        'disease_management',
        'tele_health',
        'pharmacy_rebate_credit',
        'pharmacy_carveout_pbm_fee',
        'wellness_fee_credit',
        'misc_broker_fees',
    ];

    public function planDesignYear(): BelongsTo
    {
        return $this->belongsTo(PlanDesignYear::class);
    }
}
