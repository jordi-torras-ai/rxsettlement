<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployerResource\Pages;
use App\Models\Employer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EmployerResource extends Resource
{
    protected static ?string $model = Employer::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    public static function canViewAny(): bool
    {
        return auth()->check();
    }

    public static function getNavigationLabel(): string
    {
        return auth()->user()?->isAdmin() ? 'Employers' : 'Employer';
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
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
            $query->whereKey($user?->employer_id);
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        $isAdmin = auth()->user()?->isAdmin() ?? false;

        return $form
            ->schema([
                Forms\Components\TextInput::make('legal_name')
                    ->label('Employer (Plan Sponsor) Legal Name')
                    ->required()
                    ->maxLength(255)
                    ->disabled(!$isAdmin),
                Forms\Components\TextInput::make('dba')
                    ->label('DBA (if applicable)')
                    ->maxLength(255),
                Forms\Components\TextInput::make('address_line_1')
                    ->label('Address Line 1')
                    ->maxLength(255),
                Forms\Components\TextInput::make('address_line_2')
                    ->label('Address Line 2')
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->maxLength(255),
                Forms\Components\TextInput::make('state')
                    ->maxLength(255),
                Forms\Components\TextInput::make('zip_code')
                    ->label('Zip code')
                    ->maxLength(20),
                Forms\Components\Select::make('headquartered_state')
                    ->label('State of Headquartered Office')
                    ->options(static::usStates())
                    ->searchable(),
                Forms\Components\Select::make('operating_states')
                    ->label("If there are multiple locations within the U.S. 'Click' all States that apply.")
                    ->options(static::usStates())
                    ->multiple()
                    ->searchable(),
                Forms\Components\Fieldset::make('Authorized Employer Contact')
                    ->schema([
                        Forms\Components\TextInput::make('authorized_contact_name')
                            ->label('Employer Primary Contact Name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('authorized_contact_email')
                            ->label('Employer Primary Email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('authorized_contact_phone')
                            ->label('Employer Primary Phone')
                            ->tel()
                            ->maxLength(50),
                    ]),
                Forms\Components\Fieldset::make('Billing Contact')
                    ->schema([
                        Forms\Components\TextInput::make('billing_contact_name')
                            ->label('Employer Primary Contact Name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('billing_contact_email')
                            ->label('Employer Primary Email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('billing_contact_phone')
                            ->label('Employer Primary Phone')
                            ->tel()
                            ->maxLength(50),
                    ]),
                Forms\Components\Fieldset::make('Other Company Information')
                    ->schema([
                        Forms\Components\TextInput::make('fein')
                            ->label('FEIN #')
                            ->maxLength(20),
                        Forms\Components\Select::make('naics_sector')
                            ->label('NAICS Sector')
                            ->options(static::naicsSectors())
                            ->searchable(),
                        Forms\Components\Textarea::make('other_comments')
                            ->label('Other Comments')
                            ->rows(3)
                            ->maxLength(2000),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('legal_name')
                    ->label('Legal Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dba')
                    ->label('DBA')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('address_line_1')
                    ->label('Address 1')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('address_line_2')
                    ->label('Address 2')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('city')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('state')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('zip_code')
                    ->label('Zip')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('headquartered_state')
                    ->label('HQ State')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('operating_states')
                    ->label('Operating States')
                    ->formatStateUsing(fn (?array $state): string => $state ? implode(', ', $state) : '')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('authorized_contact_name')
                    ->label('Authorized Contact')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('authorized_contact_email')
                    ->label('Authorized Email')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('authorized_contact_phone')
                    ->label('Authorized Phone')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('billing_contact_name')
                    ->label('Billing Contact')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('billing_contact_email')
                    ->label('Billing Email')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('billing_contact_phone')
                    ->label('Billing Phone')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('fein')
                    ->label('FEIN')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('naics_sector')
                    ->label('NAICS')
                    ->formatStateUsing(fn (?string $state): string => $state ? (static::naicsSectors()[$state] ?? $state) : '')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListEmployers::route('/'),
            'create' => Pages\CreateEmployer::route('/create'),
            'view' => Pages\ViewEmployer::route('/{record}'),
            'edit' => Pages\EditEmployer::route('/{record}/edit'),
        ];
    }

    private static function usStates(): array
    {
        return [
            'AL' => 'Alabama',
            'AK' => 'Alaska',
            'AZ' => 'Arizona',
            'AR' => 'Arkansas',
            'CA' => 'California',
            'CO' => 'Colorado',
            'CT' => 'Connecticut',
            'DE' => 'Delaware',
            'DC' => 'District of Columbia',
            'FL' => 'Florida',
            'GA' => 'Georgia',
            'HI' => 'Hawaii',
            'ID' => 'Idaho',
            'IL' => 'Illinois',
            'IN' => 'Indiana',
            'IA' => 'Iowa',
            'KS' => 'Kansas',
            'KY' => 'Kentucky',
            'LA' => 'Louisiana',
            'ME' => 'Maine',
            'MD' => 'Maryland',
            'MA' => 'Massachusetts',
            'MI' => 'Michigan',
            'MN' => 'Minnesota',
            'MS' => 'Mississippi',
            'MO' => 'Missouri',
            'MT' => 'Montana',
            'NE' => 'Nebraska',
            'NV' => 'Nevada',
            'NH' => 'New Hampshire',
            'NJ' => 'New Jersey',
            'NM' => 'New Mexico',
            'NY' => 'New York',
            'NC' => 'North Carolina',
            'ND' => 'North Dakota',
            'OH' => 'Ohio',
            'OK' => 'Oklahoma',
            'OR' => 'Oregon',
            'PA' => 'Pennsylvania',
            'RI' => 'Rhode Island',
            'SC' => 'South Carolina',
            'SD' => 'South Dakota',
            'TN' => 'Tennessee',
            'TX' => 'Texas',
            'UT' => 'Utah',
            'VT' => 'Vermont',
            'VA' => 'Virginia',
            'WA' => 'Washington',
            'WV' => 'West Virginia',
            'WI' => 'Wisconsin',
            'WY' => 'Wyoming',
            'AS' => 'American Samoa',
            'GU' => 'Guam',
            'MP' => 'Northern Mariana Islands',
            'PR' => 'Puerto Rico',
            'VI' => 'U.S. Virgin Islands',
        ];
    }

    private static function naicsSectors(): array
    {
        return [
            '11' => '11 - Agriculture, Forestry, Fishing and Hunting',
            '21' => '21 - Mining, Quarrying, and Oil and Gas Extraction',
            '22' => '22 - Utilities',
            '23' => '23 - Construction',
            '31-33' => '31-33 - Manufacturing',
            '42' => '42 - Wholesale Trade',
            '44-45' => '44-45 - Retail Trade',
            '48-49' => '48-49 - Transportation and Warehousing',
            '51' => '51 - Information',
            '52' => '52 - Finance and Insurance',
            '53' => '53 - Real Estate and Rental and Leasing',
            '54' => '54 - Professional, Scientific, and Technical Services',
            '55' => '55 - Management of Companies and Enterprises',
            '56' => '56 - Administrative and Support and Waste Management and Remediation Services',
            '61' => '61 - Educational Services',
            '62' => '62 - Health Care and Social Assistance',
            '71' => '71 - Arts, Entertainment, and Recreation',
            '72' => '72 - Accommodation and Food Services',
            '81' => '81 - Other Services (except Public Administration)',
            '92' => '92 - Public Administration',
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

        return (int) $user->employer_id === (int) $record->getKey();
    }
}
