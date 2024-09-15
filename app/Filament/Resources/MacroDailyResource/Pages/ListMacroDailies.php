<?php

namespace App\Filament\Resources\MacroDailyResource\Pages;

use App\Filament\Resources\MacroDailyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMacroDailies extends ListRecords
{
    protected static string $resource = MacroDailyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
