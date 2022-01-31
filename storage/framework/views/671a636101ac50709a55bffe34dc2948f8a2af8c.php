<?php $__env->startSection('content'); ?>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Merchant Agents</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Merchant</li>
                        </ol>
                    </nav>
                </div>
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

                <div class="col-md-3">


                </div>

            </div>

            <div class="col-lg-12 table-margin-top">

                <?php $i= 1;?>
                <table class="table table-bordered table-striped">

                    <thead>
                    <tr>

                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th>Merchant</th>
                        <th>Actions</th>

                    </tr>
                    </thead>

                    <tbody>

                    <?php $__currentLoopData = $merchantAgents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $merchantAgent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>

                        <td><?php echo e($i); ?></td>
                        <td><?php echo e($merchantAgent->first_name); ?></td>
                        <td><?php echo e($merchantAgent->last_name); ?></td>
                        <td><?php echo e($merchantAgent->phone_number); ?></td>
                        <td><?php echo e($merchantAgent->email); ?></td>
                        <td><?php echo e($merchantAgent->tin); ?></td>
                        <td>

                            <a href="<?php echo e(url('merchants/edit-user',$merchantAgent->tin)); ?>"   class="btn btn-cyan btn-sm"><i class="fa fa-edit"></i> Edit</a>

                        </td>

                    </tr>
                    <?php $i++;?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>
                </table>

                <a  href="<?php echo e(url()->previous()); ?>" class="btn btn-info"> back</a>

            </div>

        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/merchants/show_merchant_agents.blade.php ENDPATH**/ ?>