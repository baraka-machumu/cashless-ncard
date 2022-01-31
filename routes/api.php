<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\helper\HelperController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 *CARD MANAGEMENT
 */

Route::group(['prefix'=>'card-management'], function (){

    Route::post('send-batch-data','Card\CardManagementController@index');

});

Route::get('consumer-report-statement','Report\ReportController@consumerStatement');



