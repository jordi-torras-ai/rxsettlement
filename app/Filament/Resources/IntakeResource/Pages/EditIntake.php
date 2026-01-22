<?php

namespace App\Filament\Resources\IntakeResource\Pages;

use App\Filament\Pages\Concerns\RedirectToIndex;
use App\Filament\Resources\IntakeResource;
use Filament\Resources\Pages\EditRecord;

class EditIntake extends EditRecord
{
    protected static string $resource = IntakeResource::class;

    use RedirectToIndex;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id'] = $this->record->user_id;
        $data['updated_by'] = auth()->id();

        return $data;
    }
}
