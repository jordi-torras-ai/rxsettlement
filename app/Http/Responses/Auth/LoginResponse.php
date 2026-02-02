<?php

namespace App\Http\Responses\Auth;

use App\Filament\Pages\Welcome;
use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as Responsable;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class LoginResponse implements Responsable
{
    public function toResponse($request): RedirectResponse | Redirector
    {
        $user = Filament::auth()->user();

        if ($user && ! $user->isAdmin()) {
            return redirect()->to(Welcome::getUrl());
        }

        return redirect()->intended(Filament::getHomeUrl());
    }
}
