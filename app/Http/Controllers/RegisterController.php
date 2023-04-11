<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Session;

class RegisterController extends Controller
{
    public function register(){
        return view('register');
    }

        public function submitRegister(Request $request){
            try {
                //code...
                // print_r($request->all());exit;
                $api_url= env('APP_URL').'/api/register';
    
                $response = Curl::to($api_url)
                ->withData( array( 'email' => $request->email,'password'=>$request->password,'name'=>$request->name,'social_login_type'=>$request->social_login_type,'lattitude'=>$request->lattitude,'longitude'=>$request->lattitude ) )
                ->asJson( true )
                ->post();


                if($response['status']){
                    Session::put('authorizationToken', $response['token']);
                }
    
                return $response;
                
            } catch (\Throwable $th) {
                //throw $th;
               
                return response()->json(['status' => false,'message' => 'Something went wrong','errorMessage' => $th->getMessage()
                ]);
            }
        }
    
}
