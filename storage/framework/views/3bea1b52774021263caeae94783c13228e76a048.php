



<?php $__env->startSection('content'); ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('agent-topup')): ?>

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <div class="col-md-12" style="border: 2px solid #cdd1d3; height: 50px; line-height: 50px; margin-top: 5px;">
                    <span class="page-title">Get Agent Summary</span>

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
                        <form method="get" action="<?php echo e(url('reports/agent-summary')); ?>">

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
                                    <input type="date" name="start_date" class="form-control" placeholder="Start date">
                                </div>

                                <div class="col-md-4">

                                    <input type="date" name="end_date" class="form-control" placeholder="End date">

                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">

                                        <button class="btn btn-info" type="submit">Search</button>
                                        <a href="<?php echo e(url('reports/agent-summary')); ?>" class="btn btn-cyan">Refresh</a>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                                <?php if(sizeof($result) > 0): ?>
                                    <div class="col-md-2 text-right">
                                        <div class="form-group">
                                            <a href="<?php echo e(url('export/agent-summary',[$request_for_export['agent_code'],$request_for_export['start_date'],$request_for_export['end_date']])); ?>" class="btn btn-primary btn-block" type="submit">Export CSV</a>
                                        </div>
                                    </div>
                                 <?php endif; ?>

                            </div>
                        </form>
                        <hr/>
                        <table class="table table-bordered" id="trans">

                            <thead>
                            <tr>
                                <th>Agent Code</th>
                                <th>Tota Card sold</th>
                                <th>Full Name</th>
                                <th>Phone number</th>
                                <th>Action</th>
                            </tr>

                            </thead>

                            <tbody>

                            <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($row->agent_code); ?></td>
                                    <td><?php echo e($row->total_cards); ?></td>
                                    <td><?php echo e($row->fullname); ?></td>
                                    <td><?php echo e($row->phone_number); ?></td>

                                    <td>
                                        <a href="<?php echo e(url('reports/agent-summary',[$row->agent_code])); ?>" class="btn btn-info ">

                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>

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

    <?php endif; ?>


<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>

    <script>

        $('#agent-summary').select2();
        $('#trans').dataTable();

    </script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/summary/agents/index.blade.php ENDPATH**/ ?>