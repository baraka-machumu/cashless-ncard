<?php


namespace App\Helper;


use Illuminate\Support\Facades\DB;

class PetrolStationPrice
{

    public  static   function  price($price,$tin,$product_id){

        $product  = DB::table('service_products')
            ->select('price')
            ->where(['id'=>$product_id,'tin'=>$tin,''])->first();

        $litre  = $price/($product->price);

        return    number_format((float)$litre, 2, '.', '');

    }

}
