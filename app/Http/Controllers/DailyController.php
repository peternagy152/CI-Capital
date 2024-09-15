<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\MacroPublication;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DailyController extends Controller
{
    function calendar_by_month(Request $request_data)
    {
        $day = $request_data->day ;
        $month = $request_data->month ;
        $year = $request_data->year ;
        if($day){
            $events = Event::select(["title", "desc", "cat", "published_at" ])->whereYear('published_at', $year)
                ->whereMonth('published_at', $month)->whereDay('published_at', $day)
                ->get();
        }else{
            $events = Event::select(["title", "desc", "cat", "published_at"])->whereYear('published_at', $year)
                ->whereMonth('published_at', $month)
                ->get();
        }

        $events->transform(function ($event) {
            $event->cat = Str::snake($event->cat, '_');
            return $event;
        });

        if($day){
            $company_report = Publication::select("name", "published_at" , "report")
                ->whereYear('published_at', $year)
                ->whereMonth('published_at', $month)
                ->whereDay('published_at', $day)
                ->get()
                ->map(function ($publication) {
                    return [
                        'title' => $publication->name,
                        "report" => url("/") . "/storage/" . $publication->report,
                        'created_at' => $publication->published_at
                    ];
                }) ->toArray();
            $macro_report = MacroPublication::select("name", "published_at" , "report")
                ->whereYear('published_at', $year)
                ->whereMonth('published_at', $month)
                ->whereDay('published_at', $day)
                ->get()
                ->map(function ($publication) {
                    return [
                        'title' => $publication->name,
                        "report" => url("/") . "/storage/" . $publication->report,
                        'created_at' => $publication->published_at
                    ];
                })->toArray();

        }else{
            $company_report = Publication::select("name", "published_at" , "report")
                ->whereYear('published_at', $year)
                ->whereMonth('published_at', $month)
                ->get()
                ->map(function ($publication) {
                    return [
                        'title' => $publication->name,
                        "report" => url("/") . "/storage/" . $publication->report,
                        'created_at' => $publication->published_at
                    ];
                }) ->toArray();
            $macro_report = MacroPublication::select("name", "published_at" , "report")
                ->whereYear('published_at', $year)
                ->whereMonth('published_at', $month)
                ->get()
                ->map(function ($publication) {
                    return [
                        'title' => $publication->name,
                        "report" => url("/") . "/storage/" . $publication->report,
                        'created_at' => $publication->published_at
                    ];
                })->toArray();
        }


        $reports = array_merge($company_report, $macro_report);


        $data = [
            "events" => $events,
            "reports" => $reports
        ];
        return ['status' => 'success', 'msg' => "Calendar Fetched", 'data' => $data];
    }

}
