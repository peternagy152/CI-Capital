<?php

namespace App\Filament\Resources\ServiceInquiryResource\Pages;

use App\Filament\Resources\ServiceInquiryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServiceInquiry extends EditRecord
{
    protected static string $resource = ServiceInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
