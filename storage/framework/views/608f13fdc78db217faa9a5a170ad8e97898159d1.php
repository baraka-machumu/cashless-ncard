<?php $__env->startSection('content'); ?>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">N-CARD DISBURSEMENT ACCOUNTS</h4>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12">
                <?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(Session::has('alert-' . $msg)): ?>

                        <p class="alert alert-<?php echo e($msg); ?>"><?php echo e(Session::get('alert-' . $msg)); ?>

                            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                

                <a  href="<?php echo e(url('access/users/create')); ?>" class="btn btn-cyan btn-sm" id="previous">New Account</a>


                

            </div>

            <div class="col-lg-12 table-margin-top">

                <table class="table table-bordered table-striped" id="users-table">

                    <thead>
                    <tr>

                        <th>#</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Code</th>
                        <th>Description</th>

                    </tr>
                    </thead>

                    <tbody>

                    <?php  $index =1;?>

                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <tr>

                            <td><?php echo e($index); ?></td>
                            <td><?php echo e($row->name); ?></td>
                            <td><?php echo e(number_format($row->amount,2,'.',',')); ?></td>
                            <td><?php echo e($row->code); ?></td>
                            <td><?php echo e($row->description); ?></td>


                        </tr>
                        <?php  $index++;?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    </tbody>
                </table>

            </div>

        </div>

    </div>


<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>


    <script>

        $(function () {


        })
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/advanced_settings/charges/index.blade.php ENDPATH**/ ?>