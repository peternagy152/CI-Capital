<?php
// app/Traits/GlobalFunctionsTrait.php

namespace App\Traits;

use App\Models\Company;
use App\Models\CompanyHistory;
use App\Models\Macro;
use Carbon\Carbon;
use Filament\Notifications\Notification;

trait GlobalWidgets
{

    public function randomPassword($counter)
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $counter; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function publicationWidget($publications, $type, $user_data)
    {
        $publications_array = [];
        $oneWeekAgo = Carbon::now()->subWeek();

        foreach ($publications as $one_report) {

            $analysts = [];

            foreach ($one_report['analyst'] as $one_analyst) {
                $publishedDate = Carbon::parse($one_report->published_at);
                $user = $one_analyst['user'];
                $data = [
                    "id" => $one_analyst->id,
                    "name" => $user->name,
                    "profile_pic" => $user->profile_pic ? url('/storage') . '/' . $user->profile_pic : "",
                    "title" => $user->title,
                ];
                $analysts[] = $data;
            }
            if ($type == "company") {
                $company_names = [];
                $companies_data = [];
                foreach ($one_report['company'] as $one_company) {
                    $companies_data[] = ["id" => $one_company->id ,"name" => $one_company['name'], "logo" => url("/storage") . '/' . $one_company['logo']];
                    $company_names[] = $one_company['name'];
                }

                $data = [
                    "type" => "company",
                    "liked" => $user_data->Publication()->wherePivot('publication_id', $one_report->id)->exists(),
                    "new" => $publishedDate->greaterThanOrEqualTo($oneWeekAgo),
                    "companies" => $company_names,
                    "companies_data" => $companies_data,
                    "id" => $one_report->id,
                    "name" => $one_report->name,
                    "desc" => $one_report->desc,
                    "read_in" => $one_report->read_in,
                    "report" => url('/storage') . '/' . $one_report->report,
                    "created_at" => Carbon::parse($one_report->published_at)->format('M d, Y'),
                    "analysts" => $analysts,
                ];
            } else {
                $data = [
                    "type" => "macro",
                    "liked" => $user_data->MacroPublication()->wherePivot('macro_publication_id', $one_report->id)->exists(),
                    "new" => $publishedDate->greaterThanOrEqualTo($oneWeekAgo),
                    "macro_name" => $one_report['macro']['name'],
                    'macro_id' => $one_report['macro']['id'],
                    "flag" => url('/storage') . '/' . $one_report['macro']['flag'],
                    "id" => $one_report->id,
                    "name" => $one_report->name,
                    "desc" => $one_report->desc,
                    "read_in" => $one_report->read_in,
                    "report" => url('/storage') . '/' . $one_report->report,
                    "created_at" => Carbon::parse($one_report->published_at)->format('M d, Y'),
                    "analysts" => $analysts,
                ];
            }
            $publications_array[] = $data;


        }
        return $publications_array;

    }

    public function dailyWidget($all_dailies, $type)
    {
        $daily = [];

        if ($type == "macro") {
            foreach ($all_dailies as $one_daily) {
                $sources = [];
                foreach ($one_daily['source'] as $one_source) {
                    $sources[] = $one_source['name'];
                }
                $data = [
                    "title" => $one_daily->title,
                    "desc" => $one_daily->desc,
                    "source" => $sources,
                    "macro" => $one_daily['macro']->name,
                    "macro_id" => $one_daily['macro']->id,
                    "company" => "",
                    "created_at" => Carbon::parse($one_daily->published_at)->format('M d, Y'),
                ];
                $daily[] = $data;
            }
        } else {
            foreach ($all_dailies as $one_daily) {
                $sources = [];
                foreach ($one_daily['source'] as $one_source) {
                    $sources[] = $one_source['name'];
                }
                $data = [
                    "title" => $one_daily->title,
                    "desc" => $one_daily->desc,
                    "source" => $sources,
                    "macro" => $one_daily['company']["macro"]->name,
                    "macro_id" => $one_daily['company']["macro"]->id,
                    "company" => $one_daily["company"]->name,
                    "created_at" => Carbon::parse($one_daily->published_at)->format('M d, Y'),
                ];
                $daily[] = $data;
            }

        }
        return $daily;
    }

    public function analystWidget($all_analysts, $user_object)
    {
        $enhanced_analysts = [];

        foreach ($all_analysts as $one_analyst) {
            $sectors = [];
            foreach ($one_analyst['Sector'] as $oneSector) {
                $sectors[] = $oneSector->name;
            }
            $data = [
                "id" => $one_analyst->id,
                "liked" => $user_object->LikeAnalyst()->wherePivot('analyst_id', $one_analyst->id)->exists(),
                "profile_pic" => url('/storage') . '/' . $one_analyst['user']->profile_pic,
                "name" => $one_analyst['user']->name,
                "title" => $one_analyst['user']->title,
                "email" => $one_analyst['user']->email,
                "sectors" => $sectors
            ];

            $enhanced_analysts [] = $data;

        }
        return $enhanced_analysts;
    }

    public function companyWidget($all_company, $user_object)
    {
        $output_companies = [];
        foreach ($all_company as $one_company) {
            $like = $user_object->Company()->wherePivot('company_id', $one_company->id)->exists();
            $company_parameters = [];
            $company_parameters[] = ["title" => "Bloomberg", "value" => $one_company->bloomberg];
            $company_parameters[] = ["title" => "Reuters", "value" => $one_company->reuters];
            $company_parameters[] = ['title' => "COUNTRY", "value" => $one_company["macro"]->name];
            $company_parameters[] = ['title' => "Sector", "value" => $one_company["sector"]->name];
            $company_parameters[] = ['title' => "MARKET CAP (USDmn)", "value" => $one_company->market_cap];
            $company_parameters[] = ['title' => "MARKET CAP (LCYmn)", "value" => $one_company->market_cap_local];
            $company_parameters[] = ['title' => "ADTV (USDmn)", "value" => $one_company->adtv];
            $company_parameters[] = ['title' => "RATING", "value" => $one_company->recommendation];
            $company_parameters[] = ['title' => "TP CURRENCY", "value" => $one_company->tp_currency];
            $company_parameters[] = ['title' => "Target Price", "value" => $one_company->target_price];
            $company_parameters[] = ['title' => "CLOSING PRICE", "value" => $one_company->closing_price];
            $company_parameters[] = ["title" => "UPSIDE (DOWNSIDE) POTENTIAL", "value" => $one_company->potential_return];
            $data = [
                "id" => $one_company->id,
                "liked" => $like,
                "name" => $one_company->name,
                "logo" => url('/storage') . '/' . $one_company->logo,
                "parameters" => $company_parameters,
            ];
            $output_companies [] = $data;
        }
        return $output_companies;

    }

    public function validate_macro_sheet_cols($file_path)
    {
        $valid_records = [
            "Real GDP growth",
            "Real hydrocarbon growth",
            "Real non hydrocarbon growth",
            "GDP per capital",
            "Population",
            "Unemployment rate",
            "Government revenues",
            "Government expenditure",
            "Fiscal balance",
            "Debit",
            "Trade balance",
            "Hydrocarbon exports",
            "Current account balance",
            "Current account balance gdp",
            "Inflation",
            "private sector credit growth",
            "Discount rate",
            "Oil production",
            "Brent price",
            "Natural gas production"
        ];
        $exel_file = fopen($file_path, 'r');
        $first_row = 0;
        $input_records = [];
        while (($line = fgetcsv($exel_file)) !== FALSE) {
            if ($first_row == 0) {
                $first_row++;
                continue;
            }
            $input_records [] = trim($line[0]);
        }
        if (count($input_records) != count($valid_records)) {
            return "mismatch";
        }
        foreach ($valid_records as $valid) {
            if (!in_array($valid, $input_records)) {
                return $valid;
            }
        }
        return "valid";

    }

    public function validate_macro_sheet_values($file_path)
    {
        $exel_file = fopen($file_path, 'r');
        $first_row = 0;
        $valid = true;
        $wrong_values = "";
        while (($line = fgetcsv($exel_file)) !== FALSE) {
            if ($first_row == 0) {
                $first_row++;
                continue;
            }
            for ($x = 1; $x <= 5; $x++) {
                if (!($line[$x] === '-' || is_numeric($line[$x]))) {
                    $line[$x] = false;
                    $wrong_values = $line[$x];
                    break;
                }
            }
            if ($valid == false) {
                break;
            }
        }
        if ($valid) {
            return "valid";
        } else {
            return $wrong_values;
        }

    }

    public function import_macro_sheet($file_path, $macro_id)
    {
        $matching_array = [
            "GDP per capital" => "gdp_per_capita",
//            "Growth in private sector credit" => 'private_sector_credit_growth'
        ];
        $exel_file = fopen($file_path, 'r');
        $macro_object = Macro::find($macro_id);
        $first_row = 0;
        while (($line = fgetcsv($exel_file)) !== FALSE) {
            if ($first_row == 0) {
                $first_row++;
                continue;
            }
            $column_name = $line[0];
            if (isset($matching_array[$column_name])) {
                $column_name = $matching_array[$column_name];
            } else {
                $column_name = trim($column_name);
                $column_name = strtolower($column_name);
                $column_name = str_replace(" ", "_", $column_name);
            }
            $py_2 = $column_name . "_py_2";
            $py_1 = $column_name . "_py_1";
            $py = $column_name . "_py";
            $cy = $column_name . "_cy";
            $cy_1 = $column_name . "_cy_1";
            if ($line[1] == '') {
                $line[1] = "";
                $line[2] = "";
                $line[3] = "";
                $line[4] = "";
            }
            $macro_object->$py_2 = $line[1];
            $macro_object->$py_1 = $line[2];
            $macro_object->$py = $line[3];
            $macro_object->$cy = $line[4];
            $macro_object->$cy_1 = $line[5];
        }
        $macro_object->save();


    }

    public function new_import_equity($file_path, $company_id)
    {
        $categories = [
            "Income Statement" => "is",
            "Balance Sheet" => "bs",
            "Cash flow summary" => "cfs",
            "Growth ratios" => "gr",
            "Profitability" => "p",
            "Liquidity" => "l",
            "Liquidity, asset quality, and capital" => "laqc",
            "Per share data & valuation" => "dv",
        ];
        $exel_file = fopen($file_path, 'r');
        $first_row = 0;
        $company_object = Company::find($company_id);
        if ($company_object) {
            while (($line = fgetcsv($exel_file)) !== FALSE) {
                if ($first_row == 0) {
                    $first_row++;
                    continue;
                }
                $parameter_name = trim($line[0]);
                $parameter_name = strtolower($parameter_name);
                $parameter_name = str_replace("&", " ", $parameter_name);
                $parameter_name = str_replace(" ", "_", $parameter_name);
                $parameter_name = $parameter_name . '_' . $categories[$line[6]];
                $data = [
                    "previous_year" => ($line[2]),
                    "current_year" => ($line[3]),
                    "current_year_1" => ($line[4]),
                    "current_year_2" => ($line[5])
                ];
                $company_object->$parameter_name = [$data];
            }
            $company_object->save();
        }
    }


    public function validate_equity_sheet_cols($file_path)
    {

        $valid_records = array(
            "Taxes or zakat",
            "Net income",
            "Revenue",
            "Cost of sale",
            "Gross profit",
            "SG&A",
            "EBITDA",
            "D&A",
            "EBIT",
            "Net interest income",
            "Non interest income",
            "Total income",
            "Total operating expenses",
            "Net operating income",
            "Provision expense",
            "Net income before tax or zakat",
            "Net income before minority",
            "Minority interest",
            "Total liabilities",
            "Total assets",
            "Shareholders equity",
            "Total liabilities&equity",
            "Cash&equivalents",
            "Accounts receivables",
            "Inventory",
            "Net fixed assets",
            "Other assets",
            "Short term debt",
            "Payables",
            "Current liabilities",
            "Long term debt",
            "Cash&due from CB",
            "Due from banks",
            "Investments",
            "Net loans",
            "Other assets",
            "Deposits",
            "Due to banks",
            "Borrowings",
            "Other liabilities",
            "Operating cash flow",
            "Working capital changes",
            "Cash flow from operations",
            "Cash flow from investing",
            "Cash flow from financing",
            "Net change in cash flow",
            "Net income",
            "Revenue",
            "EBITDA",
            "EBIT",
            "Assets",
            "Loans",
            "Deposits",
            "Gross margin",
            "EBITDA margin",
            "Net margin",
            "NIM",
            "Cost to income",
            "RoE",
            "RoA",
            "Total debt to equity",
            "Net debt to equity",
            "Net debt cash",
            "Net Debt to EBITDA",
            "Loans to deposit",
            "NPL ratio",
            "CoR bps",
            "Coverage",
            "Total CAR",
            "Tier 1 capital",
            "EPS",
            "BVPS",
            "DPS"
        );
        $exel_file = fopen($file_path, 'r');
        $first_row = 0;
        $input_records = [];
        while (($line = fgetcsv($exel_file)) !== FALSE) {
            if ($first_row == 0) {
                $first_row++;
                continue;
            }
            $input_records [] = trim($line[0]);
        }
        if (count($input_records) != count($valid_records)) {
            return "mismatch";
        }
        foreach ($valid_records as $valid) {
            if (!in_array($valid, $input_records)) {
                return $valid;
            }
        }
        return "valid";
    }

    public function validate_equity_sheet_values($file_path)
    {
        $exel_file = fopen($file_path, 'r');
        $first_row = 0;
        $valid = true;
        $wrong_values = "";

        while (($line = fgetcsv($exel_file)) !== FALSE) {
            if ($first_row == 0) {
                $first_row++;
                continue;
            }
            for ($x = 2; $x <= 5; $x++) {
                if (!($line[$x] === '-' || is_numeric($line[$x]))) {
                    $valid = false;
                    $wrong_values = $line[$x];
                    break;
                }
            }
            if ($valid == false) {
                break;
            }
        }

        if ($valid) {
            return "valid";
        } else {
            return $wrong_values;
        }

    }

    public function validate_bloomberg_ticker($file_path)
    {
        $exel_file = fopen($file_path, 'r');
        $first_row = 0;
        $valid = true;
        $wrong_values = "";

        while (($line = fgetcsv($exel_file)) !== FALSE) {
            if ($first_row == 0) {
                $first_row++;
                continue;
            }
            $ticker = $line[0];
            $company = Company::where("bloomberg", $ticker)->first();
            if (!$company) {
                $wrong_values = $ticker;
                $valid = false;
                break;
            }
        }

        if ($valid) {
            return "valid";
        } else {
            return $wrong_values;
        }


    }

    public function import_closing_price($file_path)
    {
        $exel_file = fopen($file_path, 'r');
        $first_row = 0;
        while (($line = fgetcsv($exel_file)) !== FALSE) {
            if ($first_row == 0) {
                $first_row++;
                continue;
            }
            $ticker = $line[0];
            $company = Company::where("bloomberg", $ticker)->with("Type")->first();
            if ($company) {
                $company->closing_price = $line[2];
                $history_record = CompanyHistory::where("company_id", $company->id)->where("closing_date", $line[1])->first();

                if ($history_record) {
                    $history_record->closing_price = $line[2];
                    $history_record->save();
                } else {
                    CompanyHistory::create([
                        "company_id" => $company->id,
                        "closing_date" => $line[1],
                        "closing_price" => $line[2],
                    ]);
                }

                $company->adtv = $line[3];
                $company->recommendation = $line[4];
                $company->target_price = $line[5];
                $company->market_cap = $line[6];
                $company->market_cap_local = $line[7];
                $company->save();


                if (!empty($company->eps_dv[0]['previous_year']) && !empty($company->eps_dv[0]['current_year']) && !empty($company->eps_dv[0]['current_year_1']) && !empty($company->eps_dv[0]['current_year_2'])) {
                    if (is_numeric($company->eps_dv[0]['previous_year']) && is_numeric($company->eps_dv[0]['current_year']) && is_numeric($company->eps_dv[0]['current_year_1']) && is_numeric($company->eps_dv[0]['current_year_2'])) {
                        $p_e_dv = [
                            "previous_year" => $line[2] / (float)$company->eps_dv[0]['previous_year'],
                            "current_year" => $line[2] / (float)$company->eps_dv[0]['current_year'],
                            "current_year_1" => $line[2] / (float)$company->eps_dv[0]['current_year_1'],
                            "current_year_2" => $line[2] / (float)$company->eps_dv[0]['current_year_2']
                        ];
                        $company->p_e_dv = [$p_e_dv];
                    }

                }

                if (!empty($company->bvps_dv[0]['previous_year']) && !empty($company->bvps_dv[0]['current_year']) && !empty($company->bvps_dv[0]['current_year_1']) && !empty($company->bvps_dv[0]['current_year_2'])) {
                    if (is_numeric($company->bvps_dv[0]['previous_year']) && is_numeric($company->bvps_dv[0]['current_year']) && is_numeric($company->bvps_dv[0]['current_year_1']) && is_numeric($company->bvps_dv[0]['current_year_2'])) {
                        $p_b_v_dv = [
                            "previous_year" => $line[2] / $company->bvps_dv[0]['previous_year'],
                            "current_year" => $line[2] / $company->bvps_dv[0]['current_year'],
                            "current_year_1" => $line[2] / $company->bvps_dv[0]['current_year_1'],
                            "current_year_2" => $line[2] / $company->bvps_dv[0]['current_year_2']
                        ];
                        $company->p_b_v_dv = [$p_b_v_dv];
                    }

                }

                if (!empty($company->ebitda_is[0]['previous_year']) && !empty($company->ebitda_is[0]['current_year']) && !empty($company->ebitda_is[0]['current_year_1']) && !empty($company->ebitda_is[0]['current_year_2'])) {
                    if (is_numeric($company->ebitda_is[0]['previous_year']) && is_numeric($company->ebitda_is[0]['current_year']) && is_numeric($company->ebitda_is[0]['current_year_1']) && is_numeric($company->ebitda_is[0]['current_year_2'])) {
                        $ev_ebitda_dv = [
                            "previous_year" => ($line[6] - (float)$company->cash_equivalents_bs[0]['previous_year'] + (float)$company->net_fixed_assets_bs[0]['previous_year'] + (float)$company->short_term_debt_bs[0]['previous_year']) / (float)$company->ebitda_is[0]['previous_year'],
                            "current_year" => ($line[6] - (float)$company->cash_equivalents_bs[0]['current_year'] + (float)$company->net_fixed_assets_bs[0]['current_year'] + (float)$company->short_term_debt_bs[0]['current_year']) / (float)$company->ebitda_is[0]['current_year'],
                            "current_year_1" => ($line[6] - (float)$company->cash_equivalents_bs[0]['current_year_1'] + (float)$company->net_fixed_assets_bs[0]['current_year_1'] + (float)$company->short_term_debt_bs[0]['current_year_1']) / (float)$company->ebitda_is[0]['current_year_1'],
                            "current_year_2" => ($line[6] - (float)$company->cash_equivalents_bs[0]['current_year_2'] + (float)$company->net_fixed_assets_bs[0]['current_year_2'] + (float)$company->short_term_debt_bs[0]['current_year_2']) / (float)$company->ebitda_is[0]['current_year_2'],
                        ];
                        $company->ev_ebitda_dv = [$ev_ebitda_dv];
                    }


                }

                if (!empty($company->dps_dv[0]['previous_year']) && !empty($company->dps_dv[0]['current_year']) && !empty($company->dps_dv[0]['current_year_1']) && !empty($company->dps_dv[0]['current_year_2'])) {
                    if (is_numeric($company->dps_dv[0]['previous_year']) && is_numeric($company->dps_dv[0]['current_year']) && is_numeric($company->dps_dv[0]['current_year_1']) && is_numeric($company->dps_dv[0]['current_year_2'])) {
                        $dividend_yield_dv = [
                            "previous_year" => ($company->dps_dv[0]['previous_year'] / $line[2]) * 100,
                            "current_year" => ($company->dps_dv[0]['current_year'] / $line[2]) * 100,
                            "current_year_1" => ($company->dps_dv[0]['current_year_1'] / $line[2]) * 100,
                            "current_year_2" => ($company->dps_dv[0]['current_year_2'] / $line[2]) * 100,
                        ];
                        $company->dividend_yield_dv = [$dividend_yield_dv];
                    }
                }

                $potential_return = ($line[5] / $line[2] - 1) * 100;
                $company->potential_return = $potential_return;


                $company->save();

            }
        }

    }





}
