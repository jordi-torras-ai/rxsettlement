<?php

namespace App\Filament\Pages\Concerns;

use App\Filament\Pages\Welcome;
use Filament\Actions;

trait HasInstructions
{
    protected function getInstructionsAction(string $anchor): Actions\Action
    {
        $instructionsUrl = Welcome::getUrl() . '#' . $anchor;

        return Actions\Action::make('instructions')
            ->label('Instructions')
            ->icon('heroicon-o-arrow-top-right-on-square')
            ->iconPosition('after')
            ->url($instructionsUrl)
            ->view('filament.actions.instructions-action');
    }
}
