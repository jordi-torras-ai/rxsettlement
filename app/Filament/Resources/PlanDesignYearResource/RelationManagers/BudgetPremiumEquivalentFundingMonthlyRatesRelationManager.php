<?php

namespace App\Filament\Resources\PlanDesignYearResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class BudgetPremiumEquivalentFundingMonthlyRatesRelationManager extends RelationManager
{
    protected static string $relationship = 'budgetPremiumEquivalentFundingMonthlyRates';

    protected static ?string $title = 'Budget Premium-Equivalent Funding Monthly Rates';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('plan_name')
                    ->label('Plan Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('admin_fee_group')
                    ->label('Admin Fee Group')
                    ->maxLength(255),
                Forms\Components\TextInput::make('employee')
                    ->label('Employee')
                    ->prefix('$')
                    ->numeric(),
                Forms\Components\TextInput::make('emp_spouse')
                    ->label('Emp/Spouse')
                    ->prefix('$')
                    ->numeric(),
                Forms\Components\TextInput::make('emp_child')
                    ->label('Emp/Child')
                    ->prefix('$')
                    ->numeric(),
                Forms\Components\TextInput::make('emp_children')
                    ->label('Emp/Children')
                    ->prefix('$')
                    ->numeric(),
                Forms\Components\TextInput::make('family')
                    ->label('Family')
                    ->prefix('$')
                    ->numeric(),
                Forms\Components\DatePicker::make('plan_term_date')
                    ->label('Plan Term Date'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('plan_name')
                    ->label('Plan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('admin_fee_group')
                    ->label('Admin Fee Group')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('employee')
                    ->money('USD')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('emp_spouse')
                    ->label('Emp/Spouse')
                    ->money('USD')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('emp_child')
                    ->label('Emp/Child')
                    ->money('USD')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('emp_children')
                    ->label('Emp/Children')
                    ->money('USD')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('family')
                    ->money('USD')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('plan_term_date')
                    ->label('Plan Term')
                    ->date()
                    ->toggleable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->iconButton(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
            ]);
    }
}
