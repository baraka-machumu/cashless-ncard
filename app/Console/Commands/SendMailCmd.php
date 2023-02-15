<?php

namespace App\Console\Commands;

use App\Http\Controllers\Mail\MailController;
use Illuminate\Console\Command;

class SendMailCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-mail {email} {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to send email';

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

        $email  =  $this->argument('email');
        $message  =  $this->argument('message');

        MailController::sendMailMessage($email,$message);

        echo "send..";
    }
}
