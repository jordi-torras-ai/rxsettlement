<?php

namespace App\Filament\Resources\PlanDesignYearResource\Pages;

use App\Filament\Resources\PlanDesignYearResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlanDesignYears extends ListRecords
{
    protected static string $resource = PlanDesignYearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
