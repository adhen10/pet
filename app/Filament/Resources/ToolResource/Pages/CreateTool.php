<?php

namespace App\Filament\Resources\ToolResource\Pages;

use App\Filament\Resources\OwnerResource;
use Filament\Actions;
use App\Filament\Resources\ToolResource;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateTool extends CreateRecord
{
    protected static string $resource = ToolResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Tool Created');
    }

    protected function beforeCreate(): void
    {
        if (auth()->user()->id == 1) {
            Notification::make()
                ->warning()
                ->title('You don\'t have an active subscription!')
                ->body('Choose a plan to continue.')
                ->persistent()
                ->actions([
                    Action::make('Subscribe')
                        ->button()
                        ->url(OwnerResource::getUrl('create'), shouldOpenInNewTab: true),
                ])
                ->send();
                
            $this->halt();
        }
    }
}
