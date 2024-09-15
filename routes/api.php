<?php

use App\Http\Controllers\ContactUsFormController;
use App\Http\Controllers\DailyController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\ServiceInquiryController;
use App\Http\Controllers\ThemeSettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\device_controller;
use App\Http\Controllers\users_controller;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ResearchServiceController;
use App\Http\Controllers\CommodyController;
use App\Http\Controllers\MacroDailyController;
use App\Http\Controllers\MacroController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\CompanyWishlistController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AnalystController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Catching AuthenticationException for unmatched routes

// My Account Endpoints
Route::post("register_client", [users_controller::class, 'register_client']);
Route::post("client_login", [users_controller::class, 'client_login']);
Route::post("forgot_password", [users_controller::class, 'forgot_password']);
Route::post("reset_password", [users_controller::class, 'reset_password']);


// Must Be Logged In Api's
Route::middleware('auth:api')->group(function () {

    //logout
    Route::post("logout", [users_controller::class, 'logout']);
    //Header and Footer
    Route::get("get_header_footer", [ThemeSettingController::class, 'get_header_footer']);

    //My Account
    Route::get("get_client_profile", [users_controller::class, 'get_client_profile']);
    Route::post("edit_client_profile_info", [users_controller::class, 'edit_client_profile_info']);
    Route::post("change_password", [users_controller::class, 'change_password']);

    //Macro
    Route::post("get_daily", [MacroController::class, 'get_daily']);
     Route::post("get_new_daily", [MacroController::class, 'get_new_daily']);
    Route::post("single_macro", [MacroController::class, 'single_macro']);
    Route::post("get_macro_publications", [PublicationController::class, 'get_macro_publications']);

    //Publications
    Route::post("research_publications", [PublicationController::class, 'research_publications']);


    //Coverage
    Route::post("coverage_universe", [CompanyController::class, 'coverage_universe']);
    Route::post("single_company", [CompanyController::class, 'single_company']);
    Route::post("peer_companies", [CompanyController::class, 'peer_companies']);
    Route::post("coverage", [CompanyController::class, 'coverage']);  //Modified And Enhanced
    Route::post("historical_data", [CompanyController::class, 'historical_data']);


    //Analyst
    Route::post("analyst_list", [AnalystController::class, "analyst_list"]);
    Route::post("analyst_profile" , [AnalystController::class , 'analyst_profile']);

    //Pages and Forms
    Route::get("get_research_service_page_data", [ResearchServiceController::class, 'get_research_service_page_data']);
    Route::post("insert_inquiry", [ServiceInquiryController::class, "insert_inquiry"]);
    Route::post("insert_help_support_request", [ContactUsFormController::class, "insert_help_support_request"]);

    Route::get('help_support', [ThemeSettingController::class, 'help_support']);
    Route::get("get_commodities", [CommodyController::class, 'get_commodities']);

    //My Account Wishlists
    Route::post("add_company_to_wishlist", [CompanyWishlistController::class, 'add_company_to_wishlist']);
    Route::post("remove_company_from_wishlist", [CompanyWishlistController::class, 'remove_company_from_wishlist']);
    Route::post("add_publication_to_wishlist" , [PublicationController::class, 'add_publication_to_wishlist']);
    Route::post("remove_publication_from_wishlist" , [PublicationController::class, 'remove_publication_from_wishlist']);
    Route::post("add_macro_publication_to_wishlist" , [PublicationController::class , 'add_macro_publication_to_wishlist']);
    Route::post("remove_macro_publication_from_wishlist" , [PublicationController::class , 'remove_macro_publication_from_wishlist']);
    Route::post("add_analyst_to_wishlist" , [AnalystController::class , 'add_analyst_to_wishlist']);
    Route::post("remove_analyst_from_wishlist" , [AnalystController::class, 'remove_analyst_from_wishlist']);
    //My Account Lists
    Route::post("my_account_overview" , [users_controller::class , 'my_account_overview']);
    Route::get("my_account_company_list" , [CompanyController::class , 'my_account_company_list']);
    Route::get("my_account_analyst_list" , [AnalystController::class , 'my_account_analyst_list']);
    Route::get("my_account_my_publications" , [PublicationController::class , "my_account_my_publications"]);
    //My Account Calendar
    Route::post("calendar_by_month" , [DailyController::class , 'calendar_by_month']);

});


//Static Pages
Route::get("get_landing_page_data", [LandingPageController::class, 'get_landing_page_data']);
Route::get("get_companies_logo", [LandingPageController::class, 'get_companies_logo']);
Route::get('get_faqs', [ThemeSettingController::class, 'get_faqs']);

//Filters Data
Route::get("get_all_macros", [MacroController::class, 'get_all_macros']);
Route::get("get_all_sectors", [SectorController::class, 'get_all_sectors']);
Route::get("get_all_companies" , [CompanyController::class, 'get_all_companies']);
Route::get("get_all_analysts" , [AnalystController::class , 'get_all_analysts']);


Route::get("for_testing" , [device_controller::class , 'company_bloom']);

Route::get("numbers" , [device_controller::class , 'number_formating']);
