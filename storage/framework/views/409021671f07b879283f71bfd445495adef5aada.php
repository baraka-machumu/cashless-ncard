<?php $__env->startSection('stylesheets'); ?>
    <style>

        .checkbox-custom {

            height: 15px;
            width: 60px;
            margin-left: 0;
        }

        .perm-role-span {
            height: 10px;
            width: 70px;
            margin-left: 0;
            margin-top: -2px;
        }
        .rol-perm-list{

            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        ul {
            list-style-type: none;
        }
        . .rol-perm-list li {

            list-style-type: none;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12">
                <?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(Session::has('alert-' . $msg)): ?>

                        <p class="alert alert-<?php echo e($msg); ?>"><?php echo e(Session::get('alert-' . $msg)); ?>

                            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>

            <div class="col-lg-12 table-margin-top">
                <div class="col-md-12" style="border: 2px solid #cdd1d3; margin-top: 5px; margin-bottom: 10px; height: 50px; ">
                    <p class="page-title" style="line-height: 50px;">Welcome to customer support window

                    </p>
                </div>

                <form method="get" action="<?php echo e(url('support/customer-search')); ?>">
                    <div class="row" id="query-window">

                        <div class="col-md-4" >
                            <div class="form-group">

                                <label>Card Number</label>
                                <input type="text" class="form-control" value="<?php echo e(old('cardNo')); ?>" name="cardNo">

                            </div>
                        </div>
                        <div class="col-md-3" >
                            <div class="form-group">
                                <label>Wallet ID</label>

                                <input type="text"  value="<?php echo e(old('walletNo')); ?>" class="form-control" name="walletNo">

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">

                                <label>Phone Number</label>

                                <input type="text" value="<?php echo e(old('phoneNo')); ?>" class="form-control" name="phoneNo">

                            </div>
                        </div>

                        <div class="col-md-2">

                            <div class="form-group" style=" margin-top: 30px;">

                                <button type="submit" class="btn btn-cyan mdi mdi-search-web">Search Customer</button>
                            </div>
                        </div>
                    </div>
                </form>


                <table class="table table-bordered">

                    <tbody>
                    <tr>
                        <td style="background-color: #1a93ca; color: white;">Ticket Data</td>
                    </tr>
                    </tbody>
                </table>

                <form method="get" action="<?php echo e(url('support/customer-ticket-by-phone')); ?>">
                    <div class="row" id="query-window">

                                            <div class="col-md-3">
                                                <div class="form-group">

                                                    <label>Phone Number</label>

                                                    <input type="text" value="<?php echo e(old('phoneNo')); ?>" class="form-control" name="phoneNo">

                                                </div>
                                            </div>

                        <div class="col-md-5 form-group">
                            <div class="form-group">
                                <label>Event</label>

                            <select id="eventCode" name="eventCode" class="form-control eventCode">



                            </select>
                            </div>

                        </div>

                    <div class="col-md-2">

                        <div class="form-group" style=" margin-top: 30px;">

                            <button type="submit" class="btn btn-cyan mdi mdi-search-web">Search Ticket By Phone Number</button>
                        </div>
                    </div>
                    </div>
                </form>


                <?php if($resultP): ?>

                    <div class="col-lg-12 table-margin-top">

                        <table class="table table-bordered table-striped">
                            <tbody>
                            <tr>
                                <td>Ticket Number </td><td><?php echo e($resultP['TicketNo']); ?></td>
                            </tr>
                            <tr>

                                <td>Ticket Reference </td><td><?php echo e($resultP['TicketRef']); ?></td>
                            </tr>
                            <tr>
                                <td>Ticket Category </td><td><?php echo e($resultP['TicketCategoryName']); ?></td>
                            </tr>
                            <tr>
                                <td>Ticket Amount </td><td><?php echo e($resultP['Amount']); ?></td>
                            </tr>
                            <tr>
                                <td>Ticket Paid date </td><td><?php echo e($resultP['PaidDate']); ?></td>

                            </tr>

                            <tr>
                                <td>Number Of Attempt </td><td><?php echo e($resultP['NoAttempt']); ?></td>

                            </tr>

                            <tr>
                                <td>Last Attempted Date </td><td><?php echo e($resultP['LastAttemptDate']); ?></td>

                            </tr>
                            <tr>
                                <td>Is Validated </td><td>

                                    <?php if($resultP['IsValidated']==false): ?>

                                        NO
                                    <?php else: ?>

                                        YES
                                    <?php endif; ?>
                                </td>

                            </tr>

                            <tr>
                                <td>Validation Time </td><td><?php echo e($resultP['ValidatedDate']); ?></td>
                                

                            </tr>

                            <tr>
                                <td colspan="2" style="background-color: #1C729E; color: white;">Attempts</td>
                            </tr>

                            <?php if(empty($resultP['Attempts'][0])): ?>
                                <tr>
                                    <td colspan="2"  style="color: firebrick">No Attempts</td>
                                </tr>

                            <?php else: ?>
                                <?php $__currentLoopData = $resultP['Attempts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <tr>
                                        <td>AttemptDate </td><td><?php echo e($row['AttemptDate']); ?></td>
                                        <td>TicketCategory </td><td><?php echo e($row['TicketCategory']); ?></td>
                                        <td>LastValidatedDate </td><td><?php echo e($row['LastValidatedDate']); ?></td>
                                        <td>ValidatePoint </td><td><?php echo e($row['ValidatePoint']); ?></td>

                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                            <?php endif; ?>
                            </tbody>
                        </table>



                    </div>


                <?php endif; ?>

                <?php if($result): ?>

                    <p>If problem is huge submit to technical team using below  button</p>

                    <div class="row">

                        <div class="col-6">

                            <form method="get">
                                <div class="row">

                                    <div class="col-4" >
                                        <div class="form-group">

                                            <label>Ticket number</label>

                                            <input type="text" value="<?php echo e(old('phoneNo')); ?>" readonly class="form-control" name="phoneNo">

                                        </div>
                                    </div>

                                    <div class="col-4" style=" margin-top: 30px;">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="button"> submit to technical
                                            </button>
                                        </div>

                                    </div>

                                </div>
                            </form>

                        </div>

                        <?php if($walletDetails): ?>
                            <div class="col-6">

                                <form method="get"  action="<?php echo e(url('Ticket-Engine/get-ticket-by-card')); ?>">

                                    <div class="form-row">

                                        <div class="col-md-4 form-group">
                                            <input  type="text"  class="form-control"  value="<?php echo e($walletDetails->card_number); ?>" name="consumer_card_number" readonly>

                                        </div>
                                        <div class="col-md-5 form-group">

                                            <select id="eventCode" name="eventCode" class="form-control eventCode">


                                            </select>

                                        </div>
                                        <div class=" col-md-3 form-group" >

                                            <button class="btn btn-primary" type="submit"> Check Ticket
                                            </button>
                                        </div>

                                    </div>
                                </form>

                            </div>

                        <?php endif; ?>
                    </div>




                    <?php if(!empty($walletDetails)): ?>
                        <div class="col-md-12 result-window" >


                            <table class="table table-bordered table-striped">
                                <tbody>
                                <tr>
                                    <td>card_number</td><td>
                                        <?php if(!$walletDetails->card_number): ?>
                                            NO CARD ASSIGNED
                                        <?php else: ?>
                                            <?php echo e($walletDetails->card_number); ?>

                                        <?php endif; ?>
                                    </td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-consumer-credentials')): ?>

                                    <td>

                                        <button class="btn btn-danger" data-toggle="modal" data-target="#show-card-disable-modal">Disable card</button>

                                    </td>

                                        <?php endif; ?>
                                </tr>
                                <tr>
                                    <td>card status</td><td colspan="2">

                                        <?php if(!$walletDetails->status_name): ?>
                                            N/A
                                        <?php else: ?>
                                            <?php echo e($walletDetails->status_name); ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>wallet_id</td><td colspan="2"><?php echo e($walletDetails->wallet_id); ?></td>
                                </tr>
                                <tr>
                                    <td><b>balance</b></td><td colspan="2"><b style="font-size: 17px;"><?php echo e($walletDetails->balance); ?></b></td>
                                </tr>
                                <tr>
                                    <td>wallet_status</td><td><?php echo e($walletDetails->wallet_status); ?></td><td>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-consumer-credentials')): ?>

                                        <button class="btn btn-danger" data-toggle="modal" data-target="#show-account-disable-modal">
                                            Disable wallet</button>

                                            <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>email</td><td colspan="2"><?php echo e($walletDetails->email); ?></td>
                                </tr>
                                <tr>

                                    <td>first_name</td><td colspan="2"><?php echo e($walletDetails->first_name); ?></td>
                                </tr>

                                <tr>

                                    <td>Phone number</td><td colspan="2"><?php echo e($walletDetails->phone_number); ?></td>
                                </tr>
                                <tr>
                                    <td>last_name</td><td colspan="2"><?php echo e($walletDetails->last_name); ?></td>
                                </tr>
                                <tr>

                                    <td>source</td><td colspan="2"><?php echo e($walletDetails->agent_code); ?></td>
                                </tr>

                                <tr>

                                    <td>Registered date</td><td colspan="2"><?php echo e($walletDetails->created_at); ?></td>
                                </tr>
                                <tr>

                                    <td>Registered date</td><td colspan="2"><?php echo e($walletDetails->created_at); ?></td>
                                </tr>
                                <tr>

                                    <td>Agent Fullname</td><td colspan="2"><?php echo e($agentName); ?></td>
                                </tr>

                                </tbody>
                            </table>


                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-consumer-credentials')): ?>
                            <div class="col-md-12" style="border: 2px solid #cdd1d3; margin-top: 5px;">

                                <p>Password and pin management</p>

                                <form method="post" action="<?php echo e(url('consumers/pin-reset')); ?>">
                                    <?php echo e(csrf_field()); ?>

                                    <div class="col-md-12">
                                        <input type="hidden"  name="wallet_id" value="<?php echo e($walletDetails->wallet_id); ?>">
                                        <div class="form-group">

                                            <input type="text"  readonly class="form-control" placeholder="Enter pin" name="pin" >
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-info">Reset pin</button>
                                        </div>
                                    </div>
                                </form>

                                <form method="post" action="<?php echo e(url('consumers/password-reset')); ?>">
                                    <?php echo e(csrf_field()); ?>

                                    <div class="col-md-12">
                                        <input type="hidden"  name="wallet_id" value="<?php echo e($walletDetails->wallet_id); ?>">
                                        <div class="form-group">

                                            <input type="text"  class="form-control" placeholder="Enter password" name="password" >
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-info">Reset password</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <?php endif; ?>

                        </div>
                        <div class="col-md-12 result-window" >

                            <p>   Latest five deposits</p>

                            <table class="table table-bordered">

                                <thead>

                                <tr>
                                    <th>NO</th>
                                    <th>ncard_reference</th>
                                    <th>amount</th>
                                    <th>created_at</th>
                                    <th>current_balance</th>
                                    <th>previous_balance</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php $__currentLoopData = $consumerDeposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($index+1); ?></td>
                                        <td><?php echo e($row->ncard_reference); ?></td>
                                        <td><?php echo e($row->amount); ?></td>
                                        <td><?php echo e($row->created_at); ?></td>
                                        <td><?php echo e($row->current_balance); ?></td>
                                        <td><?php echo e($row->previous_balance); ?></td>
                                    </tr>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>

                        </div>

                        <div class="col-md-12 result-window">

                            <p>   Latest five payments</p>
                            <table class="table table-bordered">
                                <thead>

                                <tr>
                                    <th>NO</th>
                                    <th>reference</th>
                                    <th>amount</th>
                                    <th>created_at</th>
                                    <th>current_balance</th>
                                    <th>previous_balance</th>
                                    <th>phone_number</th>

                                </tr>
                                </thead>

                                <tbody>
                                <?php $sum  = 0; ?>
                                <?php $__currentLoopData = $consumerPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <?php $sum  =  $sum+$row->amount ?>
                                    <tr>
                                        <td><?php echo e($index+1); ?></td>
                                        <td><?php echo e($row->reference); ?></td>
                                        <td><?php echo e($row->amount); ?></td>
                                        <td><?php echo e($row->created_at); ?></td>
                                        <td><?php echo e($row->current_balance); ?></td>
                                        <td><?php echo e($row->previous_balance); ?></td>
                                        <td><?php echo e($row->phone_number); ?></td>



                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <td colspan="2">Total</td>
                                    <td><strong><?php echo e($sum); ?></strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <?php echo $__env->make('wallets.actions.disable_account_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php echo $__env->make('wallets.actions.disable_card_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <?php else: ?>
                        <table class="table table-bordered">
                            <tbody>
                            <tr><td>No data found</td></tr>
                            </tbody>
                        </table>
                    <?php endif; ?>
                <?php endif; ?>

            </div>

        </div>

    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>

    <script>
        $(function (){

            let event  =  '<?php echo e(url('active-event')); ?>';

            console.log('sss'+event)

            $('.eventCode').html('')

            $.get(event, function (data){

                let events =   data.result;

                console.log(events)

                $('.eventCode').append('<option></option>');

                $('.eventCode').append('<option value="" selected disabled>--select event--</option>')
                for (let i=0; i<events.length; i++){

                    let tr = '<option value="'+events[i].EventCode+'">'+events[i].EventName+'</option>';

                    $('.eventCode').append(tr);

                }

            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/support/index.blade.php ENDPATH**/ ?>