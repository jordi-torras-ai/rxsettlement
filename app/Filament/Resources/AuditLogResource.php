<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditLogResource\Pages;
use App\Models\AuditLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AuditLogResource extends Resource
{
    protected static ?string $model = AuditLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Audit Trail';

    protected static ?string $navigationGroup = 'Admin';

    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('User')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('auditable_type')
                    ->label('Model')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('auditable_id')
                    ->label('Model ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('url')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP')
                    ->toggleable()
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton(),
            ])
            ->bulkActions([]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('created_at')
                    ->label('Time')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\TextInput::make('event')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\TextInput::make('user.email')
                    ->label('User')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\TextInput::make('auditable_type')
                    ->label('Model')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\TextInput::make('auditable_id')
                    ->label('Model ID')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\TextInput::make('ip_address')
                    ->label('IP')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\Textarea::make('url')
                    ->label('URL')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\Textarea::make('user_agent')
                    ->label('User Agent')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\KeyValue::make('old_values')
                    ->label('Old Values')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\KeyValue::make('new_values')
                    ->label('New Values')
                    ->disabled()
                    ->dehydrated(false),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuditLogs::route('/'),
            'view' => Pages\ViewAuditLog::route('/{record}'),
        ];
    }
}
