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
        $instructionsUrl = \App\Filament\Pages\Welcome::getUrl() . '#plan-design-year';

        return [
            Actions\Action::make('instructions')
                ->label('Instructions')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->iconPosition('after')
                ->url($instructionsUrl)
                ->view('filament.actions.instructions-action'),
            Actions\CreateAction::make(),
        ];
    }
}
