<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsumerDeposit extends Model
{
    public function consumerWallet(){
        return $this->belongsTo('App\ConsumerWallet', 'consumer_wallet_id');
    }

    public function consumer(){

        return $this->belongsTo('App\Consumer','consumers_id');
    }


    public  function  consumerFeeDisbursement(){

        return  $this->hasOne('App\FeeDisbursmentAccount','consumer_deposits_reference', 'ncard_reference');
    }


    public  function  agent(){

        return  $this->belongsTo('App\Agent','gateway_id','agent_code');
    }

    public  function  consumer_deposit(){

        return  $this->belongsTo('App\Consumer','gateway_id','id');
    }

    public  function  consumerDeposits(){

        return  $this->belongsTo('App\Consumer','consumers_id','id');
    }
}
