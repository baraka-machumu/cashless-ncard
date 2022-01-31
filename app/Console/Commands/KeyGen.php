<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class KeyGen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen-t {n}';

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

        $input = $this->argument('n');


        try {
            for ($i=0; $i<$input; $i++){

                $k = $this->getRandomHex();

                DB::update('call SecuritySaveTypeBKeySP(?)',array($k));

                echo 'Result number: ' . $k ." => index ".$i."\r\n";

            }

        }

        catch (\Throwable $exception){

            echo "duplicate key ";

        }


        return 0;
    }

    function getRandomHex($num_bytes=4) {
        $alphabet = '0123456789ABCDEF';
        $pass = [];
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 11; $i++) {
            $n = random_int(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        array_splice( $pass, random_int(1,count($pass)-1), 0);

        $pas = implode(',', $pass);

        return str_replace(',','',$pas);
    }
}
