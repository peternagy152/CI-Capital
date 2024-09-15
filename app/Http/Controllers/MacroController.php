<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Traits\GlobalWidgets;
use Illuminate\Http\Request;
use App\Models\MacroDaily;
use App\Models\Daily;
use App\Models\Macro;
use App\Models\MacroPublication;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

use App\Services\MacroService ;

class MacroController extends Controller
{
    use GlobalWidgets;
    private $macroService;
    public function __construct(macroService $macroService){
        $this->macroService = $macroService;
    }

    function get_new_daily(Request $request_data)
    {
        if (isset($request_data->date) && !empty($request_data->date)) {
            $selectedDate = $request_data->date;
        } else {
            $selectedDate = Carbon::today()->toDateString();
        }
        $keyword = $request_data->keyword ?? "" ;
        $daily = $this->macroService->getDaily($keyword ,$selectedDate ) ;
        $data = [
            "date" => date('j M Y'),
            "title" => "MENA daily",
            "daily" => $daily
        ];

        return ["status" => "success", "msg" => "Latest Macro Daily Fetched ! ", "data" => $data];
    }

    function single_macro(Request $request_data)
    {
        //Macros
        $limit = $request_data->daily_limit ?? 3;
        $macros = Macro::selectRaw("id, name, CONCAT('" . url('/') . "', '/storage/', flag) as flag")->get();
        $macroId = $request_data->macro_id ?? $macros[0]->id;
        $daily = $this->macroService->getDailiesForSingleMacro($limit, $macroId);
        $macroObject = Macro::find($macroId);

        $data = [
            "title" => "Macro coverage",
            "macros" => $macros,
            "daily_section" => ["title" => "stories", "daily" =>  $this->dailyWidget($daily, "macro")],
            "reports_section" => ["title" => "reports"],
            "forecasts_section" => ["title" => "macro forecasts", "forecasts_data" => $this->macroService->formatMacroForecast($macroObject)],
            "forecasts_note" => $macroObject->note,
            "forecasts_source" => $macroObject->source,
        ];

        return ["status" => "success", "msg" => "Macro Data Fetched", "data" => $data];
    }

    function get_all_macros()
    {
        $macros = Macro::select(["id", "name"])->get();
        return ["status" => "success", "msg" => "Macro Data Fetched", "data" => $macros];
    }
}
