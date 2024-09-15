<?php
namespace App\Services;

use App\Models\Company;
use App\Models\CompanyHistory;
class CompanyService{

    // Logic Functions for Coverage Universe
    function handle_number_format($number)
    {
        $number =  floatval($number);
        if($number < 0 ){
            $is_negative = true ;
        }else{
            $is_negative = false ;
        }

        $number = abs($number) ;
        $point_loc = strpos($number , '.') ;

        if($point_loc == 1){
            $number = round($number , 2);
            $number = number_format($number , 2);

        }else if($point_loc == 2){
            $number = round($number , 1);
            $number = number_format($number , 1);
        }else{
            $number = round($number);
            $number = number_format($number);
        }


        $point_loc = strpos($number , '.') ;
        $comma_loc = strpos($number , ',');
        if($point_loc == '' && $comma_loc == ''){
            $length =  strlen($number) ;
            if($length == 1){
                $number = $number . ".00" ;
            }else if($length == "2"){
                $number = $number . ".0" ;
            }

        }

        if($is_negative){
            $number = "(" . $number . ")" ;
        }

        return $number ;
    }
    function handle_equity_record($record){

        $record[0]['previous_year'] =  $this->handle_number_format($record[0]['previous_year']);
        $record[0]['current_year'] =  $this->handle_number_format($record[0]['current_year']);
        $record[0]['current_year_1'] =  $this->handle_number_format($record[0]['current_year_1']);
        $record[0]['current_year_2'] =  $this->handle_number_format($record[0]['current_year_2']);

        return $record ;


    }


    public function getCompaniesForCoverageUniverse( $keyword, $page, $perPage, $wishlist, $macros, $sectors , $user)
    {
        if(!empty($keyword)){
            return Company::select(
                "id", "name", "logo", "macro_id", "sector_id" , "bloomberg", "reuters", "market_cap",
                "market_cap_local", "adtv", "tp_currency", "target_price", "closing_price", "potential_return" , "recommendation",
            )
                ->with("Macro:id,name")
                ->with("Sector:id,name")
                ->where(function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->paginate($perPage, ['*'], 'page', $page);
        }
        if($wishlist){
            return $user->Company()->paginate($perPage, ['*'], 'page', $page);
        }

        return  Company::select(
            "id", "name", "logo", "macro_id", "sector_id", "bloomberg", "reuters",
            "market_cap", "market_cap_local", "adtv", "tp_currency", "target_price", "closing_price", "potential_return" ,"recommendation",
        )
            ->with("Macro:id,name")
            ->with("Sector:id,name")
            ->when(!empty($sectors), function ($query) use ($sectors) {
                $query->whereHas('Sector', function ($subQuery) use ($sectors) {
                    $subQuery->whereIn('id', $sectors);
                });
            })
            ->when(!empty($macros), function ($query) use ($macros) {
                $query->whereHas('Macro', function ($subQuery) use ($macros) {
                    $subQuery->whereIn('id', $macros);
                });
            })
            ->paginate($perPage, ['*'], 'page', $page);

    }

    public function formatCompaniesForCoverageUniverse($companies , $user){

        $formatCompanies = [];
        foreach ($companies as $singleCompany) {
            $companyParameters = [];
            $companyParameters[] = ["title" => "Bloomberg", "value" => $singleCompany->bloomberg];
            $companyParameters[] = ["title" => "Reuters", "value" => $singleCompany->reuters];
            $companyParameters[] = ['title' => "Country", "value" => $singleCompany["macro"]->name];
            $companyParameters[] = ['title' => "Sector", "value" => $singleCompany["sector"]->name];
            $companyParameters[] = ['title' => "Market cap (USDmn)", "value" => $this->handle_number_format($singleCompany->market_cap)];
            $companyParameters[] = ['title' => "Market cap (LCYmn)", "value" => $this->handle_number_format($singleCompany->market_cap_local)];
            $companyParameters[] = ['title' => "6M ADTV (USDmn)", "value" => $this->handle_number_format($singleCompany->adtv)];
            $companyParameters[] = ['title' => "Rating", "value" => $singleCompany->recommendation];
            $companyParameters[] = ['title' => "Currency", "value" => $singleCompany->tp_currency];
            $companyParameters[] = ['title' => "TP", "value" => $this->handle_number_format($singleCompany->target_price)];
            $companyParameters[] = ['title' => "Closing price", "value" => $this->handle_number_format($singleCompany->closing_price)];
            $companyParameters[] = ["title" => "Upside/downside potential (%)", "value" => $this->handle_number_format($singleCompany->potential_return)];

            $data = [
                "id" => $singleCompany->id,
                "liked" =>  $user->Company()->wherePivot('company_id', $singleCompany->id)->exists(),
                "name" => $singleCompany->name,
                "logo" => url('/storage') . '/' . $singleCompany->logo,
                "parameters" => $companyParameters,
            ];
            $formatCompanies [] = $data;
        }

        return $formatCompanies ;

    }

    // Logic Functions for Coverage Page
    public function getCompaniesForCoverage($keyword , $perPage , $page) {

        if (!empty($keyword)) {
            return Company::with(["Macro:id,name", "Sector:id,name"])
                ->where('name', 'like', '%' . $keyword . '%')
                ->get();
        }

        if ($perPage == -1) {
            return Company::with(["Macro:id,name", "Sector:id,name"])->get();
        }

        return Company::with(["Macro:id,name", "Sector:id,name"])
            ->paginate($perPage, ['*'], 'page', $page);

    }

    public function formatCompaniesForCoverage($companies) {

        $currentYear = date("Y");
        $nextYear = date("Y", strtotime("+1 year"));
        $yearAfterNext = date("Y", strtotime("+2 years"));

        return $companies->map(function ($company) use ($currentYear, $nextYear, $yearAfterNext) {
            $companyParameters = [
                ["title" => "COMPANY", "value" => $company->name],
                ["title" => "BBG TICKER", "value" => $company->bloomberg],
                ["title" => "COUNTRY", "value" => $company->macro->name],
                ["title" => "SECTOR", "value" => $company->sector->name],
                ["title" => "MARKET CAP (USD)", "value" => $this->handle_number_format($company->market_cap)],
                ["title" => "6M ADTV (USDmn)", "value" =>$this->handle_number_format($company->adtv) ],
                ["title" => "STOCK RATING", "value" => $company->recommendation],
                ["title" => "TP CURRENCY", "value" => $company->tp_currency],
                ["title" => "TP", "value" => $this->handle_number_format($company->target_price)],
                ["title" => "CLOSING PRICE", "value" => $this->handle_number_format($company->closing_price)],
                ["title" => "UPSIDE (DOWNSIDE) POTENTIAL", "value" => $this->handle_number_format($company->potential_return)],

                ["title" => "$currentYear P/E (X)", "value" => $this->handle_number_format($company->p_e_dv[0]["current_year"] , 2)],
                ["title" => "$nextYear P/E (X)", "value" => $this->handle_number_format($company->p_e_dv[0]["current_year_1"] , 2)],
                ["title" => "$yearAfterNext P/E (X)", "value" => $this->handle_number_format($company->p_e_dv[0]["current_year_2"] , 2)],

                ["title" => "$currentYear P/BV (X)", "value" => $this->handle_number_format($company->p_b_v_dv[0]["current_year"] , 2)],
                ["title" => "$nextYear P/BV (X)", "value" => $this->handle_number_format($company->p_b_v_dv[0]["current_year_1"] , 2)],
                ["title" => "$yearAfterNext P/BV (X)", "value" => $this->handle_number_format($company->p_b_v_dv[0]["current_year_2"] , 2)],

                ["title" => "$currentYear EV/EBITDA", "value" => $this->handle_number_format($company->ev_ebitda_dv[0]["current_year"] , 2)],
                ["title" => "$nextYear EV/EBITDA", "value" => $this->handle_number_format($company->ev_ebitda_dv[0]["current_year_1"] , 2)],
                ["title" => "$yearAfterNext EV/EBITDA", "value" => $this->handle_number_format($company->ev_ebitda_dv[0]["current_year_2"] , 2)],

                ["title" => "$currentYear DIVIDEND YIELD", "value" => $this->handle_number_format($company->dividend_yield_dv[0]["current_year"] , 2)],
                ["title" => "$nextYear DIVIDEND YIELD", "value" => $this->handle_number_format($company->dividend_yield_dv[0]["current_year_1"] , 2)],
                ["title" => "$yearAfterNext DIVIDEND YIELD", "value" => $this->handle_number_format($company->dividend_yield_dv[0]["current_year_2"] , 2)],

                ["title" => "$currentYear EBITDA GROWTH", "value" => $this->handle_number_format($company->ebitda_gr[0]["current_year"])],
                ["title" => "$nextYear EBITDA GROWTH", "value" => $this->handle_number_format($company->ebitda_gr[0]["current_year_1"])],
                ["title" => "$yearAfterNext EBITDA GROWTH", "value" => $this->handle_number_format($company->ebitda_gr[0]["current_year_2"])],

                ["title" => "$currentYear NET INCOME GROWTH", "value" => $this->handle_number_format($company->net_income_gr[0]["current_year"])],
                ["title" => "$nextYear NET INCOME GROWTH", "value" => $this->handle_number_format($company->net_income_gr[0]["current_year_1"])],
                ["title" => "$yearAfterNext NET INCOME GROWTH", "value" => $this->handle_number_format($company->net_income_gr[0]["current_year_2"])],
            ];

            return [
                "id" => $company->id,
                "logo" => url('/storage/' . $company->logo),
                "parameters" => $companyParameters,
            ];
        })->toArray();
    }

    //Single Company Logic Functions
    public function formatSingleCompany($companyObject){

        $currency = $companyObject->tp_currency ;
        $exceptions = ["FERTIGLB" , "ORAS EY" , "EKHO EY"] ;
        if(in_array($companyObject->bloomberg , $exceptions)){
            $currency = "USD";
        }
        $companyParameters = [];
        $companyParameters[] = ["title" => "BLOOMBERG", "value" => $companyObject->bloomberg];
        $companyParameters[] = ["title" => "RIC", "value" => $companyObject->reuters];
        $companyParameters[] = ['title' => "COUNTRY", "value" => $companyObject["macro"]->name];
        $companyParameters[] = ['title' => "MARKET CAP (USDmn)", "value" => $this->handle_number_format($companyObject->market_cap)];
        $companyParameters[] = ['title' => "MARKET CAP (LCYmn)", "value" => $this->handle_number_format($companyObject->market_cap_local)];
        $companyParameters[] = ['title' => "6M ADTV (USDmn)", "value" => $this->handle_number_format($companyObject->adtv)];
        $companyParameters[] = ['title' => "RATING", "value" => $companyObject->recommendation];
        $companyParameters[] = ['title' => "CURRENCY", "value" => $companyObject->tp_currency];
        $companyParameters[] = ['title' => "TP", "value" => $this->handle_number_format($companyObject->target_price)];
        $companyParameters[] = ['title' => "CLOSING PRICE", "value" => $this->handle_number_format($companyObject->closing_price)];
        $companyParameters[] = ["title" => "UPSIDE/DOWNSIDE POTENTIAL (%)", "value" => $this->handle_number_format($companyObject->potential_return)];

        if ($companyObject["type"]->name == "Company") {
            $incomeStatus = [];
            $incomeStatus[] = ["title" => "Revenue", "data" => $this->handle_equity_record($companyObject->revenue_is)];
            $incomeStatus[] = ["title" => "Cost of sales", "data" => $this->handle_equity_record($companyObject->cost_of_sale_is)];
            $incomeStatus[] = ["title" => "Gross profit", "data" => $this->handle_equity_record($companyObject->gross_profit_is)];
            $incomeStatus[] = ["title" => "SG&A", "data" => $this->handle_equity_record($companyObject->sg_a_is)];
            $incomeStatus[] = ["title" => "EBIT", "data" => $this->handle_equity_record($companyObject->ebit_is)];
            $incomeStatus[] = ["title" => "D&A", "data" => $this->handle_equity_record($companyObject->d_a_is)];
            $incomeStatus[] = ["title" => "EBITDA", "data" => $this->handle_equity_record($companyObject->ebitda_is)];
            $incomeStatus[] = ["title" => "Taxes or zakat", "data" => $this->handle_equity_record($companyObject->taxes_or_zakat_is)];
            $incomeStatus[] = ["title" => "Net income", "data" => $this->handle_equity_record($companyObject->net_income_is)];



            $balanceSheet = [];
            $balanceSheet[] = ["title" => "Cash & cash equivalents", "data" => $this->handle_equity_record($companyObject->cash_equivalents_bs)];
            $balanceSheet[] = ["title" => "Accounts receivables", "data" => $this->handle_equity_record($companyObject->accounts_receivables_bs)];
            $balanceSheet[] = ["title" => "Inventory", "data" => $this->handle_equity_record($companyObject->inventory_bs)];
            $balanceSheet[] = ["title" => "Net fixed assets", "data" => $this->handle_equity_record($companyObject->net_fixed_assets_bs)];
            $balanceSheet[] = ["title" => "Other assets", "data" => $this->handle_equity_record($companyObject->other_non_current_assets_bs)];
            $balanceSheet[] = ["title" => "Total assets", "data" => $this->handle_equity_record($companyObject->total_assets_bs)];
            $balanceSheet[] = ["title" => "Short-term debt", "data" => $this->handle_equity_record($companyObject->short_term_debt_bs)];
            $balanceSheet[] = ["title" => "Payables", "data" => $this->handle_equity_record($companyObject->payables_bs)];
            $balanceSheet[] = ["title" => "Current liabilities", "data" => $this->handle_equity_record($companyObject->current_liabilities_bs)];
            $balanceSheet[] = ["title" => "Long-term debt", "data" => $this->handle_equity_record($companyObject->long_term_debt_bs)];
            $balanceSheet[] = ["title" => "Total liabilities", "data" => $this->handle_equity_record($companyObject->total_liabilities_bs)];
            $balanceSheet[] = ["title" => "Shareholders equity", "data" => $this->handle_equity_record($companyObject->shareholders_equity_bs)];
            $balanceSheet[] = ["title" => "Total liabilities and shareholders’ equity", "data" => $this->handle_equity_record($companyObject->total_liabilities_equity_bs)];


            $cashFlowSummary = [];
            $cashFlowSummary[] = ["title" => "Operating cash flow", "data" => $this->handle_equity_record($companyObject->operating_cash_flow_cfs)];
            $cashFlowSummary[] = ["title" => "Working capital changes", "data" => $this->handle_equity_record($companyObject->working_capital_changes_cfs)];
            $cashFlowSummary[] = ["title" => "Cash flow from operations", "data" => $this->handle_equity_record($companyObject->cash_flow_from_operations_cfs)];
            $cashFlowSummary[] = ["title" => "Cash flow from investing", "data" => $this->handle_equity_record($companyObject->cash_flow_from_investing_cfs)];
            $cashFlowSummary[] = ["title" => "Cash flow from financing", "data" => $this->handle_equity_record($companyObject->cash_flow_from_financing_cfs)];
            $cashFlowSummary[] = ["title" => "Net change in cash flow", "data" => $this->handle_equity_record($companyObject->net_change_in_cash_flow_cfs)];

            $growthRate = [];
            $growthRate[] = ["title" => "Revenue", "data" => $this->handle_equity_record($companyObject->revenue_gr)];
            $growthRate[] = ["title" => "EBITDA", "data" => $this->handle_equity_record($companyObject->ebitda_gr)];
            $growthRate[] = ["title" => "EBIT", "data" => $this->handle_equity_record($companyObject->ebit_gr)];
            $growthRate[] = ["title" => "Net income", "data" => $this->handle_equity_record($companyObject->net_income_gr)];


            $profitability = [];
            $profitability[] = ["title" => "Gross margin", "data" => $this->handle_equity_record($companyObject->gross_margin_p)];
            $profitability[] = ["title" => "EBITDA margin", "data" => $this->handle_equity_record($companyObject->ebitda_margin_p)];
            $profitability[] = ["title" => "Net margin", "data" => $this->handle_equity_record($companyObject->net_margin_p)];

            $liquidity = [];
            $liquidity[] = ["title" => "Total debt-to-equity", "data" => $this->handle_equity_record($companyObject->total_debt_to_equity_l)];
            $liquidity[] = ["title" => "Net debt-to-equity", "data" => $this->handle_equity_record($companyObject->net_debt_to_equity_l)];
            $liquidity[] = ["title" => "Net debt (cash) " . "(". $companyObject->tp_currency . "mn)", "data" => $this->handle_equity_record($companyObject->net_debt_cash_l)];
            $liquidity[] = ["title" => "Net debt-to-EBITDA", "data" => $this->handle_equity_record($companyObject->net_debt_to_ebitda_l)];

            $dataValuation = [];
            $dataValuation[] = ["title" => "EPS", "data" => $this->handle_equity_record($companyObject->eps_dv)];
            $dataValuation[] = ["title" => "BVPS", "data" => $this->handle_equity_record($companyObject->bvps_dv)];
            $dataValuation[] = ["title" => "DPS", "data" => $this->handle_equity_record($companyObject->dps_dv)];
            $dataValuation[] = ["title" => "P/E (x)", "data" => $this->handle_equity_record($companyObject->p_e_dv)];
            $dataValuation[] = ["title" => "P/BV (x)", "data" => $this->handle_equity_record($companyObject->p_b_v_dv)];
            $dataValuation[] = ["title" => "EV/EBITDA (x)", "data" => $this->handle_equity_record($companyObject->ev_ebitda_dv)];
            $dataValuation[] = ["title" => "Dividend yield (x)", "data" => $this->handle_equity_record($companyObject->dividend_yield_dv)];


            $summaryValuation = [];
            $summaryValuation[] = [ "parameter" => "(". $currency.  "mn)" , "category_name" => "Income statement", "data" => $incomeStatus ];
            $summaryValuation[] = [ "parameter" => "(". $currency.  "mn)" , "category_name" => "Balance sheet", "data" => $balanceSheet ];
            $summaryValuation[] = ["parameter" => "(". $currency.  "mn)"  , "category_name" => "Cash flow summary", "data" => $cashFlowSummary , ];
            $summaryValuation[] = ["parameter" => "(%)" , "category_name" => "Growth rate", "data" => $growthRate ,  ];
            $summaryValuation[] = ["parameter" => "(%)" , "category_name" => "Profitability", "data" => $profitability ,  ];
            $summaryValuation[] = [ "parameter" => "(x)"  , "category_name" => "Liquidity", "data" => $liquidity ,];
            $summaryValuation[] = [ "parameter" => "(". $currency.  ")"  , "category_name" => "Per share data & valuation", "data" => $dataValuation ];

        } else {

            $incomeStatus = [];

            $incomeStatus[] = ["title" => "Net interest income", "data" => $this->handle_equity_record($companyObject->net_interest_income_is)];
            $incomeStatus[] = ["title" => "Non-interest income", "data" => $this->handle_equity_record($companyObject->non_interest_income_is)];
            $incomeStatus[] = ["title" => "Total income", "data" => $this->handle_equity_record($companyObject->total_income_is)];
            $incomeStatus[] = ["title" => "Total operating expenses", "data" => $this->handle_equity_record($companyObject->total_operating_expenses_is)];
            $incomeStatus[] = ["title" => "Net operating income", "data" => $this->handle_equity_record($companyObject->net_operating_income_is)];
            $incomeStatus[] = ["title" => "Provision expense", "data" => $this->handle_equity_record($companyObject->provision_expense_is)];
            $incomeStatus[] = ["title" => "Net income before tax/zakat", "data" => $this->handle_equity_record($companyObject->net_income_before_tax_or_zakat_is)];
            $incomeStatus[] = ["title" => "Taxes or zakat", "data" => $this->handle_equity_record($companyObject->taxes_or_zakat_is)];
            $incomeStatus[] = ["title" => "Net income before minority", "data" => $this->handle_equity_record($companyObject->net_income_before_minority_is)];
            $incomeStatus[] = ["title" => "Minority interest", "data" => $this->handle_equity_record($companyObject->minority_interest_is)];
            $incomeStatus[] = ["title" => "Net income", "data" => $this->handle_equity_record($companyObject->net_income_is)];


            $balanceSheet = [];

            $balanceSheet[] = ["title" => "Cash & due from CB", "data" => $this->handle_equity_record($companyObject->cash_due_from_cb_bs)];
            $balanceSheet[] = ["title" => "Due from banks", "data" => $this->handle_equity_record($companyObject->due_from_banks_bs)];
            $balanceSheet[] = ["title" => "Investments", "data" => $this->handle_equity_record($companyObject->investments_bs)];
            $balanceSheet[] = ["title" => "Net loans", "data" => $this->handle_equity_record($companyObject->net_loans_bs)];
            $balanceSheet[] = ["title" => "Other assets", "data" => $this->handle_equity_record($companyObject->other_assets_bs)];
            $balanceSheet[] = ["title" => "Total assets", "data" => $this->handle_equity_record($companyObject->total_assets_bs)];
            $balanceSheet[] = ["title" => "Deposits", "data" => $this->handle_equity_record($companyObject->deposits_bs)];
            $balanceSheet[] = ["title" => "Due to banks", "data" => $this->handle_equity_record($companyObject->due_to_banks_bs)];
            $balanceSheet[] = ["title" => "Borrowings", "data" => $this->handle_equity_record($companyObject->borrowings_bs)];
            $balanceSheet[] = ["title" => "Other liabilities", "data" => $this->handle_equity_record($companyObject->other_liabilities_bs)];
            $balanceSheet[] = ["title" => "Total liabilities", "data" => $this->handle_equity_record($companyObject->total_liabilities_bs)];
            $balanceSheet[] = ["title" => "Shareholders equity", "data" => $this->handle_equity_record($companyObject->shareholders_equity_bs)];
            $balanceSheet[] = ["title" => "Total liabilities equity", "data" => $this->handle_equity_record($companyObject->total_liabilities_equity_bs)];

            $growthRate = [];
            $growthRate[] = ["title" => "Assets", "data" => $this->handle_equity_record($companyObject->assets_gr)];
            $growthRate[] = ["title" => "Loans", "data" => $this->handle_equity_record($companyObject->loans_gr)];
            $growthRate[] = ["title" => "Deposits", "data" => $this->handle_equity_record($companyObject->deposits_gr)];
            $growthRate[] = ["title" => "Net income", "data" => $this->handle_equity_record($companyObject->net_income_gr)];


            $profitability = [];

            $profitability[] = ["title" => "NIM", "data" => $this->handle_equity_record($companyObject->nim_p)];
            $profitability[] = ["title" => "Cost-to-income", "data" => $this->handle_equity_record($companyObject->cost_to_income_p)];
            $profitability[] = ["title" => "RoE", "data" => $this->handle_equity_record($companyObject->roe_p)];
            $profitability[] = ["title" => "RoA", "data" => $this->handle_equity_record($companyObject->roa_p)];

            $laqc = [];

            $laqc[] = ["title" => "Loans-to-deposits", "data" => $this->handle_equity_record($companyObject->loans_to_deposit_laqc)];
            $laqc[] = ["title" => "NPL ratio", "data" => $this->handle_equity_record($companyObject->npl_ratio_laqc)];
            $laqc[] = ["title" => "CoR (bps)", "data" => $this->handle_equity_record($companyObject->cor_bps_laqc)];
            $laqc[] = ["title" => "Coverage", "data" => $this->handle_equity_record($companyObject->coverage_laqc)];
            $laqc[] = ["title" => "Total CAR", "data" => $this->handle_equity_record($companyObject->total_car_laqc)];
            $laqc[] = ["title" => "Tier-1 capital", "data" => $this->handle_equity_record($companyObject->tier_1_capital_laqc)];

            $dataValuation = [];

            $dataValuation[] = ["title" => "EPS", "data" => $this->handle_equity_record($companyObject->eps_dv)];
            $dataValuation[] = ["title" => "BVPS", "data" => $this->handle_equity_record($companyObject->bvps_dv)];
            $dataValuation[] = ["title" => "DPS", "data" => $this->handle_equity_record($companyObject->dps_dv)];
            $dataValuation[] = ["title" => "P/E (x)", "data" => $this->handle_equity_record($companyObject->p_e_dv)];
            $dataValuation[] = ["title" => "P/BV (x)", "data" => $this->handle_equity_record($companyObject->p_b_v_dv)];
//            $dataValuation[] = ["title" => "EV/EBITDA (x)", "data" => $this->handle_equity_record($companyObject->ev_ebitda_dv)];
            $dataValuation[] = ["title" => "Dividend yield (x)", "data" => $this->handle_equity_record($companyObject->dividend_yield_dv)];

            $summaryValuation = [];
            $summaryValuation[] = ["parameter" => "(". $currency.  "mn)" , "category_name" => "Income statement", "data" => $incomeStatus];
            $summaryValuation[] = ["parameter" => "(". $currency.  "mn)" , "category_name" => "Balance sheet", "data" => $balanceSheet];
            $summaryValuation[] = ["parameter" => "(%)" , "category_name" => "Growth rate", "data" => $growthRate];
            $summaryValuation[] = ["parameter" => "(%)" , "category_name" => "Profitability", "data" => $profitability];
            $summaryValuation[] = [ "parameter" => "(x)" , "category_name" => "Liquidity, asset quality, and capitalisation", "data" => $laqc];
            $summaryValuation[] = [ "parameter" => "(". $currency.  ")"  , "category_name" => "Per share data & valuation", "data" => $dataValuation];

        }

        // Analysts
        $analysts = [];
        foreach ($companyObject['analyst'] as $one_analyst) {
            $user = $one_analyst['user'];
            $data = [
                "id" => $one_analyst->id,
                "name" => $user->name,
                "title" => $user->title,
                "profile_pic" => $user->profile_pic ? url('/storage') . '/' . $user->profile_pic : "",
            ];
            $analysts[] = $data;
        }

        return ["top_data" => $companyParameters ,"analyst" => $analysts , "summary" => $summaryValuation];


    }

    public function getPeerCompanies($companyObject , $selection){

        if ($selection == "local") {
            //Same Macro Same Sector
            $peerCompanies = Company::select(
                "id", "name", "logo", "macro_id", "sector_id", "bloomberg", "reuters", "recommendation",
                "market_cap", "market_cap_local", "adtv", "tp_currency", "target_price", "closing_price", "potential_return" , "p_e_dv", "p_b_v_dv" , "ev_ebitda_dv" , "dividend_yield_dv"
            )
                ->with("Macro:id,name")->with("Sector:id,name")->where('id', '!=', $companyObject->id)
                ->where('macro_id', '=', $companyObject->macro_id)
                ->where("sector_id", '=', $companyObject->sector_id)
                ->inRandomOrder()
                ->get();

        } else {
            //Same Sector but other Macors
            $peerCompanies = Company::select(
                "id", "name", "logo", "macro_id", "sector_id", "bloomberg", "recommendation", "reuters",
                "market_cap", "market_cap_local", "adtv", "tp_currency", "target_price", "closing_price", "potential_return" ,"p_e_dv", "p_b_v_dv" , "ev_ebitda_dv" , "dividend_yield_dv"
            )
                ->with("Macro:id,name")->with("Sector:id,name")->where('id', '!=', $companyObject->id)
                ->where('macro_id', '!=', $companyObject->macro_id)
                ->where("sector_id", '=', $companyObject->sector_id)
                ->inRandomOrder()
                ->get();
        }
        return $peerCompanies ;

    }

    public function formatPeerCompanies($peerCompanies){
        $peerCompaniesData = [];
        foreach ($peerCompanies as $singleCompany) {
            $companyParameters = [];
            $companyParameters[] = ["title" => "COMPANY", "value" => $singleCompany->name , "logo" => url('/storage') . '/' . $singleCompany->logo];
            $companyParameters[] = ["title" => "BBG TICKER", "value" => $singleCompany->bloomberg];
            $companyParameters[] = ['title' => "COUNTRY", "value" => $singleCompany["macro"]->name];
            $companyParameters[] = ['title' => "MARKET CAP (USD)", "value" => $this->handle_number_format($singleCompany->market_cap)];
            $companyParameters[] = ['title' => "STOCK RATING", "value" => $singleCompany->recommendation];
            $companyParameters[] = ['title' => "TP (LCY)", "value" => $this->handle_number_format($singleCompany->target_price)];
            $companyParameters[] = ['title' => "P/E", "value" => $this->handle_number_format($singleCompany->p_e_dv[0]['current_year'])];
            $companyParameters[] = ['title' => "P/BV", "value" => $this->handle_number_format($singleCompany->p_b_v_dv[0]['current_year'])];
            $companyParameters[] = ['title' => "EV/EBITDA", "value" => $this->handle_number_format($singleCompany->ev_ebitda_dv[0]['current_year'])];
            $companyParameters[] = ['title' => "DIVIDEND YIELD (%)", "value" => $this->handle_number_format($singleCompany->dividend_yield_dv[0]['current_year'])];
            $data = [
                "id" => $singleCompany->id,
                "parameters" => $companyParameters,
            ];
            $peerCompaniesData [] = $data;
        }
        return $peerCompaniesData ;

    }

}
