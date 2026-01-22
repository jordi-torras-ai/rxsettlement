<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Pages\Concerns\RedirectToIndex;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    use RedirectToIndex;
}
