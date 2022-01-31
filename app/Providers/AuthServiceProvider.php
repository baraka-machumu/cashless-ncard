<?php

namespace App\Providers;

use App\Permission;
use http\Client\Curl\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('do-finance',function ($user){

            return Permission::finance();

        });

        Gate::define('manage-user',function ($user){

            return Permission::managerUser();

        });

        Gate::define('manage-merchant',function ($user){

            return Permission::managerMerchant();

        });

        Gate::define('manage-agent',function ($user){

            return Permission::managerAgent();

        });
        Gate::define('manage-consumer',function ($user){

            return Permission::managerConsumer();

        });

        /**
         * manage consumer
         */
        Gate::define('customer-care',function ($user){

            return Permission::customercare();

        });

        /**
         * view only dashboard
         */

        Gate::define('low-account',function ($user){

            return Permission::lowAccount();

        });
        /**
         * manage pos and card
         */
        Gate::define('manage-card-pos',function ($user){

            return Permission::manageCardPos();

        });

        /**
     * manage serfvice,
     */
        Gate::define('manage-service-role-perm',function ($user){

            return Permission::manageCardPos();

        });

        /**
         * manage serfvice,
         */
        Gate::define('view-transactions',function ($user){

            return Permission::manageCardPos();

        });


        /**
         * manage serfvice,
         */
        Gate::define('manage-wallet',function ($user){

            return Permission::managerWallet();

        });


        /**
     * manage serfvice,
     */
        Gate::define('view-report',function ($user){

            return Permission::viewReport();

        });

        /**
         * manage , customer-refund
         */
        Gate::define('customer-refund',function ($user){

            return Permission::customerRefund();

        });


        /**
         * manage serfvice,
         */
        Gate::define('agent-topup',function ($user){

            return Permission::agentToup();

        });

        /**
         * manage serfvice,
         */
        Gate::define('agent-update',function ($user){

            return Permission::agentUpdate();

        });

        /**
         * manage serfvice,
         */

        Gate::define('consumer-update',function ($user){

            return Permission::consumerUpdate();

        });

        /**
         * transfer-revenue
         */

        Gate::define('transfer-revenue',function ($user){

            return Permission::transferRevenue();

        });

        Gate::define('reconcile',function ($user){

            return Permission::reconcile();

        });

        Gate::define('manage-consumer-credentials',function ($user){

            return Permission::manageConsumerCredentials();

        });

    }
}
