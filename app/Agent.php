<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Agent extends Model
{

    protected $primaryKey ='agent_code';


    public function wallet()
    {
        return $this->hasOne('App\AgentWallet','agents_code');
    }
}
