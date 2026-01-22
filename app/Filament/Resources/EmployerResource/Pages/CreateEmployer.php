<?php

namespace App\Filament\Resources\EmployerResource\Pages;

use App\Filament\Pages\Concerns\RedirectToIndex;
use App\Filament\Resources\EmployerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployer extends CreateRecord
{
    protected static string $resource = EmployerResource::class;

    use RedirectToIndex;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['name'] = $data['legal_name'] ?? $data['name'] ?? null;

        return $data;
    }
}
