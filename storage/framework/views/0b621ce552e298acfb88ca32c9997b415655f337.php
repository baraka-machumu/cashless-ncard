<?php $__env->startSection('content'); ?>

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12" style="margin-bottom: 10px;">
                <div class="col-md-12" style="border: 2px solid #cdd1d3; margin-top: 5px; height: 50px; ">
                    <h4 class="page-title" style="line-height: 50px;">Create Merchant</h4>

                </div>
            </div>

               <div class="col-lg-12">
                <?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(Session::has('alert-' . $msg)): ?>

                        <p class="alert alert-<?php echo e($msg); ?>"><?php echo e(Session::get('alert-' . $msg)); ?>

                            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
            <div class="col-md-12">


                <div class="card">
                    <form method="post" action="<?php echo e(route('merchants.store')); ?>"  enctype="multipart/form-data">

                        <?php echo e(csrf_field()); ?>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="mname">Merchant Name</label>
                                        <input type="text" required pattern="[A-Za-z]*"   class="form-control" id="mname" name="name" >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mtin">Tin Number</label>
                                        <input type="number" required data-validation="required"  data-validation-error-msg-required="Merchant name required" class="form-control" name="tin" id="tin" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="telephone_number">Telephone Number</label>
                                        <input type="text" data-validation="required" data-validation-error-msg-required="Merchant name required" class="form-control" name="telephone" id="telephone_number">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="mregion">Region</label> <br>
                                        <select  data-validation="required" data-validation-error-msg-required="Merchant name required"  class="select2 form-control region" id="mregions" name="region" style="width: 100%; height:36px;">
                                            <option></option>

                                            <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <option value="<?php echo e($region['id']); ?>"><?php echo e($region['name']); ?></option>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">

                                        <label for="district">District</label> <br>

                                        <select  data-validation="required" data-validation-error-msg-required="Merchant name required" class="select2 form-control custom-select district" name="district"  id="mdistricts" style="width: 100%; height:36px;">


                                        </select>


                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="location">Location</label>
                                        <input type="text"  required data-validation="required" data-validation-error-msg-required="Merchant name required" class="form-control" name="location" id="location">

                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">

                                        <label for="email">Email</label>
                                        <input type="email" required data-validation="required" data-validation-error-msg-required="Merchant name required" class="form-control" id="email" name="email" >

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="maccount">Account</label>
                                        <input type="text" required data-validation="required" data-validation-error-msg-required="Merchant name required" class="form-control" name="account" id="account">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="mbank">Bank Name</label> <br>

                                        <select data-validation="required" data-validation-error-msg-required="Merchant name required" class="form-control custom-select bank" name="bank"  id="" style="width: 100%; height:36px;">
                                            <option></option>
                                            <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <option value="<?php echo e($bank['id']); ?>"><?php echo e($bank['name']); ?></option>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="branch">Bank Branch Name</label> <br>

                                        <input type="text" name="branch" id="branch" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="merchant-type">Merchant Type</label> <br>

                                        <select class="select2 form-control custom-select " name="merchantType"  id="merchant-type" style="width: 100%; height:36px;">

                                            <?php $__currentLoopData = $merchantTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <option value="<?php echo e($row->id); ?>"><?php echo e($row->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>


                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="business">Business License</label>
                                        <input type="file"  required data-validation="required" data-validation-error-msg-required="business file required" class="form-control" name="business" id="business">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="bankverification">Bank Verification License</label>
                                        <input type="file" required data-validation="required" data-validation-error-msg-required="bankverification file required" class="form-control" name="bankverification" id="bankverification">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label for="tinno_certificate">Tin No Certificate</label>
                                        <input type="file" required data-validation="required" data-validation-error-msg-required="tinnocertificate file required" class="form-control" name="tinno_certificate" id="tinno_certificate">

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">

                                        <label for="bankverification">Merchant Group</label>

                                        <select  class="form-control" name="group_code">
                                            <option selected disabled value="">--select group--</option>

                                            <?php $__currentLoopData = $merchantGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <option value="<?php echo e($row->code); ?>"><?php echo e($row->name); ?></option>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">

                                        <label for="bankverification">Viewed on mobile</label>

                                        <select class="form-control" name="addMobile">
                                            <option value="R">Remove</option>

                                            <option value="A">Add</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="merchant-type">Managed by</label> <br>

                                        <select class="select2 form-control custom-select " name="managedby"  id="managedby" style="width: 100%; height:36px;">

                                            <option selected disabled value="">--select receipt management type--</option>
                                            <?php $__currentLoopData = $managedby; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <option value="<?php echo e($row->name); ?>"><?php echo e($row->name); ?></option>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="merchant-type">Communication Type</label> <br>

                                        <select class="select2 form-control custom-select " name="comm_type"  id="comm_type" style="width: 100%; height:36px;">

                                            <option selected disabled value="">--select receipt communication type--</option>
                                            <?php $__currentLoopData = $comm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <option value="<?php echo e($row->type); ?>"><?php echo e($row->name); ?></option>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group text-right">
                                    <hr/>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>



                            </div>

                        </div>
                    </form>
                </div>


            </div>
        </div>

    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/merchants/create.blade.php ENDPATH**/ ?>