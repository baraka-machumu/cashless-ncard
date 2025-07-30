<?php

namespace App\Console\Commands;

use App\Helper\NameSearchApi;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BulkDisable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bdc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to disable cards';

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
        $content = fopen(Storage::path("/cards.csv"),'r');
        $i =1;

        while(!feof($content)){
            $line = fgets($content);
            $line  =( explode(' ',$line));

            $line  = preg_replace('/[^\w\d]/', '', $line[0]);

            if (empty($line)){
                continue;
            }

            $data  =  DB::table('consumer_cards')->select('consumers_wallet_id as wallet_id')->where(['consumers_wallet_id'=>$line])->first();
            $result=   DB::table('consumer_cards')->where(['consumers_wallet_id'=>$line])->update(['status_id'=>1]);
            $result2=    DB::table('consumer_wallets')
                ->where(['wallet_id'=>$data->wallet_id])->update(['consumers_status_id'=>1,'fraud'=>0]);
            echo $i. " W ".$line." - result  ".$result." result2 ".$result2." \n";
            $i++;

        }
    }
}
