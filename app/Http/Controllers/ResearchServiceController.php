<?php

namespace App\Http\Controllers;

use App\Models\ResearchService ;
use Illuminate\Http\Request;

class ResearchServiceController extends Controller
{

    function get_research_service_page_data(){
        $page_data = ResearchService::latest()->first();
        $repeated_section = []  ;
        foreach($page_data->repeated_section as $one_section){
            $data = array(
                "title" => $one_section['title'] ,
                "desc" => $one_section['desc'] ,
                "image" => url('/') . "/storage/" . $one_section['right_image'] ,
            );
            $repeated_section [] = $data ;
        }
        $data = array(
            "header" => $page_data->header ,
            "repeated_section" => $repeated_section ,
        );
        return [ "status" => "success" , "msg" => "Data fetched" , "data" => $data ] ;
    }
}
