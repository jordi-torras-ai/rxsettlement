<?php

namespace App\Providers;

use App\Http\Responses\Auth\LoginResponse as AppLoginResponse;
use App\Models\AuditLog;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LoginResponseContract::class, AppLoginResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(Login::class, function (Login $event): void {
            $this->recordAuthEvent('login', $event->user?->getAuthIdentifier());
        });

        Event::listen(Logout::class, function (Logout $event): void {
            $this->recordAuthEvent('logout', $event->user?->getAuthIdentifier());
        });

        Event::listen('eloquent.created: *', function (string $event, array $payload): void {
            $model = $payload[0] ?? null;
            if (!$model instanceof Model || $model instanceof AuditLog) {
                return;
            }

            $this->recordModelEvent('created', $model, null, $this->filteredAttributes($model));
        });

        Event::listen('eloquent.updated: *', function (string $event, array $payload): void {
            $model = $payload[0] ?? null;
            if (!$model instanceof Model || $model instanceof AuditLog) {
                return;
            }

            $changes = $model->getChanges();
            if ($changes === []) {
                return;
            }

            $keys = array_keys($changes);
            $old = Arr::only($model->getOriginal(), $keys);
            $new = Arr::only($model->getAttributes(), $keys);

            $this->recordModelEvent('updated', $model, $this->filteredArray($model, $old), $this->filteredArray($model, $new));
        });

        Event::listen('eloquent.deleted: *', function (string $event, array $payload): void {
            $model = $payload[0] ?? null;
            if (!$model instanceof Model || $model instanceof AuditLog) {
                return;
            }

            $this->recordModelEvent('deleted', $model, $this->filteredAttributes($model), null);
        });
    }

    private function recordAuthEvent(string $event, ?int $userId): void
    {
        [$ip, $agent, $url] = $this->requestContext();

        AuditLog::create([
            'user_id' => $userId,
            'event' => $event,
            'auditable_type' => null,
            'auditable_id' => null,
            'old_values' => null,
            'new_values' => null,
            'ip_address' => $ip,
            'user_agent' => $agent,
            'url' => $url,
            'created_at' => now(),
        ]);
    }

    private function recordModelEvent(string $event, Model $model, ?array $old, ?array $new): void
    {
        [$ip, $agent, $url] = $this->requestContext();

        AuditLog::create([
            'user_id' => auth()->id(),
            'event' => $event,
            'auditable_type' => $model::class,
            'auditable_id' => $model->getKey(),
            'old_values' => $old,
            'new_values' => $new,
            'ip_address' => $ip,
            'user_agent' => $agent,
            'url' => $url,
            'created_at' => now(),
        ]);
    }

    private function requestContext(): array
    {
        if (app()->runningInConsole()) {
            return [null, null, null];
        }

        $request = request();

        return [
            $request->ip(),
            $request->userAgent(),
            $request->fullUrl(),
        ];
    }

    private function filteredAttributes(Model $model): array
    {
        return $this->filteredArray($model, $model->getAttributes());
    }

    private function filteredArray(Model $model, array $values): array
    {
        return Arr::except($values, $model->getHidden());
    }
}
