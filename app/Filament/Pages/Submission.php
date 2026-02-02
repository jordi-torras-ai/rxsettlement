<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Submission extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';

    protected static ?int $navigationSort = 999;

    protected static ?string $title = 'Submission';

    protected static string $view = 'filament.pages.submission';

    public static function canAccess(): bool
    {
        return auth()->check();
    }
}
