<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Resources\CompanyResource;
use App\Models\Company;
use Filament\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use App\Traits\GlobalWidgets;

class ListCompanies extends ListRecords
{
    use GlobalWidgets;

    protected static string $resource = CompanyResource::class;

    protected function getHeaderActions(): array
    {
        $companies = Company::select(["id", "name"])->get();
        $company_select = [];
        foreach ($companies as $compnay) {
            $company_select[$compnay->id] = $compnay->name;
        }
        return [
            Actions\CreateAction::make(),
            \Filament\Actions\Action::make("equity_importer")
                ->label("Update Company")->icon('heroicon-m-document-text')
                ->outlined()
                ->form([
                    Select::make("Company")->options($company_select),
                    FileUpload::make('attachments')->downloadable()->directory("macro_uploads")->visibility("public"),
                ])
                ->action(function (array $data) {
                    $file_path = public_path('storage/' . $data['attachments']);
                    $cols_validation = $this->validate_equity_sheet_cols($file_path);

                    if ($cols_validation != "valid") {
                        if ($cols_validation == 'mismatch') {
                            Notification::make()->title("Count Error")
                                ->persistent()
                                ->body('Columns count doesnt match please follow the shared template')
                                ->danger()
                                ->send();
                        } else {
                            Notification::make()->title("Missing Error")
                                ->persistent()
                                ->body($cols_validation . " is missing , Please follow the shared template ")
                                ->danger()
                                ->send();
                        }
                    } else {
                        Notification::make()->title("Cols Validated")->color("success")->success()->send();
                        $values_validation = 'valid'; //$this->validate_equity_sheet_values($file_path);
                        if ($values_validation != 'valid') {
                            Notification::make()->title("Wrong Values Entry")
                                ->persistent()
                                ->body($values_validation . ' - Only Accepting Numeric Values')
                                ->danger()
                                ->send();

                        } else {
                            $this->new_import_equity($file_path, $data['Company']);
                            Notification::make()->title("Company Updated Successfully")
                                ->icon('heroicon-o-document-text')
                                ->iconColor('success')->send();
                        }
                    }
                }),
            \Filament\Actions\Action::make("closing_price_importer")
                ->label("Update Closing Price")->icon('heroicon-m-arrow-trending-up')
                ->outlined()
                ->form([
                    FileUpload::make('attachments')->downloadable()->directory("macro_uploads")->visibility("public"),
                ])
                ->action(function (array $data) {
                    $file_path =public_path('storage/' . $data['attachments']);
                    $bloomberg_validation = $this->validate_bloomberg_ticker($file_path);
                    if ($bloomberg_validation != "valid") {
                        Notification::make()->title("Bloomberg Ticker Error")
                            ->persistent()
                            ->body($bloomberg_validation . " - No Equity with this bloomberg ticker found ! ")
                            ->danger()
                            ->send();
                    }else{
                        $this->import_closing_price($file_path);
                        Notification::make()->title("Closing Prices Updated Successfully")
                            ->icon('heroicon-o-document-text')
                            ->iconColor('success')->send();
                    }

                }),
        ];
    }
}
