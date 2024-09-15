<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'desc' => $this->faker->paragraph,
            'logo' => $this->faker->image,
            'macro_id' => $this->faker->numberBetween(1, 5),
            'type_id' => $this->faker->numberBetween(1, 2),
            'sector_id' => $this->faker->numberBetween(1, 30),
            'bloomberg' => $this->faker->firstName,
            'reuters' => $this->faker->firstName,
            'tp_currency' => "EGP",
            "market_cap" => $this->faker->randomFloat("2", 0, 100000),
            "market_cap_local" => $this->faker->randomFloat("2", 0, 100000),
            "adtv" => $this->faker->randomFloat("2", 0, 100000),
            "recommendation"=> $this->faker->firstName,
            "target_price" => $this->faker->randomFloat("2", 0, 100000),
            "closing_price" => $this->faker->randomFloat("2", 0, 100000),
            "potential_return"=> $this->faker->randomFloat("2", 0, 100000),
            'taxes_or_zakat_is' => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "net_income_is" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "revenue_is" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "cost_of_sale_is" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "gross_profit_is" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "sg_a_is" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "ebit_is" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "d_a_is" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "ebitda_is" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "net_interest_income_is" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "non_interest_income_is" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "total_income_is" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "total_operating_expenses_is" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "net_operating_income_is" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "provision_expense_is" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "net_income_before_tax_or_zakat_is" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "net_income_before_minority_is" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "minority_interest_is" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "total_assets_bs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "total_liabilities_bs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "shareholders_equity_bs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "total_liabilities_equity_bs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "cash_equivalents_bs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "accounts_receivables_bs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "inventory_bs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "net_fixed_assets_bs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "other_non_current_assets_bs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "short_term_debt_bs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "long_term_debt_bs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "payables_bs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "current_liabilities_bs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "other_liabilities_bs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "other_assets_bs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "cash_due_from_cb_bs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "due_from_banks_bs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "due_to_banks_bs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "investments_bs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "net_loans_bs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "deposits_bs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "borrowings_bs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "operating_cash_flow_cfs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "working_capital_changes_cfs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "cash_flow_from_operations_cfs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "cash_flow_from_investing_cfs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "cash_flow_from_financing_cfs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "net_change_in_cash_flow_cfs" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "net_income_gr" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "revenue_gr" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "ebitda_gr" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "ebit_gr" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "assets_gr" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "loans_gr" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "deposits_gr" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "gross_margin_p" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "ebitda_margin_p" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "net_margin_p" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "nim_p" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "cost_to_income_p" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "roe_p" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "roa_p" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "total_debt_to_equity_l" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "net_debt_to_equity_l" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "net_debt_cash_l" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "net_debt_to_ebitda_l" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "loans_to_deposit_laqc" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "npl_ratio_laqc" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "cor_bps_laqc" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "coverage_laqc" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "total_car_laqc" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "tier_1_capital_laqc" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "eps_dv" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "bvps_dv" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "dps_dv" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "p_e_dv" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "p_b_v_dv" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "dividend_yield_dv" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),
            "ev_ebitda_dv" => array(
                [
                    "previous_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_1" => $this->faker->randomFloat("2", 0, 100000),
                    "current_year_2" => $this->faker->randomFloat("2", 0, 100000),
                ],
            ),


        ];
    }
}
