<?php

namespace App\Filament\Resources\EmployerResource\Pages;

use App\Filament\Pages\Concerns\RedirectToIndex;
use App\Filament\Resources\EmployerResource;
use Filament\Resources\Pages\EditRecord;

class EditEmployer extends EditRecord
{
    protected static string $resource = EmployerResource::class;

    use RedirectToIndex;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['name'] = $data['legal_name'] ?? $data['name'] ?? $this->record->name;

        return $data;
    }
}
