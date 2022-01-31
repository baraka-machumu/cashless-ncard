

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="create-role-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form method="post" action="<?php echo e(url('access/roles')); ?>">

        <?php echo e(csrf_field()); ?>

        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel">Create Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">

                                    <div class="row">


                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <label for="service_name">Role Name</label>
                                                <input type="text" class="form-control"b name="role_name" id="service_name" placeholder="Service Name">

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

                                            <div class="col-md-6" style="float: left">

                                                <ul class="rol-perm-list">
                                                    <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <?php if($index<7): ?>
                                                            <li>
                                                                <span class="perm-role-span"><input type="checkbox" name="permission[]" class="checkbox-custom" value="<?php echo e($permission->id); ?>"> <?php echo e($permission->name); ?> </span>
                                                            </li>

                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </ul>
                                            </div>

                                            <div class="col-md-6" style="float: left">

                                                <ul class="rol-perm-list">
                                                    <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <?php if($index>=7): ?>

                                                            <li>
                                                                <span class="perm-role-span"><input type="checkbox" name="permission[]" class="checkbox-custom" value="<?php echo e($permission->id); ?>"> <?php echo e($permission->name); ?> </span>
                                                            </li>

                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </ul>
                                            </div>

                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </form>

</div>
<?php /**PATH C:\xampp\htdocs\cashless\resources\views/roles/create.blade.php ENDPATH**/ ?>