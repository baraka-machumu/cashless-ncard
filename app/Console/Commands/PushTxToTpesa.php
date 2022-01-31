<?php

namespace App\Console\Commands;

use App\Jobs\ProcessTxJob;
use Illuminate\Console\Command;

class PushTxToTpesa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push-tx';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to push tx to tpesa...';

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

        ProcessTxJob::dispatch();
        return 0;

    }
}
