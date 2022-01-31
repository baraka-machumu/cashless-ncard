<?php $__env->startSection('content'); ?>


    <div class="col-md-12" style="margin-top: 20px;">

        <?php echo $__env->make('partials.error_message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <form method="post" action="<?php echo e(url('top')); ?>">

            <?php echo csrf_field(); ?>

            <label>Card Number</label>

            <input type="text" name="card">


            <label>Start Date</label>

            <input type="date" name="start_date"  >

            <label>End Date</label>

            <input type="date" name="end_date"  >


            <button type="submit" class="btn btn-primary">Get</button>
        </form>


        <?php if($res): ?>


            <form method="post" action="<?php echo e(url('top-user')); ?>">

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
                    <th>previous_balance</th>

                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $tx; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <tr>

                    <th><?php echo e($index); ?></th>
                    <th><?php echo e($row->card_number); ?></th>
                    <th><?php echo e($row->amount); ?></th>
                    <th><?php echo e($row->prev); ?></th>

                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>

            </table>


            <table class="table table-bordered" style="margin-top: 10px;">

                <thead>

                <tr>
                    <th colspan="6" style="background-color: #0d374a; color: white;"> Ticket Engine Transactions  Total Amount - <?php echo $sum ?></th>
                </tr>

                <tr>
                    <th>No</th>
                    <th>PhoneNumber</th>
                    <th>EventName</th>
                    <th>TicketRef</th>
                    <th>Amount</th>
                    <th>PaidDate</th>

                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $engine; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <tr>

                        <th><?php echo e($index); ?></th>
                        <th><?php echo e($row->PhoneNumber); ?></th>
                        <th><?php echo e($row->EventName); ?></th>
                        <th><?php echo e($row->TicketRef); ?></th>
                        <th><?php echo e($row->Amount); ?></th>
                        <th><?php echo e($row->PaidDate); ?></th>

                    </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>

            </table>


        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/top.blade.php ENDPATH**/ ?>