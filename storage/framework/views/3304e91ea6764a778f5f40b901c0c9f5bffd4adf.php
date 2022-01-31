<?php $__env->startSection('content'); ?>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="user-details-round-icon">
                    <span><?php echo e(mb_strtoupper(substr($merchant->name,0,1))); ?></span>
                </div>
                <h4 class="page-title"><?php echo e($merchant->name); ?>'s Profile</h4>
                <div class="ml-auto text-right">

                    <nav aria-label="breadcrumb">
                        <input type="hidden" value="<?php echo e($merchant->name); ?>" id="merchant-name">

                        <input type="hidden" id="merchant-type" value="<?php echo e($merchant->merchant_type); ?>">

                        <?php if($merchant->status_id===1): ?>
                            <a href="#" class="btn btn-warning disable-merchant"  id="<?php echo e($merchant->tin); ?>">Deactivate </a>

                        <?php else: ?>
                            <a href="#" class="btn btn-info enable-merchant"  id="<?php echo e($merchant->tin); ?>">Activate </a>
                        <?php endif; ?>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        
        <?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(Session::has('alert-' . $msg)): ?>

                <p class="alert alert-<?php echo e($msg); ?>"><?php echo e(Session::get('alert-' . $msg)); ?>

                    <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        

        <div class="col-lg-12 show-user-details-2">


            <div class="pull-left">

                <span style="text-align: start">Info</span>
            </div>

            <div class="pull-right">
                <h5  style="font-style: italic; text-align: end; font-size: 10px; margin-bottom: 40px;"> Total money earned </h5>


            </div>

        </div>

        <div class="row">


            <div class="col-md-6">

                <table class="table table-striped">

                    <tbody>

                    <tr>
                        <th>Merchant Name</th>
                        <td><?php echo e($merchant->name); ?></td>

                    </tr>

                    <tr>
                        <th>Merchant Tin</th>
                        <td><?php echo e($merchant->tin); ?></td>
                    </tr>
                    <tr>
                        <th>Merchant Account Number</th>
                        <td>
                            <form action="<?php echo e(url('merchants/update-account')); ?>" method="post">

                                <?php echo csrf_field(); ?>

                                <input type="text" class="form-control" name="accountNo" value="<?php echo e($merchant->account_number); ?>" id="accountNo" style="margin-bottom: 10px;">

                                <input type="hidden" name="tin" value="<?php echo e($merchant->tin); ?>">

                                <button class="btn btn-primary" id="edit-acc" type="button"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-danger" id="edit-close" type="button"><i class="fa fa-window-close"></i></button>

                                <button class="btn btn-secondary" type="submit" id="update-acc">Update</button>
                            </form>


                        </td>
                    </tr>
                    <tr>
                        <th>Merchant Phone Number</th>
                        <td><?php echo e($merchant->phone_number); ?></td>
                    </tr>
                    <tr>
                        <th>Merchant Type</th>

                        <td><?php echo e($merchant->merchant_type); ?></td>
                    </tr>

                    </tbody>
                </table>

                
                <a  class="btn btn-success" id="add-agent-pos" data-toggle="modalss" href="#add-pos-modal88"><i class="fa fa-plus-square"></i> Pos</a>
                <a  class="btn btn-info  pull-right"  href="<?php echo e(url('merchants/users',$merchant->tin)); ?>"><i class="fa fa-plus-square"></i>Syetem  Users</a>

                <table class="table table-striped" id="pos-merchant">

                    <thead>

                    <tr>
                        <th>#</th>
                        <th>Pos Number</th>
                        <th>Status</th>
                        <th>Location</th>
                        <th>Actions</th>


                    </tr>
                    </thead>

                    <tbody>

                    <?php $i=1;?>
                    <?php $__currentLoopData = $merchant_pos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <tr>
                            <th>#</th>
                            <th><?php echo e($pos->imei_no); ?></th>
                            <th><?php echo e($pos->name); ?></th>
                            <th><?php echo e($pos->location); ?></th>
                            <th>
                                
                                <a href="#" class="btn btn-success add-merchant-agent-user-btn" id="<?php echo e($pos->imei_no); ?>" ><i class="fa fa-user-plus"></i></a>
                                <a href="<?php echo e(url("merchants/agent",['imei_no'=>$pos->imei_no])); ?>" class="btn btn-success" id="<?php echo e($pos->imei_no); ?>" ><i class="fa fa-eye"></i></a>

                            </th>


                        </tr>
                        <?php $i++;?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>



                </table>

            </div>

            <div class="col-md-6">

                <table class="table table-striped  dataTable">

                    <tbody>


                    <tr>
                        <th>Email</th>
                        <td><?php echo e($merchant->email); ?></td>
                    </tr>

                    <tr>
                        <th>Region</th>
                        <td><?php echo e($merchant->rname); ?></td>
                    </tr>

                    <tr>
                        <th>District</th>
                        <td><?php echo e($merchant->dname); ?></td>
                    </tr>
                    <tr>
                        <th>Location</th>
                        <td><?php echo e($merchant->location); ?></td>
                    </tr>

                    <tr style="background-color:#1C729E;">
                        <td colspan="2" style="color: white;">Commission</td>
                    </tr>

                    <?php if(!$commission): ?>
                    <tr>

                        <td>No Commission Set</td>

                        <td>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#merchant-commission-modal">Set commission</button>
                        </td>
                    </tr>

                    <?php endif; ?>

                    <?php if($commission): ?>
                        <tr>

                            <th>Commission Percentage</th> <td><?php echo e($commission->percentage); ?></td>
                        </tr>

                    <?php endif; ?>

                    </tbody>
                </table>


                
                <a  class="btn btn-success" id="add-merchant-service-btn" data-toggle="modalss" href="#add-pos-modal88"><i class="fa fa-plus-square"></i> Service</a>

                <table class="table table-striped">

                    <thead>

                    <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>Actions</th>

                    </tr>
                    </thead>

                    <tbody>

                    <?php $i=1;?>
                    <?php $__currentLoopData = $merchantServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                        <tr>
                            <th>#</th>
                            <th><?php echo e($row->name); ?></th>
                            

                            <th>
                                <a href="<?php echo e(route('merchant-products',[$merchant->tin,$row->id])); ?>" class="btn btn-success">products <i class="fa fa-plus"></i></a>

                                <a href="" class="btn btn-danger"><i class="fa fa-trash"></i></a>

                            </th>


                        </tr>
                        <?php $i++;?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>


                </table>

            </div>

        </div>

    </div>


    

    <?php echo $__env->make('merchants.add_posmerchant_agent_user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('merchants.add_merchant_services', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Modal for adding pos-->
    <div class="modal fade bd-example-modal-lg" id="add-pos-modal" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <div class="modal-header h4-background">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Pos</h5>
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

                                            <div class="form-group" id="s">

                                                <label for="service" id="add-label-warning">Select Pos </label> <br>

                                                <select class="form-control custom-select pos" name="imei_no"  id="add-pos-imei" style="width: 100%; height:36px;">
                                                    <option></option>

                                                </select>

                                            </div>

                                            <div class="form-group ifis-udart">

                                                <label for="mregion">Region</label> <br>
                                                <select type="text" data-validation="required" data-validation-error-msg-required="Merchant name required"  class="select2 form-control region" id="mregions" name="region" style="width: 100%; height:36px;">
                                                    <option></option>

                                                    <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option value="<?php echo e($region['id']); ?>"><?php echo e($region['name']); ?></option>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </select>

                                            </div>
                                            <div class="form-group ifis-udart" >

                                                <label for="district">District</label> <br>

                                                <select  data-validation="required" data-validation-error-msg-required="Merchant name required" class="select2 form-control custom-select district" name="district"  id="mdistricts" style="width: 100%; height:36px;">


                                                </select>


                                            </div>


                                            <div class="form-group">

                                                <div class="form-group" >

                                                    <label for="add-pos-location">Location</label> <br>

                                                    <input type="text"  data-validation="required" data-validation-error-msg-required="location name required" class=" form-control" name="location"  id="add-pos-location" style="width: 100%; height:36px;">
                                                    

                                                    
                                                    

                                                    

                                                    

                                                </div>

                                            </div>
                                            <div class="form-group">

                                                <button type="button" id="btn-add-posto-table" class="btn btn-cyan mdi mdi-plus"></button>
                                                
                                                <button  id="btn-form-submit-addpos"  type="submit" class="btn btn-success">Save</button>

                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <form id="add-pos-form" method="post" action="<?php echo e(url('merchants/add-pos-tomerchant')); ?>">
                                                <?php echo e(csrf_field()); ?>

                                                
                                                <input type="hidden" value="<?php echo e($merchant->tin); ?>" name="tin">
                                                <label class="err-warning-table"></label>

                                                <table id="table-pos-added"   class="table table-striped" style="margin-top: 10px;">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Pos Number</th>
                                                        <th>Location</th>
                                                        <th>Action</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody id="add-pos-tr">

                                                    </tbody>
                                                </table>


                                            </form>

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
    </div>

    

    <?php echo $__env->make('merchants.enable_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Modal -->

    

    <?php echo $__env->make('merchants.disable_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('merchants.commission_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

    <script>

        $(function () {

            let editBtn  = $('#edit-acc');

            $('#accountNo').prop('disabled',true)

            editBtn.show();

            $('#update-acc').hide();

            let closeBtn  =  $('#edit-close')

            closeBtn.hide()

            editBtn.click( function (){

                editBtn.hide();
                closeBtn.show();

                $('#accountNo').prop('disabled',false)
                $('#update-acc').show();

            });


            closeBtn.click( function (){

                editBtn.show();
                $('#edit-close').hide();

                $('#accountNo').prop('disabled',true)
                $('#update-acc').hide();

            });

            $('#pos-merchant').dataTable();

        })

z


    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/merchants/show_merchant.blade.php ENDPATH**/ ?>