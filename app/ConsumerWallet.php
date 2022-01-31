<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsumerWallet extends Model
{
    public function consumer(){
        return $this->belongsTo('App\Consumer', 'consumers_id');
    }

    protected $primaryKey ='wallet_id';

}
