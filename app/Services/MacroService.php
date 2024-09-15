<?php

namespace App\Services;

use App\Models\Daily;
use App\Models\Macro;
use App\Models\MacroDaily;
use App\Traits\GlobalWidgets;
use Carbon\Carbon;

class MacroService
{
    use GlobalWidgets;


    public function getDailiesForSingleMacro($limit, $macroId)
    {
        return MacroDaily::where("macro_id", $macroId)
            ->with(['Source:id,name', 'Macro:id,name,flag'])
            ->latest('created_at')
            ->take($limit)
            ->get();

    }

    public function getDaily($keyword, $selectedDate)
    {

        $macros = Macro::select(["id", "name", "flag"])->get();
        $collectedDaily = [];
        if (!empty ($keyword)) {
            foreach ($macros as $macro) {
                $macroDaily = MacroDaily::with(['Source:name', 'Macro:id,name,flag'])
                    ->where("macro_id", $macro->id)
                    ->where(function ($query) use ($keyword) {
                        $query->where('title', 'like', '%' . $keyword . '%')
                            ->orWhere('desc', 'like', '%' . $keyword . '%');
                    })
                    ->get();

                $companyDaily = Daily::select("dailies.*")
                    ->join('companies', 'dailies.company_id', '=', 'companies.id')
                    ->join('macros', 'companies.macro_id', '=', 'macros.id')
                    ->with(['Source:name', 'Company:id,name,macro_id', 'Company.Macro:id,name'])
                    ->where('companies.macro_id', $macro->id)
                    ->where(function ($query) use ($keyword) {
                        $query->where('dailies.title', 'like', '%' . $keyword . '%')
                            ->orWhere('dailies.desc', 'like', '%' . $keyword . '%');
                    })
                    ->get();

                $daily = $this->dailyWidget($macroDaily, "macro");
                $daily = array_merge($daily, $this->dailyWidget($companyDaily, "company"));

                $singleData = [
                    "name" => $macro->name,
                    "flag" => url('storage') . '/' . $macro->flag,
                    "daily" => $daily

                ];
                $collectedDaily[] = $singleData;

            }

            return $collectedDaily;
        }

        // Get Results By Selected Date
        foreach ($macros as $one_macro) {

            $macroDaily = MacroDaily::with(['Source:name', 'Macro:id,name,flag'])
                ->where("macro_id", $one_macro->id)
                ->whereDate('published_at', $selectedDate)
                ->get();

            //Company Dailies
            $companyDaily = Daily::select("dailies.*")
                ->join('companies', 'dailies.company_id', '=', 'companies.id')
                ->join('macros', 'companies.macro_id', '=', 'macros.id')
                ->with(['Source:name', 'Company:id,name,macro_id', 'Company.Macro:id,name'])
                ->where('companies.macro_id', $one_macro->id)
                ->whereDate('dailies.published_at', $selectedDate)
                ->get();

            $daily = $this->dailyWidget($macroDaily, "macro");
            $daily = array_merge($daily,  $this->dailyWidget($companyDaily, "company"));


            $singleData = [
                "name" => $one_macro->name,
                "flag" => url('storage') . '/' . $one_macro->flag,
                "daily" => $daily

            ];
            $collectedDaily[] = $singleData;
        }
        $empty = true ;
        foreach($collectedDaily as $one_macro){
            if(!empty($one_macro['daily'] )){
                $empty = false ;
                break;
            }
        }

        if($empty && $selectedDate == Carbon::today()->toDateString() ) {
            $collectedDaily = [];
            foreach ($macros as $one_macro) {
                $macroDaily = MacroDaily::Select("title", "desc",  "macro_id", "published_at")
                    ->with(['Source:name', 'Macro:id,name,flag'])
                    ->where("macro_id", $one_macro->id)
                    ->orderBy('published_at', 'desc')
                    ->take(5)
                    ->get();

                //Company Dailies
                $companyDaily = Daily::select("dailies.title", "dailies.desc" , "dailies.company_id", "dailies.published_at")
                    ->join('companies', 'dailies.company_id', '=', 'companies.id')
                    ->join('macros', 'companies.macro_id', '=', 'macros.id')
                    ->with(['Source:name', 'Company:id,name,macro_id', 'Company.Macro:id,name'])
                    ->where('companies.macro_id', $one_macro->id)
                    ->orderBy('dailies.published_at', 'desc')
                    ->take(5)
                    ->get();

                $daily = $this->dailyWidget($macroDaily, "macro");
                $daily = array_merge($daily, $this->dailyWidget($companyDaily, "company"));


                $singleData = [
                    "name" => $one_macro->name,
                    "flag" => url('storage') . '/' . $one_macro->flag,
                    "daily" => $daily

                ];

                $collectedDaily[] = $singleData;

            }
        }

        return $collectedDaily ;


    }

    public function getDailyNew($keyword , $date_from , $date_to ){

    }

    public function formatMacroForecast($macroObject)
    {

        $real_sector = [];
        $real_sector[] = [
            "name" => "Real GDP growth (%)",
            "previous_year_2" => $macroObject->real_gdp_growth_py_2,
            "previous_year_1" => $macroObject->real_gdp_growth_py_1,
            "previous_year" => $macroObject->real_gdp_growth_py,
            "current_year" => $macroObject->real_gdp_growth_cy,
            "current_year_1" => $macroObject->real_gdp_growth_cy_1
        ];
        $real_sector[] = [
            "name" => "GDP/capita, current (USD)",
            "previous_year_2" => $macroObject->gdp_per_capita_py_2,
            "previous_year_1" => $macroObject->gdp_per_capita_py_1,
            "previous_year" => $macroObject->gdp_per_capita_py,
            "current_year" => $macroObject->gdp_per_capita_cy,
            "current_year_1" => $macroObject->gdp_per_capita_cy_1
        ];
        $real_sector[] = [
            "name" => "Population (mn)",
            "previous_year_2" => $macroObject->population_py_2,
            "previous_year_1" => $macroObject->population_py_1,
            "previous_year" => $macroObject->population_py,
            "current_year" => $macroObject->population_cy,
            "current_year_1" => $macroObject->population_cy_1
        ];
        $real_sector[] = [
            "name" => "Unemployment rate (%)",
            "previous_year_2" => $macroObject->unemployment_rate_py_2,
            "previous_year_1" => $macroObject->unemployment_rate_py_1,
            "previous_year" => $macroObject->unemployment_rate_py,
            "current_year" => $macroObject->unemployment_rate_cy,
            "current_year_1" => $macroObject->unemployment_rate_cy_1
        ];

        if ($macroObject->real_hydrocarbon_growth_py_2 != null) {
            $real_sector[] = [
                "name" => "Real hydrocarbon growth (%)",
                "previous_year_2" => $macroObject->real_hydrocarbon_growth_py_2,
                "previous_year_1" => $macroObject->real_hydrocarbon_growth_py_1,
                "previous_year" => $macroObject->real_hydrocarbon_growth_py,
                "current_year" => $macroObject->real_hydrocarbon_growth_cy,
                "current_year_1" => $macroObject->real_hydrocarbon_growth_cy_1
            ];
            $real_sector[] = [
                "name" => "Real non-hydrocarbon growth (%)",
                "previous_year_2" => $macroObject->real_non_hydrocarbon_growth_py_2,
                "previous_year_1" => $macroObject->real_non_hydrocarbon_growth_py_1,
                "previous_year" => $macroObject->real_non_hydrocarbon_growth_py,
                "current_year" => $macroObject->real_non_hydrocarbon_growth_cy,
                "current_year_1" => $macroObject->real_non_hydrocarbon_growth_cy_1
            ];
        }

        $fiscal_sector = [];
        $fiscal_sector[] = [
            "name" => "Government revenues (" . $macroObject->currency . "bn)",
            "previous_year_2" => $macroObject->government_revenues_py_2,
            "previous_year_1" => $macroObject->government_revenues_py_1,
            "previous_year" => $macroObject->government_revenues_py,
            "current_year" => $macroObject->government_revenues_cy,
            "current_year_1" => $macroObject->government_revenues_cy_1
        ];

        $fiscal_sector[] = [
            "name" => "Government expenditure (" . $macroObject->currency . "bn)",
            "previous_year_2" => $macroObject->government_expenditure_py_2,
            "previous_year_1" => $macroObject->government_expenditure_py_1,
            "previous_year" => $macroObject->government_expenditure_py,
            "current_year" => $macroObject->government_expenditure_cy,
            "current_year_1" => $macroObject->government_expenditure_cy_1
        ];
        $fiscal_sector[] = [
            "name" => "Fiscal balance (% of GDP)",
            "previous_year_2" => $macroObject->fiscal_balance_py_2,
            "previous_year_1" => $macroObject->fiscal_balance_py_1,
            "previous_year" => $macroObject->fiscal_balance_py,
            "current_year" => $macroObject->fiscal_balance_cy,
            "current_year_1" => $macroObject->fiscal_balance_cy_1
        ];
        $fiscal_sector[] = [
            "name" => "Debt (% of GDP)",
            "previous_year_2" => $macroObject->debit_py_2,
            "previous_year_1" => $macroObject->debit_py_1,
            "previous_year" => $macroObject->debit_py,
            "current_year" => $macroObject->debit_cy,
            "current_year_1" => $macroObject->debit_cy_1
        ];

        $external_sector = [];
        $external_sector[] = [
            "name" => "Trade balance (" . $macroObject->currency . "bn)",
            "previous_year_2" => $macroObject->trade_balance_py_2,
            "previous_year_1" => $macroObject->trade_balance_py_1,
            "previous_year" => $macroObject->trade_balance_py,
            "current_year" => $macroObject->trade_balance_cy,
            "current_year_1" => $macroObject->trade_balance_cy_1
        ];
        $external_sector[] = [
            "name" => "Hydrocarbon exports (" . $macroObject->currency . "bn)",
            "previous_year_2" => $macroObject->hydrocarbon_exports_py_2,
            "previous_year_1" => $macroObject->hydrocarbon_exports_py_1,
            "previous_year" => $macroObject->hydrocarbon_exports_py,
            "current_year" => $macroObject->hydrocarbon_exports_cy,
            "current_year_1" => $macroObject->hydrocarbon_exports_cy_1
        ];
        $external_sector[] = [
            "name" => "Current account balance (" . $macroObject->currency . "bn)",
            "previous_year_2" => $macroObject->current_account_balance_py_2,
            "previous_year_1" => $macroObject->current_account_balance_py_1,
            "previous_year" => $macroObject->current_account_balance_py,
            "current_year" => $macroObject->current_account_balance_cy,
            "current_year_1" => $macroObject->current_account_balance_cy_1
        ];
        $external_sector[] = [
            "name" => "Current account balance (% of GDP)",
            "previous_year_2" => $macroObject->current_account_balance_gdp_py_2,
            "previous_year_1" => $macroObject->current_account_balance_gdp_py_1,
            "previous_year" => $macroObject->current_account_balance_gdp_py,
            "current_year" => $macroObject->current_account_balance_gdp_cy,
            "current_year_1" => $macroObject->current_account_balance_gdp_cy_1
        ];
        $monetary_section = [];
        $monetary_section[] = [
            "name" => "Inflation (%)",
            "previous_year_2" => $macroObject->inflation_py_2,
            "previous_year_1" => $macroObject->inflation_py_1,
            "previous_year" => $macroObject->inflation_py,
            "current_year" => $macroObject->inflation_cy,
            "current_year_1" => $macroObject->inflation_cy_1
        ];
        $monetary_section[] = [
            "name" => "Growth in private sector credit (%)",
            "previous_year_2" => $macroObject->private_sector_credit_growth_py_2,
            "previous_year_1" => $macroObject->private_sector_credit_growth_py_1,
            "previous_year" => $macroObject->private_sector_credit_growth_py,
            "current_year" => $macroObject->private_sector_credit_growth_cy,
            "current_year_1" => $macroObject->private_sector_credit_growth_cy_1
        ];
        if ($macroObject->discount_rate_py_2 != null) {
            $monetary_section[] = [
                "name" => "Discount rate (%)",
                "previous_year_2" => $macroObject->discount_rate_py_2,
                "previous_year_1" => $macroObject->discount_rate_py_1,
                "previous_year" => $macroObject->discount_rate_py,
                "current_year" => $macroObject->discount_rate_cy,
                "current_year_1" => $macroObject->discount_rate_cy_1
            ];
        }

        $forecasts = [];
        $forecasts[] = ["category_name" => "Real sector", "data" => $real_sector];
        $forecasts[] = ["category_name" => "Fiscal sector", "data" => $fiscal_sector];
        $forecasts[] = ["category_name" => "External sector", "data" => $external_sector];
        $forecasts[] = ["category_name" => "Monetary sector", "data" => $monetary_section];

        if ($macroObject->oil_production_py_2 != null) {
            $hydrocarbon = [];
            $hydrocarbon[] = [
                "name" => "Oil production (mn bpd)",
                "previous_year_2" => $macroObject->oil_production_py_2,
                "previous_year_1" => $macroObject->oil_production_py_1,
                "previous_year" => $macroObject->oil_production_py,
                "current_year" => $macroObject->oil_production_cy,
                "current_year_1" => $macroObject->oil_production_cy_1
            ];
            $hydrocarbon[] = [
                "name" => "Brent price (USD/bbl)",
                "previous_year_2" => $macroObject->brent_price_py_2,
                "previous_year_1" => $macroObject->brent_price_py_1,
                "previous_year" => $macroObject->brent_price_py,
                "current_year" => $macroObject->brent_price_cy,
                "current_year_1" => $macroObject->brent_price_cy_1
            ];
            $hydrocarbon[] = [
                "name" => "Natural gas production (mn tpa)",
                "previous_year_2" => $macroObject->natural_gas_production_py_2,
                "previous_year_1" => $macroObject->natural_gas_production_py_1,
                "previous_year" => $macroObject->natural_gas_production_py,
                "current_year" => $macroObject->natural_gas_production_cy,
                "current_year_1" => $macroObject->natural_gas_production_cy_1
            ];


            $forecasts[] = ["category_name" => "Hydrocarbon indicators", "data" => $hydrocarbon];
        }

        return $forecasts;


    }

}
