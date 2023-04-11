<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Ixudra\Curl\Facades\Curl;
use Session;
use DB;

use Illuminate\Support\Facades\Redis;

class IndexController extends Controller
{
    public function index(){
        return view('index');
    }

    public function dashboard(Request $request){
        if (Session::has('authorizationToken'))
        {
            $api_url= env('APP_URL').'/api/home';
            $response = Curl::to($api_url)
            ->withBearer(Session::get('authorizationToken'))
            ->asJson( true )
            ->get();
            return view('home',compact('response'));
        }else{
            return redirect('/');
        }
        
    }

    public function logout(){
        session()->forget('authorizationToken');
        return redirect('/');
    }

   
}
