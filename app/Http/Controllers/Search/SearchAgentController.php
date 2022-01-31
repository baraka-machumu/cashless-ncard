<?php

namespace App\Http\Controllers\Search;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchAgentController extends Controller
{
    //


    public  function index(){

        return view('search.search_agent');
    }
}
