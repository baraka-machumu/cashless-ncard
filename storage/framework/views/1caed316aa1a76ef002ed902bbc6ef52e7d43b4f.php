<?php $__env->startSection('content'); ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('agent-topup')): ?>

        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    <div class="col-md-12" style="border: 2px solid #cdd1d3; height: 50px; line-height: 50px; margin-top: 5px;">
                        <span class="page-title">Get Consumer Transactions By Mobile App</span>

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

                            <form method="get" action="<?php echo e(url('reports/consumer-transactions')); ?>">

                                <?php echo e(csrf_field()); ?>



                                <div class="row">

                                    <div class="col-md-4 form-group">


                                        <?php if($tin): ?>
                                            <select name="tin"  class="form-control" id="agent-summary">

                                                <option value="" selected disabled>--select merchant--</option>

                                                <?php $__currentLoopData = $merchants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <option value="<?php echo e($row->tin); ?>"
                                                    <?php if($row->tin==$tin): ?>  selected <?php endif; ?>
                                                    ><?php echo e($row->name); ?></option>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </select>

                                        <?php else: ?>
                                            <select name="tin"  class="form-control" id="agent-summary">

                                                <option value="" selected disabled>--select merchant--</option>

                                                <?php $__currentLoopData = $merchants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <option value="<?php echo e($row->tin); ?>"><?php echo e($row->name); ?></option>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </select>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-md-4 form-group">

                                        <?php if($start_date): ?>

                                            <input type="date" name="start_date"  value="<?php echo e($start_date); ?>" class="form-control" placeholder="Start date">

                                        <?php else: ?>

                                            <input type="date" name="start_date"   class="form-control" placeholder="Start date">

                                        <?php endif; ?>

                                    </div>

                                    <div class="col-md-4">

                                        <?php if($start_date): ?>
                                            <input type="date" name="end_date" value="<?php echo e($end_date); ?>" class="form-control" placeholder="End date">

                                        <?php else: ?>
                                            <input type="date" name="end_date" class="form-control" placeholder="End date">

                                        <?php endif; ?>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <button class="btn btn-info" name="repo-btn" type="submit">Search</button>
                                            <a href="<?php echo e(url('reports/consumer-transactions')); ?>" class="btn btn-cyan">Refresh</a>

                                        </div>
                                    </div>

                                </div>
                            </form>


                            <?php if($result): ?>

                                <form method="get" action="<?php echo e(url('reports/consumer-transactions-export')); ?>">

                                    <?php echo e(csrf_field()); ?>


                                    <input type="hidden" name="a_start_date"  value="<?php echo e($start_date); ?>" >
                                    <input type="hidden" name="a_end_date"  value="<?php echo e($end_date); ?>">
                                    <input type="hidden" name="a_tin"  value="<?php echo e($tin); ?>">

                                    <div style="float: right">

                                        <button type="submit" class="btn btn-info pull-right" style="float: right">EXPORT EXCEL</button>

                                    </div>

                                </form>

                                <table class="table table-bordered" id="trans">

                                    <thead>
                                    <tr>
                                        <th>wallet_id</th>
                                        <th>amount (TZS)</th>
                                        <th>recipient_id</th>
                                        
                                        <th>reference</th>
                                        <th>transaction_type</th>
                                        <th>created_at</th>

                                        
                                    </tr>

                                    </thead>

                                    <tbody>

                                    <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                        <tr>

                                            <td><?php echo e($row->wallet_id); ?></td>
                                            <td><?php echo e(number_format($row->amount,2,'.',',')); ?></td>
                                            <td><?php echo e($row->recipient_id); ?></td>
                                            <td><?php echo e($row->reference); ?></td>
                                            
                                            <td><?php echo e($row->transaction_type); ?></td>
                                            <td><?php echo e($row->created_at); ?></td>

                                            
                                            

                                            
                                            

                                            

                                            
                                            

                                        </tr>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>


                            <?php endif; ?>
                        </div>

                    </div>


                </div>

                <div class="col-lg-12 table-margin-top">

                </div>

            </div>

        </div>

    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

    <script>

        $('#agent-summary').select2();
        $('#trans').dataTable();

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/summary/consumers/consumer_transactions.blade.php ENDPATH**/ ?>