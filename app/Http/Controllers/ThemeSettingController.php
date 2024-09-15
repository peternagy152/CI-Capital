<?php

namespace App\Http\Controllers;

use App\Models\ThemeSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Psy\Output\Theme;

class ThemeSettingController extends Controller
{
    function get_faqs(Request $request_data){
        $faqs = ThemeSetting::select( "faqs_header" ,"faqs")->first();

        return ['status' => "success" , 'msg' => "Faqs fetched" , "data" => $faqs] ;
    }

    function get_header_footer(Request $request_data){
        $user_id=$request_data->user()->id;
        $user = User::find($user_id);

        //header
        $theme_settings = ThemeSetting::latest()->first();

        $user_data = array(
            "user_id" => $user->id ,
            "name" => $user->name ,
            "email" => $user->email ,
            "mobile" => $user->mobile ,
            "title" => $user->title ,
            "company_name" => $user->company_name ,
            "profile_pic" => url('/') . '/storage/' .  $user->profile_pic ,
        );
        $data = [
            "header" => $theme_settings->primary_header ,
            "user_data" => $user_data ,
        ];

        return [
            "status" => "success",
            "msg" =>"Data Fetched" ,
            "data" => $data ,
        ] ;

    }

    function help_support(Request $request_data){
         $contact_data = ThemeSetting::select("theme_settings_1" , "contact_info")->latest()->first();
         $contact_info_data = [] ;

         foreach($contact_data['contact_info'] as $one_info){
             $temp_data = [
                 'icon' => url('storage')  . '/' . $one_info['contact_icon']  ,
                 'text' => $one_info['contact_text'] ,
                 'link' => $one_info['contact_link'] ,
             ] ;
             $contact_info_data [] = $temp_data ;
         }
         $data = [
             "help_support_title" => $contact_data['theme_settings_1'][0]['help_support_title'] ,
             "help_support_desc" => $contact_data['theme_settings_1'][0]['help_support_desc'] ,
             "contact_info" => $contact_info_data ,
         ] ;


        return ['status' => "success" , 'msg' => "Data fetched" , "data" => $data] ;

    }
}
