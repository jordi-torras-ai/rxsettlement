<?php

namespace App\Filament\Resources\GlossaryResource\Pages;

use App\Filament\Pages\Concerns\HasInstructions;
use App\Filament\Resources\GlossaryResource;
use Filament\Resources\Pages\ViewRecord;

class ViewGlossary extends ViewRecord
{
    protected static string $resource = GlossaryResource::class;

    use HasInstructions;

    protected function getHeaderActions(): array
    {
        return array_merge(
            [$this->getInstructionsAction('glossary')],
            parent::getHeaderActions(),
        );
    }
}
