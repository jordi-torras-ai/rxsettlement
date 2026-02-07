<?php

namespace App\Filament\Resources\PlanDesignYearResource\Pages;

use App\Filament\Pages\Concerns\HasInstructions;
use App\Filament\Resources\PlanDesignYearResource;
use Filament\Resources\Pages\ViewRecord;

class ViewPlanDesignYear extends ViewRecord
{
    protected static string $resource = PlanDesignYearResource::class;

    use HasInstructions;

    protected function getHeaderActions(): array
    {
        return array_merge(
            [$this->getInstructionsAction('plan-design-year')],
            parent::getHeaderActions(),
        );
    }
}
