<?php

namespace App\Filament\Resources\IntakeResource\Pages;

use App\Filament\Pages\Concerns\HasInstructions;
use App\Filament\Resources\IntakeResource;
use Filament\Resources\Pages\ViewRecord;

class ViewIntake extends ViewRecord
{
    protected static string $resource = IntakeResource::class;

    use HasInstructions;

    protected function getHeaderActions(): array
    {
        return array_merge(
            [$this->getInstructionsAction('intake')],
            parent::getHeaderActions(),
        );
    }
}
