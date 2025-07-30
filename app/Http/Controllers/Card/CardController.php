<?php

namespace App\Http\Controllers\Card;

use App\Card;
use App\Exports\CardUidExport;
use App\Imports\ExcelBalance;
use App\Imports\ImportCards;
use App\Imports\ImportCardsToGetUid;
use App\Jobs\UploadCardJob;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CardController extends Controller
{


    public  function  index(){

        if (!Gate::allows('manage-card-pos')) {

            return redirect('error-access');

        }

            $cards  =  Card::query()->latest()->paginate(200);

        return view('cards.index',compact('cards'));
    }

    public  function storeCards(Request $request){

        if (!Gate::allows('manage-card-pos')) {

            return redirect('error-access');

        }

        $validator = Validator::make(
            [
                'file'=> $request->file,
            ],
            [
                'file'=>'required|mimes:xlsx,xls',

            ]


        );

        if ($validator->fails()){
            Session::flash('alert-danger',' Please Upload a valid Excel file '.$validator->errors());
            return redirect('cards');
        }

        try {
            $file = $request->file('file');

            Session::flash('alert-success','Successful uploaded');

//             Excel::import(new ImportCards(), request()->file('file'));

//            $cardfile = time().'.'.$file->getClientOriginalExtension();
//            $bank_verify_destinationPath = public_path('/card');
//            $file->move($bank_verify_destinationPath, $cardfile);
//
//            UploadCardJob::dispatch(request()->file('file'));
            Excel::import(new ImportCards(), request()->file('file'));

            return back();

        } catch (\Exception $exception){

            Session::flash('alert-danger','Failed '.$exception->getMessage());
            return back();
        }

    }



    public  function  howCardUidForm(){

        $cards  =  DB::table('card_tmp_uid')->get();
        return view('cards.card_by_uid',compact('cards'));

    }

    public  function  storeCardNumberTemp(Request  $request){

        try {
            DB::table('card_tmp_uid')->truncate();
            Excel::import(new ImportCardsToGetUid(), $request->file('file'));
            Session::flash('alert-info','Successful saved');

            return redirect('cards-info');

        }catch (\Throwable $exception){
            Log::error($exception);
            Session::flash('alert-danger','Server error');
            return redirect('cards-info');
        }
    }

    public  function  downloadTemplate(){

        $path  = storage_path('app/template-card.xlsx');
        return response()->download($path);
    }

    public  function  exportData(){
      return  Excel::download(new CardUidExport(),'card-data.csv');
    }
}
