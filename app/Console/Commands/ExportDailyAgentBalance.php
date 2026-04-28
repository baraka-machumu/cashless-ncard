<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExportDailyAgentBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily-agent-balance';


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
        set_time_limit(3600);
        ini_set('memory_limit', '-1');

        $results = DB::select('CALL FetchDailyAgentBalanceSP');

        if (empty($results)) {
            $this->info('No data found.');
            return 0;
        }

        $filePath = '/home/balance/agent/daily_agent_balance_' . date('Y_m_d_His') . '.csv';

        // Ensure directory exists
        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }

        $file = fopen($filePath, 'w');

        // Write CSV header
        fputcsv($file, array_keys((array) $results[0]));

        // Write data rows
        foreach ($results as $row) {
            fputcsv($file, (array) $row);
        }

        fclose($file);

        $this->info("CSV exported successfully: {$filePath}");
        return 0;
    }

}
