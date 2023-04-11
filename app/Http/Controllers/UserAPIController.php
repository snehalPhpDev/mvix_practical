<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

use App\Models\User;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class UserAPIController extends Controller
{
    public function register(RegisterRequest $request){
        try {
            $user = User::create([
                'email' => $request->email,
                'password'=> bcrypt($request->password),
                'name'=>$request->name,
                'email_verified_at'=>date('Y-m-d H:i:s'),
                'lattitude'=>$request->lattitude,
                'longitude'=>$request->longitude
            ]);
            Auth::login($user);
            $accessToken = $user->createToken($user->email)->accessToken;
            return response()->json(['status' => true,'message' => 'User registration successfully','data' => $user,'token' => $accessToken]);
        } catch (\Throwable $th) {
                return response()->json(['status' => false,'message' => 'Something went wrong','errorMessage' => $th->getMessage()
            ]);
        }
    }

    
    public function socialLogin(LoginRequest $request){
        try {
            $params=$request->all();
            $params['password'] = 'social_login_password';
            $params['name'] = $request->name;
            $params['email'] = $request->email;
            $params['social_id']=$request->social_id;
            if (@$request['name']=='') {
                unset($params['name']);
            }
            
            $user = User::updateOrCreate(['email'=>$request->email],$params);
            $token = $user->createToken($request->email)->accessToken;
            Auth::login($user);
            $accessToken = $user->createToken($user->email)->accessToken;
            return response()->json(['status' => true,'message' => 'User login successfully','data' => $user,'token' => $accessToken]);
        } catch (\Throwable $th) {
                return response()->json(['status' => false,'message' => 'Something went wrong','errorMessage' => $th->getMessage()
            ]);
        }
    }

    public function login(LoginRequest $request){
        
        try {
            
            $user=User::where('email',$request->email)->first();
            
            User::where('email',$request->email)->update([
                'lattitude'=>$request->lattitude,
                'longitude'=>$request->longitude
            ]);
            $data = [
                'email' => $request->email,
                'password' => $request->password
            ];
            if (auth()->attempt($data)) {
                $accessToken = auth()->user()->createToken($request->email)->accessToken;
                return response()->json(['status'=>true,'message' => 'Login successfully.','data' => $user,'token' => $accessToken]);
            } else {
                return response()->json(['status'=>false,'message' => 'Invalid login access.']);
            }
           
        } catch (\Throwable $th) {
            
                return response()->json(['status' => false,'message' => 'Something went wrong','errorMessage' => $th->getMessage()
            ]);
        }
    }

    public function home(Request $request){
        
        $user=Auth::user();
        $redis = Redis::connection();
        $api_data=json_decode(Redis::get('user'.$user->id));

        $data=array('user'=>$user,'main'=>$api_data) ;
        return response()->json(['status'=>true,'message' => 'Data fetch successfully.','data' => $data]);
    }

    
}
