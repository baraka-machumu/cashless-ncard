

<aside class="left-sidebar" data-sidebarbg="skin5" >
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">

            <input type="text" id="ul-sidebar-filter" onkeyup="myFunction()" placeholder="Search for names.."
                   class="form-control" style="background-color: #1F262D; color: white; ">

            <ul id="sidebarnav" class="p-t-30">

                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo e(url('dashboard')); ?>" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
                
                
                
                
                

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('low-account')): ?>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-settings"></i><span class="hide-menu">Management</span></a>
                    <ul aria-expanded="false" class="collapse  first-level">

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-merchant')): ?>
                            <li class="sidebar-item"><a href="<?php echo e(url('merchants')); ?>" class="sidebar-link">

                                    <i class="mdi mdi-note-outline"></i><span class="hide-menu">Merchants </span></a></li>
                        <?php endif; ?>

                        <li class="sidebar-item"><a href="<?php echo e(url('merchant-Aggregators')); ?>" class="sidebar-link">

                                <i class="mdi mdi-note-outline"></i><span class="hide-menu">Merchants Aggregator</span></a></li>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-agent')): ?>
                            <li class="sidebar-item"><a href="<?php echo e(url('agents')); ?>" class="sidebar-link">
                                    <i class="mdi mdi-note-outline"></i><span class="hide-menu">Manage Agents</span></a></li>
                        <?php endif; ?>
                        <li class="sidebar-item"><a href="<?php echo e(url('aggregators')); ?>" class="sidebar-link">
                                <i class="mdi mdi-note-outline"></i><span class="hide-menu">Aggregator Agents</span></a></li>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-consumer')): ?>
                            <li class="sidebar-item"><a href="<?php echo e(url('consumers')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Manage Consumers</span></a></li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-user')): ?>
                            <li class="sidebar-item"><a href="<?php echo e(url('access/users')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Users</span></a></li>

                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-card-pos')): ?>
                            <li class="sidebar-item"><a href="<?php echo e(url('cards')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Cards</span></a></li>
                            <li class="sidebar-item"><a href="<?php echo e(url('pos')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Pos</span></a></li>

                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-service-role-perm')): ?>
                            <li class="sidebar-item"><a href="<?php echo e(url('access/roles')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Roles</span></a></li>
                            <li class="sidebar-item"><a href="<?php echo e(url('access/permissions')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Permissions</span></a></li>
                            <li class="sidebar-item"><a href="<?php echo e(url('access/profiles')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Profile</span></a></li>
                            <li class="sidebar-item"><a href="<?php echo e(url('access/user-profiles')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">User Profile</span></a></li>
                            <li class="sidebar-item"><a href="<?php echo e(url('services')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Services</span></a></li>
                            <li class="sidebar-item"><a href="<?php echo e(url('gateways')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Gateways</span></a></li>

                        <?php endif; ?>


                    </ul>
                </li>

                <?php endif; ?>

                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-settings"></i><span class="hide-menu">Advanced</span></a>

                    <ul aria-expanded="false" class="collapse  first-level">

                        <li class="sidebar-item"><a href="<?php echo e(url('ncard-collections/accounts')); ?>" class="sidebar-link">

                                <i class="mdi mdi-note-outline"></i><span class="hide-menu">Collection Accounts</span></a>
                        </li>

                        <li class="sidebar-item"><a href="<?php echo e(url('ncard-disbursement/accounts')); ?>" class="sidebar-link">

                                <i class="mdi mdi-note-outline"></i><span class="hide-menu">Disbursement Accounts</span></a>
                        </li>

                        <li class="sidebar-item"><a href="<?php echo e(url('charges')); ?>" class="sidebar-link">

                                <i class="mdi mdi-note-outline"></i><span class="hide-menu">Manage Charges</span></a>
                        </li>

                    </ul>
                </li>


            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-transaction')): ?>

                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-account"></i>
                            <span class="hide-menu">Transactions</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"><a href="<?php echo e(url('merchant-transactions')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Merchants</span></a></li>
                            <li class="sidebar-item"><a href="<?php echo e(url('agent-transactions')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Agents</span></a></li>
                            

                            <li class="sidebar-item"><a href="<?php echo e(url('consumer-transactions')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Consumers</span></a></li>

                            
                            <li class="sidebar-item"><a href="<?php echo e(url('filter/all')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Transaction Filter</span></a></li>
                            <li class="sidebar-item"><a href="<?php echo e(url('tx-deposits/agents')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">agent deposits</span></a></li>


                        </ul>
                    </li>


                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-wallet')): ?>
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-wallet"></i><span class="hide-menu">Wallet</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            
                            <li class="sidebar-item"><a href="<?php echo e(url('wallet/agents')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Agents</span></a></li>
                            <li class="sidebar-item"><a href="<?php echo e(url('wallet/consumers')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline">

                                    </i><span class="hide-menu">Consumers</span></a></li>
                            <li class="sidebar-item"><a href="<?php echo e(url('wallet/info')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline">

                                    </i><span class="hide-menu">Ncard wallet info</span></a>
                            </li>

                            <li class="sidebar-item"><a href="<?php echo e(url('t-pesa/balance')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline">

                                    </i><span class="hide-menu">Ncard-Accounts</span></a>
                            </li>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transfer-revenue')): ?>

                                <li class="sidebar-item"><a href="<?php echo e(url('Fund/transfer-to-merchant')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline">

                                        </i><span class="hide-menu">Pay Merchant</span></a>
                                </li>

                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer-refund')): ?>

                                <li class="sidebar-item"><a href="<?php echo e(url('refund/top')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline">

                                        </i><span class="hide-menu">Customer Refund</span></a>
                                </li>

                            <?php endif; ?>


                        </ul>
                    </li>

                <?php endif; ?>

                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                                                 href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-wallet"></i><span class="hide-menu">Transaction</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">

                                <li class="sidebar-item"><a href="<?php echo e(url('View-Transactions/consumer')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline">

                                        </i><span class="hide-menu">Get Consumer Transactions</span></a>


                        </ul>
                    </li>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-report')): ?>
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-book"></i><span class="hide-menu">Reports</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">


                                <li class="sidebar-item"><a href="<?php echo e(url('reports/agent-summary')); ?>" class="sidebar-link"><i class="fa fa-cog"></i><span class="hide-menu">Agent Card Sales</span></a></li>

                                <li class="sidebar-item"><a href="<?php echo e(url('reports/agent-transactions')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Agent transactions</span></a></li>


                                <li class="sidebar-item"><a href="<?php echo e(url('reports/consumer-transactions')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Consumer transaction</span></a></li>

                                <li class="sidebar-item"><a href="<?php echo e(url('reports/ticket-sales')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Ticket Sales</span></a></li>
                                <li class="sidebar-item"><a href="<?php echo e(url('reports/mno-collection')); ?>" class="sidebar-link"><i class="fa fa-cog"></i><span class="hide-menu"> Mno Top Up</span></a></li>
                                <li class="sidebar-item"><a href="<?php echo e(url('reports/mno-trnx')); ?>" class="sidebar-link"><i class="fa fa-cog"></i><span class="hide-menu"> Mno Top Transactions</span></a></li>

                                <li class="sidebar-item"><a href="<?php echo e(url('reports/agent-topup')); ?>" class="sidebar-link"><i class="fa fa-cog"></i><span class="hide-menu"> Agent Top Up</span></a></li>

                                <li class="sidebar-item"><a href="<?php echo e(url('reports/merchant-collection')); ?>" class="sidebar-link"><i class="fa fa-cog"></i><span class="hide-menu"> Merchant collection</span></a></li>

                                <hr>












                            <li class="sidebar-item"><a href="<?php echo e(url('reports/consumer-report-statement')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Consumers Statement</span></a></li>


                            <li class="sidebar-item"><a href="<?php echo e(url('reports/getTransactionReportDaily')); ?>" class="sidebar-link">
                                    <i class="fa fa-cog"></i><span class="hide-menu">Collection By Date</span></a></li>

                            <li class="sidebar-item"><a href="<?php echo e(url('reports/configuration')); ?>" class="sidebar-link"><i class="fa fa-cog"></i><span class="hide-menu">Configurations</span></a></li>

                        </ul>
                    </li>

                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer-care')): ?>
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-book"></i><span class="hide-menu">Support</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">

                            <li class="sidebar-item"><a href="<?php echo e(url('support/customer-query')); ?>" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Customer Query</span></a></li>


                        </ul>
                    </li>

                <?php endif; ?>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<?php /**PATH C:\xampp\htdocs\cashless\resources\views/partials/sidebar.blade.php ENDPATH**/ ?>