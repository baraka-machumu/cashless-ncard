



<?php $__env->startSection('content'); ?>

    <div class="container-fluid">


        <div class="row">
            <div class="col-md-12">

                <h4>Consumer Reports</h4>

                

            </div>
            <div class="col-md-12 table-margin-top">

                <table class="table table-striped table-bordered table-condensed">

                    <thead>

                    <tr>
                        <th>#</th>
                        <th>name</th>
                        <th>Action</th>

                    </tr>
                    </thead>

                    <tbody>

                    <?php $i =1;?>
                    <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($i); ?></td>
                            <td><?php echo e($report->name); ?></td>
                            <td><a href="<?php echo e(url('reports/consumer-report',$report->id)); ?>" class="btn btn-cyan"><i class="fa fa-eye"></i></a>

                        </tr>
                        <?php $i++;?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/reports/consumer_reports.blade.php ENDPATH**/ ?>