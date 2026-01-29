<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GlossaryResource\Pages;
use App\Models\Glossary;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GlossaryResource extends Resource
{
    protected static ?string $model = Glossary::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?int $navigationSort = 80;

    protected static ?string $modelLabel = 'Glossary';

    protected static ?string $pluralModelLabel = 'Glossary';

    public static function canViewAny(): bool
    {
        return auth()->check();
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canView(Model $record): bool
    {
        return auth()->check();
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('type')
                    ->label('Type')
                    ->disabled(),
                Forms\Components\TextInput::make('rates')
                    ->label('Rates')
                    ->disabled(),
                Forms\Components\Textarea::make('definition')
                    ->label('Definition')
                    ->rows(4)
                    ->disabled(),
                Forms\Components\Textarea::make('other_industry_terms_used')
                    ->label('Other Industry Terms Used')
                    ->rows(3)
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('order')
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->sortable(),
                Tables\Columns\TextColumn::make('rates')
                    ->label('Rates')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('definition')
                    ->label('Definition')
                    ->wrap()
                    ->limit(120)
                    ->searchable(),
                Tables\Columns\TextColumn::make('other_industry_terms_used')
                    ->label('Other Industry Terms Used')
                    ->wrap()
                    ->limit(80)
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Type')
                    ->options(fn (): array => Glossary::query()
                        ->whereNotNull('type')
                        ->orderBy('type')
                        ->pluck('type', 'type')
                        ->all())
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGlossaries::route('/'),
            'view' => Pages\ViewGlossary::route('/{record}'),
        ];
    }
}
