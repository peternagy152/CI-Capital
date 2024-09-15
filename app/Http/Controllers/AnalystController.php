<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use App\Models\MacroPublication;
use App\Models\Publication;
use App\Models\User;
use App\Traits\GlobalWidgets;
use Illuminate\Http\Request;
use App\Models\Analyst;
use App\Services\AnalystService;

class AnalystController extends Controller
{
    use GlobalWidgets;
    private $analystService ;
    private $reportService;
    function __construct( analystService $analystService , ReportService $reportService){
        $this->analystService = $analystService;
        $this->reportService = $reportService;
    }

    function get_all_analysts()
    {
        $analysts = Analyst::with("User")->get();
        $list = [];
        foreach ($analysts as $analyst) {
            $data = [
                'id' => $analyst->id,
                "name" => $analyst['user']->name,
                "title" => $analyst['user']->title,
                "profile_pic" => url('/storage/') . '/' . $analyst['user']->profile_pic,
            ];
            $list[] = $data;
        }
        return $list;
    }

    function analyst_list(Request $request_data)
    {
        $page = $request_data->page ?? 1;
        $perPage = 40 ;  // $request_data->per_page ?? 16;
        $wishlist = $request_data->wishlist ?? false;
        $keyword = $request_data->keyword ?? "";
        $macro = $request_data->macro ?? [];
        $sector = $request_data->sector ?? [];

        $analyst = $this->analystService->getAnalysts($page,$perPage,$keyword ,$wishlist,$request_data->user(),$macro,$sector);

        $data = [
            "analysts" => $this->analystService->formatAnalyst($analyst, $request_data->user()),
            "total_pages" => $analyst->lastPage()
        ];

        return ["status" => "success", "msg" => "Analysts Fetched ", "data" => $data];
    }

    function add_analyst_to_wishlist(Request $request_data)
    {
        if (empty($request_data->analyst_id)) {
            return ["status" => "error", "msg" => "Analyst ID is required"];
        }
        $analyst_id = $request_data->analyst_id;
        $analyst_object = Analyst::find($analyst_id);
        if ($analyst_object) {
            //Attach
            $request_data->user()->LikeAnalyst()->syncWithoutDetaching($analyst_id);
            return ["status" => "success", "msg" => "Analyst Added to wishlist"];
        } else {
            return ["status" => "error", "msg" => "Analyst not found"];
        }
    }

    function remove_analyst_from_wishlist(Request $request_data)
    {
        if (!isset($request_data->analyst_id) || empty($request_data->analyst_id)) {
            return ["status" => "error", "msg" => "Analyst ID is required"];
        }
        $analyst_id = $request_data->analyst_id;
        $analyst_object = Analyst::find($analyst_id);
        if ($analyst_object) {
            $request_data->user()->LikeAnalyst()->detach($analyst_id);
            return ["status" => "success", "msg" => "Analyst removed from wishlist"];
        } else {
            return ["status" => "error", "msg" => "Analyst not found"];
        }
    }

    function my_account_analyst_list(Request $request_data)
    {
        $all_liked_analysts = $request_data->user()->LikeAnalyst()->with("User")->get();
        $analysts = $this->analystWidget($all_liked_analysts, $request_data->user());
        return ["status" => "success", "msg" => "success", "data" => $analysts];
    }

    function analyst_profile(Request $request_data)
    {
        $analyst_id = $request_data->analyst_id ;
        $analyst = Analyst::find($analyst_id);
        $user = $analyst->user;;
        $page = $request_data->page ?? 1;
        $perPage = $request_data->per_page ?? 5;
        $type = $request_data->type ?? "";
        $macro = $request_data->macro ?? [];
        $sector = $request_data->sector ?? [];
        $company = $request_data->company ?? [];
        $keyword = $request_data->keyword ?? "";

        $reports = $this->reportService->getReports($page , $perPage ,$keyword , $analyst_id , $macro , $sector , $company , $type, $request_data->user());
        $sectors = [] ;
        foreach($analyst['Sector'] as  $oneSector) {$sectors[] = $oneSector->name;}
        $analyst_data = [
            "liked" =>  $request_data->user()->LikeAnalyst()->wherePivot('analyst_id', $analyst->id)->exists(),
            "name" => $user->name ,
            "title" => $user->title,
            "bio" => $analyst->bio ,
            "mobile" => $user->mobile,
            "email" => $user->email,
            "profile_pic" => url('/storage') . '/' . $user->profile_pic,
            "sectors" => $sectors
        ];

        $data = [
            "user_data" => $analyst_data,
            "reports" => $reports['reports'] ,
            "total_pages" => $reports['total_pages']
        ];

        return ["status" => "success", "msg" => "success", "data" => $data];

    }
}
