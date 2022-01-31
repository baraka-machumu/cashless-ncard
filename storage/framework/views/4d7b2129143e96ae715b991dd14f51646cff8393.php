



<?php $__env->startSection('content'); ?>

    <div class="container-fluid">

        <div class="col-lg-12 show-user-details-2">

            <span>Supply parameter to get report</span>

        </div>
        <div class="row">

            <div class="col-md-12">


                <form  action="<?php echo e(url('reports/consumer-report',$report_id)); ?>" method="post">
                    <?php echo e(csrf_field()); ?>


                    <div class="col-md-4">
                    <?php $__currentLoopData = $params; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $param): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <div class="form-group">

                            <label for="<?php echo e($param->name); ?>"><?php echo e($param->description); ?></label>
                            <input type="text" class="form-control" name="params[<?php echo e($param->name); ?>]" id="<?php echo e($param->name); ?>">

                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <div class="form-group">

                            <button type="submit" class="btn btn-success">Get Report</button>


                        </div>

                        <a href="<?php echo e(url()->previous()); ?>" class="btn btn-info"><i class="fa fa-backward"></i></a>

                    </div>


                </form>


            </div>

        </div>

    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/reports/params.blade.php ENDPATH**/ ?>