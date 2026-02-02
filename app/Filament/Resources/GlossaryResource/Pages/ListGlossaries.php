<?php

namespace App\Filament\Resources\GlossaryResource\Pages;

use App\Filament\Resources\GlossaryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGlossaries extends ListRecords
{
    protected static string $resource = GlossaryResource::class;

    protected function getHeaderActions(): array
    {
        $instructionsUrl = \App\Filament\Pages\Welcome::getUrl() . '#glossary';

        return [
            Actions\Action::make('instructions')
                ->label('Instructions')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->iconPosition('after')
                ->url($instructionsUrl)
                ->view('filament.actions.instructions-action'),
        ];
    }
}
