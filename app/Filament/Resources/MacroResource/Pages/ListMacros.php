<?php

namespace App\Filament\Resources\MacroResource\Pages;

use App\Filament\Imports\MacroImporter;
use App\Filament\Resources\MacroResource;
use App\Models\Macro;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use App\Traits\GlobalWidgets;

class ListMacros extends ListRecords
{
    use GlobalWidgets;
    protected static string $resource = MacroResource::class;

    protected function getHeaderActions(): array
    {
        $macros = Macro::select(['id', 'name'])->get();
        $macro_select = [] ;
        foreach ($macros as $macro) {
            $macro_select[$macro->id] = $macro->name;
        }

        return [
            Actions\CreateAction::make(),
            Action::make("macro_importer")
                ->label("Update Macro")->icon('heroicon-m-document-text')
                ->outlined()
                ->form([
                Select::make("Macro")->options($macro_select) ,
                FileUpload::make('attachments')->downloadable()->directory("macro_uploads")->visibility("public"),
            ])
            ->action(function (array $data) {
                $file_path = public_path('storage/' . $data['attachments']);
                //Validate the Cols
                $cols_validation = $this->validate_macro_sheet_cols($file_path) ;
                //validate the Values
                $values_validation = $this->validate_macro_sheet_values($file_path);
                if($cols_validation != "valid"){
                    if($cols_validation == 'mismatch'){
                        Notification::make()->title("Count Error")
                            ->persistent()
                            ->body('Columns count doesnt match please follow the shared template')
                            ->danger()
                            ->send();
                    }else{
                        Notification::make()->title("Missing Error")
                            ->persistent()
                            ->body($cols_validation . " is missing , Please follow the shared template ")
                            ->danger()
                            ->send();
                    }

                }else{
                    Notification::make()->title("Cols Validated")->color("success")->success()->send();
                    if($values_validation != 'valid'){
                        Notification::make()->title("Wrong Values Entry")
                            ->persistent()
                            ->body( $values_validation . ' - Only Accepting Numeric Values')
                            ->danger()
                            ->send();

                    }else{
                        Notification::make()->title("Records Validated")->color("success")->success()->send();
                        $this->import_macro_sheet($file_path , $data['Macro']);
                        Notification::make()->title("Macro Updated Successfully")
                            ->icon('heroicon-o-document-text')
                            ->iconColor('success')->send();
                    }
                }
                })
        ];
    }
}
