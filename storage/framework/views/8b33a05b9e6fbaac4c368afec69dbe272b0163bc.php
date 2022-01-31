<?php $__env->startSection('content'); ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-report')): ?>

        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    <div class="col-md-12" style="border: 2px solid #cdd1d3; height: 50px; line-height: 50px; margin-top: 5px;">
                        <span class="page-title">Get Agent Transactions Summary</span>

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

                            <form method="get" action="<?php echo e(url('reports/agent-transactions')); ?>">

                                <?php echo e(csrf_field()); ?>



                                <div class="row">

                                    <div class="col-md-4 form-group">

                                        <select name="agent_code"  class="form-control" id="agent-summary">

                                            <option value="" selected disabled>--select agent--</option>

                                            <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <option value="<?php echo e($row->agent_code); ?>"><?php echo e($row->first_name.'  '.$row->last_name); ?></option>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </select>
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

                                            <button class="btn btn-info" type="submit">Search</button>
                                            <a href="<?php echo e(url('reports/agent-summary')); ?>" class="btn btn-cyan">Refresh</a>

                                        </div>
                                    </div>

                                </div>
                            </form>

                            <?php if($result): ?>



                                    <form method="post" action="<?php echo e(url('reports/agent-transactions-export')); ?>">

                                        <?php echo e(csrf_field()); ?>


                                        <input type="hidden" name="a_start_date"  value="<?php echo e($start_date); ?>" >
                                        <input type="hidden" name="a_end_date"  value="<?php echo e($end_date); ?>">

                                        <div style="float: right">

                                            <button type="submit" class="btn btn-info pull-right" style="float: right">EXPORT EXCEL</button>

                                        </div>

                                    </form>


                                    <table class="table table-bordered" id="trans">

                                        <thead>
                                        <tr>
                                            <th>Agent Code</th>
                                            <th>amount (TZS)</th>
                                            <th>recipient_id</th>
                                            
                                            <th>terminal_device</th>
                                            
                                            

                                            <th>Action</th>
                                        </tr>

                                        </thead>

                                        <tbody>

                                        <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                            <tr>

                                                <td><?php echo e($row->agent_code); ?></td>
                                                <td><?php echo e(number_format($row->amount,2,'.',',')); ?></td>
                                                <td><?php echo e($row->recipient_id); ?></td>
                                                
                                                <td><?php echo e($row->terminal_device); ?></td>
                                                
                                                

                                                <td>
                                                    <form method="get" action="<?php echo e(url('reports/agent-transactions',[$row->agent_code])); ?>" class="btn btn-info ">

                                                        <input type="hidden" name="a_start_date" value="<?php echo e($start_date); ?>">
                                                        <input type="hidden" name="a_end_date" value="<?php echo e($end_date); ?>">

                                                        <button type="submit" class="btn btn-sm btn-info">View</button>

                                                    </form>
                                                </td>

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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/summary/agents/agent_transactions.blade.php ENDPATH**/ ?>