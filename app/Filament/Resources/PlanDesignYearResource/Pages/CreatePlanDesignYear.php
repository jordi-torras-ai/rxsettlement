<?php

namespace App\Filament\Resources\PlanDesignYearResource\Pages;

use App\Filament\Pages\Concerns\RedirectToIndex;
use App\Filament\Resources\PlanDesignYearResource;
use App\Models\Intake;
use App\Models\PlanDesignYear;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreatePlanDesignYear extends CreateRecord
{
    protected static string $resource = PlanDesignYearResource::class;

    use RedirectToIndex;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $intake = Intake::query()->find($data['intake_id']);
        $data['user_id'] = $intake?->user_id;

        $existingCount = PlanDesignYear::query()
            ->where('intake_id', $data['intake_id'])
            ->count();

        if ($existingCount >= 6) {
            throw ValidationException::withMessages([
                'year' => 'An intake can only have up to 6 plan design years.',
            ]);
        }

        return $data;
    }
}
