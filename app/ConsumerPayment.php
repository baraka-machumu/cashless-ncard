<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsumerPayment extends Model
{
    //

    public function consumer(){

        return $this->belongsTo('App\Consumer','consumers_id');
    }

    public  function  feeCollection(){
        return  $this->hasOne('App\FeeCollectionAccount','consumer_payments_reference', 'reference');
    }

    public  function  merchant(){

        return  $this->belongsTo('App\Merchant','recipient_id','tin');
    }

    public  function  consumerRecipient(){

        return  $this->belongsTo('App\Consumer','recipient_id','id');
    }

    public function  agent(){

        $this->belongsTo('App\Agent','recipient_id');
    }
}
