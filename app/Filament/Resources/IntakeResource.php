<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IntakeResource\Pages;
use App\Models\Employer;
use App\Models\Intake;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class IntakeResource extends Resource
{
    protected static ?string $model = Intake::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

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
            $query->where('user_id', $user?->id);
        }

        return $query;
    }

    public static function getNavigationLabel(): string
    {
        return auth()->user()?->isAdmin() ? 'Intakes' : 'Intake';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(fn () => auth()->id()),
                Forms\Components\TextInput::make('name')
                    ->label('Intake Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Fieldset::make('Primary Day-to-Day for Intake')
                    ->schema([
                        Forms\Components\TextInput::make('primary_name')
                            ->label('Name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('primary_title')
                            ->label('Title')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('primary_email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('primary_phone')
                            ->label('Phone #')
                            ->tel()
                            ->maxLength(50),
                    ]),
                Forms\Components\Fieldset::make('Contact for Escalations')
                    ->schema([
                        Forms\Components\TextInput::make('escalation_name')
                            ->label('Name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('escalation_title')
                            ->label('Title')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('escalation_email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('escalation_phone')
                            ->label('Phone #')
                            ->tel()
                            ->maxLength(50),
                    ]),
                Forms\Components\Fieldset::make('Other')
                    ->schema([
                        Forms\Components\TextInput::make('other_name')
                            ->label('Name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('other_title')
                            ->label('Title')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('other_email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('other_phone')
                            ->label('Phone #')
                            ->tel()
                            ->maxLength(50),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Intake')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('primary_name')
                    ->label('Primary Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('primary_email')
                    ->label('Primary Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('escalation_name')
                    ->label('Escalation Name')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('escalation_email')
                    ->label('Escalation Email')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('other_name')
                    ->label('Other Name')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('other_email')
                    ->label('Other Email')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('createdBy.email')
                    ->label('Created By')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updatedBy.email')
                    ->label('Updated By')
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
                    ->modalHeading('Delete intake?')
                    ->modalDescription('This will also delete related records: vendor coverages, plan design years, and all plan design detail rows (budget premium-equivalent funding monthly rates, employee monthly contributions, PEPM admin fee groups). This action cannot be undone.')
                    ->visible(fn (Model $record): bool => static::canDelete($record)),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->iconButton()
                    ->modalHeading('Delete selected intakes?')
                    ->modalDescription('This will also delete related records: vendor coverages, plan design years, and all plan design detail rows (budget premium-equivalent funding monthly rates, employee monthly contributions, PEPM admin fee groups). This action cannot be undone.')
                    ->visible(fn (): bool => auth()->check()),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIntakes::route('/'),
            'create' => Pages\CreateIntake::route('/create'),
            'view' => Pages\ViewIntake::route('/{record}'),
            'edit' => Pages\EditIntake::route('/{record}/edit'),
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
