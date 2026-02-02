<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Intake;
use App\Models\PlanDesignYear;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;

class ListDocuments extends ListRecords
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        $instructionsUrl = \App\Filament\Pages\Welcome::getUrl() . '#documents';

        return [
            Actions\Action::make('instructions')
                ->label('Instructions')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->iconPosition('after')
                ->url($instructionsUrl)
                ->view('filament.actions.instructions-action'),
            Actions\CreateAction::make(),
            Actions\Action::make('requiredDocuments')
                ->label('Generate Documents')
                ->modalHeading('Create Required Documents')
                ->modalSubmitActionLabel('Create')
                ->form([
                    Select::make('intake_id')
                        ->label('Intake')
                        ->options(function (): array {
                            $user = auth()->user();
                            $query = Intake::query()->orderBy('name');
                            if (!$user?->isAdmin()) {
                                $query->where('user_id', $user?->id);
                            }

                            return $query->pluck('name', 'id')->all();
                        })
                        ->default(function (): ?int {
                            $user = auth()->user();
                            $query = Intake::query()->select('id');
                            if (!$user?->isAdmin()) {
                                $query->where('user_id', $user?->id);
                            }

                            $ids = $query->pluck('id')->all();

                            return count($ids) === 1 ? (int) $ids[0] : null;
                        })
                        ->searchable()
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $user = auth()->user();
                    $intakeId = $data['intake_id'];

                    $intake = Intake::query()
                        ->when(!$user?->isAdmin(), fn ($query) => $query->where('user_id', $user?->id))
                        ->findOrFail($intakeId);

                    $documentTypes = DocumentType::query()->orderBy('description')->get();
                    $planDesignYears = PlanDesignYear::query()
                        ->where('intake_id', $intake->id)
                        ->with('budgetPremiumEquivalentFundingMonthlyRates')
                        ->get();

                    $createdCount = 0;
                    foreach ($documentTypes as $documentType) {
                        foreach ($planDesignYears as $planDesignYear) {
                            foreach ($planDesignYear->budgetPremiumEquivalentFundingMonthlyRates as $rate) {
                                $document = Document::query()->firstOrCreate([
                                    'document_type_id' => $documentType->id,
                                    'year' => $planDesignYear->year,
                                    'intake_id' => $intake->id,
                                    'budget_premium_equivalent_funding_monthly_rate_id' => $rate->id,
                                ]);

                                if ($document->wasRecentlyCreated) {
                                    $createdCount++;
                                }
                            }
                        }
                    }

                    if ($createdCount === 0) {
                        Notification::make()
                            ->title('No new documents created')
                            ->warning()
                            ->send();

                        return;
                    }

                    Notification::make()
                        ->title('Created ' . $createdCount . ' documents')
                        ->success()
                        ->send();
                }),
        ];
    }
}
