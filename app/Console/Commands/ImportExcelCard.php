<?php

namespace App\Console\Commands;

use App\Imports\ImportCards;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ImportExcelCard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import-cards';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to import new cards';

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

        try {


            $file  = File::get(storage_path('app/cards.xlsx'));

            if (empty($file)){

                return  "not valid";
            }
            Excel::import(new ImportCards(), $file);

           echo "success";

        } catch (\Exception $exception){

            Session::flash('alert-danger','Failed '.$exception->getMessage());
            return back();
        }
    }
}
