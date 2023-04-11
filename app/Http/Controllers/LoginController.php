<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Ixudra\Curl\Facades\Curl;
use Session;

class LoginController extends Controller
{
    public function redirectToGoogle()
    {
         return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        $user = Socialite::driver('google')->user();
        $api_url= env('APP_URL').'/api/social-login';

            $response = Curl::to($api_url)
            ->withData( array( 'email' => $user->email,'social_id'=>$user->id,'social_login_type'=>'google','name'=>$user->name ) )
            ->asJson( true )
            ->post();
            
            if($response['status']){
                Session::put('authorizationToken', $response['token']);
                Session::put('user', $response['data']['id']);
                return redirect('/home');
            }else{
                return redirect('login/google/callback');
            }
    }

    public function login(){
        return view('login');
    }

    public function submitLogin(Request $request){
        try {
             $api_url= env('APP_URL').'/api/login';

            $response = Curl::to($api_url)
            ->withData( array( 'email' => $request->email,'password'=>$request->password,'social_login_type'=>$request->social_login_type,'lattitude'=>$request->lattitude,'longitude'=>$request->lattitude ) )
            ->asJson( true )
            ->post();
            
            if($response['status']){
                Session::put('authorizationToken', $response['token']);
                Session::put('user', $response['data']['id']);
            }

            return $response;
            
        } catch (\Throwable $th) {
            return response()->json(['status' => false,'message' => 'Something went wrong','errorMessage' => $th->getMessage()
            ]);
        }
       
    }

    
}
