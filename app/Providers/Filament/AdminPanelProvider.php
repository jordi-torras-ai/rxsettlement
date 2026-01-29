<?php

namespace App\Providers\Filament;

use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->darkMode(true)
            ->defaultThemeMode(ThemeMode::Dark)
            ->homeUrl(fn (): string => auth()->user()?->isAdmin()
                ? \App\Filament\Pages\Dashboard::getUrl()
                : \App\Filament\Resources\EmployerResource::getUrl('index'))
            ->renderHook(
                PanelsRenderHook::HEAD_START,
                fn (): string => Blade::render(<<<'BLADE'
<script>
(function () {
  const match = document.cookie.match(/(?:^|; )filament_theme=([^;]+)/);
  if (match && !localStorage.getItem('theme')) {
    localStorage.setItem('theme', decodeURIComponent(match[1]));
  }

  document.addEventListener('theme-changed', function (event) {
    if (!event || !event.detail) return;
    document.cookie = 'filament_theme=' + encodeURIComponent(event.detail) + '; path=/; max-age=31536000; samesite=lax';
  });
})();
</script>
BLADE),
            )
            ->renderHook(
                PanelsRenderHook::FOOTER,
                fn (): string => Blade::render(<<<'BLADE'
<div class="mx-auto w-full px-4 py-3 text-center text-xs text-gray-500 dark:text-gray-400 sm:px-6 lg:px-8">
    v{{ config('app.version') }} &mdash; © 2026 1BeneCare
</div>
BLADE),
            )
            ->colors([
                'primary' => Color::Blue,
            ])
            ->brandName('1BeneCare')
            ->brandLogo(asset('images/1benecare_logo.png'))
            ->brandLogoHeight('2.5rem')
            ->maxContentWidth('full')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
