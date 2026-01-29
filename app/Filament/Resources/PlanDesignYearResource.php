<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanDesignYearResource\Pages;
use App\Filament\Resources\PlanDesignYearResource\RelationManagers\BudgetPremiumEquivalentFundingMonthlyRatesRelationManager;
use App\Filament\Resources\PlanDesignYearResource\RelationManagers\EmployeeMonthlyContributionsRelationManager;
use App\Filament\Resources\PlanDesignYearResource\RelationManagers\PepmAdminFeeGroupsRelationManager;
use App\Models\Employer;
use App\Models\Intake;
use App\Models\PlanDesignYear;
use App\Models\VendorCoverage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Unique;

class PlanDesignYearResource extends Resource
{
    protected static ?string $model = PlanDesignYear::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?int $navigationSort = 50;

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
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->withCount([
                'budgetPremiumEquivalentFundingMonthlyRates',
                'employeeMonthlyContributions',
                'pepmAdminFeeGroups',
            ]);
        $user = auth()->user();

        if (!$user?->isAdmin()) {
            $query->where('user_id', $user?->id);
        }

        return $query;
    }

    public static function getNavigationLabel(): string
    {
        return auth()->user()?->isAdmin() ? 'Plan Design Years' : 'Plan Design Year';
    }

    public static function form(Form $form): Form
    {
        $user = auth()->user();

        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(fn () => auth()->id()),
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
                Forms\Components\Select::make('year')
                    ->label('Plan Design Year')
                    ->options([
                        1 => '1',
                        2 => '2',
                        3 => '3',
                        4 => '4',
                        5 => '5',
                        6 => '6',
                    ])
                    ->required()
                    ->unique(
                        modifyRuleUsing: function (Unique $rule, Forms\Get $get): Unique {
                            return $rule->where('intake_id', $get('intake_id'));
                        },
                        ignoreRecord: true
                    ),
                Forms\Components\Select::make('employer_plan_sponsor_name')
                    ->label('Employer (Plan Sponsor Name)')
                    ->options(fn (): array => Employer::query()
                        ->orderBy('legal_name')
                        ->pluck('legal_name', 'legal_name')
                        ->all())
                    ->default(function () use ($user): ?string {
                        return $user?->employer?->legal_name;
                    })
                    ->disabled(fn (): bool => !($user?->isAdmin() ?? false))
                    ->dehydrated()
                    ->searchable()
                    ->required(),
                Forms\Components\DatePicker::make('plan_effective_date')
                    ->label('Plan Effective Date'),
                Forms\Components\Select::make('current_vendor_name')
                    ->label('Current Vendor Name')
                    ->options(function (Forms\Get $get): array {
                        $intakeId = $get('intake_id');
                        if (blank($intakeId)) {
                            return [];
                        }

                        return VendorCoverage::query()
                            ->where('intake_id', $intakeId)
                            ->orderBy('vendor_name')
                            ->pluck('vendor_name', 'vendor_name')
                            ->all();
                    })
                    ->disabled(fn (Forms\Get $get): bool => blank($get('intake_id')))
                    ->searchable(),
                Forms\Components\Toggle::make('is_new_vendor')
                    ->label("Is this a 'new' vendor?")
                    ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('intake.name')
                    ->label('Intake')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('year')
                    ->label('Year')
                    ->sortable(),
                Tables\Columns\TextColumn::make('budget_premium_equivalent_funding_monthly_rates_count')
                    ->label('Plans')
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee_monthly_contributions_count')
                    ->label('Contributions')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pepm_admin_fee_groups_count')
                    ->label('Groups')
                    ->sortable(),
                Tables\Columns\TextColumn::make('employer_plan_sponsor_name')
                    ->label('Employer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('current_vendor_name')
                    ->label('Current Vendor')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('plan_effective_date')
                    ->label('Effective Date')
                    ->date()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_new_vendor')
                    ->label('New Vendor')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('employer_id')
                    ->label('Employer')
                    ->visible(fn (): bool => auth()->user()?->isAdmin() ?? false)
                    ->options(function (): array {
                        return Employer::query()
                            ->orderBy('legal_name')
                            ->pluck('legal_name', 'id')
                            ->all();
                    })
                    ->searchable()
                    ->query(function ($query, array $data) {
                        if (blank($data['value'] ?? null)) {
                            return $query;
                        }

                        return $query->whereHas('user', function ($userQuery) use ($data) {
                            $userQuery->where('employer_id', $data['value']);
                        });
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton(),
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->visible(fn (): bool => auth()->user()?->isAdmin() ?? false),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->iconButton()
                    ->visible(fn (): bool => auth()->user()?->isAdmin() ?? false),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            BudgetPremiumEquivalentFundingMonthlyRatesRelationManager::class,
            EmployeeMonthlyContributionsRelationManager::class,
            PepmAdminFeeGroupsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlanDesignYears::route('/'),
            'create' => Pages\CreatePlanDesignYear::route('/create'),
            'view' => Pages\ViewPlanDesignYear::route('/{record}'),
            'edit' => Pages\EditPlanDesignYear::route('/{record}/edit'),
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

        return (int) $record->user_id === (int) $user->id;
    }
}
