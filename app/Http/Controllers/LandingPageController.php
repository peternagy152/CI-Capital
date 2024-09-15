<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\LandingPage ;
use App\Models\ThemeSetting;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    //


    function get_landing_page_data(){
        $page_data = LandingPage::latest()->first();
        $theme_settings = ThemeSetting::latest()->first();
        if(!$page_data){
            return ['status' => "Error" , 'msg' => "No Data Found !"] ;
        }

        $about_repeater = array() ;
        foreach($page_data->about_repeater as $one_repeater){
            $data = array(
                "title" =>  $one_repeater['title'] ,
                "subtitle" => $one_repeater['subtitle'] ,
                "about_image" => url('/') .  "/storage/" . $one_repeater['about_image'] ,
            );

            array_push($about_repeater , $data);
        }
        $about_section = array(
            "header" => $page_data->section_about ,
            "repeated_section" => $about_repeater
        );

        $navigate_head = array() ;
        foreach($page_data->navigate_section as $one_repeater){
            $data = array(
                "title" => $one_repeater['title'] ,
                "subtitle" => $one_repeater['subtitle'] ,
                "navigate_image" => url('/') .  "/storage/" . $one_repeater['navigate_image'] ,
//                "navigate_video" =>  $one_repeater['video_link']
            );
            array_push($navigate_head , $data);
        }

        $data = [
            "nav_menu" => $page_data->nav ,
            "hero_section" => $page_data->hero_section ,
            "about_section" => $about_section ,
            "navigation_section" =>array( "header" =>$navigate_head  ,"steps" => $page_data->navigate_steps) ,
            "request_form" => $page_data->request_form_header ,
        ] ;
        return ['status' => "success" , 'msg' => 'data fetched' , 'data' => $data];

    }
    function get_companies_logo(){
        $companies = Company::select("logo")->get();
        $logos = [] ;
        foreach($companies as $company){
            $logos [] = url('/') .  "/storage/" . $company->logo;
        }
        return $logos;

    }
}
