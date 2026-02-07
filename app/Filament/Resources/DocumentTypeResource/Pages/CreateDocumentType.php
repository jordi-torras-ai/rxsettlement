<?php

namespace App\Filament\Resources\DocumentTypeResource\Pages;

use App\Filament\Pages\Concerns\HasInstructions;
use App\Filament\Resources\DocumentTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDocumentType extends CreateRecord
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
