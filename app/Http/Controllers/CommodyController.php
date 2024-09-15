<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

//Models
use App\Models\Commody ;

class CommodyController extends Controller
{
    function get_commodities(Request $request_data){
        $model_commodities = Commody::select('category' , 'name' , "unit" , "spot" , "wow" , "mom" , "ytd")->get()->groupBy('category')->values();

        $formatted_commodities = [];
        foreach ($model_commodities as $category) {
            $category_data = [
                'category' => $category->first()->category,
                'data' => $category->map(function ($item) {
                    return [
                        'name' => $item->name,
                        'unit' => $item->unit,
                        'spot' => $item->spot,
                        'wow' => $item->wow,
                        'mom' => $item->mom,
                        'ytd' => $item->ytd,
                    ];
                })->toArray(),
            ];

            $formatted_commodities[] = $category_data;
        }

        $data = [
            "date" => date('j M Y') ,
            "title" => "MENA daily",
            "commodities" => $formatted_commodities,
        ];

       return ["status" => "success" , "msg" => "Commodities Fetched !" ,  "data" => $data];
    }
}
