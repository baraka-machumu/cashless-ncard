<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/','Auth\LoginController@showLoginForm')->name('login');
Route::post('/auth/login','Auth\LoginController@loginWeb');

Route::get('error-access', function (){
    return view('errors.login_access');
});

Route::get('/auth/change-password','Auth\PasswordResetController@changePassword')
    ->middleware(['auth','user-is-active']);
Route::post('/auth/change-password','Auth\PasswordResetController@saveNewPassword')
    ->middleware(['auth','user-is-active']);

Route::group(['middleware'=>['auth','user-is-active','firstLogin']],function () {
    Route::get('/auth/otp','Auth\OTPController@otpForm');
    Route::post('/auth/verify-otp','Auth\OTPController@verify');
    Route::get('/auth/otp/resend','Auth\OTPController@resentToken');
    Route::get('error-access/429-ex/{data}','Access\ErrorController@access429');
});
Route::group(['middleware'=>['auth','user-is-active','firstLogin','token']],function (){

    Route::get('locked', 'Auth\LoginController@locked')->middleware('auth');
    Route::get('lock','Auth\LoginController@lock');
    Route::post('unlock', 'Auth\LoginController@unlock')->name('unlock');
    Route::get('multiple-sessions','Auth\LoginController@hasMultipleSessions');
    Route::post('logout-this-device','Auth\LoginController@logoutCurrentSession');
    Route::post('logout-others-device','Auth\LoginController@logoutOtherSessions');

});

Route::get('/dashboard','DashboardController@adminDashboard')->name('dashboard');
Route::group(['middleware'=>['auth','user-is-active','firstLogin','session-timeout-check','token']], function (){


    Route::get('/dashboard','DashboardController@adminDashboard')->name('dashboard');

//merchants

    Route::post('/merchants/set-commission/{tin}','Merchant\MerchantActionsController@setCommission');
    Route::get('merchants/users/get-merchant-users-data','Merchant\MerchantsController@getMerchantUsersAjax');
    Route::post('merchants/users/store/{id}','Merchant\MerchantUserController@store')->name('merchants.store.user');
    Route::get('merchants/users/edit','Merchant\MerchantsController@usersFormEdit');
    Route::get('merchants/users/','Merchant\MerchantsController@showUser');
    Route::get('merchants/users/{id}','Merchant\MerchantUserController@index');
    Route::get('merchants/edit','Merchant\MerchantsController@edit');
    Route::get('merchants/agent/{imei_no}','Merchant\MerchantsController@getMerchantAgentUsers');
    Route::get('merchants','Merchant\MerchantsController@index');
    Route::get('merchants/get-merchant-data/{id}','Merchant\MerchantsController@getMerchantData');
    Route::post('merchants/users/update/{id}','Merchant\MerchantsController@userUpdate');

    Route::post('merchants/update','Merchant\MerchantsController@updateMerchant');
    Route::post('merchants/add-pos-tomerchant','Merchant\MerchantsController@storePos');
    Route::post('merchants/add-merchant-agent','Merchant\MerchantsController@storeMerchantAgentUsers');
    Route::post('merchants/add-merchant-service','Merchant\MerchantsController@stoteMerchantService');

    Route::post('merchants/account/enable','Merchant\MerchantsController@enableAccount')->name('m-enable-acount');
    Route::post('merchants/account/disable','Merchant\MerchantsController@disableAccount')->name('m-enable-acount');

    Route::post('merchants/update','Merchant\MerchantsController@updateMerchantAgentUsers');
    Route::get('merchants/edit-user/{tin}','Merchant\MerchantsController@editUserMerchant');

    Route::get('merchants/config/{tin}','Merchant\AppConfigController@index');
    Route::post('merchants/config/{tin}','Merchant\AppConfigController@saveJsonColumn');

    Route::post('merchants/update-account','Merchant\MerchantActionsController@updateAccountNumber');

    Route::resource('merchants','Merchant\MerchantsController');


    Route::get('merchant-app-config/{merchantTin}','Merchant\AppConfigController@view');
    //agents controller

    Route::get('agents/topup/{agent_code}/form','TopUp\AgentTopUpController@topupForm')->name('topup-form');

    Route::get('agents/getall/details/{agent_code}','Agent\AgentsController@getAgentDataJson');

    Route::get('agents-topup/pos/{agent_id}/create','Agent\AgentsController@posCreate')->name('pos-create');
    Route::post('agents-topup/pos/store/{agent_code}','Agent\AgentsController@storeAgentPosCredentials');

    Route::resource('agents','Agent\AgentsController');
    Route::post('agents/add-pos-toagent','Agent\AgentsController@storeAdditionalAgentPos')->name('add-agent-pos');
    Route::post('agents/account/disable','Agent\AgentsController@disableAccount')->name('disable-aacount');
    Route::post('/agent-topup/store/{agent_code}','TopUp\AgentTopUpController@storeTopup')->name('store-topup');

    Route::post('agents/account/enable','Agent\AgentsController@enableAccount')->name('enable-aacount');

    Route::post('agents/account/enable-pos','Agent\AgentsController@enablePos')->name('enable-agent-pos');

    Route::post('agents/account/disable-pos','Agent\AgentsController@disablePos')->name('enable-agent-pos');
    Route::post('agents/store-topup','Agent\AgentsController@topup');

    Route::post('agents/pin-reset','Agent\AgentsController@pinReset');

    Route::post('agents/password-reset','Agent\AgentsController@passwordReset');

    Route::post('agents/get-by-phonenumber','Agent\AgentsController@getByPhoneNumber');

    /**
     * AGENT TX LOGS
     *
     */
    Route::get('agent-request-logs/{txId}','Transaction\AgentTnxController@viewTxLogs');
    Route::post('agent-request-logs/{agent_code}','Agent\AgentTxHelperController@reprocess');

    // agent roles

    Route::get('agents/roles/{agent_code}','Agent\AgentRoleController@index');
    Route::post('agents/roles/save/{agent_code}','Agent\AgentRoleController@save');
    Route::post('agents/roles/disable/{pos_id}','Agent\AgentRoleController@delete');

    //consumer resource

    Route::get('consumers/getall/deposits/{id}','Consumer\ConsumerController@getAllConsumerDeposits');

    Route::post('consumers/account/enable','Consumer\ConsumerController@enableAccount')->name('c-enable-acount');
    Route::post('consumers/account/disable','Consumer\ConsumerController@disableAccount')->name('c-enable-acount');

    Route::resource('consumers','Consumer\ConsumerController');

    Route::get('consumers/reports','Consumer\ConsumerController@report');

    Route::post('consumers/pin-reset','Consumer\ConsumerController@pinReset');

    Route::post('consumers/password-reset','Consumer\ConsumerController@passwordReset');
    Route::post('consumers/update/{id}','Consumer\ConsumerController@update');

    Route::get('consumers/search-data/get-all','Consumer\ConsumerSearchController@search');

//services controller

    Route::resource('services','Service\ServiceController');

    Route::group(['prefix'=>'complementary'], function (){
        Route::get('/','ComplimentaryController@index');
    });

// role and permission controller

    Route::group(['prefix'=>'access'], function (){

        Route::group(['prefix'=>'users'], function (){

            Route::resource('/','Access\UserController');
            Route::get('/{id}/edit','Access\UserController@edit')->name('access-user-edit');
            Route::post('/update/{id}','Access\UserController@update');
            Route::get('/view/{id}','Access\UserController@show');
            Route::post('/activate','Access\UserController@activateUser');
            Route::post('/disable','Access\UserController@disabledUser');
            Route::post('/reset-password','Access\UserController@resetPassword');

        });

        Route::post('roles/update/{id}','Access\RoleController@roleUpdate');

        Route::get('roles/getrole-data/{id}','Access\RoleController@getRoleData');
        Route::get('permissions/getpermission-data/{id}','Access\PermissionController@getPermissionData');

        Route::resource('roles','Access\RoleController');

        Route::post('permissions/update','Access\PermissionController@permissionUpdate');

        Route::post('assign/permission','Access\ProfileController@assignPermissionToProfile');

        Route::resource('permissions','Access\PermissionController');
        Route::get('role/{roleId}/edit','Access\RoleController@edit')->name('access-role-edit');

        Route::get('errors/login','Access\ErrorController@errorLogin');

        Route::resource('profiles','Access\ProfileController');


    });

    //Export Reports
    Route::group(['prefix'=>'export'], function (){
        Route::get('agent-summary/{agentCode}/{startDate}/{endDate}','Summary\AgentSummaryController@exportAgentSummary')->name('export.agent_summary');

    });


//gateways controller

    Route::resource('gateways','Gateway\GatewayController');


//Transaction controller

    Route::group(['prefix'=>'transactions'], function (){

        Route::get('history/{id}','Transaction\TransactionController@history')->name('transactions.history');

        Route::get('success','Transaction\TransactionController@successTransaction');
        Route::get('failed','Transaction\TransactionController@failedTransaction');
        Route::get('reversal','Transaction\TransactionController@reversalTransaction');
        Route::get('pending','Transaction\TransactionController@pendingTransaction');

        Route::resource('/','Transaction\TransactionController');

    });


//consumer transactions
    Route::group(['prefix'=>'consumer-transactions'], function (){


        Route::get('history/{id}','Transaction\TransactionController@history')->name('transactions.history');

        Route::get('/','Transaction\ConsumerTransactionController@index');

        Route::get('fee-collection','Transaction\ConsumerTransactionController@feeCollectionTransactions');

        Route::get('deposits','Transaction\ConsumerTransactionController@depositTransactions');
        Route::get('payments','Transaction\ConsumerTransactionController@paymentsTransactions');
        Route::get('payment-history/{consumer_wallet_id}','Transaction\ConsumerTransactionController@paymentsHistory')->name('payment.history');
        Route::get('deposit-history/{consumer_wallet_id}','Transaction\ConsumerTransactionController@depositsHistory')->name('deposit.history');


    });

//agent transactions
    Route::group(['prefix'=>'agent-transactions'], function (){

        Route::get('/','Transaction\AgentTransactionController@index');

        Route::get('deposits','Transaction\AgentTransactionController@depositTransactions');
        Route::get('payments','Transaction\AgentTransactionController@paymentsTransactions');
        Route::get('payment-history/{consumer_wallet_id}','Transaction\AgentTransactionController@paymentsHistory')->name('payment.history');
        Route::get('deposit-history/{consumer_wallet_id}','Transaction\AgentTransactionController@depositsHistory')->name('deposit.history');

        // agent history

        Route::get('disbursement','Transaction\AgentTransactionController@AgentdisbursementTransactions');

        Route::get('history/{agent_code}','Transaction\AgentTransactionController@history')->name('agent-history');


    });


//merchant transactions
    Route::group(['prefix'=>'merchant-transactions'], function (){


        Route::get('history/{id}','Transaction\MerchantTransactionController@history')->name('transactions.history');

        Route::get('/','Transaction\MerchantTransactionController@index');

        Route::get('deposits','Transaction\MerchantTransactionController@depositTransactions');
        Route::get('payments','Transaction\MerchantTransactionController@paymentsTransactions');
        Route::get('payment-history/{tin}','Transaction\MerchantTransactionController@paymentsHistory')->name('payment.history');
        Route::get('deposit-history/{tin}','Transaction\MerchantTransactionController@depositsHistory')->name('deposit.history');


    });

//------------------------search controller --------------------------------

    Route::group(['prefix'=>'search'],function (){

        Route::get('merchant','Search\SearchMerchantController@index');
        Route::get('agent','Search\SearchAgentController@index');
        Route::get('consumer','Search\SearchConsumerController@index');

    });

    Route::group(['prefix'=>'charges'],function (){

        Route::get('/','Charge\ChargesController@index');

    });

    // -------------------------wallet controller-----------------------------
    Route::group(['prefix'=>'wallet','middleware'=>'manage-wallet'],function (){
        Route::get('consumer/details/{wallet_id}','Wallet\WalletController@getConsumerWalletDetails');
        Route::get('merchants','Wallet\WalletController@merchantWallet');
        Route::get('agents','Wallet\WalletController@agentWallet');
        Route::get('consumers','Wallet\WalletController@consumerWallet');
        Route::get('info','Wallet\WalletController@ncardWalletInfo');
        Route::post('disable-consumer-wallet','Wallet\ConsumerWalletController@disableAccount');
        Route::post('disabled-consumer-card','Wallet\ConsumerWalletController@disableCard');

    });


    // merchant products------------
    Route::group(['prefix'=>'merchant-products'],function (){
        Route::get('/{tin}/{service_id}','Service\ProductController@index')->name("merchant-products");
        Route::post('/store','Service\ProductController@store');
        Route::post('/remove','Service\ProductController@removeFromList');
    });

//authentications routes

    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/home', 'HomeController@index')->name('home');

/// merchant dashboard

//Route::get('merchant-dashboard','MerchantDashboard\MerchantController');

    Route::resource('merchant-transaction','MerchantDashboard\TransactionController');
    //region
    Route::get('regions/get-all','DashboardController@getRegions');
    Route::get('branches/get-all','DashboardController@getBranches');
    Route::get('/districts/get-all','DashboardController@getDistricts');
    Route::get('agents/districts/get-all','DashboardController@getDistricts');

    /** reports goes here */
    Route::group(['prefix'=>'reports','middleware'=>'view-report'], function (){
        Route::get('consumer-report-statement','Report\ReportController@consumerStatement');
        Route::get('consumer-report','Report\ReportController@consumerReports');
        Route::get('merchant-report','Report\ReportController@merchantReports');
        Route::get('agent-report','Report\ReportController@agentReports');
        Route::get('consumer-report/{report_id}','Report\ReportController@getReport');
        Route::post('consumer-report/{report_id}','Report\ReportController@getParameterizedReport');
        Route::get('configuration/get-report-by-id/{id}','Report\ConfigurationController@apiGetReportById');
        Route::resource('configuration','Report\ConfigurationController');
        Route::post('configuration/update','Report\ConfigurationController@updateReport');
        Route::get('/agent-summary','Summary\AgentSummaryController@index');
        Route::get('/agent-summary/{agent_code}','Summary\AgentSummaryController@getAllConsumerRegisterPerAgent');
        // mno topup
        Route::get('/mno-collection','Report\MnoCollectionController@index');
        //agent transaction
        Route::get('/agent-transactions','Summary\AgentTransactionController@index');
        Route::get('/agent-transactions/{agent_code}','Summary\AgentTransactionController@getAllConsumerRegisterPerAgent');
        Route::post('/agent-transactions-export','Summary\AgentTransactionController@export');
        //consumer transaction
        Route::get('/ticket-sales','Summary\TicketSalesController@index');
        Route::get('/consumer-transactions','Summary\ConsumerTransactionController@index');
        Route::get('/consumer-transactions/{agent_code}','Summary\ConsumerTransactionController@getAllConsumerRegisterPerAgent');
        Route::get('/consumer-transactions-export','Summary\ConsumerTransactionController@export');
        Route::get('/merchant-collection','Report\MerchantCollection@index');
        Route::get('/merchant-collection/get-data','Report\MerchantCollection@getData');
        Route::post('/merchant-collection/export-data','Report\MerchantCollection@export');
        Route::get('/agent-topup','Report\AgentCollectionController@index');
        Route::get('/agent-topup-collection','Report\AgentCollectionController@index');
        //mno trnx records
        Route::get('/mno-trnx','Report\MnoCollectionController@mnoTrnx');
        //get daily transaction
        Route::get('getTransactionReportDaily','Report\DailyTransactionReportController@index');
        Route::get('getTransactionReportDaily-collection','Report\DailyTransactionReportController@getTransactionReport');

    });

    Route::get('/agents/getall/pos', 'Agent\AgentsController@getAllPos')->name('getall-pos');

    /** filters action  */
    Route::group(['prefix'=>'filter'], function (){
        Route::get('/all','Filter\FilterController@index');
        Route::get('/get-data','Filter\FilterController@getFilter');
    });


    /** card routes */
    Route::group(['prefix'=>'cards'], function (){
        Route::get('/','Card\CardController@index');
        Route::post('reset-pos','Card\CardController@reset');
        Route::post('card-upload','Card\CardController@storeCards');

    });

    Route::group(['prefix'=>'pos'], function (){
        Route::get('/','PosController@index');
        Route::post('store','PosController@store');
        Route::get('/reset/{imei_no}','PosController@reset');
        Route::post('/reset-status','PosController@resetStatus');
    });

    Route::group(['prefix'=>'support'], function (){
        Route::get('/customer-query','Support\CustomerSupportController@index');
        Route::get('/customer-search','Support\CustomerSupportController@getResult');
    });


    Route::group(['prefix'=>'View-Transactions'], function (){
        Route::get('/consumer','Transaction\ConsumerTransactionController@index');
        Route::post('/consumer-get-trx','Transaction\ConsumerTransactionController@getTnx');

//        Route::post('/consumer-get-trx','Transaction\TicketEngineTrnxController@getTrnx');
        Route::get('/agent','Transaction\AgentTnxController@index');
        Route::post('/agent','Transaction\AgentTnxController@getTnx');
        Route::get('/agent-tnx-print','Transaction\AgentTnxController@getTnx');

    });

    Route::group(['prefix'=>'Fund','middleware'=>'transfer-m'], function (){
        Route::get('transfer-to-merchant','Tpesa\CashOutController@index');
        Route::get('view-transfer-status/{reference}/{tin}','Tpesa\CashOutController@view');
        Route::post('transfer-to-merchant','Tpesa\CashOutController@pay');
        Route::post('Resend-fund','Tpesa\CashOutController@repay');
    });

    /**
     *TPESA FUND MV
     */

    Route::group(['prefix'=>'t-pesa','middleware'=>'user-is-active'], function (){
        Route::get('send-fund','Tpesa\CashOutController@index');
        Route::get('balance','Tpesa\TpesaController@balance');
        Route::get('check-balance/{account}','Tpesa\TpesaController@checkBalance');
    });

    Route::group(['prefix'=>'tx-deposits'], function (){

        Route::get('agents','Transaction\AgentDepositController@deposits');
        Route::post('agents','Transaction\AgentDepositController@getAgentDepositByOptions');

    });

    Route::group(['prefix'=>'Ticket-Engine'], function (){

        Route::get('/get-ticket-by-card','TicketEngine\TicketEngineController@getTicketByCard');

        Route::get('/get-sold-ticket','Summary\TicketSalesController@getSold');

        Route::get('/get-event-by-ms-code/{mscode}','Summary\TicketSalesController@getEventBymSCode');

        Route::get('/get-merchant-code/{mscode}','Summary\TicketSalesController@getMerchantCode');

    });

    Route::group(['prefix'=>'aggregators'], function (){

        Route::get('/','Aggregator\AggregatorController@index');
        Route::get('/view/{code}','Aggregator\AggregatorController@view');

        Route::get('/create','Aggregator\AggregatorController@create');
        Route::post('/save','Aggregator\AggregatorController@save')->name('agg.save');

        Route::get('/users/{agent_code}','Aggregator\AggregatorUserController@index');
        Route::get('/users/create/{agent_code}','Aggregator\AggregatorUserController@create');
        Route::get('/users/store','Aggregator\AggregatorUserController@store');

        Route::post('/store-topup','Aggregator\AggregatorTopUpController@topup');

        Route::get('set-commission/{code}','Aggregator\AggregatorCommissionController@index');
        Route::get('set-commission-new/{code}','Aggregator\AggregatorCommissionController@create');
        Route::post('set-commission-save/{code}','Aggregator\AggregatorCommissionController@saveCommission')->name('agg-commission.save');

    });


    /** merchant-Aggregators */

    Route::group(['prefix'=>'merchant-Aggregators'], function (){

        Route::get('/','MerchantAggregator\MerchantAggregatorController@index');
        Route::get('/view/{code}','MerchantAggregator\MerchantAggregatorController@view');
        Route::get('/create','MerchantAggregator\MerchantAggregatorController@create');
        Route::post('/save','MerchantAggregator\MerchantAggregatorController@saveMA');
        Route::get('/set-commission','MerchantAggregator\MerchantAggregatorCommissionController@index');
        Route::get('/users','MerchantAggregator\MerchantAggregatorUserController@index');
    });


    Route::group(['prefix'=>'ncard-collections'], function (){
        Route::get('accounts', 'AdvancedSettings\NcardCollectionAccountController@index');
    });

    Route::group(['prefix'=>'ncard-disbursement'], function (){
        Route::get('accounts', 'AdvancedSettings\DisbursementAccountController@index');
    });

    Route::get('active-event', function (){

        $url = 'http://10.60.82.50:8095/active-event';
        $res  =  Http::get($url);
        return $res->json();

    });
    Route::get('support/customer-ticket-by-phone','TicketEngine\TicketEngineController@getTicketByPhoneNumber');
    Route::get('regii', function (){
        return view('home');
    });
    Route::get('refund/top', 'Wallet\ConsumerWalletController@getRefundView');
    Route::post('refund/check', 'Wallet\ConsumerWalletController@checkTx');

    Route::post('top', 'Wallet\ConsumerWalletController@verifyTopupRefund');
    Route::post('refund/top-user','Wallet\ConsumerWalletController@saveTopup');
    Route::get('reg','Wallet\ConsumerWalletController@saveCustomer');

    /**
     * TNX VERIFICATION
     * CREATED BY @baraka machumu
     */

    Route::get('tnx-recon/verify','Transaction\TnxVerifyController@index');
    Route::post('tnx-recon/verify','Transaction\TnxVerifyController@store');
    Route::post('tnx-recon/check-status','Transaction\TnxVerifyController@checkStatus');
    Route::post('tnx-recon/download','Transaction\TnxVerifyController@download');

});
//END AUTH GROUP






