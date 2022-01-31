

<aside class="left-sidebar" data-sidebarbg="skin5" >
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">

            <input type="text" id="ul-sidebar-filter" onkeyup="myFunction()" placeholder="Search for names.."
                   class="form-control" style="background-color: #1F262D; color: white; ">

            <ul id="sidebarnav" class="p-t-30">

                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('dashboard')}}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
                {{--                <li class="sidebar-item">--}}
                {{--                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('dashboard')}}" aria-expanded="false">--}}
                {{--                        <i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Complimentary</span>--}}
                {{--                    </a>--}}
                {{--                </li>--}}

                @cannot('low-account')
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-settings"></i><span class="hide-menu">Management</span></a>
                    <ul aria-expanded="false" class="collapse  first-level">

                        @can('manage-merchant')
                            <li class="sidebar-item"><a href="{{url('merchants')}}" class="sidebar-link">

                                    <i class="mdi mdi-note-outline"></i><span class="hide-menu">Merchants </span></a></li>
                        @endcan

                        <li class="sidebar-item"><a href="{{url('merchant-Aggregators')}}" class="sidebar-link">

                                <i class="mdi mdi-note-outline"></i><span class="hide-menu">Merchants Aggregator</span></a></li>

                        @can('manage-agent')
                            <li class="sidebar-item"><a href="{{url('agents')}}" class="sidebar-link">
                                    <i class="mdi mdi-note-outline"></i><span class="hide-menu">Manage Agents</span></a></li>
                        @endcan
                        <li class="sidebar-item"><a href="{{url('aggregators')}}" class="sidebar-link">
                                <i class="mdi mdi-note-outline"></i><span class="hide-menu">Aggregator Agents</span></a></li>
                        @can('manage-consumer')
                            <li class="sidebar-item"><a href="{{url('consumers')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Manage Consumers</span></a></li>
                        @endcan

                        @can('manage-user')
                            <li class="sidebar-item"><a href="{{url('access/users')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Users</span></a></li>

                        @endcan
                        @can('manage-card-pos')
                            <li class="sidebar-item"><a href="{{url('cards')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Cards</span></a></li>
                            <li class="sidebar-item"><a href="{{url('pos')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Pos</span></a></li>

                        @endcan
                        @can('manage-service-role-perm')
                            <li class="sidebar-item"><a href="{{url('access/roles')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Roles</span></a></li>
                            <li class="sidebar-item"><a href="{{url('access/permissions')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Permissions</span></a></li>
                            <li class="sidebar-item"><a href="{{url('access/profiles')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Profile</span></a></li>
                            <li class="sidebar-item"><a href="{{url('access/user-profiles')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">User Profile</span></a></li>
                            <li class="sidebar-item"><a href="{{url('services')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Services</span></a></li>
                            <li class="sidebar-item"><a href="{{url('gateways')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Gateways</span></a></li>

                        @endcan


                    </ul>
                </li>

                @endcannot

                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-settings"></i><span class="hide-menu">Advanced</span></a>

                    <ul aria-expanded="false" class="collapse  first-level">

                        <li class="sidebar-item"><a href="{{url('ncard-collections/accounts')}}" class="sidebar-link">

                                <i class="mdi mdi-note-outline"></i><span class="hide-menu">Collection Accounts</span></a>
                        </li>

                        <li class="sidebar-item"><a href="{{url('ncard-disbursement/accounts')}}" class="sidebar-link">

                                <i class="mdi mdi-note-outline"></i><span class="hide-menu">Disbursement Accounts</span></a>
                        </li>

                        <li class="sidebar-item"><a href="{{url('charges')}}" class="sidebar-link">

                                <i class="mdi mdi-note-outline"></i><span class="hide-menu">Manage Charges</span></a>
                        </li>

                    </ul>
                </li>


            @can('view-transaction')

                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-account"></i>
                            <span class="hide-menu">Transactions</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"><a href="{{url('merchant-transactions')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Merchants</span></a></li>
                            <li class="sidebar-item"><a href="{{url('agent-transactions')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Agents</span></a></li>
                            {{--                        <li class="sidebar-item"><a href="{{url('agent-transactions/disbursement')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Agents Disbursement Acc</span></a></li>--}}

                            <li class="sidebar-item"><a href="{{url('consumer-transactions')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Consumers</span></a></li>

                            {{--                        <li class="sidebar-item"><a href="{{url('consumer-transactions/fee-collection')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Fee Collection Acc</span></a></li>--}}
                            <li class="sidebar-item"><a href="{{url('filter/all')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Transaction Filter</span></a></li>
                            <li class="sidebar-item"><a href="{{url('tx-deposits/agents')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">agent deposits</span></a></li>


                        </ul>
                    </li>


                @endcan

                @can('manage-wallet')
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-wallet"></i><span class="hide-menu">Wallet</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            {{--<li class="sidebar-item"><a href="{{url('wallet/merchants')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Merchants</span></a></li>--}}
                            <li class="sidebar-item"><a href="{{url('wallet/agents')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Agents</span></a></li>
                            <li class="sidebar-item"><a href="{{url('wallet/consumers')}}" class="sidebar-link"><i class="mdi mdi-note-outline">

                                    </i><span class="hide-menu">Consumers</span></a></li>
                            <li class="sidebar-item"><a href="{{url('wallet/info')}}" class="sidebar-link"><i class="mdi mdi-note-outline">

                                    </i><span class="hide-menu">Ncard wallet info</span></a>
                            </li>

                            <li class="sidebar-item"><a href="{{url('t-pesa/balance')}}" class="sidebar-link"><i class="mdi mdi-note-outline">

                                    </i><span class="hide-menu">Ncard-Accounts</span></a>
                            </li>

                            @can('transfer-revenue')

                                <li class="sidebar-item"><a href="{{url('Fund/transfer-to-merchant')}}" class="sidebar-link"><i class="mdi mdi-note-outline">

                                        </i><span class="hide-menu">Pay Merchant</span></a>
                                </li>

                            @endcan

                            @can('customer-refund')

                                <li class="sidebar-item"><a href="{{url('refund/top')}}" class="sidebar-link"><i class="mdi mdi-note-outline">

                                        </i><span class="hide-menu">Customer Refund</span></a>
                                </li>

                            @endcan


                        </ul>
                    </li>

                @endcan

                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                                                 href="javascript:void(0)" aria-expanded="false">
                            <i class="mdi mdi-wallet"></i><span class="hide-menu">Transaction</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">

                                <li class="sidebar-item"><a href="{{url('View-Transactions/consumer')}}" class="sidebar-link"><i class="mdi mdi-note-outline">

                                        </i><span class="hide-menu">Get Consumer Transactions</span></a>


                        </ul>
                    </li>

            @can('view-report')
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-book"></i><span class="hide-menu">Reports</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
{{--                            @can('agent-topup')--}}

                                <li class="sidebar-item"><a href="{{url('reports/agent-summary')}}" class="sidebar-link"><i class="fa fa-cog"></i><span class="hide-menu">Agent Card Sales</span></a></li>

                                <li class="sidebar-item"><a href="{{url('reports/agent-transactions')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Agent transactions</span></a></li>


                                <li class="sidebar-item"><a href="{{url('reports/consumer-transactions')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Consumer transaction</span></a></li>

                                <li class="sidebar-item"><a href="{{url('reports/ticket-sales')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Ticket Sales</span></a></li>
                                <li class="sidebar-item"><a href="{{url('reports/mno-collection')}}" class="sidebar-link"><i class="fa fa-cog"></i><span class="hide-menu"> Mno Top Up</span></a></li>
                                <li class="sidebar-item"><a href="{{url('reports/mno-trnx')}}" class="sidebar-link"><i class="fa fa-cog"></i><span class="hide-menu"> Mno Top Transactions</span></a></li>

                                <li class="sidebar-item"><a href="{{url('reports/agent-topup')}}" class="sidebar-link"><i class="fa fa-cog"></i><span class="hide-menu"> Agent Top Up</span></a></li>

                                <li class="sidebar-item"><a href="{{url('reports/merchant-collection')}}" class="sidebar-link"><i class="fa fa-cog"></i><span class="hide-menu"> Merchant collection</span></a></li>

                                <hr>

{{--                                <li class="sidebar-item"><a href="{{url('reports/merchant/select-report')}}" class="sidebar-link"><i class="fa fa-cog"></i><span class="hide-menu"> Merchant Account</span></a></li>--}}
{{--                                <li class="sidebar-item"><a href="{{url('reports/consumer/select-report')}}" class="sidebar-link"><i class="fa fa-cog"></i><span class="hide-menu"> Consumer Account</span></a></li>--}}
{{--                                <li class="sidebar-item"><a href="{{url('reports/ncard/select-report')}}" class="sidebar-link"><i class="fa fa-cog"></i><span class="hide-menu"> N-Card Account</span></a></li>--}}

{{--                        @endcan--}}

{{--                        <!--            <li class="sidebar-item"><a href="{{url('reports/merchant-report')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Merchants</span></a></li>--}}
{{--                            <li class="sidebar-item"><a href="{{url('reports/agent-report')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Agents</span></a></li>--}}
{{--                            --}}{{--

          <li class="sidebar-item"><a href="{{url('reports/fee')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">FEE</span></a></li>--}}

{{--                 <li class="sidebar-item"><a href="{{url('reports/consumer-report')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Consumers</span></a></li>--}}
                            <li class="sidebar-item"><a href="{{url('reports/consumer-report-statement')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Consumers Statement</span></a></li>


                            <li class="sidebar-item"><a href="{{url('reports/getTransactionReportDaily')}}" class="sidebar-link">
                                    <i class="fa fa-cog"></i><span class="hide-menu">Collection By Date</span></a></li>

                            <li class="sidebar-item"><a href="{{url('reports/configuration')}}" class="sidebar-link"><i class="fa fa-cog"></i><span class="hide-menu">Configurations</span></a></li>

                        </ul>
                    </li>

                @endcan

                @can('customer-care')
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-book"></i><span class="hide-menu">Support</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">

                            <li class="sidebar-item"><a href="{{url('support/customer-query')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Customer Query</span></a></li>


                        </ul>
                    </li>

                @endcan

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
