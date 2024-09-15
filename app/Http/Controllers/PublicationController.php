<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Publication;
use App\Traits\GlobalWidgets;
use Illuminate\Http\Request;

use App\Models\MacroDaily;
use App\Models\Daily;
use App\Models\Macro;
use App\Models\MacroPublication;
use Carbon\Carbon;

class PublicationController extends Controller
{

    use GlobalWidgets;

    function get_macro_publications(Request $request_data)
    {

        $macroId = $request_data->macro_id;
        $page = $request_data->page ?? 1;
        $per_page = $request_data->per_page ?? 4;

        $publications = MacroPublication::where('macro_id', $macroId)
            ->with("Analyst.User")
            ->latest()
            ->paginate($per_page, ['*'], 'page', $page);
        $totalPages = $publications->lastPage();

        $publications_array = $this->publicationWidget($publications , "macro" , $request_data->user());
        $data = [
            "publications" => $publications_array,
            "total_pages" => $totalPages,
        ];

        return ["status" => "success", "msg" => "Macro Publications Fetched", "data" => $data];


    }

    function research_publications(Request $request_data)
    {
        $page = $request_data->page ?? 1;
        $per_page = $request_data->per_page ?? 5;
        $type = $request_data->type ?? "";
        $macro = $request_data->macro ?? [];
        $sector = $request_data->sector ?? [];
        $company = $request_data->company ?? [];
        $analyst = $request_data->analyst ?? [];
        $wishlist = $request_data->wishlist ?? "false" ;
        $date_from = $request_data->date_from ?? "";
        $date_to = $request_data->date_to ?? "";

        if (isset($request_data->keyword) && !empty($request_data->keyword)) {
            $keyword = $request_data->keyword;
            $publications = Publication::with("Company.Macro:id,name")
                ->with("Company.Sector:id,name")
                ->with("Analyst:id")
                ->with("Analyst.User")
                ->where(function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })->get();
            $publications_array = $this->publicationWidget($publications,"company" , $request_data->user());
            $macroPublications = MacroPublication::with("Macro:id,name")
                ->with("Analyst.User")
                ->with("Analyst:id")
                ->where(function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })->get();
            $macro_publications_array = $this->publicationWidget($macroPublications,"macro" , $request_data->user()) ;
            $totalPages = 0 ;

        } else if($wishlist){
            $liked_publications = $request_data->user()->Publication()->with("Company.Macro:id,name")
                ->with("Analyst:id")
                ->with("Analyst.User")->get();
            $publications_array = $this->publicationWidget($liked_publications,"company" ,  $request_data->user());
            $liked_macro_publications = $request_data->user()->MacroPublication()->with("Macro:id,name")
                ->with("Analyst.User")
                ->with("Analyst:id")->get() ;
            $macro_publications_array = $this->publicationWidget($liked_macro_publications,"macro" ,  $request_data->user());
            $totalPages = 0 ;

        }else {
            $publications_array = [] ;
            $macro_publications_array = [] ;

           if(empty($type) || $type == "Macro"){
               $macroPublications = MacroPublication::with("Macro:id,name")
                   ->with("Analyst.User")
                   ->with("Analyst:id")
                   ->when(!empty($macro), function ($query) use ($macro) {
                       $query->whereHas('Macro', function ($subQuery) use ($macro) {
                           $subQuery->whereIn('id', $macro);
                       });
                   })
                   ->when(!empty($analyst), function ($query) use ($analyst) {
                       $query->whereHas('Analyst', function ($subQuery) use ($analyst) {
                           $subQuery->whereIn('macro_publications_analysts.analyst_id', $analyst);
                       });
                   })
                   ->when(!empty($date_from) && !empty($date_to), function ($query) use ($date_from, $date_to) {
                       $query->whereBetween('published_at', [$date_from, $date_to]);
                   })
                   ->orderBy('created_at', 'desc')
                   ->paginate($per_page, ['*'], 'page', $page);
               $totalPages = $macroPublications->lastPage();
               $macro_publications_array = $this->publicationWidget($macroPublications,"macro" ,  $request_data->user()) ;

           }
            if(empty($type) || $type == "Equity"){
                $publications = Publication::with("Company.Macro:id,name")
                    ->with("Company.Sector:id,name")
                    ->with("Analyst:id")
                    ->with("Analyst.User")
                    ->when(!empty($macro), function ($query) use ($macro) {
                        $query->whereHas('Company.Macro', function ($subQuery) use ($macro) {
                            $subQuery->whereIn('id', $macro);
                        });
                    })
                    ->when(!empty($sector), function ($query) use ($sector) {
                        $query->whereHas('Company.Sector', function ($subQuery) use ($sector) {
                            $subQuery->whereIn('id', $sector);
                        });
                    })
                    ->when(!empty($company), function ($query) use ($company) {

                        $query->whereHas('Company', function ($subQuery) use ($company) {
                            $subQuery->where('company_id', $company);
                        });
                    })

                    ->when(!empty($analyst), function ($query) use ($analyst) {
                        $query->whereHas('Analyst', function ($subQuery) use ($analyst) {
                            $subQuery->whereIn('publications_analysts.analyst_id', $analyst);
                        });
                    })
                    ->when(!empty($date_from) && !empty($date_to), function ($query) use ($date_from, $date_to) {
                        $query->whereBetween('published_at', [$date_from, $date_to]);
                    })
                    ->orderBy('published_at', 'desc')
                    ->paginate($per_page, ['*'], 'page', $page);
                $publications_array = $this->publicationWidget($publications,"company" ,  $request_data->user());
                $totalPages = $publications->lastPage();

            }

        }
        $merged_array = array_merge($publications_array, $macro_publications_array);
        usort($merged_array, function($a, $b) {return strtotime($b['created_at']) - strtotime($a['created_at']);});

        $data = [
            "publications" => $merged_array,
            "pages" => $totalPages,
        ];
        return $data;

    }

    function add_publication_to_wishlist(Request $request_data){

        if(!isset($request_data->report_id) || empty( $request_data->report_id)){
            return ["status" => "error" , "msg" => "Report ID is required"] ;
        }
        $report_id = $request_data->report_id ;
        $report_object = Publication::find($report_id);
        if($report_object){
            //Attach
            $request_data->user()->Publication()->syncWithoutDetaching($report_id) ;
            return ["status" => "success" , "msg" => "Report Added to wishlist"];
        }else{
            return ["status" => "error" , "msg" => "Report not found"] ;
        }

    }
    function remove_publication_from_wishlist(Request $request_data)
    {
        if(!isset($request_data->report_id) || empty( $request_data->report_id)){
            return ["status" => "error" , "msg" => "Report ID is required"] ;
        }
        $report_id = $request_data->report_id ;
        $company_object = Publication::find($report_id);
        if($company_object){
            $request_data->user()->Publication()->detach($report_id) ;
            return ["status" => "success" , "msg" => "Report removed from wishlist"];
        }else{
            return ["status" => "error" , "msg" => "Report not found"] ;
        }
    }

    function add_macro_publication_to_wishlist(Request $request_data){

        if(!isset($request_data->report_id) || empty( $request_data->report_id)){
            return ["status" => "error" , "msg" => "Report ID is required"] ;
        }
        $report_id = $request_data->report_id ;
        $report_object = MacroPublication::find($report_id);
        if($report_object){
            //Attach
            $request_data->user()->MacroPublication()->syncWithoutDetaching($report_id) ;
            return ["status" => "success" , "msg" => "Report Added to wishlist"];
        }else{
            return ["status" => "error" , "msg" => "Report not found"] ;
        }

    }

    function remove_macro_publication_from_wishlist(Request $request_data)
    {
        if(!isset($request_data->report_id) || empty( $request_data->report_id)){
            return ["status" => "error" , "msg" => "Report ID is required"] ;
        }
        $report_id = $request_data->report_id ;
        $company_object = MacroPublication::find($report_id);
        if($company_object){
            $request_data->user()->MacroPublication()->detach($report_id) ;
            return ["status" => "success" , "msg" => "Report removed from wishlist"];
        }else{
            return ["status" => "error" , "msg" => "Report not found"] ;
        }
    }

    function my_account_my_publications(Request $request_data){
        $liked_publications = $request_data->user()->Publication()->with("Company.Macro:id,name")
            ->with("Analyst:id")
            ->with("Analyst.User")->get();
        $publications_array = $this->publicationWidget($liked_publications,"company" ,  $request_data->user());
        $liked_macro_publications = $request_data->user()->MacroPublication()->with("Macro:id,name")
            ->with("Analyst.User")
            ->with("Analyst:id")->get() ;
        $macro_publications_array = $this->publicationWidget($liked_macro_publications,"macro" ,  $request_data->user());
        $merged_array = array_merge($publications_array, $macro_publications_array);

        return ["status" => "success" , "msg" => "Data Fetched", "data" => $merged_array ];
    }

}
