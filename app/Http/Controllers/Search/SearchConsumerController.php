<?php

namespace App\Http\Controllers\Search;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchConsumerController extends Controller
{
    //


    public  function index(){

        return view('search.search_consumer');
    }
}
