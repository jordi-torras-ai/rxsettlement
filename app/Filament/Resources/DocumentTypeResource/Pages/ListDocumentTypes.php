<?php

namespace App\Filament\Resources\DocumentTypeResource\Pages;

use App\Filament\Resources\DocumentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDocumentTypes extends ListRecords
{
    protected static string $resource = DocumentTypeResource::class;

    protected function getHeaderActions(): array
    {
        $instructionsUrl = \App\Filament\Pages\Welcome::getUrl() . '#document-types';

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
