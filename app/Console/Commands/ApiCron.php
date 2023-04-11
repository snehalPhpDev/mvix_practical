<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use App\Models\User;
use Ixudra\Curl\Facades\Curl;

class ApiCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'store api data in redis';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users=User::get();
        $redis = Redis::connection();
        foreach($users as $user){
            $api_url='https://api.openweathermap.org/data/2.5/weather?lat='.$user->lattitude.'&lon='.$user->longitude.'&appid=850974d2de8c60a4ac34162bb759d0eb';
            $response = Curl::to($api_url)
            ->asJson( true )
            ->get();
            
            if(@$response['main']){
                Redis::set('user'.$user->id, json_encode($response['main']));
               
            }
        }
        return response()->json(['status' => true,'message' => 'success']);
    }
}
