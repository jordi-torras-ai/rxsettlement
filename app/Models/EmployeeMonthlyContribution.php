<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeMonthlyContribution extends Model
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
    ];

    public function planDesignYear(): BelongsTo
    {
        return $this->belongsTo(PlanDesignYear::class);
    }
}
