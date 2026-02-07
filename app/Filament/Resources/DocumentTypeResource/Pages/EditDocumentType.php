<?php

namespace App\Filament\Resources\DocumentTypeResource\Pages;

use App\Filament\Pages\Concerns\HasInstructions;
use App\Filament\Resources\DocumentTypeResource;
use Filament\Resources\Pages\EditRecord;

class EditDocumentType extends EditRecord
{
    protected static string $resource = DocumentTypeResource::class;

    use HasInstructions;

    protected function getHeaderActions(): array
    {
        return array_merge(
            [$this->getInstructionsAction('document-types')],
            parent::getHeaderActions(),
        );
    }
}
