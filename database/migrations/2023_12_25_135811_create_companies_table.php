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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string("name") ;
            $table->string("logo") ;
            $table->longText("desc") ;


            // Data Basic
            $table->string("bloomberg")->nullable() ;
            $table->string("reuters")->nullable() ;
            $table->integer("market_cap")->nullable() ;
            $table->integer("market_cap_local")->nullable() ;
            $table->integer("adtv")->nullable() ;
            $table->string("recommendation")->nullable();
            $table->string("tp_currency")->nullable();
            $table->float("target_price" , 8,2)->nullable();
            $table->float("closing_price",8,2)->nullable() ;
            $table->float("potential_return" ,8,2)->nullable();


            // ---------------------------- Data Miner---------------------

            // -------------------------------------- Income Statement ----------------------------


            $table->json("taxes_or_zakat_is")->nullable(); //Both
            $table->json("net_income_is")->nullable(); //Both

            $table->json("revenue_is")->nullable(); //Company
            $table->json("cost_of_sale_is")->nullable(); //Company
            $table->json("gross_profit_is")->nullable(); //Company
            $table->json("sg_a_is")->nullable(); //Company
            $table->json("ebit_is")->nullable(); //Company
            $table->json("d_a_is")->nullable(); //Company
            $table->json("ebitda_is")->nullable(); //Company


            $table->json("net_interest_income_is")->nullable(); //Bank
            $table->json("non_interest_income_is")->nullable(); //Bank
            $table->json("total_income_is")->nullable(); //Bank
            $table->json("total_operating_expenses_is")->nullable(); //Bank
            $table->json("net_operating_income_is")->nullable();  //Bank
            $table->json("provision_expense_is")->nullable();  //Bank //->ADD to Filament
            $table->json("net_income_before_tax_or_zakat_is")->nullable(); //Bank
            $table->json("net_income_before_minority_is")->nullable(); //Bank
            $table->json("minority_interest_is")->nullable(); //Bank


            // ------------------------- Balance Sheet --------- ------------


            $table->json("total_assets_bs")->nullable();  //Both
            $table->json("total_liabilities_bs")->nullable();  //Both
            $table->json("shareholders_equity_bs")->nullable();  //Both
            $table->json("total_liabilities_equity_bs")->nullable();   //Both


            $table->json("cash_equivalents_bs")->nullable(); //Company
            $table->json("accounts_receivables_bs")->nullable(); //Company
            $table->json("inventory_bs")->nullable(); //Company
            $table->json("net_fixed_assets_bs")->nullable(); //Company
            $table->json("other_non_current_assets_bs")->nullable(); //Company
            $table->json("short_term_debt_bs")->nullable(); //Company
            $table->json("long_term_debt_bs")->nullable(); //Company
            $table->json("payables_bs")->nullable(); //Company
            $table->json("current_liabilities_bs")->nullable(); //Company



            $table->json("other_liabilities_bs")->nullable();  //Bank
            $table->json("other_assets_bs")->nullable();  //Bank
            $table->json("cash_due_from_cb_bs")->nullable();   //Bank
            $table->json("due_from_banks_bs")->nullable();  //Bank
            $table->json("due_to_banks_bs")->nullable(); //Bank
            $table->json("investments_bs")->nullable();  //Bank
            $table->json("net_loans_bs")->nullable();  //Bank
            $table->json("deposits_bs")->nullable();  //Bank
            $table->json("borrowings_bs")->nullable();  //Bank



            //  ----------------- Cash Flow Summary  ----------------------

            $table->json("operating_cash_flow_cfs")->nullable(); //Company
            $table->json("working_capital_changes_cfs")->nullable(); //Company -> ADD to filament
            $table->json("cash_flow_from_operations_cfs")->nullable(); //Company
            $table->json("cash_flow_from_investing_cfs")->nullable(); //Company
            $table->json("cash_flow_from_financing_cfs")->nullable(); //Company
            $table->json("net_change_in_cash_flow_cfs")->nullable(); //Company

            // ----------------------- Growth Ratios --------------

            $table->json("net_income_gr")->nullable(); //Both

            $table->json("revenue_gr")->nullable(); //company
            $table->json("ebitda_gr")->nullable(); //company
            $table->json("ebit_gr")->nullable(); //company

            $table->json("assets_gr")->nullable(); //Bank
            $table->json("loans_gr")->nullable(); //Bank
            $table->json("deposits_gr")->nullable(); //Bank


            // ----------------------- Profitability --------------

            $table->json("gross_margin_p")->nullable() ; // Company
            $table->json("ebitda_margin_p")->nullable() ; // Company
            $table->json("net_margin_p")->nullable() ; // Company

            $table->json("nim_p")->nullable();  //Bank
            $table->json("cost_to_income_p")->nullable(); //Bank
            $table->json("roe_p")->nullable();  //Bank
            $table->json("roa_p")->nullable();  //Bank


            // ------------------- Liquidity ----------------

            $table->json("total_debt_to_equity_l")->nullable() ; //Company
            $table->json("net_debt_to_equity_l")->nullable() ; //Company
            $table->json("net_debt_cash_l")->nullable() ; //Company
            $table->json("net_debt_to_ebitda_l")->nullable() ; //Company

            // ------------------- Liquidity, asset quality, and capital ---------


            $table->json("loans_to_deposit_laqc")->nullable() ; //Bank
            $table->json("npl_ratio_laqc")->nullable() ; //Bank
            $table->json("cor_bps_laqc")->nullable() ; //Bank
            $table->json("coverage_laqc")->nullable() ; //Bank
            $table->json("total_car_laqc")->nullable() ; //Bank
            $table->json("tier_1_capital_laqc")->nullable() ; //Bank

            // ---------------- Per share data & valuation (x) --------------
            $table->json("eps_dv")->nullable(); //Both
            $table->json("bvps_dv")->nullable(); //Both
            $table->json("dps_dv")->nullable(); //Both
            $table->json("p_e_dv")->nullable(); //Both
            $table->json("p_b_v_dv")->nullable(); //Both
            $table->json("dividend_yield_dv")->nullable(); //Both
            $table->json("ev_ebitda_dv")->nullable(); //Company


            //Relations
            $table->unsignedBigInteger("macro_id") ;
            $table->unsignedBigInteger("type_id") ;
            $table->unsignedBigInteger("sector_id") ;

            $table->timestamps();

            $table->foreign('macro_id')
                ->references('id')
                ->on('macros')
                ->onDelete('cascade');

            $table->foreign('sector_id')
                ->references('id')
                ->on('sectors')
                ->onDelete('cascade');

            $table->foreign('type_id')
                ->references('id')
                ->on('types')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
