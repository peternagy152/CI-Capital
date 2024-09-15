<?php

namespace App\Filament\Resources\MacroPublicationResource\Pages;

use App\Filament\Resources\MacroPublicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMacroPublication extends EditRecord
{
    protected static string $resource = MacroPublicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
