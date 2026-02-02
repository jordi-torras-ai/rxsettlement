<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Welcome extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = -10;

    protected static ?string $navigationLabel = 'Welcome';

    protected static ?string $title = 'Welcome';

    protected static string $view = 'filament.pages.welcome';

    public static function canAccess(): bool
    {
        return auth()->check();
    }
}
