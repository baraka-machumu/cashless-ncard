<?php


namespace App\Http\Controllers\ApplicationRequest;


use App\Events\ApiNotification;
use App\Helper\AdjustmentHelper;
use App\Helper\ApplicationUtils;
use App\Helper\AppReject;
use App\Helper\AuditLogs;
use App\Helper\CardHelpers;
use App\Helper\CustomerHelper;
use App\Helper\ExchangeHelper;
use App\Helper\ExMessage;
use App\Helper\ManualReleaseHelper;
use App\Helper\RandomGenerator;
use App\Helper\SwitchHelper;
use App\Helper\UpdateCardStatus;
use App\Http\Controllers\Access\RoleController;
use App\Http\Controllers\Access\UserController;
use App\Http\Controllers\Card\CardController;
use App\Http\Controllers\Controller;
use App\Imports\ManReserveClearImport;
use App\ISO\IsoServiceApi;
use App\Jobs\MailProcessingJob;
use App\Jobs\SendSmsJob;
use App\Models\Adjustment;
use App\Models\ApplicationRequest;
use App\Models\BinPrefix;
use App\Models\ChangeCustomerStatus;
use App\Models\ChargeSettings;
use App\Models\ChargeSettingsApplication;
use App\Models\Consumer;
use App\Models\ConsumerCard;
use App\Models\CurrencyTypes;
use App\Models\CustomerPrepostData;
use App\Models\DormantPeriod;
use App\Models\DuoAddNewCard;
use App\Models\DuoChangeCardStatus;
use App\Models\DuoPasswordReset;
use App\Models\DuoProduct;
use App\Models\DuoReplaceCard;
use App\Models\DuoRole;
use App\Models\DuoRolePermission;
use App\Models\DuoUser;
use App\Models\ExchangeRateTmp;
use App\Models\Levy;
use App\Models\Limit;
use App\Models\LimitApplication;
use App\Models\LimitClass;
use App\Models\LimitClassApplication;
use App\Models\LimitClassLog;
use App\Models\LimitLog;
use App\Models\LimitOnCard;
use App\Models\ManualReserveClear;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use App\Notifications\SendMailNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Monolog\Handler\IFTTTHandler;
use Throwable;


class RejectApplicationController extends Controller
{

    public  function  reject(Request  $request,$id){
        DB::beginTransaction();
        try {
            $application  = ApplicationRequest::query()->where(['id'=>$id])->first();
            $comment  = $request->comment;
            if ($application->status=='02'){
                Session::flash('alert-danger','Application Already Rejected!');
                return back();
            }
            $action_status  = 'REJECTED';
            if ($request->action=='cancel'){
                $action_status  = 'CANCELED';
            }
            $application->status  = '02';
            $application->action_status  = $action_status;
            $application->comment = $comment;
            $application->rejected_by = Auth::user()->id;
            $application->rejected_date = date('Y-m-d h:i:s');

            $app =  $application->save();
            if (!$app){
                Session::flash('alert-danger','Application could not be rejected');
                return back();
            }

            $app_type  = decrypt($request->app_type);
            Log::info('APP TYPE '.$app_type);

            $success  = false;
            if ($app_type=='EX001'){
                $tmp=  ExchangeRateTmp::query()
                    ->where(['application_id'=>$id])->first();
                $tmp->status  = '02';
                $success =   $tmp->save();
            }
            else if($app_type=='ECI001'){
                $consumer_info = Consumer::rejectUserInfo($application->item_id);
            }

            else if($app_type=='MRCLR002'){
                $success = ManualReserveClear::reject($app->application_code);
            }

            else if($app_type=='ENC001')
            {
                $success =UpdateCardStatus::rejectCard($application->item_id);
            }

            else if($app_type=='DISC001')
            {
                $success =UpdateCardStatus::rejectCard($application->item_id);
            }
            else if($app_type=='USR001'){
                $success = AppReject::userRejection($application,$action_status);
            }
            else if($request->app_type=='UPLVY001'||$request->app_type=='LVY001'){

                $success  = Levy::reject($application->item_id,$request);

            }
            else if($app_type=='LOC001'){
                $success = LimitOnCard::rejectLimit($application->item_id);
            }
            else if($app_type=='RL001'){
                $success  =  AppReject::roleRejection($application->item_id,$action_status);
            }

            else if ($app_type=='CR001'){
                $success = AppReject::cardActivation($application->item_id,$action_status);
            }
            else if ($app_type=='CC001'){
                $success = AppReject::currencyCode($application->item_id,$action_status);
            }
            else if ($app_type=='CCS001'){

                $success = AppReject::changeCustomerStatus($application->item_id,$comment);

            }

            else if ($app_type=='CS001'){
                $success = AppReject::chargeSetup($application->item_id,$action_status);
            }
            else if ($app_type=='LM001'){
                $success = AppReject::limits($application->item_id,$action_status);
            }
            else if ($app_type=='PR001'){
                $success = AppReject::product($application->item_id,$action_status);
            }

            else if ($app_type=='ADJUST001'){
                $success = AdjustmentHelper::rejectRequest($application->item_id);
            }
            else if ($app_type=='BLKAD001'){
                $bulkData = DB::table('duo_adjustment')->where('bulk_ref', $application->application_code)->get();
                foreach ($bulkData as $data){
                    $success = AdjustmentHelper::rejectRequest($data->id,true);
                }
            }

            else if($app_type=='MRL002'){
                $success  = DB::table('duo_manual_release')
                    ->where(['id'=>$application->item_id])
                    ->update(['rejected_by'=>Auth::user()->id,'rejected_date'=>date('Y-m-d h:i:s'),
                        'status'=>'REJECTED']);
            }

            else if ($app_type == 'NF001') {
                $success = AppReject::noFundFeeService($application->item_id, $action_status);
            }

            else{

                Log::info('APP INV '.$request->app_type);
                Session::flash('alert-danger','Invalid request');
                return  back();
            }

            if ($success){
                Session::flash('alert-success','Successful rejected');
                DB::commit();
            }
            else{
                Session::flash('alert-danger','Rejection Failed');
                DB::rollBack();
            }
        }

        catch (Throwable $Throwable){
            DB::rollBack();
            ExMessage::exp($Throwable);
            return  back();
        }
        $desc  = "Rejecting application request ";
        AuditLogs::save($desc,$id,'APPLICATION','REJECT','SUCCESS','APPLICATION');

        if ($request->app_type=='ADJUST001'){
            return  redirect('applications/AD');
        }

        if ($app_type=='BLKAD001'){
            return  redirect('bulk-adjustment/approval');
        }

        return  redirect('applications/PA');

    }

    public  function  rejectUpdatedApp(Request  $request,$id)
    {
        try {

            DB::beginTransaction();
            $application = ApplicationRequest::query()->where(['id' => $id])->first();
            $itemId  = $application->item_id;
            if ($application->status != '01') {
                Session::flash('alert-danger', 'Action Not allowed, Since It was acted upon');
                return back();
            }
            $action_status  = 'REJECTED';
            if ($request->action=='cancel'){
                $action_status  = 'CANCELED';
            }
            $comment  = $request->comment;
            $application->status  = '02';
            $application->action_status  = $action_status;
            $application->comment = $comment;
            $app =  $application->save();
            if (!$app){
                Session::flash('alert-danger','Application could not be rejected');
                return back();
            }
            $app_type  = decrypt($request->app_type);
            if ($app_type=='UPLM001'){
                $lim_app  =  LimitClassApplication::query()->where(['id'=>$itemId])->first();
                $lim_app->status  = $action_status;
                $successLimApp = $lim_app->save();
                if (!$successLimApp){
                    Session::flash('alert-danger','Application could not be rejected');
                    DB::rollBack();
                    return  back();
                }
                Session::flash('alert-success','Application successful updated');
                DB::commit();

            }
            else if ($app_type=='UPPR001'){
                $duoProduct=  DuoProduct::query()
                    ->where(['id'=>$application->item_id])->first();
                $duoProduct->status  = '02';
                $success =   $duoProduct->save();
                if ($success){
                    DB::commit();
                    Session::flash('alert-success','Application successful updated');
                }
                else{
                    Session::flash('alert-danger','Application could not be rejected');
                    DB::rollBack();
                    return  back();
                }
            }
            else if($request->app_type=='UPLVY001'){

                $success  = Levy::reject($application->item_id,$request);
                if ($success){
                    DB::commit();
                    Session::flash('alert-success','Application successful updated');
                }
                else{
                    Session::flash('alert-danger','Application could not be rejected');
                    DB::rollBack();
                    return  back();
                }
            }
            else if ($app_type=='UPLMI001'){
                $limitApplication  =  LimitApplication::query()->where(['id'=>$itemId])->first();
                $limitApplication->status  =  $action_status;
                $limSuccess = $limitApplication->save();
                if (!$limSuccess) {

                    Session::flash('alert-danger', 'Application could not be rejected');
                    DB::rollBack();
                    return back();
                }

                Session::flash('alert-success','Application successful updated');
                DB::commit();
            }
            $desc  = "Rejecting Edited application request";
            AuditLogs::save($desc,$request->app_type,'APPLICATION','REJECT','SUCCESS','APPLICATION');

            return  redirect('applications');
        }
        catch (Throwable $Throwable){
            DB::rollBack();
            ExMessage::exp($Throwable);
            return back();
        }
    }


}
