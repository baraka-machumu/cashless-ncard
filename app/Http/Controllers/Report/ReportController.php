<?php

namespace App\Http\Controllers\Report;

use App\Report;
use App\ReportParameter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Jaspersoft\Client\Client;

class ReportController extends Controller
{

    public function consumerReports()
    {


        $reports = Report::where('report_type', 3)->get();
        return view('reports.consumer_reports', compact('reports'));

    }

    public function agentReports()
    {
        $reports = Report::where('report_type', 1)->get();
        return view('reports.agent_reports', compact('reports'));

    }

    public function merchantReports()
    {
        $reports = Report::where('report_type', 2)->get();
        return view('reports.merchant_reports', compact('reports'));
    }



    public  function  getReport($report_id){

        $report  =  Report::where('id',$report_id)->first();

        $url  =  "http://localhost:8080/jasperserver";
        $user  =  "jasperadmin";
        $password  =  "jasperadmin";

        $server  =  new Client($url,$user,$password);

        $report_url =  $report->report_url;

        if ($report->has_parameter==0){
            $getReport  =  $server->reportService()->runReport($report_url,'pdf');
            header('Content-Type: application/pdf');
            echo  $getReport;

        }

        $params  = DB::table('report_parameters')
            ->where('report_parameters.report_id',$report_id)
            ->select('report_parameters.parameter_id','parameters.name','parameters.description')
            ->join('parameters','parameters.id','=','report_parameters.parameter_id')
            ->get();

        return  view('reports.params',compact('params','report_id'));

    }


    public  function getParameterizedReport(Request  $request ,$report_id){

        $report  =  Report::where('id',$report_id)->first();



        $url  =  "http://localhost:8080/jasperserver";

        $user  =  "jasperadmin";
        $password  =  "jasperadmin";

        $server  =  new Client($url,$user,$password);

        $report_url =  $report->report_url;

        $inputControls =  $request->get('params');

        $getReport  =  $server->reportService()->runReport($report_url,'pdf',null,null,$inputControls);
        header('Content-Type: application/pdf');

        echo  $getReport;


    }



    public  function  consumerStatement(Request  $request){

        $start_date  =  $request->start_date;
        $end_date  =  $request->end_date;
        $wallet_option  =  $request->wallet_option;
        $number  =  $request->number;

        if (!isset($_GET['get-report'])){

            return false;
            return view('reports.consumer.statement');
        }

        $wp = 'cw.wallet_id';

        if ($wallet_option=='C'){

            $wp  =  'cc.card_number';
        } else if ($wallet_option=='P') {

            $wp = 'c.phone_number';
        }


        $customer  =  DB::table('consumer_wallets as cw')
            ->select('cw.wallet_id','c.phone_number','c.first_name','c.last_name','cw.amount as balance')
            ->join('consumers as c','c.id','=','cw.consumers_id')
            ->join('consumer_cards as cc','cc.consumer_id','=','c.id')
            ->where([$wp=>$number,'c.status_id'=>1])->first();



        if (app()->environment()=='local'){

            $url  =  Config('api.TEST_JASPER_SERVER');
        }

        else if(app()->environment()=='production'){

            $url =  Config('api.LIVE_JASPER_SERVER');

        }

        $user  =  "jasperadmin";
        $password  =  "jasperadmin";

        $server  =  new Client($url,$user,$password);

        $report_url =  '/reports/cashless/CustomerStatement';

        $fullname  =  $customer->first_name.' '.$customer->last_name;


        $inputControls = array('StartDate'=>$start_date,'EndDate'=>$end_date,'customerName'=>$fullname,'WalletNo'=>$customer->wallet_id,'PhoneNo'=>$customer->phone_number,'Balance'=>$customer->balance);

        $getReport  =  $server->reportService()->runReport($report_url,'pdf',null,null,$inputControls);
        header('Content-Type: application/pdf');

        echo  $getReport;


    }

}
