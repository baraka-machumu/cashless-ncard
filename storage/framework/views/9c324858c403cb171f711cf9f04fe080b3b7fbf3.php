<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="show-edit-agent-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <form method="post" action="<?php echo e(url('')); ?>" id="edit-agent-form">

        <?php echo e(csrf_field()); ?>

        <?php echo method_field('put'); ?>
        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel">Update Agent</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    

                    

                    
                    <div class="row">


                        <div class="col-md-6">

                            <div class="form-group">

                                <label for="middle_name">Agent Code</label>
                                <input type="text" class="form-control agent_code" name="agent_code" id="agent_code" placeholder="Agent Code">

                            </div>

                            <div class="form-group">
                                <label for="mname">First Name</label>
                                <input type="text" data-validation="required" data-validation-error-msg-required="No first name provided"  class="form-control first_name" id="first_name" name="first_name" placeholder="First Name">

                            </div>

                            <div class="form-group">

                                <label for="last_name">Last Name</label>
                                <input type="text" data-validation="required" data-validation-error-msg-required="No last name provided"  class="form-control last_name" name="last_name" id="last_name" placeholder="Last Name">

                            </div>

                            <div class="form-group">

                                <label for="service">Gender</label> <br>

                                <select data-validation="required" data-validation-error-msg-required="No gender provided"  class="select2 form-control custom-select gender" name="gender"  id="service" style="width: 100%; height:36px;">
                                    <option></option>
                                    <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <option value="<?php echo e($gender['id']); ?>"><?php echo e($gender['name']); ?></option>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                            </div>
                            <div class="form-group">

                                <label for="regions">Region</label> <br>
                                <select data-validation="required" data-validation-error-msg-required="No region provided"  type="text" class="select2 form-control region" id="regions" name="region" style="width: 100%; height:36px;">
                                    <option></option>

                                    <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <option value="<?php echo e($region['id']); ?>"><?php echo e($region['name']); ?></option>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </select>

                            </div>




                        </div>
                        <div class="col-md-5">
                            <div class="form-group">

                                <label for="middle_name">Middle Name</label>
                                <input type="text" data-validation="required" data-validation-error-msg-required="No middle name provided"  class="form-control middle_name" name="middle_name" id="middle_name" placeholder="Middle Name">

                            </div>

                            <div class="form-group">

                                <label for="email">Email</label>
                                <input type="text" data-validation="required" data-validation-error-msg-required="No email provided"  class="form-control email" id="email" name="email" placeholder="Email">

                            </div>
                            <div class="form-group">

                                <label for="location">Location</label>
                                <input type="text" data-validation="required" data-validation-error-msg-required="No location provided"  class="form-control location" name="location" id="location" placeholder="Location">

                            </div>

                            <div class="form-group">

                                <label for="phone_number">Phone Number</label>
                                <input type="text" data-validation="required" data-validation-error-msg-required="No phone number provided"  class="form-control phone_number" name="phone_number" id="phone_number" placeholder="Phone Number">

                            </div>
                            <div class="form-group">

                                <label for="districts">District</label> <br>

                                <select data-validation="required" data-validation-error-msg-required="No district provided"  class="select2 form-control custom-select district" name="district_id"  id="district" style="width: 100%; height:36px;">


                                </select>


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

<?php /**PATH C:\xampp\htdocs\cashless\resources\views/agents/edit_agent_modal.blade.php ENDPATH**/ ?>