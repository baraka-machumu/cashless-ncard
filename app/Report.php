<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
//    protected $table='reports';
//    protected $primaryKey='id';
    public static function find($id)
    {
    }
    public function hasParam(){
        return $this->hasOne('App\HasParam');
    }

    public function params()
    {
        return $this->hasMany('App\ReportParameter');
    }
}
