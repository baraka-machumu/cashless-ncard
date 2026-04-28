<?php

namespace App\Console\Commands;

use App\ConsumerReverseTrx;
use App\ConsumerWallet;
use App\Helper\PaymentHelper;
use App\Http\Controllers\Retry\PushFailedDataController;
use App\Monitor;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RetryFailedTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bl-tpesa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run this command for failed job';

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
     * @return mixed
     */
    public function handle()
    {

        set_time_limit(0);
        ini_set('memory_limit','1G');

        $filePath = storage_path('app/data.csv'); // path to your CSV

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        if (($handle = fopen($filePath, 'r')) !== false) {

            $headers = fgetcsv($handle);
            $counter = 0;
            $counter1 =0;
            while (($row = fgetcsv($handle)) !== false) {
                $counter1++;
                $record = array_combine($headers, $row);
                echo "start: {$counter1}\n";

                $exists = DB::table('consumer_wallets')
                    ->where('virtual_msisdn', $record['virtual_msisdn'])
                    ->exists();

                if ($exists) continue;

                $updated = DB::table('consumer_wallets')
                    ->where('wallet_id', $record['jamii_ref_no'])
                    ->update(['virtual_msisdn' => $record['virtual_msisdn']]);

                if ($updated) {
                    $counter++;
                    echo "Updated {$counter}\n";
                }
            }

            fclose($handle);

            echo "Done. Total updated: {$counter}\n";
        }

    }
}
