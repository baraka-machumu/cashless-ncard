<?php

namespace App\Console\Commands;

use App\Helper\NameSearchApi;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TpesaDataSyncRegistration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tpesa-reg';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to send data ';

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

        $url  = Config::get('api.API_DATA_SYNC_TPESA_URL').'/'.'kyc/registry';
        $key  =Config::get('api.X_API_KEY');
        $username  =Config::get('api.X_USER');
        $profileData  = DB::select('call GetDataForTpesaProfileSP');

        foreach ($profileData as $row){
            try {
                $result  = Http::withHeaders(['x_api_key'=>$key,'x_user'=>$username])
                    ->post($url,
                        [
                            'first_name'=>$row->first_name,
                            'last_name'=>$row->last_name,
                            'dob'=>'1970-01-01',
                            'nin'=>$row->nin,
                            'email'=>$row->email,
                            'agent_code'=>(string)$row->agent_code,
                            'agentName'=>$row->agentName,
                            'gender_id'=>$row->gender_id,
                            'IsNew'=>$row->IsNew,
                            'phone_number'=>$row->phone_number,
                            'created_at'=>$row->created_at,
                            'country_code'=>$row->country_code,
                            'registration_source'=>$row->registration_source,
                            'consumer_wallet_id'=>$row->consumer_wallet_id,
                            'customer_category_code'=>$row->customer_category_code,
                            'card_number'=>$row->card_number,
                            'card_uid'=>$row->card_uid,
                            'WalletCategoryID'=>$row->WalletCategoryID,
                            'Keyword'=>$row->Keyword
                        ]
                    );
                $result  = json_decode($result);

                Log::info('RESULT',['MESSAGE'=>$result]);

                if($result->Status=='0' || $result->Message=='Phone Number Exist'){

                    DB::table('consumers')
                        ->where(['id'=>$row->id])->update(['sent_to_tpesa'=>1]);
                }
            }catch (\Throwable $exception){
                Log::error('Data sync error',['message'=>$exception]);
            }
        }

    }
}
