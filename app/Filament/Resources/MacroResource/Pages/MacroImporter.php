<?php

namespace App\Filament\Resources\MacroResource\Pages;

use App\Filament\Resources\MacroResource;
use App\Models\Macro;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;

use Filament\Forms;

class MacroImporter extends Page
{
    protected static string $resource = MacroResource::class;

    protected static string $view = 'filament.resources.macro-resource.pages.macro-importer';

    public function mount(): void
    {
        $this->form->fill();
        static::authorizeResourceAccess();
    }
    protected function getFormSchema(): array
    {
        $fileUpload = new FileUpload('sheet');
        $fileUpload->directory('importers')
            ->downloadable()
            ->openable()
            ->visibility('public')
            ->required();
        return [

            Forms\Components\Select::make('name')
                ->options(Macro::pluck('name', 'id')->toArray())
                ->reactive()
                ->required(),

            // Forms\Components\FileUpload::make('sheet')->directory('importers')->downloadable()->openable()->visibility('public')->required(),

        ];
    }

    public function submit(){
        Notification::make()
            ->title('Sheet Importer')
            ->success()
            ->send();
    }
}
