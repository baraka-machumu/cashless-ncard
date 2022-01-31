<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class AgentPos extends Authenticatable
{

    protected $table = 'agent_pos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agent_code', 'email', 'password',
    ];

    public function generateToken(){
        $this->api_token = str::Random(60);
        $this->save();
        return $this->api_token;
    }

    /**
     *The attributes that should be hidden for arrays
     *
     *@var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $primaryKey ='imei_no';
}
