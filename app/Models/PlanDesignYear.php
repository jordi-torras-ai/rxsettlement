<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlanDesignYear extends Model
{
    protected $fillable = [
        'user_id',
        'intake_id',
        'year',
        'employer_plan_sponsor_name',
        'plan_effective_date',
        'current_vendor_name',
        'is_new_vendor',
    ];

    protected $casts = [
        'plan_effective_date' => 'date',
        'is_new_vendor' => 'bool',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function intake(): BelongsTo
    {
        return $this->belongsTo(Intake::class);
    }

    public function budgetPremiumEquivalentFundingMonthlyRates(): HasMany
    {
        return $this->hasMany(BudgetPremiumEquivalentFundingMonthlyRate::class);
    }

    public function employeeMonthlyContributions(): HasMany
    {
        return $this->hasMany(EmployeeMonthlyContribution::class);
    }

    public function pepmAdminFeeGroups(): HasMany
    {
        return $this->hasMany(PepmAdminFeeGroup::class);
    }
}
