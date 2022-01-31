    

    <?php $__env->startSection('stylesheets'); ?>
    <style>

        .checkbox-custom {

            height: 15px;
            width: 60px;
            margin-left: 0;
        }

        .perm-role-span {
            height: 10px;
            width: 70px;
            margin-left: 0;
            margin-top: -2px;
        }
        .rol-perm-list{

            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        ul {
            list-style-type: none;
        }
        . .rol-perm-list li {

            list-style-type: none;
        }
    </style>
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('content'); ?>

        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">Roles</h4>
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

                    

                    <button type="button" data-toggle="modal" data-target="#create-role-modal" class="btn btn-cyan btn-sm" id="previous">New Role</button>


                    

                </div>

                <div class="col-lg-12 table-margin-top">


                    <table class="table table-bordered table-striped">

                        <thead>
                        <tr>

                            <th>#</th>
                            <th>Role Name</th>
                            <th>Created Date</th>
                            <th>Actions</th>

                        </tr>
                        </thead>

                        <tbody>

                        <?php  $i =1;?>
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>

                                <td><?php echo e($i); ?></td>

                                <td><?php echo e($role['name']); ?></td>
                                <td><?php echo e($role['created_at']); ?></td>

                                <td>
                                    <a  href="<?php echo e(route('access-role-edit',$role['id'])); ?>" class="btn btn-success edit-roles"><i class="fa fa-edit"></i></a>
                                    <a href="#" class="btn btn-danger  disabled-role" id="<?php echo e($role['id']); ?>"><i class="fa fa-trash"></i></a>

                                </td>

                            </tr>
                            <?php  $i++;?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        </tbody>
                    </table>

                </div>

            </div>

        </div>

        <?php echo $__env->make('roles.role_disable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('roles.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>




    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/roles/index.blade.php ENDPATH**/ ?>