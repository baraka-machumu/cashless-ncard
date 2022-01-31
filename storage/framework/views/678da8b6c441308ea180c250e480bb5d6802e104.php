<!-- Modal -->


<div class="modal fade bd-example-modal-lg" id="assign-permission" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <form method="post" action="<?php echo e(url('agents/roles/save',[$agent_code])); ?>" id="edit-agent-form">

        <?php echo e(csrf_field()); ?>


        <?php echo method_field('post'); ?>

        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel">Agent Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    

                    

                    
                    <div class="row">


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

                        </div>


                    </div>

                </div>


                <div class="modal-footer text-right">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success submit-edit-agent">save</button>
                </div>
            </div>
        </div>
    </form>

</div>

<?php /**PATH C:\xampp\htdocs\cashless\resources\views/agents/assign-permission-modal.blade.php ENDPATH**/ ?>