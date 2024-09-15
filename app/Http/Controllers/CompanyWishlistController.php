<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Responses\MyJsonResponse;

use App\Models\CompaniesUser ;
use App\Models\User ;
use App\Models\Company ;

class CompanyWishlistController extends Controller
{
    public function __construct(){

        $this->middleware('auth:api');
    }


    function add_company_to_wishlist(Request $request_data){

        if(!isset($request_data->company_id) || empty( $request_data->company_id)){
            return ["status" => "error" , "msg" => "Company ID is required"] ;
        }
        $company_id = $request_data->company_id ;
        $company_object = Company::find($company_id);
        if($company_object){
            //Attach
            $request_data->user()->Company()->syncWithoutDetaching($company_id) ;
            return ["status" => "success" , "msg" => "Company Added to wishlist"];
        }else{
            return ["status" => "error" , "msg" => "Company not found"] ;
        }

    }

    function remove_company_from_wishlist(Request $request_data){
        $user_id = $request_data->user()->id;
        if(!isset($request_data->company_id) || empty( $request_data->company_id)){
            return ["status" => "error" , "msg" => "Company ID is required"] ;
        }
        $company_id = $request_data->company_id ;
        $company_object = Company::find($company_id);
        if($company_object){
            $request_data->user()->Company()->detach($company_id) ;
            return ["status" => "success" , "msg" => "Company removed from wishlist"];
        }else{
            return ["status" => "error" , "msg" => "Company not found"] ;
        }

    }
}
