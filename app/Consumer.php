<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Consumer extends Authenticatable
{

    protected $table = 'consumers';

//    protected $primaryKey = ['wallet_id', 'consumers_id', 'consumers_status_id'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     *The attributes that should be hidden for arrays
     *
     *@var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function generateToken(){
        $this->api_token = str::Random(60);
        $this->save();
        return $this->api_token;
    }

    public function wallet(){
        return $this->hasOne('App\Wallet');
    }

    public  static  function getConsumerData($consumer_id){
        $consumer =  Consumer::find($consumer_id);
        return $consumer;

    }

}
