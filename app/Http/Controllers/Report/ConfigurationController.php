<?php

namespace App\Http\Controllers\Report;

use App\Parameter;
use App\Report;
use App\ReportParameter;
use App\ReportType;
use App\Role;
use App\HasParam;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $reports = DB::table("reports")
            ->select('reports.name', 'reports.report_type','reports.report_url','report_types.name as rname','reports.id')
            ->join('report_types', 'reports.report_type', '=', 'report_types.id')

            ->latest()->get();

        $report_types  =  DB::table('report_types')->get();

        $params = DB::table('parameters')->get();

        $has_params = DB::table('has_params')->get();

        return view('reports.index', compact('reports','report_types','params', 'has_params'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        dd($request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'report_type' => 'required',
            'report_url' => 'required'
        ]);

        if ($validator->fails()){

            Session::flash('alert-warning', 'Fill all the fields');

            return   redirect()->back();

        }

        $name= $request->get('name');
        $hasparam  =  $request->get('has_param');
        $report_type  =  $request->get('report_type');
        $params = $request->get('params');
        $report_url = $request->get('report_url');


        $report  =  new Report();

        $report->name =  $name;
        $report->has_parameter =  $hasparam;
        $report->report_type =  $report_type;
        $report->report_url = $report_url;

        $success =  $report->save();

        if ($success){

            if ($hasparam == 0)
            {
                return redirect()->back();

            }
            $reportId  =  $report->id;


             $success =  false;

            for ($i=0; $i<sizeof($params); $i++) {
                $parameter = new ReportParameter();
                $parameter->report_id = $reportId;
                $parameter->parameter_id = $params[$i];

                $success = $parameter->save();

            }

           if ($success){

               Session::flash('alert-success', ' Successful  saved');

           }

           else {

               Session::flash('alert-warning', ' failed to save');


           }



        }
        return redirect()->back();

    }
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }






    public  function apiGetReportById($id){

//        $report  = Report::where('id',$id)->params;

        $report =  Report::where('id',$id)->first();


//        $params =  DB::table('report_parameters')
//                        ->where('report_parameters.report_id',$id)
//                        ->select('report_parameters.parameter_id','parameters.name')
//                        ->join('parameters','parameters.id','=','report_parameters.parameter_id')
//                        ->get();

        $params   =  ReportParameter::select('parameter_id')->where('report_id',$id)->get();
        $has_params = DB::table('has_params')->get();

        if (empty($report)){

            return  response()->json(['error'=>true,'data'=>[]]);
        }
        return response()->json(['error'=>false,'data'=>$report,'params'=>$params, 'has_param'=>$has_params]);
    }

    public function updateReport(Request $request)
    {
//      dd($request->all());

        $report_id = $request->get('report_id');
        $report_name = $request->get('report_name');
        $has_param = $request->get('has_param');
        $report_type = $request->get('report_type');
        $report_url = $request->get('report_url');
        $param = $request->get('params[]');



        $success = DB::table('reports')
            ->where('id', $report_id)
            ->update(['name'=>$report_name, 'has_parameter'=>$has_param,
                'report_type'=>$report_type, 'report_url'=>$report_url]);


        if ($success){


            DB::table('report_parameters')->where('report_id', $report_id)->update(['report_id'=>$report_id, 'parameter_id'=>$param]);

            Session::flash('alert-success', $report_name.' Successful updated');

        } else {

            Session::flash('alert-danger', $report_name.' Was not updated');


        }


        return redirect('reports/configuration');
    }

}
