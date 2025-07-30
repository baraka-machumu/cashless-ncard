<?php

namespace App\Console\Commands;

use App\Helper\NameSearchApi;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testcmd {counter} {date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        $counter  = $this->argument('counter');
        $date  = $this->argument('date');

        for ($i=0; $i<$counter; $i++){
            echo  'date --- up '.$date."\n";
            DB::select('CALL manualUpdateMerchantCollection(?)',[$date]);

            $date =  Carbon::make($date)->addDay();
            echo  'date --- down '.$date."\n";

        }

    }
}
