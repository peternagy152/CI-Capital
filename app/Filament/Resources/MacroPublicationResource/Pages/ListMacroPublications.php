<?php

namespace App\Filament\Resources\MacroPublicationResource\Pages;

use App\Filament\Resources\MacroPublicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMacroPublications extends ListRecords
{
    protected static string $resource = MacroPublicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
