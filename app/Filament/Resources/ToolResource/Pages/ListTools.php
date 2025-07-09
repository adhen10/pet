<?php

namespace App\Filament\Resources\ToolResource\Pages;

use App\Models\Tool;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\ToolResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListTools extends ListRecords
{
    protected static string $resource = ToolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'active' => Tab::make('Active Tools')
                ->icon('heroicon-m-user-group')
                ->badge(Tool::query()->withoutTrashed()->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn(Builder $query) => $query->withoutTrashed()),
            'inactive' => Tab::make('Inactive Tools')
                ->icon('heroicon-m-user-group')
                ->badge(Tool::query()->onlyTrashed()->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn(Builder $query) => $query->onlyTrashed()),
            'all' => Tab::make('All Tools')
                ->icon('heroicon-m-user-group')
                ->badge(Tool::query()->withTrashed()->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->withTrashed()),
        ];
    }
}
