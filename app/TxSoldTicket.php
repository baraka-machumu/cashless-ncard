<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TxSoldTicket extends Model
{

    protected $table = 'tx_sold_tickets';

    protected $primaryKey  = 'QRSource';

}
