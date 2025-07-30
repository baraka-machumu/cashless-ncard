<?php

/**
 * UBX property
 * Created by baraka machumu
 * @2022
 */

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
use App\Helper\UpdateCardStatus;
use App\Http\Controllers\Access\RoleController;
use App\Http\Controllers\Access\UserController;
use App\Http\Controllers\Card\CardController;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessBulkAdjustment;
use App\Jobs\SendSmsJob;
use App\LimitClassApplication;
use App\Mail\ApiUserMail;
use App\Mail\OTPMail;
use App\ApplicationRequest;
use App\Models\ChangeCustomerStatus;
use App\Models\ChargeSettings;
use App\Models\DuoChangeCardStatus;
use App\Models\DuoPasswordReset;
use App\Limit;
use App\LimitApplication;
use App\LimitClass;
use App\Models\LimitOnCard;
use App\Models\ManualReserveClear;
use App\Models\NoFundFeeAllowedService;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ApplicationController extends Controller
{
    /**
     *  created by baraka machumu
     * @param $type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * type : AD means adjustment (debit or credit)
     * this function  display all pending approval for checker made by maker
     */
    public function index($type)
    {
//        if (!Gate::allows('view-action-menu')) {
//            return view('errors.login_access');
//        }

        if (!in_array($type, ['PA', 'AD'])) {
            return view('errors.login_access');

        }
        $application = DB::select('CALL GetApplicationRequestSp');
        return view('application.index', compact('application', 'type'));
    }

    public function view($id, $app_type)
    {
        $roles = [];
        $permission = [];
        $limits = [];
        try {
            $app = ApplicationRequest::getAppPerId($id);


            if (isset($app->ERROR)) {
                Session::flash('alert-danger', 'No Application data found');
                return back();
            }

            if ($app_type == 'USR001') {
                $result = User::query()
                    ->select('ra.name as role_action', 'first_name', 'last_name', 'email', 'users.created_at'
                        , 'phone_number', 'genders.name as gender_name', 'middle_name', 'br.branch_name as branch')
                    ->join('genders', 'genders.id', '=', 'users.gender_id')
                    ->join('branches as br', 'br.branch_code', '=', 'users.branch')
                    ->leftJoin('role_action_types as ra', 'ra.id', '=', 'users.role_action_type')
                    ->where(['users.id' => $app->item_id])->first();

                $roles = DB::table('user_roles as ur')
                    ->select('name as role_name')
                    ->join('roles as r', 'r.id', '=', 'ur.role_id')
                    ->where(['user_id' => $app->item_id])->get();
            } else if ($app_type == 'AUSR001') {
                $result = DB::table('api_users')
                    ->select('id', 'app_name', 'app_url', 'email', 'created_at', 'username')
                    ->where(['id' => $app->item_id])->first();
//                dd($result);
            } else if ($app_type == 'RL001') {
                $result = Role::query()->where(['id' => $app->item_id])->first();
                $permission = DB::table('role_permissions as rp')
                    ->select('p.name as p_name', 'rp.created_at')
                    ->join('permissions as p', 'p.id', '=', 'rp.permission_id')
                    ->where(['role_id' => $app->item_id])
                    ->get();
            } else if ($app_type == 'MRCLR002') {

                $result = DB::table('manualreserveclear as m')
                    ->select('m.amount', 'm.created_at', 'm.card_number', 'm.reversal_tag', 'm.desc', 'm.wallet_id',
                        'm.status', 'ct.short_code', 'c.first_name', 'c.last_name')
                    ->join('currency_types as ct', 'ct.currency_code', '=', 'm.currency')
                    ->join('consumer_wallets as cw', 'cw.wallet_id', '=', 'm.wallet_id')
                    ->join('consumers as c', 'c.id', '=', 'cw.consumers_id')
                    ->where(['bulk_ref' => $app->application_code])
                    ->get();

            } else if ($app_type == 'UPLVY001' || $app_type == 'LVY001') {

                $result = DB::table('levy as l')
                    ->select('l.status', 'l.id', 'l.min', 'l.max', 'l.created_at', 'l.rate', 'u.first_name', 'u.last_name');

                if ($app_type == 'LVY001') {
                    $result = $result->join('users as u', 'u.id', '=', 'l.created_by');
                } else {
                    $result = $result->join('users as u', 'u.id', '=', 'l.updated_by');

                }
                $result = $result->where(['l.id' => $app->item_id])->first();

            } else if ($app_type == 'PRESET001') {
                $result = DuoPasswordReset::getData($app->item_id);
            } else if ($app_type == 'UPLOC001') {
                Log::info("ITEM-ID", ['item_id' => $app->item_id]);
                $result = DB::select('CALL PortalGetLimitUpdateDuoDataSP (?)', [$app->item_id]);
            } else if ($app_type == 'ENC001') {
                $result = DuoChangeCardStatus::query()->where(['id' => $app->item_id])->first();
            } /**
             *VIEW CUSTOMER CHANGE STATUS
             */
            else if ($app_type == 'CCS001') {
                $result = DB::table('duo_change_customer_status as cc')
                    ->select('old.name as old_status', 'new.name as new_status', 'cc.created_at', 'c.first_name', 'c.last_name', 'c.first_name as u_first_name',
                        'c.last_name as u_last_name')
                    ->join('consumers as c', 'c.id', '=', 'cc.customer_id')
                    ->join('status as old', 'old.id', '=', 'cc.old_status')
                    ->join('status as new', 'new.id', '=', 'cc.new_status')
                    ->where(['cc.id' => $app->item_id])
                    ->first();
            } else if ($app_type == 'DISC001') {
                $result = DuoChangeCardStatus::query()->where(['id' => $app->item_id])->first();
            } else if ($app_type == 'LOC001') {
                $result = DB::select('call PortalGetLimitDuoDataSP(?)', [$app->item_id]);
            } else if ($app_type == 'MRL002') {
                $result = DB::select('CALL PortalManualGetDataPerIdSP(?)', [$app->item_id])[0];
            } else if ($app_type == 'CC001') {
                $result = CurrencyTypes::query()->where(['currency_code' => $app->item_id])->first();
            } else if ($app_type == 'CS001') {
                $result = ChargeSettings::getAllChargesPerChargeId($app->item_id);
            } else if ($app_type == 'PR001') {
                $result = BinPrefix::getBinProduct($app->item_id);
                if (empty($result)) {
                    $result = null;
                }
                $result = $result[0];
            } else if ($app_type == 'LM001') {
                $result = LimitClass::limitClassPerId($app->item_id);
                $limits = Limit::getLimits($result->class_code);
            } /**
             * GET CUSTOMER INFOR FOR BOTH CREATION AND UPDATE
             */
            else if (in_array($app_type, ['ECI001', 'CR001'])) {
                $result = DB::table('customer_prepost_data as c')
                    ->select('c.id', 'c.first_name', 'c.initial_name', 'c.last_name', 'c.phone_number',
                        'c.email', 'c.created_at', 'c.country', 'ct.short_code as currency',
                        'c.region', 'c.id_card', 'c.title', 'c.dob', 'c.city', 'c.gender', 'c.address', 'c.card_number as pan',
                        DB::raw("MaskFn(DecryptDataFN(c.card_number)) as card_number"), 'c.created_by', 'it.name as id_type', 'branch_name')
                    ->leftJoin('currency_types as ct', 'ct.currency_code', '=', 'c.currency')
                    ->leftJoin('id_types as it', 'it.id', '=', 'c.id_type_id')
                    ->leftJoin('branches as br', 'br.branch_code', '=', 'c.branch_id')
                    ->where(['c.id' => $app->item_id])->first();

            } else if ($app_type == 'UPLM001') {
                $result = LimitClassApplication::query()->where(['id' => $app->item_id])->first();
            } else if ($app_type == 'UPLMI001') {
                $result = LimitApplication::query()->where(['limits_applications.id' => $app->item_id])
                    ->join('services as s', 's.tx_code', '=', 'limits_applications.limit_code')
                    ->first();
            } else if ($app_type == 'UPCS001') {
                $result = DB::table('duo_charge_settings as cs')->where(['cs.id' => $app->item_id])
                    ->select('cs.name as charge_name', 'cs.created_at', 's.name as service_name',
                        'ct.name as currency', 'cs.amount')
                    ->join('services as s', 's.service_code', '=', 'cs.service_code')
                    ->join('currency_types as ct', 'ct.currency_code', '=', 'cs.currency')
                    ->first();
            } else if ($app_type == 'UPRL001') {
                $role = DuoRole::query()->where(['id' => $app->item_id])->first();
                $permission = DB::table('duo_role_permissions as p')
                    ->select('pr.name', 'p.id')
                    ->join('permissions as pr', 'pr.id', '=', 'p.permission_id')
                    ->where(['role_id' => $role->id])->get();
                $result = ['role' => $role, 'permissions' => $permission];
            } else if ($app_type == 'UPUS001') {
                $user = DuoUser::query()
                    ->select('ra.name as role_action', 'first_name', 'last_name', 'email', 'duo_users.created_at',
                        'phone_number', 'genders.name as gender_name', 'br.branch_name')
                    ->join('genders', 'genders.id', '=', 'duo_users.gender_id')
                    ->leftJoin('branches as br', 'br.branch_code', '=', 'duo_users.branch_code')
                    ->leftJoin('role_action_types as ra', 'ra.id', '=', 'duo_users.role_action_type')
                    ->where(['duo_users.id' => $app->item_id])->first();

                $role = DB::table('duo_user_roles as ur')
                    ->select('r.name', 'ur.id')
                    ->join('roles as r', 'r.id', '=', 'ur.role_id')
                    ->where(['user_id' => $user->id])->get();
                $result = ['user' => $user, 'role' => $role];
            } else if ($app_type == 'UPPR001') {
                $result = DB::table('duo_bin_prefix as b')
                    ->select('b.created_at', 'b.id', 'b.bin_number', 'b.status', 'b.category', 'b.currency', 'b.class_code',
                        'b.product_name', 'b.issuance_fee', 'b.approved_by', 'b.approved_date', 'b.organization_code',
                        'b.rejected_date', 'b.bin_id', 'ct.name as currency_name', 'min_balance')
                    ->join('currency_types as ct', 'ct.currency_code', '=', 'b.currency')
                    ->where(['b.id' => $app->item_id])->first();
                if (empty($result)) {
                    $result = null;
                }
            } else if ($app_type == 'EX001') {
                $result = self::exchangeRate($id);
            } else if ($app_type == 'ENC001') {
                $result = DuoChangeCardStatus::getDataPerId($app->item_id);
            } else if ($app_type == 'ADDC001') {
                $result = DuoAddNewCard::getData($app->item_id);
            } else if ($app_type == 'CDP002') {
                $result = DormantPeriod::getData($app->item_id);
            } else if ($app_type == 'RPC001') {
                $result = DuoReplaceCard::getData($app->item_id);
            } /**
             * DUO ADJUSTMENT
             */

            else if ($app_type == 'ADJUST001') {
                $result = AdjustmentHelper::getData($app->item_id);

            } else if ($app_type == 'NF001') {
                $result = DB::table('no_fund_fee_allowed_services as n')
                    ->leftJoin('services as s', 's.tx_code', '=', 'n.tx_code')
                    ->select('n.id', 's.name', 'n.created_at')->where('n.id', $app->item_id)->first();

            }
            if (!$result) {
                Session::flash('alert-danger', 'No data available, contact admin');
                return back();
            }

            /*
             * Sorting the back button issue
             * Author: James Buretta
             */
            if ($app_type == "ADJUST001") {
                $type = "AD";
            } else {
                $type = "PA";
            }

            if ($app->operation == 'UPDATE') {

                return view('application.edit.view_edit', compact('app', 'type', 'limits', 'permission', 'id', 'result', 'app_type', 'roles'));
            }

            return view('application.view', compact('app', 'limits', 'permission', 'id', 'result', 'app_type', 'roles', 'type'));

        } catch (Throwable $Throwable) {
            Log::error($Throwable->getMessage() . ' With line ' . $Throwable->getLine());
            ExMessage::exp($Throwable);
            return back();
        }
    }

    public function reject(Request $request, $id)
    {

        $validator = Validator::make($request->all(),
            [
                'app_type' => 'required|min:2|max:20',
            ]);

        if ($validator->fails()) {
            Session::flash('alert-danger', '' . $validator->getMessageBag()[0]);
            return back();
        }
        DB::beginTransaction();
        try {
            $application = ApplicationRequest::query()->where(['id' => $id])->first();
            $comment = $request->comment;
            if ($application->status == '02') {
                Session::flash('alert-danger', 'Application Already Rejected!');
                return back();
            }
            $action_status = 'REJECTED';
            if ($request->action == 'cancel') {
                $action_status = 'CANCELED';
            }
            $application->status = '02';
            $application->action_status = $action_status;
            $application->comment = $comment;
            $application->rejected_by = Auth::user()->id;
            $application->rejected_date = date('Y-m-d h:i:s');

            $app = $application->save();
            if (!$app) {
                Session::flash('alert-danger', 'Application could not be rejected');
                return back();
            }

            $app_type = decrypt($request->app_type);
            $success = false;
            if ($app_type == 'EX001') {
                $tmp = ExchangeRateTmp::query()
                    ->where(['application_id' => $id])->first();
                $tmp->status = '02';
                $success = $tmp->save();
            } else if ($app_type == 'USR001') {
                $success = AppReject::userRejection($application, $action_status);
            } else if ($app_type == 'LOC001') {
                $success = LimitOnCard::rejectLimit($application->item_id);
            } else if ($app_type == 'RL001') {
                $success = AppReject::roleRejection($application->item_id, $action_status);
            } else if ($app_type == 'CR001') {
                $success = AppReject::cardActivation($application->item_id, $action_status);
            } else if ($app_type == 'CC001') {
                $success = AppReject::currencyCode($application->item_id, $action_status);
            }
//            else if ($app_type=='ADDC001'){
            //
            //                $success = AppReject::currencyCode($application->item_id,$action_status);
            //
            //            }
            //            else if ($app_type=='RPC001'){
            //
            //                $success = AppReject::currencyCode($application->item_id,$action_status);
            //
            //            }

            else if ($app_type == 'CS001') {
                $success = AppReject::chargeSetup($application->item_id, $action_status);
            } else if ($app_type == 'LM001') {
                $success = AppReject::limits($application->item_id, $action_status);
            } else if ($app_type == 'PR001') {
                $success = AppReject::product($application->item_id, $action_status);
            } /**
             * Be careful on this function
             */
            else if ($app_type == 'ADJUST001') {
                $success = AdjustmentHelper::rejectRequest($application->item_id);
            } else {
                Session::flash('alert-danger', 'Invalid request');
                return back();
            }

            if ($success) {
                Session::flash('alert-success', 'Successful rejected');
                DB::commit();
            } else {
                Session::flash('alert-danger', 'Rejection Failed');
                DB::rollBack();
            }

        } catch (Throwable $Throwable) {
            DB::rollBack();
            ExMessage::exp($Throwable);
            return back();
        }
        $desc = "Rejecting application request ";
        AuditLogs::save($desc, $id, 'APPLICATION', 'REJECT', 'SUCCESS', 'APPLICATION');
        if ($request->app_type == 'ADJUST001') {
            return redirect('applications/AD');
        }

        return redirect('applications/PA');
    }

    public function rejectUpdatedApp(Request $request, $id)
    {
        try {

            DB::beginTransaction();
            $application = ApplicationRequest::query()->where(['id' => $id])->first();
            $itemId = $application->item_id;
            if ($application->status != '01') {
                Session::flash('alert-danger', 'Action Not allowed, Since It was acted upon');
                return back();
            }
            $action_status = 'REJECTED';
            if ($request->action == 'cancel') {
                $action_status = 'CANCELED';
            }
            $comment = $request->comment;
            $application->status = '02';
            $application->action_status = $action_status;
            $application->comment = $comment;
            $app = $application->save();
            if (!$app) {
                Session::flash('alert-danger', 'Application could not be rejected');
                return back();
            }
            $app_type = decrypt($request->app_type);

            if ($app_type == 'UPLOC001') {
                $lim_app = LimitOnCard::rejectLimitOnCard($itemId);
                if (!$lim_app) {
                    Session::flash('alert-danger', 'Limit was not rejected!');
                    DB::rollBack();
                    return back();
                } else {
                    Session::flash('alert-success', 'Limit rejected successfully');
                    DB::commit();
                }
            }
            if ($app_type == 'UPLM001') {
                $lim_app = LimitClassApplication::query()->where(['id' => $itemId])->first();
                $lim_app->status = $action_status;
                $successLimApp = $lim_app->save();
                if (!$successLimApp) {
                    Session::flash('alert-danger', 'Application could not be rejected');
                    DB::rollBack();
                    return back();
                }
                Session::flash('alert-success', 'Application successful updated');
                DB::commit();

            } else if ($app_type == 'UPPR001') {
                $duoProduct = DuoProduct::query()
                    ->where(['id' => $application->item_id])->first();
                $duoProduct->status = '02';
                $success = $duoProduct->save();
                if ($success) {
                    DB::commit();
                    Session::flash('alert-success', 'Application successful updated');
                } else {
                    Session::flash('alert-danger', 'Application could not be rejected');
                    DB::rollBack();
                    return back();
                }
            } else if ($app_type == 'UPLMI001') {
                $limitApplication = LimitApplication::query()->where(['id' => $itemId])->first();
                $limitApplication->status = $action_status;
                $limSuccess = $limitApplication->save();
                if (!$limSuccess) {

                    Session::flash('alert-danger', 'Application could not be rejected');
                    DB::rollBack();
                    return back();
                }

                Session::flash('alert-success', 'Application successful updated');
                DB::commit();
            }
            $desc = "Rejecting Edited application request";
            AuditLogs::save($desc, $request->app_type, 'APPLICATION', 'REJECT', 'SUCCESS', 'APPLICATION');

            if ($request->app_type == 'ADJUST001') {
                return redirect('applications/AD');
            }

            return redirect('applications/PA');
        } catch (Throwable $Throwable) {
            DB::rollBack();
            ExMessage::exp($Throwable);
            return back();
        }
    }

    public function approve(Request $request, $id)
    {
        try {

            $validator = Validator::make($request->all(),
                [
                    'app_type' => 'required|min:2|max:20',
                ]);

            if ($validator->fails()) {
                Session::flash('alert-danger', '' . $validator->getMessageBag()[0]);
                return back();
            }

            DB::beginTransaction();
            $application = ApplicationRequest::query()->where(['id' => $id])->first();
            if ($application->status != '01') {
                Session::flash('alert-danger', 'Action Not allowed, Since It was acted upon');
                return back();
            }
            $application->status = '00';
            $application->action_status = 'APPROVED';
            $application->approved_at = date('Y-m-d h:i:s');
            $application->approved_by = Auth::user()->id;

            $application->save();
            if ($request->app_type == 'EX001') {
                /**
                 * NOW UPDATE TO PREPAID WALLET DB
                 */
                $successRate = ExchangeHelper::copyToLogsAfterApproval($id);
                if ($successRate) {
                    Session::flash('alert-success', 'Successful updated');
                    DB::commit();
                } else {
                    Session::flash('alert-danger', 'Failed from switch to update exchange rate');

                    DB::rollBack();
                }
            }
            if ($request->app_type == 'ENC001' || $request->app_type == 'BLC001'
                || $request->app_type == 'DISC001' || $request->app_type == 'PNR001') {
                $success = UpdateCardStatus::update($application, $request);
                if ($success) {
                    Session::flash('alert-success', 'Successful updated');
                    DB::commit();
                } else {
                    DB::rollBack();
                }
            } else if ($request->app_type == 'UPLVY001' || $request->app_type == 'LVY001') {

                $success = Levy::approveLevy($application->item_id, $request->app_type);

                if ($success) {
                    Session::flash('alert-success', 'Successful submitted');
                    DB::commit();
                } else {
                    DB::rollBack();
                }
            } else if ($request->app_type == 'USR001') {

                $user = User::query()->where(['id' => $application->item_id])->first();
                $password = decrypt($user->pending_pwd);
                $user->approved_by = Auth::user()->id;
                $user->status = 1;
                $user->approved_date = now('Africa/Nairobi');
                $user->pending_pwd = null;
                $user->save();
                $message = 'Your access credentials are username ' . $user->email . ' and password is ' . $password;
                $params = ['has_ttach' => null, 'message' => $message, 'file' => null];

//              MailProcessingJob::dispatch($user,$message);
                //$user->notify(new SendMailNotification($user,$params));
                DB::commit();
                SendSmsJob::dispatch($user->phone_number, $message);
                $full_name = $user->first_name . " " . $user->last_name;
                Mail::to($user->email)->send(new OTPMail($full_name, $message));
                Session::flash('alert-success', 'Successful updated');

            } else if ($request->app_type == 'AUSR001') {
                $apiUser = DB::table('api_users')->where(['id' => $application->item_id])->first();
                $payload = [
                    'approved_by' => Auth::user()->id,
                    'status' => 1,
                    'approved_date' => now('Africa/Nairobi'),
                ];

                $password = decrypt($apiUser->pending_pwd);

                DB::table('api_users')->where(['id' => $application->item_id])->update($payload);

                $message = 'Hello, you have been registered to integrate with Prepaid Wallet system.
                Your access credentials are username: ' . $apiUser->username . ' and password: ' . $password;

                DB::commit();
                Mail::to($apiUser->email)->send(new ApiUserMail($message));
                Session::flash('alert-success', 'Successful updated');

            } else if ($request->app_type == 'PRESET001') {

                $userDuo = DuoPasswordReset::query()->where(['id' => $application->item_id])->first();
                $user = User::query()->where(['id' => $userDuo->user_id])->first();

                $password = decrypt($userDuo->password);
                $msisdn = RandomGenerator::addPrefixExtra($user->phone_number);
                $message = 'Your access credentials ' . $password;
                $user->password = Hash::make($password);
                $user->password_changed = 1;

                if ($user->save()) {
                    $userDuo->approved_by = Auth::user()->id;
                    $userDuo->status = 'APPROVED';
                    $userDuo->approved_date = now('Africa/Nairobi');
                    if ($userDuo->save()) {
                        SendSmsJob::dispatch($msisdn, $message);
                        $full_name = $user->first_name . " " . $user->last_name;
                        Mail::to($user->email)->send(new OTPMail($full_name, $message));
                        DB::commit();
                        Session::flash('alert-success', 'Successful updated');
                    } else {
                        DB::rollBack();
                        Session::flash('alert-danger', 'Failed to  update');
                    }
                } else {
                    DB::rollBack();
                    Session::flash('alert-danger', 'Failed to  update');
                }
            } else if ($request->app_type == 'RL001') {
                $role = Role::query()->where(['id' => $application->item_id])->first();
                $role->approved_by = Auth::user()->id;
                $role->status = 'ACTIVE';
                $role->approved_date = now('Africa/Nairobi');
                $role->save();
                DB::commit();
                Session::flash('alert-success', 'Successful updated');
            } else if ($request->app_type == 'MRCLR002') {

                $successM = ManualReserveClear::approve($application->application_code);

                if ($successM) {
                    DB::commit();

                } else {
                    DB::rollBack();
                }
                Session::flash('alert-success', 'Successful updated');
            } else if ($request->app_type == 'CDP002') {

                $userId = Auth::user()->id;
                $old_period = DormantPeriod::query()->where(['status' => 'ACTIVE'])->first();
                $old_period->status = 'INACTIVE';
                $old_period->disabled_date = now('Africa/Nairobi');
                $old_period->disabled_by = $userId;

                if (!$old_period->save()) {
                    DB::rollBack();
                    Session::flash('alert-danger', 'Failed to update old data');
                } else {

                    $period = DormantPeriod::query()->where(['id' => $application->item_id])->first();
                    $period->approved_by = $userId;
                    $period->status = 'ACTIVE';
                    $period->approved_date = now('Africa/Nairobi');

                    if ($period->save()) {
                        DB::commit();
                        Session::flash('alert-success', 'Successful updated');
                    } else {
                        DB::rollBack();
                        Session::flash('alert-danger', 'Failed to update');
                    }
                }

            } else if ($request->app_type == 'LOC001') {

                $lim = LimitOnCard::query()->where(['id' => $application->item_id])->first();
                $c_info = DB::table('consumer_cards')->select('has_spec_limit')->where(['card_number' => $lim->card_number])->first();

                if ($c_info->has_spec_limit != 1) {
                    $card = DB::table('consumer_cards')->where(['card_number' => $lim->card_number])
                        ->update(['has_spec_limit' => 1]);
                } else {
                    $card = true;
                }

                if ($card) {
                    $lim->approved_by = Auth::user()->id;
                    $lim->status = 'ACTIVE';
                    $lim->approved_date = now('Africa/Nairobi');
                    $lim->save();
                    DB::commit();
                    Session::flash('alert-success', 'Successful updated');
                } else {
                    DB::rollBack();
                    Session::flash('alert-danger', 'Failed to update card information');
                }
            } /**
             *  CREDIT/DEBIT ADJUSTMENT..
             */
            else if ($request->app_type == 'BLKAD001') {

                /**
                 * Call job to process bulk items for adjustment
                 * Added by baraka machumu
                 */
                $app = DB::table('applications as ap')
                    ->select('ap.operation', 'ap.id', 'ap.item_id', 'ap.account', 'ap.action_status', 'ap.id', 'ap.created_at', 'u.first_name',
                        'u.last_name', 'at.name as application_name', 'ap.application_type', 'u.middle_name', 'ap.user_branch_code', 'application_code')
                    ->leftJoin('application_type as at', 'at.code', '=', 'ap.application_type')
                    ->leftJoin('users as u', 'u.id', '=', 'ap.created_by')
                    ->where(['ap.id' => $id])
                    ->first();
                ProcessBulkAdjustment::dispatch($id, $app);
                DB::commit();

                Session::flash('alert-success', 'Successful queued!');

                $success = true;
            } /**
             *  CREDIT/DEBIT ADJUSTMENT..
             */
            else if ($request->app_type == 'ADJUST001') {
                $duoA = DB::table('duo_adjustment')->where(['id' => $application->item_id])
                    ->update(['status' => 'APPROVED', 'updated_at' => date('Y-m-d h:i:s'), 'updated_by' => Auth::user()->id]);

                if (!$duoA) {
                    DB::rollBack();
                    Session::flash('alert-danger', 'Failed to update record');
                }
                $res = AdjustmentHelper::sendAdjustment($application->item_id);
                $messageAuthorize = strtoupper(str_replace(' ', '', $res->MESSAGE));

                if ($res->RESPONSECODE == '00') {
                    DB::commit();
                    Session::flash('alert-success', 'Successful saved.');
                } elseif ($res->RESPONSECODE == '94' && $messageAuthorize == 'DUPLICATERRN') {
                    DB::commit();
                    Session::flash('alert-success', 'Successful saved.');
                } else {
                    DB::rollBack();
                    Session::flash('alert-danger', $res->MESSAGE);
                }
            } else if ($request->app_type == 'ADDC001') {
                $duo = DuoAddNewCard::query()->where(['id' => $application->item_id])->first();

                $branch = DB::table('users')->select('branch')->where(['id' => $duo->created_by])->first()->branch;
                $getDuo = DB::select('call GetDuoAddNewCardSP(?)', array($application->item_id))[0];
                $requestData = response()
                    ->json(['card_number' => $getDuo->card_number, 'currency' => $getDuo->currency,
                        'access_token' => $request->access_token, 'branch' => $branch,
                        'maker' => $duo->created_by, 'checker' => Auth::user()->id])
                    ->getData();
                $result_card = CardHelpers::addNewCard($requestData, $duo->owner_id);

                if ($result_card->RESPONSECODE == '00') {
                    $duo->status = 'APPROVED';
                    $duo->approved_date = Carbon::now('Africa/Nairobi');
                    $duo->approved_by = Auth::user()->id;
                    $duo->save();
                    DB::commit();
                    Session::flash('alert-success', 'Successful updated');

                } else {

                    DB::rollBack();
                    Session::flash('alert-danger', 'Failed - ' . $result_card->MESSAGE);
                }
            } else if ($request->app_type == 'RPC001') {
                $duo = DuoReplaceCard::query()->where(['id' => $application->item_id])->first();
                $card_number = CardHelpers::getDecryptedCard($duo->card_number);
                $old_card_number = CardHelpers::getDecryptedCard($duo->old_card);
                $branch = DB::table('users')->select('branch')->where(['id' => $duo->created_by])->first()->branch;

                $requestData = response()->json(['new_card' => $card_number, 'currency' => $duo->currency,
                    'old_card' => $old_card_number, 'access_token' => $request->access_token,
                    'branch' => $branch, 'maker' => $duo->created_by, 'checker' => Auth::user()->id])->getData();
                $result_card = CardHelpers::replaceCard($requestData)->getData();
                if ($result_card->result_code == '00') {
                    $duo->status = 'APPROVED';
                    $duo->approved_date = Carbon::now('Africa/Nairobi');
                    $duo->approved_by = Auth::user()->id;
                    $duo->save();
                    DB::commit();
                    Session::flash('alert-success', 'Successful updated');
                } else {
                    DB::rollBack();
                    Session::flash('alert-danger', 'Failed : ' . $result_card->message);
                }
            } else if ($request->app_type == 'CC001') {
                $currency = CurrencyTypes::query()->where(['currency_code' => $application->item_id])->first();

                $gl = DB::select('call PortalSaveGlSP(?,?)', array($currency->currency_code, $currency->short_code . ' GL'));
                if ($gl[0]->STATUS_CODE != 300) {
                    DB::rollBack();
                    Session::flash('alert-danger', $gl[0]->MESSAGE);
                }
                $currency->approved_by = Auth::user()->id;
                $currency->status = 'ACTIVE';
                $currency->approved_date = now('Africa/Nairobi');
                $currency->save();
                DB::commit();
                Session::flash('alert-success', 'Successful updated');
            } /**
             * APPROVE CHANGE OF CUSTOMER status INFORMATION
             */
            else if ($request->app_type == 'CCS001') {
                $customer = ChangeCustomerStatus::query()->where(['id' => $application->item_id])->first();
                if (CustomerHelper::changeAccountStatus($customer->new_status, $customer->customer_id)) {
                    $customer->approved_by = Auth::user()->id;
                    $customer->status = 'ACTIVE';
                    $customer->approved_date = now('Africa/Nairobi');
                    $customer->save();
                    DB::commit();
                    Session::flash('alert-success', 'Successful updated');
                } else {
                    Session::flash('alert-danger', 'Failed to update records');
                }
            } else if ($request->app_type == 'CS001') {
                $user = ChargeSettings::query()->where(['id' => $application->item_id])->first();
                $user->approved_by = Auth::user()->id;
                $user->status = 'ACTIVE';
                $user->approved_date = now('Africa/Nairobi');
                $user->save();
                DB::commit();
                Session::flash('alert-success', 'Successful updated');
            } else if ($request->app_type == 'PR001') {
                $user = BinPrefix::query()->where(['id' => $application->item_id])->first();
                $user->approved_by = Auth::user()->id;
                $user->status = 'ACTIVE';
                $user->approved_date = now('Africa/Nairobi');
                $user->save();
                DB::commit();
                Session::flash('alert-success', 'Successful updated');
            } else if ($request->app_type == 'LM001') {
                $user = LimitClass::query()->where(['id' => $application->item_id])->first();
                $user->approved_by = Auth::user()->id;
                $user->status = 'ACTIVE';
                $user->approved_date = now('Africa/Nairobi');
                $user->save();
                DB::commit();
                Session::flash('alert-success', 'Successful updated');
            } /**
             * MANUAL RELEASE OF TRANSACTION
             */

            else if ($request->app_type == 'MRL002') {
                $ml_result = ManualReleaseHelper::mlHandler($application->item_id);
                $ml = DB::table('duo_manual_release')->where(['id' => $application->item_id])->first();

                if ($ml->type_name == 'RELEASE') {
                    if ($ml_result->STATUS_CODE == '300') {
                        Session::flash('alert-success', 'Successful updated');
                        DB::commit();
                    } else {
                        Session::flash('alert-danger', $ml_result->MESSAGE);
                        DB::rollBack();
                    }

                } else {
                    if ($ml_result) {
                        Session::flash('alert-success', 'Successful updated');
                        DB::commit();
                    } else {
                        Session::flash('alert-danger', 'Failed to complete transaction');
                        DB::rollBack();
                    }

                }

            } /**
             * UPDATE CUSTOMER INFORMATION
             */
            else if ($request->app_type == 'ECI001') {

                $consumerSuccess = Consumer::updateUserInfo($application->item_id);

                if ($consumerSuccess) {
                    Session::flash('alert-success', 'Successful updated');
                    DB::commit();
                } else {
                    Session::flash('alert-success', 'Failed to update');
                    DB::rollBack();
                }

            } /**
             *  CARD ACTIVATION LOGIC
             */

            else if ($request->app_type == 'CR001') {
                $user = CustomerPrepostData::query()->where(['id' => $application->item_id])->first();
                $iso = new IsoServiceApi();
                $fullname = $user->first_name . ' ' . $user->initial . ' ' . $user->last_name;

                $c_controller = new CardController();
                $post_card_result = $c_controller->sendCardActivation($user);

                Log::info('response code ' . $post_card_result->RESPONSECODE);

                if ($post_card_result->RESPONSECODE == '00' || $post_card_result->RESPONSECODE == '94') {
                    $user->approved_by = Auth::user()->id;
                    $user->status = 'ACTIVE';
                    $user->approved_date = now('Africa/Nairobi');
                    $user->save();
                    DB::commit();
                    Session::flash('alert-success', 'Successful updated');
                } else {
                    DB::rollBack();
                    Session::flash('alert-danger', '' . $post_card_result->MESSAGE);
                    return back();
                }
            } else if ($request->app_type == 'NF001') {
                $service = NoFundFeeAllowedService::query()->where(['id' => $application->item_id])->first();
                $service->approved_by = Auth::user()->id;
                $service->status = 'ACTIVE';
                $service->approved_date = now('Africa/Nairobi');
                $service->save();
                DB::commit();
                Session::flash('alert-success', 'Successful updated');
            }
            /**
             *
             */
            $desc = "Approving application request";

            $messagePayload = [
                'desc' => $desc, 'app_type' => $request->app_type, 'data' => 'APPLICATION', 'APPROVE', 'SUCCESS', 'APPLICATION',
                'source' => 'PORTAL',
            ];
            AuditLogs::save($desc, $id, 'APPLICATION', 'APPROVE', 'SUCCESS', 'APPLICATION');

            event(new ApiNotification($messagePayload));

            if ($request->app_type == 'ADJUST001') {
                return redirect('applications/AD');
            }

            if ($request->app_type == 'BLKAD001') {
                return redirect('bulk-adjustment/approval');
            }
            return redirect('applications/PA');

        } catch (Throwable $Throwable) {
            DB::rollBack();
            Session::flash('alert-danger', 'something went wrong');
            Log::error('APPLICATION-EXCEPTION', ['MESSAGE' => $Throwable, 'USER' => Auth::user()->email]);
            if ($request->app_type == 'ADJUST001') {
                return redirect('applications/AD');
            }

            if ($request->app_type == 'BLKAD001') {
                return redirect('bulk-adjustment/approval');
            }
            return redirect('applications/PA');

        }
    }

    public static function exchangeRate($id): Collection
    {
        return DB::table('exchange_rate_tmp as er')
            ->select('er.buy', 'er.sell', 'er.midrate', 'er.buy', 'er.id', 'er.created_at', 'cto.name as currency_to', 'ctfrom.name as currency_from',
                'first_name', 'last_name')
            ->join('users as u', 'u.id', 'er.created_by_id')
            ->join('currency_types as ctfrom', 'ctfrom.currency_code', '=', 'er.currency_from_code')
            ->join('currency_types as cto', 'cto.currency_code', '=', 'er.exchange_currency_code')
            ->where('er.status', '=', null)
            ->where(['application_id' => $id])
            ->get();
    }

    public function approveUpdate(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(),
                [
                    'app_type' => 'required|min:2|max:20',
                ]);

            if ($validator->fails()) {
                Session::flash('alert-danger', '' . $validator->getMessageBag()[0]);
                return redirect('access/roles')->withInput();
            }
            DB::beginTransaction();
            $application = ApplicationRequest::query()->where(['id' => $id])->first();
            if ($application->status != '01') {
                Session::flash('alert-danger', 'Action Not allowed, Since It was acted upon');
                return back();
            }
            $application->status = '00';
            $application->action_status = 'APPROVED';
            $application->save();

            if ($request->app_type == 'UPLM001') {
                $limApp = LimitClassApplication::query()->where(['id' => $application->item_id])->first();
                $class = LimitClass::query()->where(['class_code' => $limApp->class_code])->first();
                /**
                 * Backup limit class to log table
                 */

                $successLog = ApplicationUtils::saveClassLog($class);
                $limit = Limit::query()
                    ->select('limit_code', 'max_daily', 'max_weekly', 'max_monthly', 'daily_tx_no',
                        'weekly_tx_no', 'monthly_tx_no', 'limit_code')->where(['class_limit_code' => $class->class_code])->get();
                if ($successLog) {

                    /**
                     * Backup limit to log table
                     */
                    $limitItemLogs = ApplicationUtils::saveLimitItemToLogs($limit, $class);
                    /**
                     * update limit class table with updated data
                     */
                    if ($limitItemLogs) {
                        $class->class_name = $limApp->class_name;
                        $class->class_code = $limApp->class_code;
                        $class->max_hold_amount = $limApp->max_hold_amount;
                        $class->currency = $limApp->currency;
                        $class->approved_by = Auth::user()->id;
                        $class->approved_date = now('Africa/Nairobi');
                        $successClass = $class->save();
                        if ($successClass) {
                            DB::commit();
                            Session::flash('alert-success', 'Successful updated');
                        } else {
                            Session::flash('alert-danger', 'Failed to process Old limits');
                            DB::rollBack();
                        }
                    } else {
                        Session::flash('alert-danger', 'Failed to process Old limits');
                        DB::rollBack();
                    }
                } else {
                    Session::flash('alert-danger', 'Failed to create limit class logs');
                    DB::rollBack();
                }
            } else if ($request->app_type == 'UPLMI001') {

                $successItemRule = ApplicationUtils::updateLimitRuleItem($request, $application->item_id);
                if ($successItemRule) {
                    DB::commit();
                    Session::flash('alert-success', 'Successful updated');
                } else {
                    Session::flash('alert-danger', 'Failed to create limit class logs');
                    DB::rollBack();
                }
            } else if ($request->app_type == 'UPPR001') {
                $product = DuoProduct::query()->where(['id' => $application->item_id])->first();
                $bin = BinPrefix::query()->where(['id' => $product->bin_id])->first();
                $bin->bin_number = $product->bin_number;
                $bin->currency = $product->currency;
                $bin->class_code = $product->class_code;
                $bin->product_name = $product->product_name;
                $bin->issuance_fee = $product->issuance_fee;
                $bin->min_balance = $product->min_balance;

                $bin->approved_by = Auth::user()->id;
                $bin->status = $product->status;
                $binsucess = $bin->save();
                if ($binsucess) {
                    DB::commit();
                    Session::flash('alert-success', 'Successful updated');
                } else {
                    Session::flash('alert-danger', 'Failed to update');
                    DB::rollBack();
                }
            } else if ($request->app_type == 'UPLVY001' || $request->app_type == 'LVY001') {

                $success = Levy::approveLevy($application->item_id, $request->app_type);

                if ($success) {
                    Session::flash('alert-success', 'Successful submitted');
                    DB::commit();
                } else {
                    DB::rollBack();
                }
            } else if ($request->app_type == 'UPCS001') {
                $successCharge = ApplicationUtils::updateCharge($application->item_id);
                if ($successCharge) {
                    DB::commit();
                    Session::flash('alert-success', 'Successful updated');
                } else {
                    Session::flash('alert-danger', 'Failed to create limit class logs');
                    DB::rollBack();
                }
            } else if ($request->app_type == 'UPRL001') {
                $successrole = RoleController::roleUpdate($application->item_id);
                if ($successrole) {
                    DB::commit();
                    Session::flash('alert-success', 'Successful updated');
                } else {
                    Session::flash('alert-danger', 'Failed to create limit class logs');
                    DB::rollBack();
                }

            } else if ($request->app_type == 'UPLOC001') {

                $successLimits = LimitOnCard::updateLimitOnCard($application->item_id);
                if ($successLimits) {
                    DB::commit();
                    Session::flash('alert-success', 'Successful updated');
                } else {
                    Session::flash('alert-danger', 'Failed to update limits');
                    DB::rollBack();
                }
            } else if ($request->app_type == 'UPUS001') {
                $successrole = UserController::update($application->item_id);
                if ($successrole) {
                    DB::commit();
                    Session::flash('alert-success', 'Successful updated');
                } else {
                    Session::flash('alert-danger', 'Failed to create limit class logs');
                    DB::rollBack();
                }
            }
            $desc = "Approving Edited application request";
            AuditLogs::save($desc, $request->app_type, 'APPLICATION', 'APPROVE', 'SUCCESS', 'APPLICATION');

            if ($request->app_type == 'ADJUST001') {
                return redirect('applications/AD');
            }

            return redirect('applications/PA');
        } catch (Throwable $Throwable) {
            DB::rollBack();
            ExMessage::exp($Throwable);
            if ($request->app_type == 'ADJUST001') {
                return redirect('applications/AD');
            }

            return redirect('applications/PA');

        }

    }

}
