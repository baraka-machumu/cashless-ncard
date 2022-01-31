<?php $__env->startSection('content'); ?>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="user-details-round-icon">
                    <span><?php echo e(mb_strtoupper(substr($agent->name,0,2))); ?></span>

                </div>
                <h4 class="page-title"><?php echo e(strtoupper($agent->name)); ?>'s Profile</h4>
                <div class="ml-auto text-right">

                    <nav aria-label="breadcrumb">

                        

                        

                    </nav>

                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">

        <?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(Session::has('alert-' . $msg)): ?>

                <p class="alert alert-<?php echo e($msg); ?>"><?php echo e(Session::get('alert-' . $msg)); ?>

                    <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="col-lg-12 show-user-details-2">

            <div class="pull-left">

                <span style="text-align: start">Info</span>
            </div>

            <div class="pull-right">
                <h5  style="font-style: italic; text-align: end; font-size: 13px; margin-bottom: 50px;">
                    Available balance <?php echo e(number_format($agent->current_balance,1,'.',',')); ?></h5>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-6">

                <table class="table table-striped">

                    <tbody>

                    <tr>
                        <th>Name</th>
                        <td><?php echo e($agent->name); ?></td>

                    </tr>

                    <tr>
                        <th>Agent Code</th>
                        <td><?php echo e($agent->code); ?></td>

                    </tr>

                    <tr>
                        <th>Tin Number</th>
                        <td><?php echo e($agent->tin); ?></td>

                    </tr>

                    <tr>
                        <th>Phone Number</th>
                        <td><?php echo e($agent->phone_number); ?></td>

                    </tr>


                    <tr>
                        <th>Created Date</th>
                        <td><?php echo e($agent->created_at); ?></td>

                    </tr>


                    </tbody>
                </table>


            </div>

            <div class="col-lg-6">

                <table class="table table-striped">

                    <tbody>

                    <tr>
                        <th>last_topup_date</th>
                        <td><?php echo e($agent->last_topup_date); ?></td>

                    </tr>
                    <tr>
                        <th>last_received_date</th>
                        <td><?php echo e($agent->last_received_date); ?></td>
                    </tr>

                    <tr>
                        <th>previous_balance</th>
                        <td><?php echo e($agent->previous_balance); ?></td>

                    </tr>

                    <tr>
                        <th>current_balance</th>
                        <td><?php echo e($agent->current_balance); ?></td>

                    </tr>
                    <tr>

                        <th colspan="2" style="background-color: #1C729E; color: white;">Commission (TZS)</th>

                    </tr>
                    <tr>
                        <th>Commission Collection</th>

                    </tr>
                    <tr>
                        <th>Last  updated</th>

                    </tr>


                    </tbody>
                </table>

                <div class="form-group">

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('agent-topup')): ?>

                        <a href="#" id="<?php echo e($agent->code); ?>"  class="btn btn-warning topup-agent"><i class="fa fa-money-bill-alt"></i></a>

                    <?php endif; ?>

                    <a  href="<?php echo e(url()->previous()); ?>" style="margin-top: 0px;" class="btn btn-info" name="edit-merchant">Back</a>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('agent-update')): ?>

                        <div class="col-md-12" style="border: 2px solid #cdd1d3; margin-top: 5px;">

                            <p>Password and pin management</p>

                            <form method="post" action="<?php echo e(url('aggregators/pin-reset')); ?>">

                                <?php echo e(csrf_field()); ?>


                                <div class="col-md-12">
                                    <input type="hidden"  name="agent_code" value="<?php echo e($agent->code); ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter pin " name="pin" >

                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info">Reset pin</button>

                                    </div>
                                </div>
                            </form>

                            <form method="post" action="<?php echo e(url('aggregators/password-reset')); ?>">
                                <?php echo e(csrf_field()); ?>

                                <div class="col-md-12">
                                    <input type="hidden"  name="agent_code" value="<?php echo e($agent->code); ?>">
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
            </div>


        </div>

    </div>

    <?php echo $__env->make('aggregator.topup_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/aggregator/show_agent.blade.php ENDPATH**/ ?>