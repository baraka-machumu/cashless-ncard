<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CardTmpUid extends Model
{

    protected $table = 'card_tmp_uid';
    protected $fillable = ['card_uid','card_number'];
}
