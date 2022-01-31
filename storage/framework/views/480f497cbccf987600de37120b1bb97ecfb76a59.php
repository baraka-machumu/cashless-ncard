<?php $__env->startSection('content'); ?>




    <div class="container-fluid">

        <div class="row">
        <div class="col-md-12" style="margin-top: 20px;">


            <?php echo $__env->make('partials.error_message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <form method="post" action="<?php echo e(url('refund/check')); ?>">

                <?php echo csrf_field(); ?>

                <div class="com-md-4">

                    <label>Card Number/Card uid</label>

                    <input type="text" name="card" class="form-control" required>

                </div>
                <div class="com-md-4">

                    <label>Start Date</label>

                    <input type="date" name="start_date" class="form-control" >

                </div>

                <div class="com-md-4">

                    <label>End Date</label>

                    <input type="date" name="end_date"  class="form-control">

                </div>

                <div class="col-md-12" style="margin-top: 10px;">

                    <button type="submit" class="btn btn-primary">Get</button>

                </div>
            </form>


            <?php if($res): ?>


                <form method="post" action="<?php echo e(url('refund/top-user')); ?>">

                    <?php echo csrf_field(); ?>
                    <br><br>
                    <h2>TOP UP</h2>

                    <span>Balance  -  <?php echo e($balance->amount); ?></span>

                    <table class="table table-bordered">

                        <tbody>
                        <tr>
                            <td>Previous Balance </td><td><?php echo e($balance->previous_balance); ?></td>
                        </tr>

                        <tr>
                            <td>Current Top up </td><td><?php echo e($balance->current_topup); ?></td>
                        </tr>
                        </tbody>
                    </table>
                    <br>
                    <input type="text" name="card" readonly value="<?php echo e($card_number); ?>">
                    <input type="text" name="wallet_id" readonly value="<?php echo e($balance->wallet_id); ?>">


                    <label>Amount</label>

                    <input type="text" name="amount">


                    <button type="submit" class="btn btn-primary">Save</button>
                </form>


                <table class="table table-bordered" style="margin-top: 10px;">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Card number</th>
                        <th>Amount</th>
                        <th>terminal_device</th>
                        <th>consumer_current_balance</th>
                        <th>consumer_previous_balance</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $tx; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <tr>

                            <th><?php echo e($index+1); ?></th>
                            <th><?php echo e($row->created_at); ?></th>
                            <th><?php echo e($row->amount); ?></th>
                            <th><?php echo e($row->terminal_device); ?></th>
                            <th><?php echo e($row->consumer_current_balance); ?></th>
                            <th><?php echo e($row->consumer_previous_balance); ?></th>

                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>

                </table>


            <?php endif; ?>


    </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/wallets/top_refund_ncard.blade.php ENDPATH**/ ?>