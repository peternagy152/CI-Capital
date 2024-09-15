<?php

namespace App\Http\Controllers;

use App\Models\ResearchService;
use App\Models\ServiceInquiry;
use App\Models\User;
use Illuminate\Http\Request;

class ServiceInquiryController extends Controller
{
    function insert_inquiry(Request $request_data)
    {

        if (!isset($request_data->service, $request_data->notes) || empty($request_data->service)) {
            return ['status' => 'error', 'msg' => 'service and note Required'];
        }
        $user_id = $request_data->user()->id;

        $user_object = User::find($user_id);
        ServiceInquiry::create([
            "user_id" => $user_id,
            "service" => $request_data->service,
            "notes" => $request_data->notes,
            "user_name" => $user_object->name,
            "user_email" => $user_object->email,
            "user_phone" => $user_object->mobile,
        ]);
        $thanks_page_response = ResearchService::select("thanks_page")->latest()->first();
        return ['status' => 'success', 'msg' => "Inquired Submitted", "data" => $thanks_page_response  ];

    }
}
