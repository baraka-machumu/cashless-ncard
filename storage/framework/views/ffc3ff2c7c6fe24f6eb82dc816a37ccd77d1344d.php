<?php $__env->startSection('content'); ?>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Merchant</h4>
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

                                    <a href="<?php echo e(url('merchants/create')); ?>" class="btn btn-cyan btn-sm" id="previous">New Merchant</a>


                </div>

            </div>

            <div class="col-lg-12 table-margin-top">


                <table class="table table-bordered table-striped" id="merchant-index">

                    <thead>
                    <tr>

                        <th>#</th>
                        <th>Name</th>
                        <th>Tin Number</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th>Location</th>
                        <th>Actions</th>

                    </tr>
                    </thead>

                    <tbody>

                    <?php $i=1; $clickedID='';?>
                    <?php $__currentLoopData = $merchants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $merchant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>

                            <td><?php echo e($i); ?></td>
                            <td><?php echo e($merchant['name']); ?></td>
                            <td><?php echo e($merchant['tin']); ?></td>
                            <td><?php echo e($merchant['phone_number']); ?></td>
                            <td><?php echo e($merchant['email']); ?></td>
                            <td><?php echo e($merchant['location']); ?></td>
                            <td>
                                


                                <a href="#"  id="<?php echo e($merchant['tin']); ?>" class="btn btn-success fa fa-edit edit-merchant-modal"><input type="hidden" class="mtin" value="<?php echo e($merchant['tin']); ?>"></a>
                                <a href="<?php echo e(url('merchants/config',$merchant['tin'])); ?>" class="btn btn-warning" id="v-<?php echo e($merchant['tin']); ?>"><i class="fa fa-eye view-merchant"></i></a>
                                <a href="<?php echo e(route('merchants.show',[$merchant['tin']])); ?>" class="btn btn-info"><i class="fa fa-users"></i></a>

                                <?php if($merchant['status_id']===1): ?>
                                    <a href="#"  id="<?php echo e($merchant['tin']); ?>" class="btn btn-danger disable-merchant"><i class="fa fa-trash"></i></a>

                                <?php elseif($merchant['status_id']===0): ?>
                                    <a href="#" id="<?php echo e($merchant['tin']); ?>" class="btn btn-primary enable-merchant"><i class="fa fa-toggle-on"></i></a>

                                <?php endif; ?>

                            </td>

                        </tr>
                        <?php $i++;?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    </tbody>
                </table>

            </div>

        </div>

    </div>


    <!-- Modal create -->
    <div class="modal fade bd-example-modal-lg" id="create-merchant-modal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form method="post" action="<?php echo e(route('merchants.store')); ?>" enctype="multipart/form-data" id="form-create-merchant-modal">


            <?php echo e(csrf_field()); ?>


            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content">
                    <div class="modal-header modal-background">
                        <h5 class="modal-title" id="exampleModalLabel">Create Merchant</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">


                                <div class="card">

                                    <?php echo e(csrf_field()); ?>

                                    <div class="card-body">

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <label for="mname">Merchant Name</label>
                                                    <input type="text" data-validation="required" data-validation-error-msg-required="Merchant name required"  class="form-control" id="mname" name="name" >

                                                </div>

                                                <div class="form-group">

                                                    <label for="telephone_number">Telephone Number</label>
                                                    <input type="text" data-validation="required" data-validation-error-msg-required="Merchant name required" class="form-control" name="telephone" id="telephone_number">

                                                </div>

                                                <div class="form-group">

                                                    <label for="mregion">Region</label> <br>
                                                    <select type="text" data-validation="required" data-validation-error-msg-required="Merchant name required"  class="select2 form-control region" id="mregions" name="region" style="width: 100%; height:36px;">
                                                        <option></option>

                                                        <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                            <option value="<?php echo e($region['id']); ?>"><?php echo e($region['name']); ?></option>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    </select>

                                                </div>
                                                <div class="form-group">

                                                    <label for="district">District</label> <br>

                                                    <select  data-validation="required" data-validation-error-msg-required="Merchant name required" class="select2 form-control custom-select district" name="district"  id="mdistricts" style="width: 100%; height:36px;">


                                                    </select>


                                                </div>

                                                <div class="form-group">

                                                    <label for="mbank">Bank Name</label> <br>

                                                    <select data-validation="required" data-validation-error-msg-required="Merchant name required" class="form-control custom-select bank" name="bank"  id="" style="width: 100%; height:36px;">
                                                        <option></option>
                                                        <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                            <option value="<?php echo e($bank['id']); ?>"><?php echo e($bank['name']); ?></option>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>

                                                </div>

                                                <div class="form-group">

                                                    <label for="business">Business License</label>
                                                    <input type="file"  required data-validation="required" data-validation-error-msg-required="business file required" class="form-control" name="business" id="business">

                                                </div>
                                                <div class="form-group">

                                                    <label for="bankverification">Bank Verification License</label>
                                                    <input type="file" required data-validation="required" data-validation-error-msg-required="bankverification file required" class="form-control" name="bankverification" id="bankverification">

                                                </div>

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
                                            <div class="col-md-5">
                                                <div class="form-group">

                                                    <label for="mtin">Tin Number</label>
                                                    <input type="text" required data-validation="required" data-validation-error-msg-required="Merchant name required" class="form-control" name="tin" id="tin" required>

                                                </div>

                                                <div class="form-group">

                                                    <label for="email">Email</label>
                                                    <input type="email" required data-validation="required" data-validation-error-msg-required="Merchant name required" class="form-control" id="email" name="email" >

                                                </div>
                                                <div class="form-group">

                                                    <label for="location">Location</label>
                                                    <input type="text"  required data-validation="required" data-validation-error-msg-required="Merchant name required" class="form-control" name="location" id="location">

                                                </div>
                                                <div class="form-group">

                                                    <label for="maccount">Account</label>
                                                    <input type="text" required data-validation="required" data-validation-error-msg-required="Merchant name required" class="form-control" name="account" id="account">

                                                </div>

                                                <div class="form-group">

                                                    <label for="mbranch-name">Bank Branch Name</label> <br>

                                                    <select data-validation="required" required data-validation-error-msg-required="Merchant name required" class="select2 form-control custom-select mbranch-name branch" name="branch"  id="mbranch" style="width: 100%; height:36px;">

                                                    </select>

                                                </div>
                                                <div class="form-group">

                                                    <label for="tinno_certificate">Tin No Certificate</label>
                                                    <input type="file" required data-validation="required" data-validation-error-msg-required="tinnocertificate file required" class="form-control" name="tinno_certificate" id="tinno_certificate">

                                                </div>
                                                <div class="form-group">

                                                    <label for="merchant-type">Merchant Type</label> <br>

                                                    <select class="select2 form-control custom-select " name="merchantType"  id="merchant-type" style="width: 100%; height:36px;">

                                                        <?php $__currentLoopData = $merchantTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                            <option value="<?php echo e($row->id); ?>"><?php echo e($row->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>


                                                </div>
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

                                            <div class="form-group" style="margin-top: 50px;">

                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success">Save</button>


                                            </div>



                                        </div>

                                    </div>

                                </div>


                            </div>
                        </div>


                    </div>

                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </form>

    </div>


    <!-- Modal Edit-->

    <!-- Modal create -->
    <div class="modal fade bd-example-modal-lg" id="show-edit-merchant-modal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form method="post" action="<?php echo e(url('merchants/update')); ?>" id="form-edit-merchant">

            <?php echo e(csrf_field()); ?>

            <?php echo method_field('PUT'); ?>

            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content">
                    <div class="modal-header modal-background">
                        <h5 class="modal-title" id="exampleModalLabel"><span class="dname" style="font-style: italic"></span> Merchant</h5>
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

                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <label for="mname">Merchant Name</label>
                                                    <input type="text" data-validation="required" data-validation-error-msg-required="Merchant name required"  class="form-control mname" id="" name="name">

                                                </div>

                                                <div class="form-group">

                                                    <label for="telephone_number">Telephone Number</label>
                                                    <input type="text" data-validation="required" data-validation-error-msg-required="Merchant name required" class="form-control mtelephone_number" name="telephone" id="mtelephone_number">

                                                </div>

                                                <div class="form-group">

                                                    <label for="mregion">Region</label> <br>
                                                    <select type="text" data-validation="required" data-validation-error-msg-required="Merchant name required"  class="select2 form-control region" id="" name="region" style="width: 100%; height:36px;">
                                                        <option></option>

                                                        <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                            <option value="<?php echo e($region['id']); ?>"><?php echo e($region['name']); ?></option>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    </select>

                                                </div>
                                                <div class="form-group">

                                                    <label for="district">District</label> <br>

                                                    <select  data-validation="required" data-validation-error-msg-required="Merchant name required" class="select2 form-control custom-select district" name="district"  id="mdistrict" style="width: 100%; height:36px;">


                                                    </select>


                                                </div>

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
                                            <div class="col-md-5">
                                                <div class="form-group">

                                                    <label for="mtin">Registration Number</label>
                                                    <input type="text" data-validation="required" data-validation-error-msg-required="Merchant name required tin" class="form-control tin" name="tin" id="tin" required>

                                                </div>

                                                <div class="form-group">

                                                    <label for="email">Email</label>
                                                    <input type="email" data-validation="required" data-validation-error-msg-required="Merchant name required" class="form-control email" id="email" name="email">

                                                </div>
                                                <div class="form-group">

                                                    <label for="location">Location</label>
                                                    <input type="text" data-validation="required" data-validation-error-msg-required="Merchant name required" class="form-control location" name="location" id="location" >

                                                </div>
                                                <div class="form-group">

                                                    <label for="maccount">Account</label>
                                                    <input type="text"  data-validation="required" data-validation-error-msg-required="Merchant name required " class="form-control account" name="account" id="account">

                                                </div>

                                                <div class="form-group">

                                                    <label for="mbranch-name">Bank Branch Name</label> <br>

                                                    <select data-validation="required" data-validation-error-msg-required="Merchant name required" class="select2 form-control custom-select branch" name="branch"  id="mbranch" style="width: 100%; height:36px;">

                                                    </select>


                                                </div>
                                                <div class="form-group">

                                                    <label for="edit-merchant_type">Merchant Type</label> <br>

                                                    <select class="form-control  edit-merchant_type" name="merchantType"  id="edit-merchant_types" style="width: 100%; height:36px;">


                                                        
                                                        <?php $__currentLoopData = $merchantTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                            <option value="<?php echo e($row->id); ?>"><?php echo e($row->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>


                                                </div>
                                                <div class="form-group" style="margin-top: 50px;">

                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success submit-edit-merchant-form">Save</button>


                                                </div>


                                            </div>

                                        </div>

                                    </div>

                                </div>


                            </div>
                        </div>


                    </div>

                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </form>

    </div>


    <?php echo $__env->make('merchants.disable_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('merchants.enable_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('merchants.view_merchant_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<?php $__env->stopSection(); ?>



<?php $__env->startSection('js'); ?>

    <script>
        $('#merchant-index').dataTable();

    </script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/merchants/index.blade.php ENDPATH**/ ?>