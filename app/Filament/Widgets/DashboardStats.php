<?php

namespace App\Filament\Widgets;

use App\Models\Document;
use App\Models\EmployeeMonthlyContribution;
use App\Models\Employer;
use App\Models\Intake;
use App\Models\PepmAdminFeeGroup;
use App\Models\PlanDesignYear;
use App\Models\User;
use App\Models\BudgetPremiumEquivalentFundingMonthlyRate;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Users', User::query()->count()),
            Stat::make('Employers', Employer::query()->count()),
            Stat::make('Intakes', Intake::query()->count()),
            Stat::make('Plan Design Years', PlanDesignYear::query()->count()),
            Stat::make('Budget Premium-Equivalent Funding Monthly Rates', BudgetPremiumEquivalentFundingMonthlyRate::query()->count()),
            Stat::make('Employee Monthly Contributions', EmployeeMonthlyContribution::query()->count()),
            Stat::make('PEPM Admin Fee Groups', PepmAdminFeeGroup::query()->count()),
            Stat::make('Documents', Document::query()->count()),
        ];
    }
}
