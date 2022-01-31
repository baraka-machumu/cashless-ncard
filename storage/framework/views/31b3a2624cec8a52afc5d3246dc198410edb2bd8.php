<?php $__env->startSection('content'); ?>

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12" style="margin-bottom: 10px;">
                <div class="col-md-12" style="border: 2px solid #cdd1d3; margin-top: 5px; height: 50px; ">
                    <h4 class="page-title" style="line-height: 50px;">Cash out for merchant</h4>

                </div>
            </div>
            <div class="col-md-12">

                <?php echo $__env->make('partials.error_message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="card">

                    <form method="get" action="<?php echo e(url('Fund/transfer-to-merchant')); ?>">

                        <?php echo e(csrf_field()); ?>


                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-4">

                                    <label>Merchant Name</label>

                                    <select class="form-control" name="tin" REQUIRED>

                                        <option value="">--select merchant--</option>

                                        <?php $__currentLoopData = $merchant; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <option value="<?php echo e($row->tin); ?>" ><?php echo e($row->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>


                                </div>
                                <div class="col-md-4">

                                    <label>Action type</label>

                                    <select class="form-control" name="tin" REQUIRED>

                                        <option value="">--select action--</option>

                                        <option value="1">Auto Request</option>
                                        <option value="2">Manual Request</option>

                                    </select>


                                </div>
                                <div class="col-md-1">
                                    <button name="check" style="margin-top: 25px;" type="submit" class=" btn btn-primary">Check</button>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

                <?php if($result): ?>

                    <h5 style="color: #1a93ca">Commission For - <?php echo e($mname); ?> - <?php echo e($tin); ?>  is <?php echo e($commission*100); ?> </h5>

                    <table class="table table-bordered">

                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Commission</th>
                            <th>Total</th>
                            <th>Action</th>

                        </tr>
                        </thead>

                        <?php $__currentLoopData = $rev; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>

                                <td><?php echo e($index+1); ?></td>
                                <td><?php echo e($row->mdate); ?></td>
                                <td><?php echo e(number_format($row->amount,2,'.',',')); ?></td>
                                <th><?php echo e(number_format(($row->amount)/(1-$commission)*$commission,2,'.',',')); ?></th>
                                <th><?php echo e(number_format(($row->amount)/(1-$commission),2,'.',',')); ?></th>

                                <td>













                                            <button class="btn btn-primary btn-cash-out" id="<?php echo e($row->mdate); ?>">Push payment</button>






                                </td>


                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>



                <?php endif; ?>


            </div>
        </div>

    </div>

    <?php echo $__env->make('cash_out.cash_out_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>

    <script>
        $(function (){

            $('.btn-cash-out').on('click', function (){

                let date     =  this.id;

                $('#date-c').val(date);

                $('#cash-out-modal').modal('show');
            });

        });
    </script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/cash_out/manual.blade.php ENDPATH**/ ?>