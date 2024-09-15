<?php

namespace App\Http\Controllers;

use App\Models\Macro;
use App\Models\Sector;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    //
    function get_all_sectors(){
        $sectors = Sector::select(["id" , "name"])->get();
        return ["status" => "success" , "msg" => "Sectos Data Fetched" , "data" => $sectors] ;
    }
}
