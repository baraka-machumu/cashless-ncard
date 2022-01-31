<?php

namespace App\Http\Controllers\Version;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class VersionController extends Controller
{

    public  function  mobileVersion(){

        return response()->json(['error'=>false,'version'=>'1.3.9']);
    }

    public  function  posVersion(){

        Log::info("Incoming  request : ---");
        return response()->json(['error'=>false,'version'=>'1.5']);

    }
}
