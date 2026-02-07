<?php

namespace App\Filament\Resources\EmployerResource\Pages;

use App\Filament\Pages\Concerns\HasInstructions;
use App\Filament\Resources\EmployerResource;
use Filament\Resources\Pages\ViewRecord;

class ViewEmployer extends ViewRecord
{
    protected static string $resource = EmployerResource::class;

    use HasInstructions;

    protected function getHeaderActions(): array
    {
        return array_merge(
            [$this->getInstructionsAction('employers')],
            parent::getHeaderActions(),
        );
    }
}
