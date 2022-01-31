<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mno_consumer_refund extends Model
{

    protected $table= 'mno_consumer_refund';

    protected $fillable= ['amount','card_uid','wallet_id','phone_number','created_by'];
}
