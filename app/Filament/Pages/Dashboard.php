<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardStats;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationGroup = 'Admin';

    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            DashboardStats::class,
        ];
    }

    public function getWidgets(): array
    {
        return [];
    }
}
