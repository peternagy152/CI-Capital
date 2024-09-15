<?php

namespace App\Filament\Resources\CommodyResource\Pages;

use App\Filament\Resources\CommodyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCommody extends EditRecord
{
    protected static string $resource = CommodyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
