<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Pages\Concerns\RedirectToIndex;
use App\Filament\Resources\DocumentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;

    use RedirectToIndex;
}
