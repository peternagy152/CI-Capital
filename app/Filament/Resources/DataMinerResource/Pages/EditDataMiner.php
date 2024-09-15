<?php

namespace App\Filament\Resources\DataMinerResource\Pages;

use App\Filament\Resources\DataMinerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataMiner extends EditRecord
{
    protected static string $resource = DataMinerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
