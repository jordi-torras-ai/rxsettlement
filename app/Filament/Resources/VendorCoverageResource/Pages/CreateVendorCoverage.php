<?php

namespace App\Filament\Resources\VendorCoverageResource\Pages;

use App\Filament\Pages\Concerns\RedirectToIndex;
use App\Filament\Resources\VendorCoverageResource;
use App\Models\Intake;
use Filament\Resources\Pages\CreateRecord;

class CreateVendorCoverage extends CreateRecord
{
    protected static string $resource = VendorCoverageResource::class;

    use RedirectToIndex;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $intake = Intake::query()->find($data['intake_id']);
        $data['user_id'] = $intake?->user_id;

        return $data;
    }
}
