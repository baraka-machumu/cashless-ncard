<?php $__env->startSection('content'); ?>


    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <div class="col-md-12" style="border: 2px solid #cdd1d3; height: 50px; line-height: 50px; margin-top: 5px;">
                    <span class="page-title">All Transactions :  by <?php echo e($agent_code); ?> </span>

                    <span class="pull-right" style="  float: right">Total Amount :  <b style="font-size: 18px;"><?php echo e(($amount)); ?></b></span>
                </div>
            </div>

            <div class="col-lg-12">
                <?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(Session::has('alert-' . $msg)): ?>

                        <p class="alert alert-<?php echo e($msg); ?>"><?php echo e(Session::get('alert-' . $msg)); ?>

                            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                <div class="form-row">

                    <div class="col-md-12" style="margin-top: 8px;">
                        <a href="<?php echo e(url('reports/agent-summary')); ?>" class="btn btn-cyan" style="margin-bottom: 10px;">Back</a>
                        <table class="table table-bordered">

                            <thead>
                            <tr>
                                <th>Agent Code</th>
                                <th>amount</th>
                                <th>recipient_id</th>
                                <th>Customer Phone #</th>
                                <th>terminal_device</th>
                                <th>transaction_type</th>
                                <th>created_at</th>

                            </tr>

                            </thead>

                            <tbody>

                            <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                <tr>

                                    <td><?php echo e($row->agent_code); ?></td>
                                    <td><?php echo e($row->amount); ?></td>
                                    <td><?php echo e($row->recipient_id); ?></td>
                                    <td><?php echo e($row->customer_phone_number); ?></td>
                                    <td><?php echo e($row->terminal_device); ?></td>
                                    <td><?php echo e($row->transaction_type); ?></td>
                                    <td><?php echo e($row->created_at); ?></td>



                                </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                    </div>

                </div>


            </div>

            <div class="col-lg-12 table-margin-top">

            </div>

        </div>

    </div>



<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>

    <script>

        $('#all-reg-cards').dataTable();

    </script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/summary/agents/view_transactions.blade.php ENDPATH**/ ?>