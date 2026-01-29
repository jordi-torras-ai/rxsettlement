<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Pages\Concerns\RedirectToIndex;
use App\Filament\Resources\DocumentResource;
use Filament\Resources\Pages\EditRecord;

class EditDocument extends EditRecord
{
    protected static string $resource = DocumentResource::class;

    use RedirectToIndex;
}
