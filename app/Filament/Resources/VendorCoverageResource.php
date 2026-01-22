<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VendorCoverageResource\Pages;
use App\Models\Employer;
use App\Models\Intake;
use App\Models\VendorCoverage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class VendorCoverageResource extends Resource
{
    protected static ?string $model = VendorCoverage::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?int $navigationSort = 40;

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
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if (!$user?->isAdmin()) {
            $query->where('user_id', $user?->id);
        }

        return $query;
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
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('vendor_name')
                    ->label('Vendor Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('vendor_year')
                    ->label('Vendor Year')
                    ->maxLength(50),
                Forms\Components\TextInput::make('vendor_contact_name')
                    ->label('Vendor Contact Name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('vendor_contact_email')
                    ->label('Vendor Contact Email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\Select::make('insurance_type')
                    ->label('Fully v. Self-Insured')
                    ->options([
                        'fully' => 'Fully Insured',
                        'self' => 'Self-Insured',
                    ]),
                Forms\Components\DatePicker::make('plan_year_start_date')
                    ->label('Plan Year Start Date'),
                Forms\Components\DatePicker::make('plan_year_end_date')
                    ->label('Plan Year End Date (if applicable)'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('vendor_name')
                    ->label('Vendor')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('intake.name')
                    ->label('Intake')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('vendor_year')
                    ->label('Year')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('vendor_contact_name')
                    ->label('Contact')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('vendor_contact_email')
                    ->label('Contact Email')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('insurance_type')
                    ->label('Insurance')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'fully' => 'Fully Insured',
                        'self' => 'Self-Insured',
                        default => $state ?? '',
                    })
                    ->toggleable(),
                Tables\Columns\TextColumn::make('plan_year_start_date')
                    ->label('Plan Start')
                    ->date()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('plan_year_end_date')
                    ->label('Plan End')
                    ->date()
                    ->toggleable(),
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

                        return $query->whereHas('intake.user', function ($userQuery) use ($data) {
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVendorCoverages::route('/'),
            'create' => Pages\CreateVendorCoverage::route('/create'),
            'view' => Pages\ViewVendorCoverage::route('/{record}'),
            'edit' => Pages\EditVendorCoverage::route('/{record}/edit'),
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
