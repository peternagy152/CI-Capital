<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\Models\MacroPublication;
use App\Models\Publication;
use App\Services\CompanyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\User ;
use App\Models\PasswordResetToken ;
use Carbon\Carbon;
use App\Traits\GlobalWidgets;
class users_controller extends Controller
{
    // General Function
    use GlobalWidgets;
    private $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    function randomPassword($counter) {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $counter; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function upload_image($request_image){


        $imageName = time() . '.' . $request_image->getClientOriginalExtension();
        $request_image->move(public_path('general'), $imageName);

        return $imageName ;

}

    function register_client(Request $request_data){
        //check if user Exist
        $user=User::where('email' , $request_data->email)->first();
        if($user){
            return ['status' => 'error' , 'msg' => "Email Already Exists ! " ] ;
        }
        $password = $this->randomPassword(15) ;

        $user=User::create([
            'name' => $request_data->name ,
            'email' => $request_data->email ,
            'password' => Hash::make($password) ,
            'mobile'     => $request_data->mobile ,
            'title'     => $request_data->title ,
            'company_name'     => $request_data->company_name ,
        ]);

        $user->assignRole('client');

        return [
            'status' => 'success' ,
            'msg' => "Your request is received. Please expect to receive login details soon upon internal processing. Thank you for choosing CI Capital Research." ,
        ] ;

    }

    function client_login(Request $request_data){
        $user=User::where('email' , $request_data->email)->first();
        if(!$user || !Hash::check($request_data->password , $user->password)){
            return ['status' => "error" , 'msg' => 'you provided wrong credentials'];
        }
        if(!$user->is_activated){
            return ['status' => "error" , 'msg' => 'Your Account Is not Activated , Contact Ci Capital Team'];
        }
        $token=$user->createToken('auth_token')->accessToken ;
        $user_data = array(
            "token" => $token ,
            "user_id" => $user->id ,
            "name" => $user->name ,
            "email" => $user->email ,
            "mobile" => $user->mobile ,
            "title" => $user->title ,
            "company_name" => $user->company_name ,
            "profile_pic" => url('/') .'/storage/' .   $user->profile_pic ,
        );


        return ['status' => 'success' , 'data' => $user_data];

    }

    function get_client_profile(Request $request_data){
        $user_id=$request_data->user()->id;
        $user = User::find($user_id);

        $user_data = array(
            "user_id" => $user->id ,
            "name" => $user->name ,
            "email" => $user->email ,
            "mobile" => $user->mobile ,
            "title" => $user->title ,
            "company_name" => $user->company_name ,
            "profile_pic" => url('/') .'/storage/' .   $user->profile_pic ,
        );
        return ['status' => 'success' , 'msg' => "Data Fetched " ,  'data' => $user_data];

    }

    function edit_client_profile_info(Request $request_data){
        $user_id=$request_data->user()->id;
        $user = User::find($user_id);
        $user->name = $request_data->name ;
        $user->mobile = $request_data->mobile ;
        $user->title = $request_data->title ;
        $user->company_name = $request_data->company_name ;
        $user->save();
        if(isset($request_data->profile_pic)){
            $image = $request_data->file('profile_pic');
            $imageName = "general/" . rand(0,9999) . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/storage/general/'), $imageName);
            $user->profile_pic = $imageName;
            $user->save();
        }

        //Return Data
        $user_data = array(
            "user_id" => $user->id ,
            "name" => $user->name ,
            "email" => $user->email ,
            "mobile" => $user->mobile ,
            "title" => $user->title ,
            "company_name" => $user->company_name ,
            "profile_pic" => url('/') .'/storage/' .   $user->profile_pic ,
        );

        return ['status' => 'success' , 'msg' => "Profile Updated !" , 'updated_user_data' => $user_data];
    }

    public function change_password(Request $request_data){
        $user_id=$request_data->user()->id;
        $user = User::find($user_id);

        if(!Hash::check($request_data->current_password , $user->password)){
            return ['status' => "error" , 'msg' => 'Wrong current password'];
        }else{
            $user->password =  Hash::make($request_data->new_password ) ;
            $user->save() ;
            return ['status' => 'success' , 'msg' => " Password Changed Successfully "] ;
        }


    }

    function forgot_password(Request $request_data){
        $user_email = $request_data->email ;

        $user=User::where('email' , $request_data->email)->first();
        if($user){
            //check if has an entry before
            $old_password_reset = PasswordResetToken::where('email' , $request_data->email)->first();
            if($old_password_reset){
                $old_password_reset->delete();
            }
            $token = $this->randomPassword(35);

            $passwordResetToken = new PasswordResetToken();
            $passwordResetToken->email = $request_data->email ;
            $passwordResetToken->token = $token;
            $passwordResetToken->created_at = Carbon::now();
            $passwordResetToken->save();

            //Send Mail
            $mail = new ForgotPassword($user_email , $token);
            Mail::to($request_data->email)->send($mail);

            return ['status' => 'success' , 'msg' => "A link has been sent to your email address" ] ;


          }else{
              return ['status' => 'error' , 'msg' => "Email is not registered " ] ;
          }


    }

    function reset_password(Request $request_data){
        $token  = $request_data->token ;
        $email = $request_data->email ;
        $new_password = $request_data->new_password ;


        $passwordResetToken = passwordResetToken::where('email' , $email)->first();
        if($passwordResetToken){
            if($passwordResetToken->token == $token){
            $user = User::where('email' , $email)->first();
            $user->password =  Hash::make($request_data->new_password ) ;
            $user->save() ;
            //remove record
            $passwordResetToken->delete();
            return ['status' => 'success' , 'msg' => " Password Changed Successfully "] ;
            }else{
                return ['status' => 'error' , 'msg' => "Something went wrong with the token" ] ;
            }

        }else{
            return ['status' => 'error' , 'msg' => "Something went wrong with the token" ] ;
        }
    }

    function my_account_overview(Request $request_data){
        // My Company Wishlist
        $all_liked_companies = $request_data->user()->Company() ->with("Macro:id,name")->get() ;
        $all_liked_analysts = $request_data->user()->LikeAnalyst()->with("User")->get();
        $analysts = $this->analystWidget($all_liked_analysts , $request_data->user());

        $output_companies = [];
        foreach ($all_liked_companies as $one_company) {
            $company_parameters = [];
            $company_parameters[] = ['title' => "Country", "value" => $one_company["macro"]->name];
            $company_parameters[] = ['title' => "TP", "value" =>  $this->companyService->handle_number_format($one_company->target_price) ];
            $company_parameters[] = ["title" => "Upside / downside potential", "value" =>  $this->companyService->handle_number_format($one_company->potential_return)];
            $data = [
                "id" => $one_company->id,
                "liked" => true,
                "name" => $one_company->name,
                "logo" => url('/storage') . '/' . $one_company->logo,
                "parameters" => $company_parameters,
            ];
            $output_companies [] = $data;
        }

        //Recent Publications
        $recent_company_pubs = Publication::with("Company.Macro:id,name")
            ->with("Analyst:id")
            ->with("Analyst.User")
            ->orderBy("created_at", "desc")
            ->limit(5)
            ->get();
        $recent_company_pubs_array = $this->publicationWidget($recent_company_pubs,"company" ,  $request_data->user());
        $recent_macro_pubs = MacroPublication::with("Macro:id,name")
            ->with("Analyst.User")
            ->with("Analyst:id")
            ->orderBy("created_at", "desc")
            ->limit(5)
            ->get();
        $recent_macro_pubs_array = $this->publicationWidget($recent_macro_pubs,"macro" ,  $request_data->user());
        $recent_pubs = array_merge($recent_company_pubs_array, $recent_macro_pubs_array);

        //Saved Publications
        $liked_publications = $request_data->user()->Publication()->with("Company.Macro:id,name")
            ->with("Analyst:id")
            ->with("Analyst.User")->limit(5)->get();
        $publications_array = $this->publicationWidget($liked_publications,"company" ,  $request_data->user());
        $liked_macro_publications = $request_data->user()->MacroPublication()->with("Macro:id,name")
            ->with("Analyst.User")
            ->with("Analyst:id")->limit(5)->get() ;
        $macro_publications_array = $this->publicationWidget($liked_macro_publications,"macro" ,  $request_data->user());
        $saved_merged_array = array_merge($publications_array, $macro_publications_array);


        $data = [
            "companies_count" => $request_data->user()->Company()->count() ,
            "analysts_count" => $request_data->user()->LikeAnalyst()->count() ,
            "reports_count" => $request_data->user()->Publication()->count() + $request_data->user()->MacroPublication()->count() ,
            "liked_companies"=> $output_companies ,
            "liked_analysts"=> $analysts ,
            "liked_publications"=> $saved_merged_array ,
            "recent_pubs" =>  $recent_pubs

        ] ;

        return ['status' => 'success' , 'msg' => "My Account Data Fetched " , 'data' => $data];



    }

    function logout(Request $request_data){
        $request_data->user()->token()->revoke();
        return ['status' => 'success', 'msg' => "Logged Out Successfully"];
    }

}
