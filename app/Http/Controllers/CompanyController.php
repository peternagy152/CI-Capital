<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyHistory;
use App\Models\Daily;
use App\Models\Macro;
use App\Models\Publication;
use App\Traits\GlobalWidgets;
use Illuminate\Http\Request;
use App\Services\CompanyService;

class CompanyController extends Controller
{
    use GlobalWidgets;
    private $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }


    //
    function get_all_companies()
    {
        $all_companies = Company::select(['id', "name"])->get();
        return ["status" => "success", "msg" => "Companies data fetched", "data" => $all_companies];
    }

    function coverage_universe(Request $request_data)
    {

        $page = $request_data->page ?? 1;
        $perPage = $request_data->per_page ?? 10;
        $wishlist = $request_data->wishlist ?? false;
        $user = $request_data->user();
        $keyword = $request_data->keyword ?? "";
        $sectors = $request_data->sector ?? [];
        $macros = $request_data->macro ?? [];

        $companies = $this->companyService->getCompaniesForCoverageUniverse($keyword, $page, $perPage, $wishlist, $macros, $sectors, $user);

        $data = [
            "companies" => $this->companyService->formatCompaniesForCoverageUniverse($companies, $user),
            "pages" => $companies->lastPage(),
        ];

        return ["status" => "success", "msg" => "Data Fetched ! ", "data" => $data];
    }



    function single_company(Request $request_data)
    {
        if (!isset($request_data->company_id) || empty($request_data->company_id)) {
            return response()->json([
                'status' => 'error',
                'msg' => 'No Company Selected'
            ], 400);
        }

        $company_id = $request_data->company_id;

        $companyObject = Company::where("id", $company_id)->with("Macro")->with("Type")->with("Analyst.User")->with("Sector")->first();
        if ($companyObject) {

            $singleCompanyData = $this->companyService->formatSingleCompany($companyObject);

            $top_data = [
                "name" => $companyObject->name,
                "liked" => $request_data->user()->Company()->wherePivot('company_id', $request_data->company_id)->exists(),
                "logo" => url('/storage') . '/' . $companyObject->logo,
                "parameters" => $singleCompanyData['top_data'],
            ];

            $hero = [
                "company_background" => ["title" => "Company background", "value" => $companyObject->desc],
                "analysts" => $singleCompanyData['analyst'],
            ];

            $publications = Publication::whereHas('company', function ($query) use ($company_id) {
                $query->where('company_id', $company_id);
            })
                ->with("Analyst.User")
                ->with("Company:name")
                ->latest()->take(6)
                ->get();

            $daily = Daily::with(['Source:id,name', 'Company:id,name,macro_id', "Company.Macro:id,name"])
                ->where("company_id", $company_id)
                ->latest()->take(6)
                ->get();


            $data = [
                "top" => $top_data,
                "hero" => $hero,
                "publications" => ["title" => "Recent publications", "data" => $this->publicationWidget($publications, "company", $request_data->user())],
                "daily" => ["title" => "Daily news", "data" => $this->dailyWidget($daily, "company")],
                "company_data" => ["title" => "Summary financials & valuation", "data" => $singleCompanyData['summary']],
            ];
            return response()->json([
                "status" => "success",
                "msg" => "data fetched",
                "data" => $data
            ], 200);
        } else {
            return response()->json([
                "status" => "error",
                "msg" => "Company Not Found "
            ], 400);
        }
    }

    function peer_companies(Request $request_data)
    {
        if (empty($request_data->company_id)) {
            return response()->json([
                "status" => "error",
                "msg" => "No Company Selected "
            ], 400);
        }

        if (empty($request_data->selection)) {
            return response()->json([
                "status" => "error",
                "msg" => "No Category Selected "
            ], 400);
        }
        $company_id = $request_data->company_id;
        $selection = $request_data->selection; //local - mena

        $companyObject = Company::where("id", $company_id)->with("Type")->with("Analyst.User")->with("Sector")->first();

        if ($companyObject) {
            $peerCompanies = $this->companyService->getPeerCompanies($companyObject, $selection);
            return response()->json([
                'status' => "success",
                "msg" => "Peer Companies Fetched",
                "data" => $this->companyService->formatPeerCompanies($peerCompanies)
            ], 200);
        } else {
            return response()->json([
                "status" => "error",
                "msg" => "Company Not Found"
            ], 400);
        }
    }



    function coverage(Request $request)
    {
        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? 10;
        $keyword = $request->keyword ?? '';

        $companies = $this->companyService->getCompaniesForCoverage($keyword, $perPage, $page);
        $enhancedCompanies = $this->companyService->formatCompaniesForCoverage($companies);

        $data = ["companies" => $enhancedCompanies];

        return response()->json([
            "status" => "success",
            "msg" => "Coverage Fetched",
            "data" => $data,
        ]);
    }



    function my_account_company_list(Request $request_data)
    {
        $all_liked_companies = $request_data->user()->Company()->with("Macro:id,name")->with("Sector:id,name")->get();
        $companies = $this->companyWidget($all_liked_companies, $request_data->user());
        return ["status" => "success", "msg" => "success", "data" => $companies];
    }


    function historical_data(Request $request_data)
    {
        if (!isset($request_data->company_id)) {
            return response()->json([
                "status" => "error",
                "msg" => "You must provide a company id"
            ], 400);
        } else {
            if (!Company::find($request_data->company_id)) {
                return response()->json([
                    "status" => "error",
                    "msg" => "Company Not Found"
                ], 400);
            }

            $history = CompanyHistory::select(["closing_date", "closing_price"])->where("company_id", $request_data->company_id)->orderBy('closing_date', 'asc')->get();
            return ['status' => 'success', 'msg' => "history data fetched", "data" => $history];
        }
    }
}
