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


    <div class="container-fluid">
        <div class="row">




            <div class="col-md-12">


                <div class="col-md-12">
                    <table class="table table-striped table-bordered  modal-background" id="table" >

                        <tbody>

                        <tr>

                            <td colspan="12" style="background-color: #1C729E;color: white;">Create user</td>

                        </tr>

                        </tbody>

                    </table>

                </div>
            </div>


        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <form method="post" action="<?php echo e(url('access/users')); ?>">

                        <?php echo e(csrf_field()); ?>


                        <div class="card-body">

                            <div class="row">


                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="first_name">First Name</label>
                                        <input type="text" class="form-control" required pattern="[A-Za-z]*" name="first_name" id="first_name" placeholder="First Name">

                                    </div>
                                    <div class="form-group">

                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="form-control" required pattern="[A-Za-z]*" name="last_name" id="last_name" placeholder="Last Name">

                                    </div>

                                    <div class="form-group">

                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" required name="email" id="email" placeholder="Email">

                                    </div>












                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="middle_name">Middle Name</label>
                                        <input type="text" class="form-control" pattern="[A-Za-z]*" required name="middle_name" id="middle_name" placeholder="Middle Name">

                                    </div>

                                    <div class="form-group">

                                        <label for="gender">Gender</label>
                                        <select class="select2 form-control custom-select gender" requiredname="gender"  id="gender" style="width: 100%; height:36px;">

                                            <option value="" selected disabled>--select --gender--</option>
                                            <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <option value="<?php echo e($gender['id']); ?>"><?php echo e($gender['name']); ?></option>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                                        </select>
                                    </div>

                                    <div class="form-group">

                                        <label for="phone_number">Phone Number</label>
                                        <input type="text" class="form-control" required name="phone_number" id="phone_number" placeholder="Phone Number">

                                    </div>


                                </div>


                                <div class="col-md-12">

                                    <table class="table table-striped table-bordered" id="table">

                                        <tbody>

                                        <tr>

                                            <td colspan="12" style="background-color: #31a4ba;color: white;">Select Permissions</td>

                                        </tr>

                                        </tbody>

                                    </table>
                                </div>


                                <div class="col-md-12">

                                    <div class="col-md-4" style="margin: 0;">

                                        <ul class="rol-perm-list">
                                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <?php if($index<4): ?>
                                                    <li>
                                                        <span class="perm-role-span"><input type="checkbox" name="role[]" class="checkbox-custom" value="<?php echo e($role->id); ?>"> <?php echo e($role->name); ?> </span>
                                                    </li>

                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </ul>
                                    </div>

                                    <div class="col-md-4">

                                        <ul class="rol-perm-list">
                                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <?php if($index>=4): ?>

                                                    <li>
                                                        <span class="perm-role-span"><input type="checkbox" name="role[]" class="checkbox-custom" value="<?php echo e($role->id); ?>"> <?php echo e($role->name); ?> </span>
                                                    </li>

                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </ul>
                                    </div>

                                    <div class="form-group">

                                        <a href="<?php echo e(url('users')); ?>" class="btn btn-info" >Back</a>
                                        <button class="btn btn-success" type="submit">Save</button>


                                    </div>


                                </div>

                            </div>

                        </div>
                    </form>
                </div>


            </div>
        </div>

    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/users/create.blade.php ENDPATH**/ ?>