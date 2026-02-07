<?php

namespace App\Filament\Resources\PlanDesignYearResource\Pages;

use App\Filament\Pages\Concerns\HasInstructions;
use App\Filament\Pages\Concerns\RedirectToIndex;
use App\Filament\Resources\PlanDesignYearResource;
use Filament\Resources\Pages\EditRecord;

class EditPlanDesignYear extends EditRecord
{
    protected static string $resource = PlanDesignYearResource::class;

    use RedirectToIndex;
    use HasInstructions;

    protected function getHeaderActions(): array
    {
        return array_merge(
            [$this->getInstructionsAction('plan-design-year')],
            parent::getHeaderActions(),
        );
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id'] = $this->record->user_id;

        return $data;
    }
}
