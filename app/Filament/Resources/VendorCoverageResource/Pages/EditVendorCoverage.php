<?php

namespace App\Filament\Resources\VendorCoverageResource\Pages;

use App\Filament\Pages\Concerns\RedirectToIndex;
use App\Filament\Resources\VendorCoverageResource;
use App\Models\Intake;
use Filament\Resources\Pages\EditRecord;

class EditVendorCoverage extends EditRecord
{
    protected static string $resource = VendorCoverageResource::class;

    use RedirectToIndex;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $intake = Intake::query()->find($data['intake_id']);
        $data['user_id'] = $intake?->user_id ?? $this->record->user_id;

        return $data;
    }
}
