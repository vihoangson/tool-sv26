<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReportCommand extends Command
{
/**
* The name and signature of the console command.
*
* @var string
*/
protected $signature = 'report:web';

/**
* The console command description.
*
* @var string
*/
protected $description = 'Check website';

/**
* Create a new command instance.
*
*/
public function __construct()
{
    parent::__construct();
}

/**
* Execute the console command.
*
* @return mixed
*/
public function handle()
{       

        define('KEY_CHATWORK', env('CHATWORKKEY'));


    try{
        $result = $this->checkWeb();

        $cw = new \App\Libs\ChatworkLib;
        $cw->setRoomId('191671091');
        $cw->setMsg('Report daily: '. var_export($result,true));
        $cw->nameServer = 'Server [172.16.2.8]';
        $cw->say_in_chatwork();
    }catch(\Exception $e){
        // $cw = new \App\Libs\ChatworkLib;
        // $cw->setRoomId('155104287');
        // $cw->setMsg('[toall] Automatic Cron checkweb: Can\'t connected to :  '.$e->getMessage());
        // $cw->nameServer = 'Server [172.16.2.8]';
        // $cw->say_in_chatwork();
    }


    //todo: check in web deployed
    //file_get_contents('http://oop.vn/hook/write_hook.php');
    // if(file_get_contents('http://oop.vn/hook/touch_hook.php')==1){
    //     $check_deloyed=true;
    // }else{
    //     $check_deloyed=false;
    // }
    // $check_deloyed=false;
    //
    // if($check_deloyed) {
    //
    //     $cw = new \App\Libs\ChatworkLib;
    //     $cw->setRoomId('155104287');
    //     $cw->setMsg('Hook git run  ');
    //     $cw->nameServer = 'Server 29';
    //     $cw->say_in_chatwork();
    //
    //     shell_exec('curl -X POST http://172.16.100.29:8080/job/Deploy_hito/build -H "Jenkins-Crumb:13c7f9b0e2792f89836996b8ba921aa2"');
    // }
}

    private function checkWeb(){
        $client = new \GuzzleHttp\Client();
        $endpoint = config('app.endpointWeb');

        foreach ($endpoint as $key => $v_endpoint) {
            $response = $client->get($v_endpoint);
            $statusCode = $response->getStatusCode();
            if($statusCode === 200){
                $return[$v_endpoint]['status'] = '[OK]';
            }
        }
        return $return;
    }
}
