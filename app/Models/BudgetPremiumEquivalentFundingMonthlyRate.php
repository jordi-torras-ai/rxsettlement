<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetPremiumEquivalentFundingMonthlyRate extends Model
{
    protected $fillable = [
        'plan_design_year_id',
        'plan_name',
        'admin_fee_group',
        'employee',
        'emp_spouse',
        'emp_child',
        'emp_children',
        'family',
        'plan_term_date',
    ];

    protected $casts = [
        'plan_term_date' => 'date',
    ];

    public function planDesignYear(): BelongsTo
    {
        return $this->belongsTo(PlanDesignYear::class);
    }
}
