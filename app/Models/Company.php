<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        "logo" => 'array',

        // Income Statement
        'taxes_or_zakat_is' => 'json',
        'net_income_is' => 'json',
        'revenue_is' => 'json',
        'cost_of_sale_is' => 'json',
        'gross_profit_is' => 'json',
        'sg_a_is' => 'json',
        'ebit_is' => 'json',
        'd_a_is' => 'json',
        'ebitda_is' => 'json',
        'net_interest_income_is' => 'json',
        'non_interest_income_is' => 'json',
        'provision_expense_is' => 'json',
        'total_income_is' => 'json',
        'total_operating_expenses_is' => 'json',
        'net_operating_income_is' => 'json',
        'net_income_before_tax_or_zakat_is' => 'json',
        'net_income_before_minority_is' => 'json',
        'minority_interest_is' => 'json',
        // Balance Sheet
        'total_assets_bs' => 'json',
        'total_liabilities_bs' => 'json',
        'shareholders_equity_bs' => 'json',
        'total_liabilities_equity_bs' => 'json',
        'cash_equivalents_bs' => 'json',
        'accounts_receivables_bs' => 'json',
        'inventory_bs' => 'json',
        'net_fixed_assets_bs' => 'json',
        'other_non_current_assets_bs' => 'json',
        'short_term_debt_bs' => 'json',
        'long_term_debt_bs' => 'json',
        'payables_bs' => 'json',
        'current_liabilities_bs' => 'json',
        'other_liabilities_bs' => 'json',
        'other_assets_bs' => 'json',
        'cash_due_from_cb_bs' => 'json',
        'due_from_banks_bs' => 'json',
        'due_to_banks_bs' => 'json',
        'investments_bs' => 'json',
        'net_loans_bs' => 'json',
        'deposits_bs' => 'json',
        'borrowings_bs' => 'json',
        // Cash Flow Summary
        'operating_cash_flow_cfs' => 'json',
        'working_capital_changes_cfs' => 'json',
        'cash_flow_from_operations_cfs' => 'json',
        'cash_flow_from_investing_cfs' => 'json',
        'cash_flow_from_financing_cfs' => 'json',
        'net_change_in_cash_flow_cfs' => 'json',
        // Growth Ratios
        'net_income_gr' => 'json',
        'revenue_gr' => 'json',
        'ebitda_gr' => 'json',
        'ebit_gr' => 'json',
        'assets_gr' => 'json',
        'loans_gr' => 'json',
        'deposits_gr' => 'json',
        // Profitability
        'gross_margin_p' => 'json',
        'ebitda_margin_p' => 'json',
        'net_margin_p' => 'json',
        'nim_p' => 'json',
        'cost_to_income_p' => 'json',
        'roe_p' => 'json',
        'roa_p' => 'json',
        // Liquidity
        'total_debt_to_equity_l' => 'json',
        'net_debt_to_equity_l' => 'json',
        'net_debt_cash_l' => 'json',
        'net_debt_to_ebitda_l' => 'json',
        // Liquidity, Asset Quality, and Capital
        'loans_to_deposit_laqc' => 'json',
        'npl_ratio_laqc' => 'json',
        'cor_bps_laqc' => 'json',
        'coverage_laqc' => 'json',
        'total_car_laqc' => 'json',
        'tier_1_capital_laqc' => 'json',
        // Per Share Data & Valuation
        'eps_dv' => 'json',
        'bvps_dv' => 'json',
        'dps_dv' => 'json',
        'p_e_dv' => 'json',
        'p_b_v_dv' => 'json',
        'dividend_yield_dv' => 'json',
        'ev_ebitda_dv' => 'json',

    ];

    public function Macro()
    {
        return $this->belongsTo(Macro::class);
    }

    public function Type()
    {
        return $this->belongsTo(Type::class);
    }

    public function Publication()
    {
        return $this->belongsToMany(Publication::class, "company_publication");
    }

    public function Sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function DataMiner()
    {
        return $this->hasMany(DataMiner::class);
    }

    public function Daily()
    {
        return $this->hasMany(Daily::class);
    }

    public function Analyst()
    {
        return $this->belongsToMany(Analyst::class, "companies_analysts");
    }


    public function User()
    {
        return $this->belongsToMany(User::class, "companies_users");
    }

    public function CompanyHistory()
    {
        return $this->hasMany(CompanyHistory::class);
    }


}
