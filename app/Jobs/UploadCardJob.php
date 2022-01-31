<?php

namespace App\Jobs;

use App\Imports\ImportCards;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class UploadCardJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public  $file;

    public function __construct($file)
    {
        $this->file  =  $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

//         $path  =  Storage::disk()

        Excel::import(new ImportCards(), $this->file);


    }
}
