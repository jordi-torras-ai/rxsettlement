<?php

namespace App\Filament\Resources\PlanDesignYearResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PepmAdminFeeGroupsRelationManager extends RelationManager
{
    protected static string $relationship = 'pepmAdminFeeGroups';

    protected static ?string $title = 'PEPM Admin Fee Group';

    protected function canCreate(): bool
    {
        return $this->canManage();
    }

    protected function canEdit($record): bool
    {
        return $this->canManage();
    }

    protected function canDelete($record): bool
    {
        return $this->canManage();
    }

    protected function canDeleteAny(): bool
    {
        return $this->canManage();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('admin_fee_group')
                    ->label('Admin Fee Group')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('aso')
                    ->label('ASO')
                    ->prefix('$')
                    ->numeric(),
                Forms\Components\TextInput::make('hsa_hra_admin')
                    ->label('HSA/HRA Admin')
                    ->prefix('$')
                    ->numeric(),
                Forms\Components\TextInput::make('disease_management')
                    ->label('Disease Management')
                    ->prefix('$')
                    ->numeric(),
                Forms\Components\TextInput::make('tele_health')
                    ->label('Tele-health')
                    ->prefix('$')
                    ->numeric(),
                Forms\Components\TextInput::make('pharmacy_rebate_credit')
                    ->label('Pharmacy Rebate (Credit)')
                    ->prefix('$')
                    ->numeric(),
                Forms\Components\TextInput::make('pharmacy_carveout_pbm_fee')
                    ->label('Pharmacy Carveout - PBM Fee')
                    ->prefix('$')
                    ->numeric(),
                Forms\Components\TextInput::make('wellness_fee_credit')
                    ->label('Wellness (Fee and/or Credit)')
                    ->prefix('$')
                    ->numeric(),
                Forms\Components\TextInput::make('misc_broker_fees')
                    ->label('Misc. (Broker Fees)')
                    ->prefix('$')
                    ->numeric(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('admin_fee_group')
                    ->label('Admin Fee Group')
                    ->searchable(),
                Tables\Columns\TextColumn::make('aso')
                    ->money('USD')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('hsa_hra_admin')
                    ->label('HSA/HRA Admin')
                    ->money('USD')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('disease_management')
                    ->label('Disease Management')
                    ->money('USD')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('tele_health')
                    ->label('Tele-health')
                    ->money('USD')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('pharmacy_rebate_credit')
                    ->label('Pharmacy Rebate (Credit)')
                    ->money('USD')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('pharmacy_carveout_pbm_fee')
                    ->label('Pharmacy Carveout - PBM Fee')
                    ->money('USD')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('wellness_fee_credit')
                    ->label('Wellness (Fee/Credit)')
                    ->money('USD')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('misc_broker_fees')
                    ->label('Misc. (Broker Fees)')
                    ->money('USD')
                    ->toggleable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('New')
                    ->icon('heroicon-m-plus'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
            ]);
    }

    private function canManage(): bool
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }

        return (int) $this->getOwnerRecord()->user_id === (int) $user->id;
    }
}
