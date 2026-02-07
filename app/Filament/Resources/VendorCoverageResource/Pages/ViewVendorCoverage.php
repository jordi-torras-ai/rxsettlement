<?php

namespace App\Filament\Resources\VendorCoverageResource\Pages;

use App\Filament\Pages\Concerns\HasInstructions;
use App\Filament\Resources\VendorCoverageResource;
use Filament\Resources\Pages\ViewRecord;

class ViewVendorCoverage extends ViewRecord
{
    protected static string $resource = VendorCoverageResource::class;

    use HasInstructions;

    protected function getHeaderActions(): array
    {
        return array_merge(
            [$this->getInstructionsAction('vendor-coverages')],
            parent::getHeaderActions(),
        );
    }
}
