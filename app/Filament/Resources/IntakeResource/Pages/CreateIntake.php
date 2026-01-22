<?php

namespace App\Filament\Resources\IntakeResource\Pages;

use App\Filament\Pages\Concerns\RedirectToIndex;
use App\Filament\Resources\IntakeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateIntake extends CreateRecord
{
    protected static string $resource = IntakeResource::class;

    use RedirectToIndex;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        return $data;
    }
}
