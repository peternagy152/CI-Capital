<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Analyst;
use App\Models\User;
use Filament\Forms\Components\Tabs;


class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationGroup = "Coverage";

    public static function form(Form $form): Form
    {
        $all_analyst = array();
        foreach (Analyst::all() as $one_analyst) {
            $user = User::find($one_analyst->user_id);
            $all_analyst[$one_analyst->id] = $user->name;
        }
        return $form
            ->schema([
                Forms\Components\Fieldset::make("Primary Data")
                    ->schema([
                        Forms\Components\Fieldset::make("Relations")
                            ->schema([
                                Forms\Components\Select::make('macro_id')
                                    ->relationship('Macro', 'name')->required(),
                                Forms\Components\Select::make('type_id')
                                    ->relationship('Type', 'name')->required()->live(),
                                Forms\Components\Select::make('sector_id')
                                    ->relationship('Sector', 'name')->required()->live(),
                                Forms\Components\Select::make('Analyst')
                                    ->label("Primary Analyst")
                                    ->relationship('Analyst', 'id')->multiple()->preload()->options($all_analyst),
                            ])->columns(1),

                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('desc')
                            ->required()
                            ->rows(8),
                        Forms\Components\FileUpload::make('logo')->label("Logo - 120 x 74  ")->directory('companies_data')->downloadable()
                            ->openable()->visibility('public')->required(),

                    ])->columns(1),

                Forms\Components\Fieldset::make("Basic Data")
                    ->schema([
                        Forms\Components\TextInput::make('bloomberg')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('reuters')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('market_cap')
                            ->numeric(),
                        Forms\Components\TextInput::make('market_cap_local')
                            ->numeric(),
                        Forms\Components\TextInput::make('adtv')
                            ->numeric(),
                        Forms\Components\TextInput::make('recommendation')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('tp_currency')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('target_price')
                            ->numeric(),
                        Forms\Components\TextInput::make('closing_price')
                            ->numeric(),
                        Forms\Components\TextInput::make('potential_return')
                            ->numeric(),
                    ])->columns(6),

                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Income Statements')
                            ->schema([

                                Forms\Components\Repeater::make('taxes_or_zakat_is')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('net_income_is')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('revenue_is')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('cost_of_sale_is')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('gross_profit_is')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('sg_a_is')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('ebit_is')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('d_a_is')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('ebitda_is')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('net_interest_income_is')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('non_interest_income_is')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('total_income_is')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('total_operating_expenses_is')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('net_operating_income_is')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('net_income_before_tax_or_zakat_is')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('net_income_before_minority_is')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('minority_interest_is')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                            ]), // income statment tab  ,

                        Tabs\Tab::make('Balance Sheet')
                            ->schema([

                                Forms\Components\Repeater::make('total_assets_bs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('total_liabilities_bs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('shareholders_equity_bs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('total_liabilities_equity_bs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('cash_equivalents_bs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('accounts_receivables_bs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('inventory_bs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('net_fixed_assets_bs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('other_non_current_assets_bs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('short_term_debt_bs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('long_term_debt_bs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('payables_bs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('current_liabilities_bs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('other_liabilities_bs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('other_assets_bs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('cash_due_from_cb_bs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('due_from_banks_bs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('due_to_banks_bs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('investments_bs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('net_loans_bs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('deposits_bs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('borrowings_bs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),




                            ]), //Balance Sheet Tab

                        Tabs\Tab::make('Cash Flow Summary')
                            ->schema([

                                Forms\Components\Repeater::make('operating_cash_flow_cfs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),


                                Forms\Components\Repeater::make('working_capital_changes_cfs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),


                                Forms\Components\Repeater::make('cash_flow_from_operations_cfs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),


                                Forms\Components\Repeater::make('cash_flow_from_investing_cfs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('cash_flow_from_financing_cfs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('net_change_in_cash_flow_cfs')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),


                            ]), // Cash Flow Summary ,


                        Tabs\Tab::make('Growth Ratios')
                            ->schema([

                                Forms\Components\Repeater::make('net_income_gr')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('revenue_gr')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('ebitda_gr')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('ebit_gr')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('assets_gr')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('loans_gr')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('deposits_gr')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),



                            ]), // Growth Ratios
                        Tabs\Tab::make('Profitability')
                            ->schema([
                                Forms\Components\Repeater::make('gross_margin_p')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('ebitda_margin_p')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('net_margin_p')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('nim_p')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('cost_to_income_p')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('roe_p')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('roa_p')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                            ]), // Profitability tab
                        Tabs\Tab::make('Liquidity')
                            ->schema([
                                Forms\Components\Repeater::make('total_debt_to_equity_l')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('net_debt_to_equity_l')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('net_debt_cash_l')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                                Forms\Components\Repeater::make('net_debt_to_ebitda_l')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),


                            ]), // Liquidity
                        Tabs\Tab::make('LAQC')
                            ->schema([

                                Forms\Components\Repeater::make('loans_to_deposit_laqc')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('npl_ratio_laqc')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('cor_bps_laqc')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('coverage_laqc')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('total_car_laqc')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('tier_1_capital_laqc')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                            ]), // LAQC
                        Tabs\Tab::make('Data & Valuation')
                            ->schema([

                                Forms\Components\Repeater::make('eps_dv')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('bvps_dv')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('dps_dv')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('p_e_dv')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('p_b_v_dv')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('dividend_yield_dv')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                                Forms\Components\Repeater::make('ev_ebitda_dv')
                                    ->schema([
                                        Forms\Components\TextInput::make('previous_year'),
                                        Forms\Components\TextInput::make('current_year'),
                                        Forms\Components\TextInput::make('current_year_1'),
                                        Forms\Components\TextInput::make('current_year_2')
                                    ])->columns(4)->addable(false)->reorderable(false)->deletable(false),

                            ]), // Data & Valuation
                        Tabs\Tab::make('Auto Calculated')
                        ->schema([
                            Forms\Components\Repeater::make('p_e_dv')
                                ->schema([
                                    Forms\Components\TextInput::make('previous_year')->readOnly(),
                                    Forms\Components\TextInput::make('current_year')->readOnly(),
                                    Forms\Components\TextInput::make('current_year_1')->readOnly(),
                                    Forms\Components\TextInput::make('current_year_2')->readOnly()
                                ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                            Forms\Components\Repeater::make('p_b_v_dv')
                                ->schema([
                                    Forms\Components\TextInput::make('previous_year')->readOnly(),
                                    Forms\Components\TextInput::make('current_year')->readOnly(),
                                    Forms\Components\TextInput::make('current_year_1')->readOnly(),
                                    Forms\Components\TextInput::make('current_year_2')->readOnly()
                                ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                            Forms\Components\Repeater::make('dividend_yield_dv')
                                ->schema([
                                    Forms\Components\TextInput::make('previous_year')->readOnly(),
                                    Forms\Components\TextInput::make('current_year')->readOnly(),
                                    Forms\Components\TextInput::make('current_year_1')->readOnly(),
                                    Forms\Components\TextInput::make('current_year_2')->readOnly()
                                ])->columns(4)->addable(false)->reorderable(false)->deletable(false),
                            Forms\Components\Repeater::make('ev_ebitda_dv')
                                ->schema([
                                    Forms\Components\TextInput::make('previous_year')->readOnly(),
                                    Forms\Components\TextInput::make('current_year')->readOnly(),
                                    Forms\Components\TextInput::make('current_year_1')->readOnly(),
                                    Forms\Components\TextInput::make('current_year_2')->readOnly()
                                ])->columns(4)->addable(false)->reorderable(false)->deletable(false),


                        ])


                    ])->columns(1),  // all tabs ,
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Macro.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('Type.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bloomberg')
                    ->searchable(),
                Tables\Columns\TextColumn::make('closing_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
