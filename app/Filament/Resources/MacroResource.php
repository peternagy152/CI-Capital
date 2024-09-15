<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MacroResource\Pages;
use App\Filament\Resources\MacroResource\RelationManagers;
use App\Models\Macro;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\Tabs;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Fieldset;

class MacroResource extends Resource
{
    protected static ?string $model = Macro::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationGroup = "Coverage";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make("Primary Data")
                     ->schema([
                     Forms\Components\TextInput::make('name')->maxLength(255) ,
                    Forms\Components\FileUpload::make('flag')->directory('macros')->downloadable()->openable()->visibility('public'),
                      Forms\Components\Textarea::make('source') ,
                Forms\Components\Textarea::make('note'),
                         Forms\Components\TextInput::make('currency')->maxLength(255) ,

                     ])->columns(2) ,

                Tabs::make("Tabs")
                ->tabs([
                    Tabs\Tab::make("Real sector")
                    ->schema([
                    Fieldset::make("Real GDP Growth")
                    ->schema([
                            Forms\Components\TextInput::make('real_gdp_growth_py_2')
                                ->label("Previous Year-2")
            ,
                            Forms\Components\TextInput::make('real_gdp_growth_py_1')
                                ->label("Previous Year - 1"),
                            Forms\Components\TextInput::make('real_gdp_growth_py')
                                ->label("Previous Year"),
                            Forms\Components\TextInput::make('real_gdp_growth_cy')
                                ->label("Current Year"),
                            Forms\Components\TextInput::make('real_gdp_growth_cy_1')
                            ->label("Current Year+1"),
                    ])->columns(5) ,

                    Fieldset::make("Real Hydrocarbon Growth")
                    ->schema([
                        Forms\Components\TextInput::make('real_hydrocarbon_growth_py_2')
                            ->label("Previous Year-2")
                        ,
                        Forms\Components\TextInput::make('real_hydrocarbon_growth_py_1')
                            ->label("Previous Year - 1"),
                        Forms\Components\TextInput::make('real_hydrocarbon_growth_py')
                            ->label("Previous Year"),
                        Forms\Components\TextInput::make('real_hydrocarbon_growth_cy')
                            ->label("Current Year"),
                        Forms\Components\TextInput::make('real_hydrocarbon_growth_cy_1')
                            ->label("Current Year+1"),
                    ])->columns(5),


                     Fieldset::make("Real Non-Hydrocarbon Growth")
                    ->schema([
                        Forms\Components\TextInput::make('real_non_hydrocarbon_growth_py_2')
                            ->label("Previous Year-2")
                         ,
                        Forms\Components\TextInput::make('real_non_hydrocarbon_growth_py_1')
                            ->label("Previous Year - 1"),
                        Forms\Components\TextInput::make('real_non_hydrocarbon_growth_py')
                            ->label("Previous Year"),
                        Forms\Components\TextInput::make('real_non_hydrocarbon_growth_cy')
                            ->label("Current Year"),
                        Forms\Components\TextInput::make('real_non_hydrocarbon_growth_cy_1')
                            ->label("Current Year+1"),
                    ])->columns(5),

                     Fieldset::make("GDP Per Capital")
                     ->schema([
                        Forms\Components\TextInput::make('gdp_per_capita_py_2')
                            ->label("Previous Year-2")
                         ,
                        Forms\Components\TextInput::make('gdp_per_capita_py_1')
                            ->label("Previous Year - 1"),
                        Forms\Components\TextInput::make('gdp_per_capita_py')
                            ->label("Previous Year"),
                        Forms\Components\TextInput::make('gdp_per_capita_cy')
                            ->label("Current Year"),
                        Forms\Components\TextInput::make('gdp_per_capita_cy_1')
                            ->label("Current Year+1"),
                     ])->columns(5),

                     Fieldset::make("Population")
                     ->schema([
                        Forms\Components\TextInput::make('population_py_2')
                        ->label("Previous Year-2"),
                        Forms\Components\TextInput::make('population_py_1')
                            ->label("Previous Year - 1"),
                        Forms\Components\TextInput::make('population_py')
                            ->label("Previous Year"),
                        Forms\Components\TextInput::make('population_cy')
                            ->label("Current Year"),
                        Forms\Components\TextInput::make('population_cy_1')
                            ->label("Current Year+1"),
                     ])->columns(5),

                    Fieldset::make("Unemployment Rate")
                    ->schema([
                        Forms\Components\TextInput::make('unemployment_rate_py_2')
                        ->label("Previous Year-2"),
                            Forms\Components\TextInput::make('unemployment_rate_py_1')
                            ->label("Previous Year - 1"),
                        Forms\Components\TextInput::make('unemployment_rate_py')
                            ->label("Previous Year"),
                        Forms\Components\TextInput::make('unemployment_rate_cy')
                            ->label("Current Year"),
                        Forms\Components\TextInput::make('unemployment_rate_cy_1')
                            ->label("Current Year+1"),
                    ])->columns(5),

                    ])->columns(5) ,
                     Tabs\Tab::make("Fiscal sector")
                    ->schema([

                    Fieldset::make("Government Revenues")
                    ->schema([
                Forms\Components\TextInput::make('government_revenues_py_2')
                    ->label("Previous Year-2"),
                Forms\Components\TextInput::make('government_revenues_py_1')
                    ->label("Previous Year - 1"),
                Forms\Components\TextInput::make('government_revenues_py')
                    ->label("Previous Year"),
                Forms\Components\TextInput::make('government_revenues_cy')
                    ->label("Current Year"),
                    Forms\Components\TextInput::make('government_revenues_cy_1')
                      ->label("Current Year+1"),
                    ])->columns(5) ,


                     Fieldset::make("Government Expenditure")
                     ->schema([
                Forms\Components\TextInput::make('government_expenditure_py_2')
                    ->label("Previous Year-2"),
                Forms\Components\TextInput::make('government_expenditure_py_1')
                    ->label("Previous Year - 1"),
                Forms\Components\TextInput::make('government_expenditure_py')
                    ->label("Previous Year"),
                Forms\Components\TextInput::make('government_expenditure_cy')
                    ->label("Current Year"),
                Forms\Components\TextInput::make('government_expenditure_cy_1')
                      ->label("Current Year+1"),
                     ])->columns(5) ,

                     Fieldset::make("Fiscal Balance")
                     ->schema([
                    Forms\Components\TextInput::make('fiscal_balance_py_2')
                    ->label("Previous Year-2"),
                Forms\Components\TextInput::make('fiscal_balance_py_1')
                    ->label("Previous Year - 1"),
                Forms\Components\TextInput::make('fiscal_balance_py')
                    ->label("Previous Year"),
                Forms\Components\TextInput::make('fiscal_balance_cy')
                    ->label("Current Year"),
                Forms\Components\TextInput::make('fiscal_balance_cy_1')
                      ->label("Current Year+1"),
                     ])->columns(5) ,


                     Fieldset::make("Debit")
                     ->schema([
Forms\Components\TextInput::make('debit_py_2')
                    ->label("Previous Year-2"),
                Forms\Components\TextInput::make('debit_py_1')
                    ->label("Previous Year - 1"),
                Forms\Components\TextInput::make('debit_py')
                    ->label("Previous Year"),
                Forms\Components\TextInput::make('debit_cy')
                    ->label("Current Year"),
                Forms\Components\TextInput::make('debit_cy_1')
                      ->label("Current Year+1"),
                     ])->columns(5) ,



                    ])->columns(5),
                      Tabs\Tab::make("External sector")
                    ->schema([


                    Fieldset::make("Trade Balance")
                     ->schema([
 Forms\Components\TextInput::make('trade_balance_py_2')
                    ->label("Previous Year-2"),
                Forms\Components\TextInput::make('trade_balance_py_1')
                    ->label("Previous Year - 1"),
                Forms\Components\TextInput::make('trade_balance_py')
                    ->label("Previous Year"),
                Forms\Components\TextInput::make('trade_balance_cy')
                    ->label("Current Year"),
                Forms\Components\TextInput::make('trade_balance_cy_1')
                      ->label("Current Year+1"),
                     ])->columns(5) ,


                     Fieldset::make("Hydrocarbon Exports")
                     ->schema([
 Forms\Components\TextInput::make('hydrocarbon_exports_py_2')
                    ->label("Previous Year-2"),
                Forms\Components\TextInput::make('hydrocarbon_exports_py_1')
                    ->label("Previous Year - 1"),
                Forms\Components\TextInput::make('hydrocarbon_exports_py')
                    ->label("Previous Year"),
                Forms\Components\TextInput::make('hydrocarbon_exports_cy')
                    ->label("Current Year"),
                Forms\Components\TextInput::make('hydrocarbon_exports_cy_1')
                      ->label("Current Year+1"),
                     ])->columns(5) ,


                     Fieldset::make("current account balance")
                     ->schema([
  Forms\Components\TextInput::make('current_account_balance_py_2')
                    ->label("Previous Year-2"),
                Forms\Components\TextInput::make('current_account_balance_py_1')
                    ->label("Previous Year - 1"),
                Forms\Components\TextInput::make('current_account_balance_py')
                    ->label("Previous Year"),
                Forms\Components\TextInput::make('current_account_balance_cy')
                    ->label("Current Year"),
                Forms\Components\TextInput::make('current_account_balance_cy_1')
                      ->label("Current Year+1"),
                     ])->columns(5) ,


                     Fieldset::make("current account balance gdp")
                     ->schema([
 Forms\Components\TextInput::make('current_account_balance_gdp_py_2')
                    ->label("Previous Year-2"),
                Forms\Components\TextInput::make('current_account_balance_gdp_py_1')
                    ->label("Previous Year - 1"),
                Forms\Components\TextInput::make('current_account_balance_gdp_py')
                    ->label("Previous Year"),
                Forms\Components\TextInput::make('current_account_balance_gdp_cy')
                    ->label("Current Year"),
                Forms\Components\TextInput::make('current_account_balance_gdp_cy_1')
                      ->label("Current Year+1"),
                     ])->columns(5) ,


                    ])->columns(5),
                      Tabs\Tab::make("Monetary sector")
                    ->schema([


                        Fieldset::make("Inflation")
                     ->schema([
 Forms\Components\TextInput::make('inflation_py_2')
                    ->label("Previous Year-2"),
                Forms\Components\TextInput::make('inflation_py_1')
                    ->label("Previous Year - 1"),
                Forms\Components\TextInput::make('inflation_py')
                    ->label("Previous Year"),
                Forms\Components\TextInput::make('inflation_cy')
                    ->label("Current Year"),
                Forms\Components\TextInput::make('inflation_cy_1')
                      ->label("Current Year+1"),
                     ])->columns(5) ,



                     Fieldset::make("Private Sector Credit Growth")
                     ->schema([
 Forms\Components\TextInput::make('private_sector_credit_growth_py_2')
                    ->label("Previous Year-2"),
                Forms\Components\TextInput::make('private_sector_credit_growth_py_1')
                    ->label("Previous Year - 1"),
                Forms\Components\TextInput::make('private_sector_credit_growth_py')
                    ->label("Previous Year"),
                Forms\Components\TextInput::make('private_sector_credit_growth_cy')
                    ->label("Current Year"),
                Forms\Components\TextInput::make('private_sector_credit_growth_cy_1')
                      ->label("Current Year+1"),
                     ])->columns(5) ,



                     Fieldset::make("Discount Rate")
                     ->schema([
   Forms\Components\TextInput::make('discount_rate_py_2')
                    ->label("Previous Year-2"),
                Forms\Components\TextInput::make('discount_rate_py_1')
                    ->label("Previous Year - 1"),
                Forms\Components\TextInput::make('discount_rate_py')
                    ->label("Previous Year"),
                Forms\Components\TextInput::make('discount_rate_cy')
                    ->label("Current Year"),
                Forms\Components\TextInput::make('discount_rate_cy_1')
                      ->label("Current Year+1"),
                     ])->columns(5) ,

                    ])->columns(5),
                    Tabs\Tab::make("Hydrocarbon Indicators")
                    ->schema([

                        Fieldset::make("Oil Production")
                     ->schema([
Forms\Components\TextInput::make('oil_production_py_2')
                    ->label("Previous Year-2"),
                Forms\Components\TextInput::make('oil_production_py_1')
                    ->label("Previous Year-1"),
                Forms\Components\TextInput::make('oil_production_py')
                    ->label("Previous Year"),
                Forms\Components\TextInput::make('oil_production_cy')
                    ->label("Current Year"),
                Forms\Components\TextInput::make('oil_production_cy_1')
                      ->label("Current Year+1"),
                     ])->columns(5) ,


                     Fieldset::make("Brent Price")
                     ->schema([
 Forms\Components\TextInput::make('brent_price_py_2')
                    ->label("Previous Year-2"),
                Forms\Components\TextInput::make('brent_price_py_1')
                    ->label("Previous Year-1"),
                Forms\Components\TextInput::make('brent_price_py')
                    ->label("Previous Year"),
                Forms\Components\TextInput::make('brent_price_cy')
                    ->label("Current Year"),
                Forms\Components\TextInput::make('brent_price_cy_1')
                      ->label("Current Year+1"),
                     ])->columns(5) ,

                     Fieldset::make("Natural Gas Production")
                     ->schema([
  Forms\Components\TextInput::make('natural_gas_production_py_2')
                    ->label("Previous Year-2"),
                Forms\Components\TextInput::make('natural_gas_production_py_1')
                    ->label("Previous Year-1"),
                Forms\Components\TextInput::make('natural_gas_production_py')
                    ->label("Previous Year"),
                Forms\Components\TextInput::make('natural_gas_production_cy')
                    ->label("Current Year"),
                Forms\Components\TextInput::make('natural_gas_production_cy_1')
                      ->label("Current Year+1"),
                     ])->columns(5) ,


                    ])->columns(5) ,



                ]),



            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                    Tables\Columns\TextColumn::make('name')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMacros::route('/'),
            'create' => Pages\CreateMacro::route('/create'),
            'edit' => Pages\EditMacro::route('/{record}/edit'),
            'import' => Pages\MacroImporter::route('/{record}/import'),
        ];
    }
}
