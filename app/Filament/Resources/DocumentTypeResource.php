<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentTypeResource\Pages;
use App\Models\DocumentType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class DocumentTypeResource extends Resource
{
    protected static ?string $model = DocumentType::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = null;

    protected static ?int $navigationSort = 60;

    public static function canViewAny(): bool
    {
        return auth()->check();
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function canView(Model $record): bool
    {
        return auth()->check();
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function form(Form $form): Form
    {
        $user = auth()->user();

        return $form
            ->schema([
                Forms\Components\TextInput::make('description')
                    ->label('Description')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('example_file')
                    ->label('Example File')
                    ->disk('r2')
                    ->directory('document-types')
                    ->preserveFilenames()
                    ->downloadable()
                    ->openable()
                    ->nullable()
                    ->visible(fn (): bool => $user?->isAdmin() ?? false),
                Forms\Components\Placeholder::make('example_file_download')
                    ->label('Example File')
                    ->content(function (?Model $record): HtmlString {
                        if (!$record || blank($record->example_file)) {
                            return new HtmlString('&mdash;');
                        }

                        $url = static::fileUrl($record->example_file);
                        $label = e(basename($record->example_file));

                        return new HtmlString(
                            $url
                                ? '<a class="text-primary-600 hover:underline" href="' . e($url) . '" target="_blank" rel="noopener noreferrer">Download ' . $label . '</a>'
                                : $label
                        );
                    })
                    ->visible(fn (): bool => !($user?->isAdmin() ?? false)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('example_file')
                    ->label('Example File')
                    ->formatStateUsing(fn (?string $state): ?string => $state ? basename($state) : null)
                    ->url(fn (DocumentType $record): ?string => static::fileUrl($record->example_file))
                    ->color('primary')
                    ->openUrlInNewTab(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton(),
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->visible(fn (): bool => auth()->user()?->isAdmin() ?? false),
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
            'index' => Pages\ListDocumentTypes::route('/'),
            'create' => Pages\CreateDocumentType::route('/create'),
            'view' => Pages\ViewDocumentType::route('/{record}'),
            'edit' => Pages\EditDocumentType::route('/{record}/edit'),
        ];
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
