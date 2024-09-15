<?php

namespace App\Http\Controllers;

use App\Models\CompanyHistory;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use App\Models\User ;
use App\Models\Macro ;
use App\Models\Sector ;
use App\Models\Type ;
use App\Models\Company ;
use App\Models\DataMiner ;
use App\Models\Analyst;
use App\Models\Commody;
use Illuminate\Support\Facades\Hash;
class device_controller extends Controller
{
    //
    function create_startup_roles(){
        Role::create(['name' => 'client']);
        Role::create(['name' => 'analyst']);
        Role::create(['name' => 'admin']);
        return ['status' => 'success'] ;
    }

    function create_admin(){
        $user=User::create([
            'name' => "Superadmin" ,
            'email' => "peter.nagy@mitchdesigns.com",
            'password' => Hash::make("ci_capital") ,
            'mobile'     => "01227165958" ,
            'title'     => "Website Development",
            'company_name'     => "MD" ,
        ]);

        $user->assignRole('admin');
        return ['status' => 'success' , 'msg'=> "Admin Created"] ;
    }


    function create_analyst()
    {
        $user = User::create([
            'name' => "Mai",
            'email' => "mai.ci@cicap.com",
            'password' => Hash::make("ci_capital"),
            'mobile'     => "01227165958",
            'title'     => "Senior Analyst",
            'company_name'     => "Ci Capital",
        ]);

        $user->assignRole('analyst');
        $analyst = Analyst::create([
            'user_id' => $user->id,
        ]);

        $user = User::create([
            'name' => "Ezzat Malak",
            'email' => "ezzat.malak@cicap.com",
            'password' => Hash::make("ci_capital"),
            'mobile'     => "01227165958",
            'title'     => "Senior Analyst",
            'company_name'     => "Ci Capital",
        ]);

        $user->assignRole('analyst');
        $analyst = Analyst::create([
            'user_id' => $user->id,
        ]);

        $user = User::create([
            'name' => "Peter Nagy",
            'email' => "peter.nagy@cicap.com",
            'password' => Hash::make("ci_capital"),
            'mobile'     => "01227165958",
            'title'     => "Senior Analyst",
            'company_name'     => "Ci Capital",
        ]);

        $user->assignRole('analyst');
        $analyst = Analyst::create([
            'user_id' => $user->id,
        ]);

        return ['status' => 'success', 'msg' => "Analyst Created"];
    }

    function data_faker(){
        $this->create_startup_roles();
        $this->create_admin();
        $this->create_analyst();

        $sector = Sector::create([
            'name' => "Tech",

        ]);
          $sector = Sector::create([
            'name' => "Constructions",

        ]);

        $type = Type::create([
            "name" => "Bank"
        ]);

          $type = Type::create([
            "name" => "Company"
        ]);

         return ['status' => 'success', 'msg' => "Roles , Admins , Analyst , Sectors , Types CREATED !"];
    }

    //MAcros
    function import_sheet(){

        $matching_array = [
            "GDP per capital" => "gdp_per_capita" ,
            "Growth in private sector credit" => 'private_sector_credit_growth'
        ];

        $exel_file = fopen("../storage/app/public/events/Ci Capital _Dev_ - Macro Example.csv", 'r');
        $macro_object = Macro::find(1);
        $first_row = 0 ;
        while(($line = fgetcsv($exel_file)) !== FALSE){
            if($first_row == 0){
                $first_row++;
                continue;
            }
            $column_name = $line[0] ;
            if(isset($matching_array[$column_name])){
                //var_dump( $matching_array);
                $column_name = $matching_array[$column_name] ;

            }else{
                $column_name = trim($column_name);
                $column_name = strtolower($column_name);
                $column_name = str_replace(" " , "_" , $column_name);
            }
            $py_2 = $column_name . "_py_2";
            $py_1 = $column_name . "_py_1";
            $py = $column_name . "_py";
            $cy = $column_name . "_cy";
            $cy_1 = $column_name . "_cy_1";
            if($line[1] == ''){
                continue;
            }
            $macro_object->$py_2 = $line[1];
            $macro_object->$py_1 = $line[2];
            $macro_object->$py = $line[3];
            $macro_object->$cy = $line[4];
            $macro_object->$cy_1 = $line[5];
        }
        $macro_object->save();


    }

    function product_merge()
    {
        $arabic_products = fopen("../storage/app/public/events/wc-product-export-11-2-2024-1707653223133.csv", 'r');
        $english_products = fopen("../storage/app/public/events/wc-product-export-11-2-2024-1707653494164.csv", 'r');
        $merge_sheet = fopen("../storage/app/public/events/merged.csv", 'w');

        $merged_line = [] ;

        $first_row = 0 ;
        $counter = 0 ;
        while(($line = fgetcsv($arabic_products)) !== FALSE) {

            if ($first_row == 0) {
                $first_row++;
                continue;
            }
            $english_version_found = false ;
            rewind($english_products);
            while(($english_lines = fgetcsv($english_products)) !== FALSE) {
                if($english_lines[2] == $line[2]){
                   $english_version_found = true ;
                    $data = [
                        $line[1] , // Type
                        $line[2] , // SKU
                        $line[3] , //Name
                        $line[4] , //Published
                        $line[6] , //Visibility in catalog
                        $line[29], //Images
                        $line[7] , //Short DESC
                        $line[8]  , //Desc
                        $line[13] , //Stock
                        $line[25] , //Regular price

                        $line[69] , //Rank Math title
                        $line[70] , //Rank Math desc
                        $line[78] , //Rank Math focus keys

                        $english_lines[3],
                        $english_lines[7] ,
                        $english_lines[8],
                        $english_lines[26] , //Categories
                        $english_lines[58] , //Rank Math Focus Keys
                        $english_lines[59] , //Rank Math title
                        $english_lines[60] , //Rank Math desc
                   ];
                    $merged_line [] = $data ;

                }

            }

        }
        $data = [
            "Type" ,  // Type
            "SKU" , // SKU
            "Arabic Name" , //Name
            "Published" ,
            "Visibility in catalog" ,
            "Images" ,
            "Arabic Short Desc" , //Short DESC
            "Arabic Desc"  , //Desc
            "stock ", //Stock
            "regular price" , //Regular price
            "Arabic Rank Math title" , //Rank Math title
            "Arabic Rank Math desc" , //Rank Math desc
            "Arabic Rank Math Focus Keywords" ,


            "English Name", // Name
            "English Short Desc", //Short DEsc
            "English Desc", // Dec
            "Categories" , //Categories
            "English Rank Math Focus Keywords" ,
            "English Rank Math title" , //Rank Math title
            "English Rank Math Desc", //Rank Math desc

        ];

        fputcsv($merge_sheet, $data);
        foreach ($merged_line as $line) {
            fputcsv($merge_sheet, $line);
        }

    }


    function variable_product_merge(){
        $arabic_products = fopen("../storage/app/public/events/Kouider New Products - Variable Arabic.csv", 'r');
        $english_products = fopen("../storage/app/public/events/Kouider New Products - Variable English.csv", 'r');
        $merge_sheet = fopen("../storage/app/public/events/Kouider New Products - Variable Merged.csv", 'w');

        $merged_line = [] ;

        $first_row = 0 ;
        $counter = 0 ;

        while(($line = fgetcsv($arabic_products)) !== FALSE) {

            if ($first_row == 0) {
                $first_row++;
                continue;
            }
            rewind($english_products);
            while(($english_lines = fgetcsv($english_products)) !== FALSE) {
                if($english_lines[2] == $line[2] && !empty($line[2])){
                    $data = [
                        $line[1] , // Type
                        $line[2] , // SKU
                        $line[3] , //Arabic Name
                        $line[4] , //Published
                        $line[6] , //Visibility in catalog
                        $line[29], //Images
                        $line[7] , //Short DESC
                        $line[8]  , //Desc
                        $line[13] , //Stock
                        $line[25] , //Regular price

                        $line[70] , //Rank Math title
                        $line[72] , //Rank Math desc
                        $line[84] , //Rank Math focus keys


                        $english_lines[3], // Name
                        $english_lines[7] , //Short Desc
                        $english_lines[8], //Desc
                        $english_lines[26] , //Categories

                        $english_lines[85] , //Rank Math Focus Keys
                        $english_lines[65] , //Rank Math title
                        $english_lines[66] , //Rank Math desc

                        //Variable Product Data
                        //Attribute 1
                        $english_lines[32] , //Parent
                        $english_lines[41] , // Attribute 1 name
                        $english_lines[42] , // Attribute 1 value(s)
                        $english_lines[43] , // Attribute 1 visible
                        $english_lines[44] , // Attribute 1 global

                        //Attribute 2
                        $english_lines[81] , // Attribute 2 name
                        $english_lines[82] , // Attribute 2 value(s)
                        $english_lines[83] , // Attribute 2 visible
                        $english_lines[84] , // Attribute 2 global

                        $english_lines[89] , //Attribute 1 default
                        $english_lines[90] , //Attribute 2 default


                    ];
                    $merged_line [] = $data ;
                    break ;

                }

            }

        }

        $comments = [
            'Type',
            'SKU',
            'Meta: title_ar',
            'Published',
            'Visibility in catalog',
            'Images',
            'Meta: short_desc_ar',
            'Meta: desc_ar',
            'In stock?',
            'Regular price',
            'Meta: meta_title_ar',
            'Meta: meta_desc_ar',
            'Meta: focus_keywords_ar',

            'Name',
            'Short description',
            'Description',
            'Categories',
            'Meta: rank_math_focus_keyword',
            'Meta: rank_math_title',
            'Meta: rank_math_description',
            'Parent',
            'Attribute 1 name',
            'Attribute 1 value(s)',
            'Attribute 1 visible',
            'Attribute 1 global',
            'Attribute 2 name',
            'Attribute 2 value(s)',
            'Attribute 2 visible',
            'Attribute 2 global',
            'Attribute 1 default',
            'Attribute 2 default'
        ];
        fputcsv($merge_sheet, $comments);
        foreach ($merged_line as $line) {
            fputcsv($merge_sheet, $line);
        }



    }

    function update_product_prices(){
        $new_prices = fopen("../storage/app/public/Kouieder-export-7-3-2024 - Variable.csv", 'r');
        $current_prices = fopen("../storage/app/public/variable_product_k.csv", 'r');
        $updated_sheet =fopen("../storage/app/public/variable_product_k_updated.csv", 'w');
        $first_row = 0 ;
        $sku_prices = [] ;
        while(($line = fgetcsv($new_prices)) !== FALSE) {
            if ($first_row == 0) {
                $first_row++;
                continue;
            }
            if(!empty($line[2])){
                $sku_prices[$line[2]] = $line[6];
            }
        }
        $first_row = 0 ;
        while(($new_line = fgetcsv($current_prices)) !== FALSE) {
            if ($first_row == 0) {
                $first_row++;
                continue;
            }
            fputcsv($updated_sheet , array($sku_prices[$new_line[2]]));
        }


    }
    function import_company(){

        $company_data  = ["EBITDA" , "Cash equivalent" , "Net fixed assets" , "Short term debit" ,"EPS" , "BVPS","DPS"];
        $exel_file = fopen("../storage/app/public/events/Ci Capital _Dev_ - Data Miner Example (Company).csv", 'r');
        $first_row = 0 ;
        $company_data_counter = 0 ;
        $old_data_miners = DataMiner::where("company_id" , "2")->delete();
        $company = Company::find(2);
        while(($line = fgetcsv($exel_file)) !== FALSE){
            if($first_row == 0){$first_row++ ; continue;}
            if(in_array($line[0] , $company_data)){
                $company_data_counter++;
                if($company_data_counter > 7){
                    continue;
                }
                $column_name = trim($line[0]);
                $column_name = strtolower($column_name);
                $column_name = str_replace(" " , "_" , $column_name);


                $py = $column_name . '_py';
                $cy = $column_name . '_cy';
                $cy_1 = $column_name . '_cy_1';
                $cy_2 = $column_name . '_cy_2';

                $company->$py = $line[1];
                $company->$cy = $line[2];
                $company->$cy_1 = $line[3];
                $company->$cy_2 = $line[4];
            }



            $data_miner = DataMiner::create([
                "company_id" => "2" ,
                "parameter" => $line[0] ,
                "py" => $line[1] ,
                "cy" => $line[2] ,
                "cy_1" => $line[3] ,
                "cy_2" => $line[4] ,
                "type" => "TEMP" ,
                "cat" => $line[5]
            ]);
        }
        $company->save();

        echo "<h1> Company Updated Successfully </h1>";
    }

    function new_import_equity(){
        $categories = [
            "Income Statement" => "is" ,
            "Balance Sheet" => "bs" ,
            "Cash flow summary" => "cfs" ,
            "Growth ratios" => "gr" ,
            "Profitability" => "p" ,
            "Liquidity" => "l" ,
            "Liquidity, asset quality, and capital" => "laqc" ,
            "Per share data & valuation" => "dv" ,
        ];

       // var_dump($categories['Liquidity, asset quality, and capital']);

        // Import
        $exel_file = fopen("../storage/app/public/events/Ci Capital _Dev_ - Dynamic Equity - ORHD.csv", 'r');
        $first_row = 0 ;
        $company_object = Company::find(2);
        while(($line = fgetcsv($exel_file)) !== FALSE) {
            if ($first_row == 0) {
                $first_row++;
                continue;
            }

            $parameter_name = trim($line[0]);
            $parameter_name = strtolower($parameter_name);
            $parameter_name = str_replace("&" , " " , $parameter_name);
            $parameter_name = str_replace(" " , "_" , $parameter_name);
            $parameter_name = $parameter_name . '_' .$categories[$line[6]];

            $data = [
                "previous_year" => ($line[2]),
                "current_year" =>  ($line[3]),
                "current_year_1" =>  ($line[4]),
                "current_year_2" =>  ($line[5])
            ];
           // $data = json_encode($data);

            echo "<pre>";
            print_r($data);
            echo "</pre>";

            $company_object->$parameter_name = [$data];

        }
        $company_object->save() ;
        echo "<h1> Company Imported Successfully  </h1>";
    }

    function import_commodities(){
        $exel_file = fopen("../storage/app/public/events/CI Capital _Dev_ - Commodities.csv", 'r');
        $first_row = 0 ;
        while(($line = fgetcsv($exel_file)) !== FALSE){
            if($first_row == 0){$first_row++ ; continue;}

            $commodity = Commody::create([
                "category" => $line[0] ,
                "name" => $line[1] ,
                "unit" => $line[2] ,
                "spot" => $line[3] ,
                "wow" =>  $line[4] ,
                "mom" =>  $line[5] ,
                "ytd" =>  $line[6] ,
            ]);
        }
        echo "<h1> Commodities Imported Successfully  </h1>";

    }
    function import_base_data(){

        $all_companies = Company::all();
        foreach($all_companies as $company){
            $company->delete();
        }

        $exel_file = fopen("../storage/app/public/CI Capital Primary Data - Equity.csv", 'r');
        $first_row = 0 ;
        $data = [
            "previous_year" => "",
            "current_year" =>  "",
            "current_year_1" =>  "",
            "current_year_2" =>  ""
        ];
        while(($line = fgetcsv($exel_file)) !== FALSE){
            if($first_row == 0){$first_row++ ; continue;}
//            [{"previous_year":null,"current_year":null,"current_year_1":null,"current_year_2":null}]


            $equity = Company::create([
                "macro_id" => $line[1] ,
                "type_id" => $line[2] ,
                "sector_id" => $line[3] ,
                "name" => $line[4] ,
                "desc" => $line[5] ,
                "bloomberg" => $line[6] ,
                "reuters" => $line[7] ,
                "tp_currency" => $line[8] ,
                "taxes_or_zakat_is" => [$data],
            "net_income_is" => [$data],
            "revenue_is" => [$data],
            "cost_of_sale_is" => [$data],
            "gross_profit_is" => [$data],
            "sg_a_is" => [$data],
            "ebit_is" => [$data],
            "d_a_is" => [$data],
            "ebitda_is" => [$data],
            "net_interest_income_is" => [$data],
            "non_interest_income_is" => [$data],
            "total_income_is" => [$data],
            "total_operating_expenses_is" => [$data],
            "net_operating_income_is" => [$data],
            "provision_expense_is" => [$data],
            "net_income_before_tax_or_zakat_is" => [$data],
            "net_income_before_minority_is" => [$data],
            "minority_interest_is" => [$data],
            "total_assets_bs" => [$data],
            "total_liabilities_bs" => [$data],
            "shareholders_equity_bs" => [$data],
            "total_liabilities_equity_bs" => [$data],
            "cash_equivalents_bs" => [$data],
            "accounts_receivables_bs" => [$data],
            "inventory_bs" => [$data],
            "net_fixed_assets_bs" => [$data],
            "other_non_current_assets_bs" => [$data],
            "short_term_debt_bs" => [$data],
            "long_term_debt_bs" => [$data],
            "payables_bs" => [$data],
            "current_liabilities_bs" => [$data],
            "other_liabilities_bs" => [$data],
            "other_assets_bs" => [$data],
            "cash_due_from_cb_bs" => [$data],
            "due_from_banks_bs" => [$data],
            "due_to_banks_bs" => [$data],
            "investments_bs" => [$data],
            "net_loans_bs" => [$data],
            "deposits_bs" => [$data],
            "borrowings_bs" => [$data],
            "operating_cash_flow_cfs" => [$data],
            "working_capital_changes_cfs" => [$data],
            "cash_flow_from_operations_cfs" => [$data],
            "cash_flow_from_investing_cfs" => [$data],
            "cash_flow_from_financing_cfs" => [$data],
            "net_change_in_cash_flow_cfs" => [$data],
            "net_income_gr" => [$data],
            "revenue_gr" => [$data],
            "ebitda_gr" => [$data],
            "ebit_gr" => [$data],
            "assets_gr" => [$data],
            "loans_gr" => [$data],
            "deposits_gr" => [$data],
            "gross_margin_p" => [$data],
            "ebitda_margin_p" => [$data],
            "net_margin_p" => [$data],
            "nim_p" => [$data],
            "cost_to_income_p" => [$data],
            "roe_p" => [$data],
            "roa_p" => [$data],
            "total_debt_to_equity_l" => [$data],
            "net_debt_to_equity_l" => [$data],
            "net_debt_cash_l" => [$data],
            "net_debt_to_ebitda_l" => [$data],
            "loans_to_deposit_laqc" => [$data],
            "npl_ratio_laqc" => [$data],
            "cor_bps_laqc" => [$data],
            "coverage_laqc" => [$data],
            "total_car_laqc" => [$data],
            "tier_1_capital_laqc" => [$data],
            "eps_dv" => [$data],
            "bvps_dv" => [$data],
            "dps_dv" => [$data],
            "p_e_dv" => [$data],
            "p_b_v_dv" => [$data],
            "dividend_yield_dv" => [$data],
            "ev_ebitda_dv" => [$data],

            ]);
        }
        echo "<h1> Commodities Imported Successfully  </h1>";

    }

    function import_historical_data(){
        $exel_file = fopen("../storage/app/public/history.csv", 'r');
        $first_row = 0 ;
        while(($line = fgetcsv($exel_file)) !== FALSE) {
            if ($first_row == 0) {
                $first_row++;
                continue;
            }
            $companyObject = Company::select()->where("bloomberg" , $line[0])->first();
            if($companyObject){
                CompanyHistory::create([
                    "company_id" => $companyObject->id,
                    "closing_date" => $line[1] ,
                    "closing_price" => $line[2],
                ]);

            }

        }

        echo "<h1> History  Imported Successfully  </h1>";

    }

    function company_bloom(){
        $company_object = Company::select("id")->where("bloomberg", "TMGH EY dew")->get();
        return $company_object ;
    }

    function number_formating(){
        $company_object = Company::find(172);


        return $company_object->revenue_is;
    }
}
