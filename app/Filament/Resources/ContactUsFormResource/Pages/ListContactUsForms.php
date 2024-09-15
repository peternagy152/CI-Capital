<?php

namespace App\Filament\Resources\ContactUsFormResource\Pages;

use App\Filament\Resources\ContactUsFormResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactUsForms extends ListRecords
{
    protected static string $resource = ContactUsFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
