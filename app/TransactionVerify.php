<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionVerify extends Model
{
    protected $table  = 'tnx_verify';


    protected $fillable  = [
      "channel",'ref_number','phone_number',
        'amount','channel_ref_no','tnx_date'
    ];

}
