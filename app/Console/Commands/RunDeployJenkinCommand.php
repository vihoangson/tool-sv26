<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunDeployJenkinCommand extends Command
{
/**
* The name and signature of the console command.
*
* @var string
*/
protected $signature = 'runjenkin';

/**
* The console command description.
*
* @var string
*/
protected $description = 'runjenkin';

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
   
    if(file_get_contents('http://oop.vn/hook/touch_hook.php')==1){
        $check_deloyed=true;
    }else{
        $check_deloyed=false;
    }
    
    if($check_deloyed) {

        $cw = new \App\Libs\ChatworkLib;
        $cw->setRoomId('155104287');
        $cw->setMsg('Hook git run  ');
        $cw->nameServer = 'Server 29';
        $cw->say_in_chatwork();

        shell_exec('curl -X POST http://172.16.100.29:8080/job/Deploy_hito/build -H "Jenkins-Crumb:13c7f9b0e2792f89836996b8ba921aa2"');
    }
}


}
