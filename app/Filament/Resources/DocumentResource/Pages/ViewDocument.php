<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Pages\Concerns\HasInstructions;
use App\Filament\Resources\DocumentResource;
use Filament\Resources\Pages\ViewRecord;

class ViewDocument extends ViewRecord
{
    protected static string $resource = DocumentResource::class;

    use HasInstructions;

    protected function getHeaderActions(): array
    {
        return array_merge(
            [$this->getInstructionsAction('documents')],
            parent::getHeaderActions(),
        );
    }
}
