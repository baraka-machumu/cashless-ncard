<?php

namespace App\Http\Controllers\Service;

use App\Service;
use App\ServiceProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{

    public function index($tin,$service_id)
    {

        $products = DB::table('merchant_services as ms')
            ->where(['sp.tin'=>$tin,'sp.service_id'=>$service_id,'sp.status'=>1])
            ->select('sp.id','product_name','sp.price','sp.type')
            ->join('service_products as sp','sp.service_id','=','ms.id')
            ->get();

//        return response()->json($products);

        return view('products.index',compact('products','tin','service_id'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('services.create_service');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $product =  $request->get('product');
        $price =  $request->get('price');
        $type =  $request->get('type');
        $service_id =  $request->get('service_id');
        $tin =  $request->get('tin');

        DB::beginTransaction();
        try{

            for ($i=0; $i<sizeof($product); $i++){

                $serviceProduct  =     new ServiceProduct();
                $serviceProduct->service_id =  $service_id;
                $serviceProduct->product_name =  $product[$i];
                $serviceProduct->type =  $type[$i];
                $serviceProduct->price =  $price[$i];
                $serviceProduct->tin =  $tin;
                $serviceProduct->save();

            }

            DB::commit();
            Session::flash('alert-success', ' Product(s) Successful created');

        }  catch (\Exception $exception){

            DB::rollBack();
            Session::flash('alert-success', ' Failed to create Product, try again '.$exception->getMessage());

        }

        return  redirect('merchant-products/'.$tin.'/'.$service_id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('services.show_service');

    }



    public  function  removeFromList(Request $request){


        $id  = $request->product_id;

        $tin  =   $request->tin;

        $service_id  =  $request->service_id;

        $success  = DB::table('service_products')->where(['id'=>$id,'tin'=>$tin])->update(['status'=>0]);


        if ($success){

            Session::flash('alert-success','successful removed');
        }
        else {
            Session::flash('alert-danger','operation failed, try again ');

        }

        return redirect('merchant-products/'.$tin.'/'.$service_id);

    }
}
