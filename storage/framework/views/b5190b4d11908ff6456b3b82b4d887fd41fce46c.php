<?php $__env->startSection('content'); ?>


        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    <div class="col-md-12" style="border: 2px solid #cdd1d3; height: 50px; line-height: 50px; margin-top: 5px;">
                        <span class="page-title">Get Merchant Transaction</span>

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
                            <hr/>
                            <form method="get" action="<?php echo e(url('reports/getTransactionReportDaily-collection')); ?>">

                                <?php echo e(csrf_field()); ?>


                                <div class="row">


                                    <div class="col-md-4 form-group">
                                        <input type="date" name="start_date" class="form-control" placeholder="Start date">
                                    </div>

                                    <div class="col-md-4">

                                        <input type="date" name="end_date" class="form-control" placeholder="End date">

                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <button class="btn btn-info" type="submit">Search</button>
                                            <a href="<?php echo e(url('reports/mno-collection')); ?>" class="btn btn-cyan">Refresh</a>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    </div>


                                </div>
                            </form>
                            <hr/>

                        </div>

                    </div>


                </div>


                <?php if($is_result): ?>

                    <div class="col-lg-12 table-margin-top">

                        <form method="post"  action="<?php echo e(url('reports/getTransactionReportDaily-collection')); ?>">

                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="a_start_date" class="form-control" value="<?php echo e($_GET['start_date']); ?>">
                            <input type="hidden" name="a_end_date" class="form-control" value="<?php echo e($_GET['end_date']); ?>" >

                            <input type="hidden"  name="data" value="<?php echo e(json_encode($result)); ?>">
                            <button type="submit" class="btn btn-info" style="margin-top: 10px; margin-bottom: 10px;">Export</button>
                        </form>
                        <table class="table table-bordered" id="data-tbl">
                            <thead>

                            <tr>
                                <th>Merchant ID</th>
                                <th>Merchant Name</th>

                                <th>Total Collection</th>
                            </tr>

                            </thead>

                            <tbody>

                            <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <td><?php echo e($row->merchantTin); ?></td>
                                    <td><?php echo e($row->name); ?></td>

                                    <td><?php echo e(number_format($row->amount,0,'.',',')); ?></td>

                                </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                          </tbody>
                        </table>
                    </div>

                <?php endif; ?>
            </div>

        </div>




<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>

    <script>

        $('#agent-summary').select2();
        $('#data-tbl').dataTable();

    </script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/reports/transactions/daily.blade.php ENDPATH**/ ?>