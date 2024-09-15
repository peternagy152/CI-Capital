<?php

namespace App\Filament\Resources\DailyResource\Pages;

use App\Filament\Resources\DailyResource;
use App\Models\Company;
use App\Models\Daily;
use App\Models\Macro;
use App\Models\MacroDaily;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListDailies extends ListRecords
{
    protected static string $resource = DailyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            \Filament\Actions\Action::make("daily_importer")
                ->label("Import Dailies")->icon('heroicon-m-document-text')
                ->outlined()
                ->form([
                    FileUpload::make('attachments')->downloadable()->directory("daily_upload")->visibility("public"),
                ])
                ->action(function (array $data) {
                    $file_path = public_path('storage/' . $data['attachments']);
                    $exel_file = fopen($file_path, 'r');
                    $first_row = 0 ;
                    while (($line = fgetcsv($exel_file)) !== FALSE) {
                        if ($first_row == 0) {
                            $first_row++;
                            continue;
                        }
                        if($line[0] == "company"){
                            $bloomberg_ticker = $line[1] ;
                            $company_object = Company::select("id")->where("bloomberg", $bloomberg_ticker)->get();
                            if(isset($company_object[0]->id)){
                                $company_daily = Daily::create([
                                    "title" => $line[2],
                                    "desc" => $line[3],
                                    "published_at" => $line[4],
                                    "company_id" => $company_object[0]->id,
                                ]);
                                $sources = explode("," , $line[5]);
                                $company_daily->Source()->syncWithoutDetaching($sources);
                            }else{
                                Notification::make()->title("Bloomberg Ticker Skipped")
                                    ->persistent()
                                    ->body("Ticker Skipped " .  $bloomberg_ticker)
                                    ->danger()
                                    ->send();
                            }
                        }else if($line[0] == "macro"){
                            $macro_object = Macro::find($line[1]);
                            if($macro_object){
                                $macro_daily = MacroDaily::create([
                                    "title" => $line[2],
                                    "desc" => $line[3],
                                    "published_at" => $line[4],
                                    "macro_id" => $line[1]
                                ]);
                                $sources = explode("," , $line[5]);
                                $macro_daily->Source()->syncWithoutDetaching($sources);
                            }
                        }else{
                            continue ;
                        }
                    }
                    Notification::make()->title("Dailies Imported Successfully")
                        ->icon('heroicon-o-document-text')
                        ->iconColor('success')->send();

                }),
        ];
    }
}
