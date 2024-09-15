<?php

namespace App\Filament\Resources\CommodyResource\Pages;

use App\Filament\Imports\CommodyImporter;
use App\Filament\Resources\CommodyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCommodies extends ListRecords
{
    protected static string $resource = CommodyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ImportAction::make()
                ->importer(CommodyImporter::class),
            Actions\CreateAction::make(),
        ];
    }
}
