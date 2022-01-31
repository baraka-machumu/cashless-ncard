<?php $__env->startSection('content'); ?>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Users</h4>
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

                

                <a  href="<?php echo e(url('access/users/create')); ?>" class="btn btn-cyan btn-sm" id="previous">New User</a>


                

            </div>

            <div class="col-lg-12 table-margin-top">

                <table class="table table-bordered table-striped" id="users-table">

                    <thead>
                    <tr>

                        <th>#</th>
                        <th>Fullname</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Created date</th>
                        <th>Status</th>
                        <th>Actions</th>

                    </tr>
                    </thead>

                    <tbody>

                    <?php  $i =1;?>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <tr>

                            <td><?php echo e($i); ?></td>

                            <td><?php echo e($user->first_name.' '.$user->last_name); ?></td>
                            <td><?php echo e($user->email); ?></td>
                            <td><?php echo e($user->phone_number); ?></td>
                            <td><?php echo e(date('Y-m-d h:i:s',strtotime($user->created_at))); ?></td>
                            <td><?php echo e($user->status_name); ?></td>

                            <td>
                                <a href="<?php echo e(route('access-user-edit',$user->id)); ?>" class="btn btn-success edit-roles"><i class="fa fa-edit"></i></a>


                                <?php if($user->status==1): ?>
                                    <a href="#" class="btn btn-danger user-status" id="<?php echo e($user->id); ?>">

                                        <i class="fa fa-trash"></i></a>
                                <?php else: ?>
                                    <a href="#" class="btn btn-danger user-status-activate" id="<?php echo e($user->id); ?>">

                                        <i class="fa fa-check-circle"></i>
                                    </a>

                                <?php endif; ?>

                                <a href="<?php echo e(url('access/users/view',$user->id)); ?>" class="btn btn-warning"><i class="fa fa-eye"></i></a>

                            </td>

                        </tr>

                        <?php  $i++;?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>
                </table>

            </div>

        </div>

    </div>

    <?php echo $__env->make('users.activate', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('users.disabled', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>


    <script>

        $(function () {

            alert(33)
        })
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/users/index.blade.php ENDPATH**/ ?>