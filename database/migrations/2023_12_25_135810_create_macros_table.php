<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('macros', function (Blueprint $table) {
            $table->id();
            $table->string("name") ;
            $table->string("flag")->nullable() ;

            // -------------------------- Real Sector -------------------------
            //Real GDP Growth
            // $table->string("real_gdp_growth") ->nullable();
            $table->longText("real_gdp_growth_py_2")->nullable();
            $table->longText("real_gdp_growth_py_1")->nullable();
            $table->longText("real_gdp_growth_py")->nullable();
            $table->longText("real_gdp_growth_cy")->nullable();
            $table->longText("real_gdp_growth_cy_1")->nullable();


            // Real hydrocarbon growth (%)
            // $table->$this->longText("real_hydrocarbon_growth")->nullable();
            $table->longText("real_hydrocarbon_growth_py_2")->nullable();
            $table->longText("real_hydrocarbon_growth_py_1")->nullable();
            $table->longText("real_hydrocarbon_growth_py")->nullable();
            $table->longText("real_hydrocarbon_growth_cy")->nullable();
            $table->longText("real_hydrocarbon_growth_cy_1")->nullable();

            // Real non-hydrocarbon growth (%)
            // $table->$this->longText("real_non_hydrocarbon_growth")->nullable();
            $table->longText("real_non_hydrocarbon_growth_py_2")->nullable();
            $table->longText("real_non_hydrocarbon_growth_py_1")->nullable();
            $table->longText("real_non_hydrocarbon_growth_py")->nullable();
            $table->longText("real_non_hydrocarbon_growth_cy")->nullable();
            $table->longText("real_non_hydrocarbon_growth_cy_1")->nullable();

            // GDP/capita, current (USD)
            // $table->$this->longText("gdp_per_capita")->nullable();
            $table->longText("gdp_per_capita_py_2")->nullable();
            $table->longText("gdp_per_capita_py_1")->nullable();
            $table->longText("gdp_per_capita_py")->nullable();
            $table->longText("gdp_per_capita_cy")->nullable();
            $table->longText("gdp_per_capita_cy_1")->nullable();

            // Population (mn)
            // $table->$this->longText("population")->nullable();
            $table->longText("population_py_2")->nullable();
            $table->longText("population_py_1")->nullable();
            $table->longText("population_py")->nullable();
            $table->longText("population_cy")->nullable();
            $table->longText("population_cy_1")->nullable();


            // Unemployment rate (%)
            // $table->$this->longText("unemployment_rate")->nullable();
            $table->longText("unemployment_rate_py_2")->nullable();
            $table->longText("unemployment_rate_py_1")->nullable();
            $table->longText("unemployment_rate_py")->nullable();
            $table->longText("unemployment_rate_cy")->nullable();
            $table->longText("unemployment_rate_cy_1")->nullable();


            // ---------------------------- Fiscal Sector --------------
            // Government revenues (bn)
            // $table->$this->longText("government_revenues")->nullable();
            $table->longText("government_revenues_py_2")->nullable();
            $table->longText("government_revenues_py_1")->nullable();
            $table->longText("government_revenues_py")->nullable();
            $table->longText("government_revenues_cy")->nullable();
            $table->longText("government_revenues_cy_1")->nullable();

            // Government expenditure (bn)
            // $table->$this->longText("government_expenditure")->nullable();
            $table->longText("government_expenditure_py_2")->nullable();
            $table->longText("government_expenditure_py_1")->nullable();
            $table->longText("government_expenditure_py")->nullable();
            $table->longText("government_expenditure_cy")->nullable();
            $table->longText("government_expenditure_cy_1")->nullable();

            // Fiscal balance (% of GDP)
            // $table->$this->longText("fiscal_balance")->nullable();
            $table->longText("fiscal_balance_py_2")->nullable();
            $table->longText("fiscal_balance_py_1")->nullable();
            $table->longText("fiscal_balance_py")->nullable();
            $table->longText("fiscal_balance_cy")->nullable();
            $table->longText("fiscal_balance_cy_1")->nullable();

            // Debt (% of GDP )
            // $table->$this->longText("debit")->nullable();
            $table->longText("debit_py_2")->nullable();
            $table->longText("debit_py_1")->nullable();
            $table->longText("debit_py")->nullable();
            $table->longText("debit_cy")->nullable();
            $table->longText("debit_cy_1")->nullable();

            //------------------------------- External Sector -----------------------
            // Trade balance (bn)
            // $table->$this->longText("trade_balance")->nullable();
            $table->longText("trade_balance_py_2")->nullable();
            $table->longText("trade_balance_py_1")->nullable();
            $table->longText("trade_balance_py")->nullable();
            $table->longText("trade_balance_cy")->nullable();
            $table->longText("trade_balance_cy_1")->nullable();

            // Hydrocarbon exports (bn)
            // $table->$this->longText("hydrocarbon_exports")->nullable();
            $table->longText("hydrocarbon_exports_py_2")->nullable();
            $table->longText("hydrocarbon_exports_py_1")->nullable();
            $table->longText("hydrocarbon_exports_py")->nullable();
            $table->longText("hydrocarbon_exports_cy")->nullable();
            $table->longText("hydrocarbon_exports_cy_1")->nullable();

            // Current account balance (bn)
            // $table->$this->longText("current_account_balance")->nullable();
            $table->longText("current_account_balance_py_2")->nullable();
            $table->longText("current_account_balance_py_1")->nullable();
            $table->longText("current_account_balance_py")->nullable();
            $table->longText("current_account_balance_cy")->nullable();
            $table->longText("current_account_balance_cy_1")->nullable();

            // Current account balance (% of GDP)
            // $table->$this->longText("current_account_balance_gdp")->nullable();
            $table->longText("current_account_balance_gdp_py_2")->nullable();
            $table->longText("current_account_balance_gdp_py_1")->nullable();
            $table->longText("current_account_balance_gdp_py")->nullable();
            $table->longText("current_account_balance_gdp_cy")->nullable();
            $table->longText("current_account_balance_gdp_cy_1")->nullable();

            //--------------------------  Monetary Section --------------------------

            // Inflation (%)
            // $table->$this->longText("inflation")->nullable();
            $table->longText("inflation_py_2")->nullable();
            $table->longText("inflation_py_1")->nullable();
            $table->longText("inflation_py")->nullable();
            $table->longText("inflation_cy")->nullable();
            $table->longText("inflation_cy_1")->nullable();

            // Growth in private sector credit (%)
            // $table->$this->longText("private_sector_credit_growth")->nullable();
            $table->longText("private_sector_credit_growth_py_2")->nullable();
            $table->longText("private_sector_credit_growth_py_1")->nullable();
            $table->longText("private_sector_credit_growth_py")->nullable();
            $table->longText("private_sector_credit_growth_cy")->nullable();
            $table->longText("private_sector_credit_growth_cy_1")->nullable();


            // Discount rate (%)
            // $table->$this->longText("discount_rate")->nullable();
            $table->longText("discount_rate_py_2")->nullable();
            $table->longText("discount_rate_py_1")->nullable();
            $table->longText("discount_rate_py")->nullable();
            $table->longText("discount_rate_cy")->nullable();
            $table->longText("discount_rate_cy_1")->nullable();


            // ------------------ Hydrocarbon indicators ---------------------------
             // Oil production (mn bpd)
            // $table->$this->longText("oil_production")->nullable();
            $table->longText("oil_production_py_2")->nullable();
            $table->longText("oil_production_py_1")->nullable();
            $table->longText("oil_production_py")->nullable();
            $table->longText("oil_production_cy")->nullable();
            $table->longText("oil_production_cy_1")->nullable();

            // Brent price (USD/bbl)
            // $table->$this->longText("brent_price")->nullable();
            $table->longText("brent_price_py_2")->nullable();
            $table->longText("brent_price_py_1")->nullable();
            $table->longText("brent_price_py")->nullable();
            $table->longText("brent_price_cy")->nullable();
            $table->longText("brent_price_cy_1")->nullable();

            // Natural gas production (mn tpa)
            // $table->$this->longText("natural_gas_production")->nullable();
            $table->longText("natural_gas_production_py_2")->nullable();
            $table->longText("natural_gas_production_py_1")->nullable();
            $table->longText("natural_gas_production_py")->nullable();
            $table->longText("natural_gas_production_cy")->nullable();
            $table->longText("natural_gas_production_cy_1")->nullable();


            $table->longText("source")->nullable();
            $table->longText("note")->nullable();
            $table->string("currency")->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('macros');
    }
};
