<?php

namespace App\Http\Controllers;

use App\Models\ContactUsForm;
use App\Models\User;
use Illuminate\Http\Request;

class ContactUsFormController extends Controller
{
    //
    function insert_help_support_request(Request $request_data){
        if(!isset($request_data->message) || empty($request_data->message)){
            return ["status" => "error" , "msg" => "Message is required"] ;
        }
        $user_id = $request_data->user()->id;
        $user_object = User::find($user_id);
        ContactUsForm::create([
            "user_id" => $user_id,
            "message" => $request_data->message,
            "user_name" => $user_object->name,
            "user_email" => $user_object->email,
            "user_phone" => $user_object->mobile,
        ]);

        return ["status" => "success" , "msg" => "Contact Us Form Submitted"];

    }
}
