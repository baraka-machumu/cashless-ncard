<?php $__env->startSection('content'); ?>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="user-details-round-icon">
                    <span><?php echo e(mb_strtoupper(substr($agent->first_name,0,1).''.substr($agent->last_name,0,1))); ?></span>
                </div>
                <h4 class="page-title"><?php echo e($agent->first_name.' '.$agent->last_name); ?>'s Profile</h4>
                <div class="ml-auto text-right">

                    <nav aria-label="breadcrumb">
                        

                        

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
                <h5  style="font-style: italic; text-align: end; font-size: 12px; margin-bottom: 50px;">
                    Available balance <?php echo e(number_format($balance,1,'.',',')); ?></h5>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-6">

                <table class="table table-striped">

                    <tbody>

                    <tr>
                        <th>First Name</th>
                        <td><?php echo e($agent->first_name); ?></td>

                    </tr>
                    <tr>
                        <th>Middle Name</th>
                        <td><?php echo e($agent->middle_name); ?></td>
                    </tr>
                    <tr>
                        <th>Last Name</th>
                        <td><?php echo e($agent->last_name); ?></td>
                    </tr>

                    <tr>
                        <th>Gender</th>
                        <td><?php echo e($agent->gname); ?></td>
                    </tr>
                    <tr>

                        <th>Date of Birth</th>
                        <td><?php echo e($agent->dob); ?></td>
                    </tr>

                    <tr>
                        <th>Top Up Source</th>
                        <td><strong><?php echo e($agent_wallet->top_up_source); ?></strong></td>
                    </tr>

                    </tbody>
                </table>

                

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-card-pos')): ?>

                    <a  class="btn btn-success" id="add-agent-pos" data-toggle="modalss" href="#add-pos-modal88"><i class="fa fa-plus-square"></i> Add pos</a>

                <?php endif; ?>
                <table class="table table-striped">

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
                    <?php $__currentLoopData = $agent_pos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <tr>
                            <th>#</th>
                            <th><?php echo e($pos->imei_no); ?></th>
                            <th><?php echo e($pos->name); ?></th>
                            <th><?php echo e($pos->location); ?></th>
                            <th>
                                

                                <?php if($pos->status_id==1): ?>
                                    <a href="#" class="btn btn-danger disable-pos-agent" id="<?php echo e($pos->imei_no); ?>" ><i class="fa fa-trash"></i></a>

                                <?php elseif($pos->status_id==0): ?>
                                    <a href="#" class="btn btn-cyan enable-pos-agent" id="<?php echo e($pos->imei_no); ?>" ><i class="fa fa-toggle-on"></i></a>

                                <?php endif; ?>
                            </th>


                        </tr>
                        <?php $i++;?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>



                </table>

            </div>

            <div class="col-lg-6">


                


                <table class="table table-striped">

                    <tbody>

                    <tr>
                        <th> Agent Number</th>
                        <td><?php echo e($agent->agent_code); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo e($agent->email); ?></td>
                    </tr>

                    <tr>
                        <th>Region</th>
                        <td><?php echo e($agent->rname); ?></td>
                    </tr>

                    <tr>
                        <th>District</th>
                        <td><?php echo e($agent->dname); ?></td>
                    </tr>
                    <tr>
                        <th>Location</th>
                        <td><?php echo e($agent->location); ?></td>
                    </tr>

                    <tr>
                        <th>Aggregator Name</th>

                        <td>
                            <strong><?php echo e($agent_wallet->aggregator_name); ?> -> wallet code <?php echo e($agent_wallet->aggregator_code); ?></strong>
                        </td>

                    </tr>
                    </tbody>
                </table>
                <div class="form-group">

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('agent-topup')): ?>

                        <a href="#" id="<?php echo e($agent->agent_code); ?>"  class="btn btn-warning topup-agent"><i class="fa fa-money-bill-alt"></i></a>

                    <?php endif; ?>





                    <a  href="<?php echo e(url()->previous()); ?>" style="margin-top: 0px;" class="btn btn-info" name="edit-merchant">Back</a>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('agent-update')): ?>

                        <div class="col-md-12" style="border: 2px solid #cdd1d3; margin-top: 5px;">

                            <p>Password and pin management</p>

                            <form method="post" action="<?php echo e(url('agents/pin-reset')); ?>">

                                <?php echo e(csrf_field()); ?>


                                <div class="col-md-12">
                                    <input type="hidden"  name="agent_code" value="<?php echo e($agent->agent_code); ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter pin " name="pin" >

                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info">Reset pin</button>

                                    </div>
                                </div>
                            </form>

                            <form method="post" action="<?php echo e(url('agents/password-reset')); ?>">
                                <?php echo e(csrf_field()); ?>

                                <div class="col-md-12">
                                    <input type="hidden"  name="agent_code" value="<?php echo e($agent->agent_code); ?>">
                                    <div class="form-group">

                                        <input type="text"  class="form-control" placeholder="Enter password" name="password" >
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info">Reset password</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    <?php endif; ?>
                </div>

                


            </div>

        </div>

    </div>

    <!-- Modal -->
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
                                                    



                                                </select>

                                            </div>

                                            <div class="form-group">

                                                <label for="location">Location</label>
                                                <input type="text"  class="form-control" name="location" id="add-pos-location" placeholder="Location">

                                            </div>
                                            <div class="form-group">

                                                <button type="button" id="btn-add-posto-table" class="btn btn-cyan mdi mdi-plus"></button>
                                                
                                                <button  id="btn-form-submit-addpos"  type="submit" class="btn btn-success">Save</button>


                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <form id="add-pos-form" method="post" action="<?php echo e(url('agents/add-pos-toagent')); ?>">
                                                <?php echo e(csrf_field()); ?>

                                                
                                                <input type="hidden" value="<?php echo e($agent->agent_code); ?>" name="agent_code">
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


    

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="show-posagent-disable-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <form method="post" action="<?php echo e(url('agents/account/disable-pos')); ?>">

            <?php echo e(csrf_field()); ?>

            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content">
                    <div class="modal-header modal-background">
                        <h5 class="modal-title" id="exampleModalLabel">Change Pos Status  <span id="merchant-name"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        

                        

                        
                        <div class="row">


                            <div class="col-lg-12">

                                <div class="alert alert-warning">

                                    <p>Are you sure you want to Disable this Pos?</p>

                                </div>

                                <input type="hidden" id="pos-id-to-disable" name="imei_no">

                            </div>



                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Disable</button>
                    </div>


                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </form>

    </div>


    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="show-posagent-enable-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <form method="post" action="<?php echo e(url('agents/account/enable-pos')); ?>">

            <?php echo e(csrf_field()); ?>

            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content">
                    <div class="modal-header modal-background">
                        <h5 class="modal-title" id="exampleModalLabel">Change Account Status  <span id="merchant-name"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        

                        

                        
                        <div class="row">


                            <div class="col-lg-12">

                                <div class="alert alert-warning">

                                    <p>Are you sure you want to Enable this Pos?</p>

                                </div>

                                <input type="hidden" id="pos-id-to-enable" name="imei_no">

                            </div>



                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Enable</button>
                    </div>


                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </form>

    </div>

    <?php echo $__env->make('agents.topup_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

    <script>


        

        

        
        
        
        
        
        
        
        
        


        

        
        

        
        
        


        
        
        

        

        
        
        

        
        

        

        

        
        

        
        
        

        

        

        
        
        


        
        


    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/agents/show_agent.blade.php ENDPATH**/ ?>