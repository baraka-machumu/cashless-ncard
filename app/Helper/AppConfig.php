<?php


namespace App\Helper;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Monolog\Handler\IFTTTHandler;

class AppConfig extends  Model
{


    protected $table  = 'app_config';

    public  static  function  getProperties($tin)
    {

        $config  =   DB::table('app_config')
            ->select('screen','layout','api','api_method','on_tap','column','title','sub_title','max_lenth','input_type','action')
            ->where(['tin'=>$tin])->get();

        $json  = [];

        foreach ($config as $row) {


            if ($row->on_tap == 'DIALOG') {


                $r  =   AppConfig::query()
                    ->select('screen','title','sub_title','max_lenth','input_type','action')
                    ->where(['tin'=>$tin,'screen'=>$row->screen,'layout'=>null])->first();

                $data = ['screen' => $row->screen, 'layout' => $row->layout, 'api' => str_replace("\\", "", ($row->api)), 'api_method' => $row->api_method,
                    'on_tap' => $row->on_tap, 'column' => $row->column, 'dialog' => ['title' => $r->title, 'sub_title' => $r->sub_title,
                        'max_lenth' => $r->max_lenth, 'input_type' => $r->input_type, 'action' => $r->action]];


                array_push($json, $data);

            }

            else {
                if ($row->layout) {
                    $data = ['screen' => $row->screen, 'layout' => $row->layout, 'api' => str_replace("\\", "", ($row->api)), 'api_method' => $row->api_method,
                        'on_tap' => $row->on_tap, 'column' => $row->column];

                    array_push($json, $data);

                }
            }
        }



        return $json;

    }



}
