<?php

namespace App\Filament\Resources\EmployerResource\Pages;

use App\Filament\Pages\Concerns\HasInstructions;
use App\Filament\Pages\Concerns\RedirectToIndex;
use App\Filament\Resources\EmployerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployer extends CreateRecord
{
    protected static string $resource = EmployerResource::class;

    use RedirectToIndex;
    use HasInstructions;

    protected function getHeaderActions(): array
    {
        return array_merge(
            [$this->getInstructionsAction('employers')],
            parent::getHeaderActions(),
        );
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['name'] = $data['legal_name'] ?? $data['name'] ?? null;

        return $data;
    }
}
