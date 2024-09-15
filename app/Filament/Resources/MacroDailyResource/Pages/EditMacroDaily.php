<?php

namespace App\Filament\Resources\MacroDailyResource\Pages;

use App\Filament\Resources\MacroDailyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMacroDaily extends EditRecord
{
    protected static string $resource = MacroDailyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
