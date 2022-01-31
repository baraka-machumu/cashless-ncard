<?php


namespace App\Helper;


use Carbon\Carbon;

class RandomGenerator



{

   public  static function  isHtml($string)

    {

        return preg_match("/<[^<]+>/",$string,$m) != 0;

    }

    public static function addPrefixExtra($phone)
    {

        $sub  =  substr($phone,0,1);

        if ($sub=='+'){

            $phone =substr($phone,1);

        }

        if (strlen($phone) <= 9) {
            return '255' . $phone;
        }

        if (strlen($phone) == 12){

            return $phone;
        }

        else {
            return preg_replace('/^0/', '255', $phone);
        }
    }

    public  static  function cardNumber($consumer_id){

        return   self::prefix().self::number($consumer_id);

    }

    public  static  function  number($consumer_id){

        $initial =   100000;

//        $number_generate  = $initial+$consumer_id;

        if ($consumer_id>$initial){

            $number =  $consumer_id;

        }

        else if ($consumer_id<10){

            $number =   $consumer_id.self::randomNumber(10005,99999);
        }

        else if ($consumer_id<100){

            $number =   $consumer_id.self::randomNumber(1004,9999);

        }

        else if ($consumer_id<1000){
            $number =   $consumer_id.self::randomNumber(103,999);

        }

        else if ($consumer_id<10000){
            $number =   $consumer_id.self::randomNumber(12,99);

        }

        else if ($consumer_id<100000){
            $number =   $consumer_id.self::randomNumber(1,9);

        }

        return $number;
    }


    public  static   function  prefix(){

        $year  =  Carbon::now('Africa/Nairobi')->year;

        $year_pref = substr($year,0,2);

        $prefix  =  'NC'.$year_pref;
        return $prefix;

    }


    public  static  function randomNumber($min,$max){

        try {
            return random_int($min, $max);
        } catch (\Exception $e) {
        }
    }



    public  static  function referenceNumber($walletId){

        $prefix  =  Carbon::now('Africa/Nairobi');

        $year  =  substr(date('Y', strtotime($prefix)),0,2);

        $month  = date('m', strtotime($prefix));

        $day  = date('d', strtotime($prefix));

        $time  =  date('His', strtotime($prefix));

        return  substr($prefix->dayName,0,1).$year.$month.$day.$time.$walletId;

    }



    public  static  function qr(){

        $prefix  =  Carbon::now('Africa/Nairobi');

        $year  =  substr(date('Y', strtotime($prefix)),0,2);

        $month  = date('m', strtotime($prefix));

        $day  = date('d', strtotime($prefix));

        $time  =  date('His', strtotime($prefix));

        return  $year.$month.$day.$time;

    }


    public  static  function  genCardNo($counter=1){


    }

}
