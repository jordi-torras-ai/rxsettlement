<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Models\BudgetPremiumEquivalentFundingMonthlyRate;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Intake;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-clip';

    protected static ?int $navigationSort = 70;

    public static function canViewAny(): bool
    {
        return auth()->check();
    }

    public static function canCreate(): bool
    {
        return auth()->check();
    }

    public static function canView(Model $record): bool
    {
        return static::canAccessRecord($record);
    }

    public static function canEdit(Model $record): bool
    {
        return static::canAccessRecord($record);
    }

    public static function canDelete(Model $record): bool
    {
        return static::canAccessRecord($record);
    }

    public static function canDeleteAny(): bool
    {
        return auth()->check();
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if (!$user?->isAdmin()) {
            $query->whereHas('intake', function (Builder $intakeQuery) use ($user) {
                $intakeQuery->where('user_id', $user?->id);
            });
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        $user = auth()->user();

        return $form
            ->schema([
                Forms\Components\Select::make('document_type_id')
                    ->label('Document Type')
                    ->options(fn (): array => DocumentType::query()
                        ->orderBy('description')
                        ->pluck('description', 'id')
                        ->all())
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('year')
                    ->label('Year')
                    ->options([
                        1 => '1',
                        2 => '2',
                        3 => '3',
                        4 => '4',
                        5 => '5',
                        6 => '6',
                    ])
                    ->required(),
                Forms\Components\Select::make('intake_id')
                    ->label('Intake')
                    ->options(function () use ($user): array {
                        $query = Intake::query()->orderBy('name');
                        if (!$user?->isAdmin()) {
                            $query->where('user_id', $user?->id);
                        }

                        return $query->pluck('name', 'id')->all();
                    })
                    ->default(function () use ($user): ?int {
                        $query = Intake::query()->select('id');
                        if (!$user?->isAdmin()) {
                            $query->where('user_id', $user?->id);
                        }

                        $ids = $query->pluck('id')->all();

                        return count($ids) === 1 ? (int) $ids[0] : null;
                    })
                    ->live()
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('budget_premium_equivalent_funding_monthly_rate_id')
                    ->label('Budget Premium-Equivalent Funding Monthly Rate')
                    ->options(function (Forms\Get $get): array {
                        $intakeId = $get('intake_id');
                        if (blank($intakeId)) {
                            return [];
                        }

                        return BudgetPremiumEquivalentFundingMonthlyRate::query()
                            ->whereHas('planDesignYear', function (Builder $query) use ($intakeId) {
                                $query->where('intake_id', $intakeId);
                            })
                            ->with('planDesignYear')
                            ->orderBy('plan_name')
                            ->get()
                            ->mapWithKeys(function (BudgetPremiumEquivalentFundingMonthlyRate $rate): array {
                                $year = $rate->planDesignYear?->year;
                                $label = $rate->plan_name;
                                if ($year !== null) {
                                    $label .= ' (Year ' . $year . ')';
                                }

                                return [$rate->id => $label];
                            })
                            ->all();
                    })
                    ->disabled(fn (Forms\Get $get): bool => blank($get('intake_id')))
                    ->searchable()
                    ->nullable(),
                Forms\Components\FileUpload::make('file_path')
                    ->label('Document')
                    ->disk('r2')
                    ->directory('documents')
                    ->preserveFilenames()
                    ->downloadable()
                    ->openable()
                    ->required(fn (string $operation): bool => $operation === 'create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('intake_id')
            ->columns([
                Tables\Columns\TextColumn::make('intake.name')
                    ->label('Intake')
                    ->toggleable()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('documentType.description')
                    ->label('Document Type')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('year')
                    ->label('Year')
                    ->sortable(),
                Tables\Columns\TextColumn::make('budgetPremiumEquivalentFundingMonthlyRate.plan_name')
                    ->label('Budget Rate Plan')
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('file_path')
                    ->label('Document')
                    ->formatStateUsing(fn (?string $state): ?string => $state ? basename($state) : null)
                    ->url(fn (Document $record): ?string => static::fileUrl($record->file_path))
                    ->openUrlInNewTab(),
                Tables\Columns\IconColumn::make('has_attachment')
                    ->label('Attached')
                    ->state(fn (Document $record): bool => filled($record->file_path))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('intake_id')
                    ->label('Intake')
                    ->options(function (): array {
                        $user = auth()->user();
                        $query = Intake::query()->orderBy('name');
                        if (!$user?->isAdmin()) {
                            $query->where('user_id', $user?->id);
                        }

                        return $query->pluck('name', 'id')->all();
                    })
                    ->searchable(),
                Tables\Filters\SelectFilter::make('document_type_id')
                    ->label('Document Type')
                    ->options(fn (): array => DocumentType::query()
                        ->orderBy('description')
                        ->pluck('description', 'id')
                        ->all())
                    ->searchable(),
                Tables\Filters\SelectFilter::make('year')
                    ->label('Year')
                    ->options([
                        1 => '1',
                        2 => '2',
                        3 => '3',
                        4 => '4',
                        5 => '5',
                        6 => '6',
                    ]),
                Tables\Filters\SelectFilter::make('budget_premium_equivalent_funding_monthly_rate_id')
                    ->label('Budget Rate Plan')
                    ->options(function (): array {
                        $user = auth()->user();
                        $query = BudgetPremiumEquivalentFundingMonthlyRate::query()
                            ->with('planDesignYear')
                            ->orderBy('plan_name');

                        if (!$user?->isAdmin()) {
                            $query->whereHas('planDesignYear.intake', function (Builder $intakeQuery) use ($user) {
                                $intakeQuery->where('user_id', $user?->id);
                            });
                        }

                        return $query->get()
                            ->mapWithKeys(function (BudgetPremiumEquivalentFundingMonthlyRate $rate): array {
                                $year = $rate->planDesignYear?->year;
                                $label = $rate->plan_name;
                                if ($year !== null) {
                                    $label .= ' (Year ' . $year . ')';
                                }

                                return [$rate->id => $label];
                            })
                            ->all();
                    })
                    ->searchable(),
                Tables\Filters\SelectFilter::make('has_attachment')
                    ->label('Attached')
                    ->options([
                        'yes' => 'Yes',
                        'no' => 'No',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $value = $data['value'] ?? null;
                        if ($value === 'yes') {
                            return $query->whereNotNull('file_path');
                        }
                        if ($value === 'no') {
                            return $query->whereNull('file_path');
                        }

                        return $query;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton(),
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->iconButton(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'view' => Pages\ViewDocument::route('/{record}'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }

    private static function canAccessRecord(Model $record): bool
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }

        return (int) $record->intake?->user_id === (int) $user->id;
    }

    private static function fileUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        $disk = Storage::disk('r2');
        $publicUrl = config('filesystems.disks.r2.url');

        if (filled($publicUrl)) {
            return $disk->url($path);
        }

        return $disk->temporaryUrl($path, now()->addMinutes(10));
    }
}
