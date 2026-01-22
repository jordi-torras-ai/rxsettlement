<?php

namespace App\Filament\Resources\VendorCoverageResource\Pages;

use App\Filament\Resources\VendorCoverageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVendorCoverages extends ListRecords
{
    protected static string $resource = VendorCoverageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
