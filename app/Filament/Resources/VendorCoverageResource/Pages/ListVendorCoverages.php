<?php

namespace App\Filament\Resources\VendorCoverageResource\Pages;

use App\Filament\Resources\VendorCoverageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVendorCoverages extends ListRecords
{
    protected static string $resource = VendorCoverageResource::class;

    protected function getHeaderActions(): array
    {
        $instructionsUrl = \App\Filament\Pages\Welcome::getUrl() . '#vendor-coverages';

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
