<?php

namespace App\Filament\Resources\ResearchServiceResource\Pages;

use App\Filament\Resources\ResearchServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResearchService extends EditRecord
{
    protected static string $resource = ResearchServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
