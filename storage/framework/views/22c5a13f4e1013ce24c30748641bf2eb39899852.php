<?php $__env->startSection('content'); ?>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Consumers</h4>
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

            </div>

            <div class="col-lg-12 table-margin-top">


                <table class="table table-bordered table-striped" id="consumer">

                    <thead>
                    <tr>

                        <th>#</th>
                        <th>Name</th>
                        <th>Last Name</th>
                        <th>Telephone</th>
                        <th>Registration Source</th>
                        <th>Wallet Id</th>
                        <th>Card Number</th>

                        <th>Actions</th>

                    </tr>
                    </thead>

                    <tbody>

                    <?php  $i = 1;?>
                    <?php $__currentLoopData = $consumers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consumer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>

                        <td><?php echo e($i); ?></td>
                        <td><?php echo e($consumer->first_name); ?></td>
                        <td><?php echo e($consumer->last_name); ?></td>
                        <td><?php echo e($consumer->phone_number); ?></td>
                        <td>
                            <?php if($consumer->agent_code==null): ?>
                                <span style="color:#0b94db; "> <?php echo e('Self Registration'); ?></span>
                            <?php else: ?>
                                <?php echo e($consumer->agent_code); ?>

                            <?php endif; ?>
                        </td>
                        <td><?php echo e($consumer->wallet_id); ?></td>
                        <input type="hidden" value="<?php echo e($consumer->first_name.' '.$consumer->last_name); ?>" id="<?php echo e('c-'.$consumer->wallet_id); ?>">
                        <td>
                            <?php if($consumer->card_number==null): ?>
                                <span style="color:#db5c13; "> <?php echo e('No Card Assigned'); ?></span>
                                <?php else: ?>
                                <?php echo e($consumer->card_number); ?>

                                <?php endif; ?>
                        </td>

                        <td>
                            
                            <?php if($consumer->status_id==1): ?>
                                <a href="#" class="btn btn-danger disable-consumer" id="<?php echo e($consumer->wallet_id); ?>" ><i class="fa fa-trash"></i></a>

                            <?php elseif($consumer->status_id==0): ?>
                                <a href="#" class="btn btn-cyan enable-consumer" id="<?php echo e($consumer->wallet_id); ?>" ><i class="fa fa-toggle-on"></i></a>

                            <?php endif; ?>
                            <a href="<?php echo e(route('consumers.show',$consumer->wallet_id)); ?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                            

                        </td>

                    </tr>

                    <?php  $i++;?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




                    </tbody>
                </table>

            </div>

        </div>

    </div>


    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="create-merchant-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form method="post" action="#">

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
                                    <div class="card-body">

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <label for="fname">Merchant Name</label>
                                                    <input type="text" class="form-control" id="fname" placeholder="Merchant Name">

                                                </div>

                                                <div class="form-group">

                                                    <label for="telephone_number">Telephone Number</label>
                                                    <input type="text" class="form-control" id="telephone_number" placeholder="Telephone Number">

                                                </div>

                                                <div class="form-group">

                                                    <label for="region">Region</label>
                                                    <input type="text" class="form-control" id="region" placeholder="Region">

                                                </div>

                                                <div class="form-group">

                                                    <label for="location">Location</label>
                                                    <input type="text" class="form-control" id="location" placeholder="Location">

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <label for="registration_number">Registration Number</label>
                                                    <input type="text" class="form-control" id="registration_number" placeholder="Registration Number">

                                                </div>

                                                <div class="form-group">

                                                    <label for="email">Email</label>
                                                    <input type="text" class="form-control" id="email" placeholder="Email">

                                                </div>

                                                <div class="form-group">

                                                    <label for="district">District</label>
                                                    <input type="text" class="form-control" id="district" placeholder="District">

                                                </div>

                                                

                                                    
                                                

                                            </div>

                                        </div>

                                    </div>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
        </form>

    </div>


    

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="show-consumer-disable-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <form method="post" action="<?php echo e(url('consumers/account/disable')); ?>">

            <?php echo e(csrf_field()); ?>

            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content">
                    <div class="modal-header modal-background">
                        <h5 class="modal-title" id="exampleModalLabel">Change Account Status for <span id="consumer-name-disable" style="font-size: 12px; margin-left: 4px;"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        

                        

                        
                        <div class="row">


                            <div class="col-lg-12">

                                <div class="alert alert-warning">

                                    <p>Are you sure you want to disable this consumer?</p>

                                </div>

                                <input type="hidden" id="consumer-id-to-disable" name="consumer_wallet">

                            </div>

                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Diasble</button>
                    </div>

                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </form>

    </div>


    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="show-consumer-enable-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <form method="post" action="<?php echo e(url('consumers/account/enable')); ?>">

            <?php echo e(csrf_field()); ?>

            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content">
                    <div class="modal-header modal-background">
                        <h5 class="modal-title" id="exampleModalLabel">Change Account Status  <span id="consumer-name"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        

                        

                        
                        <div class="row">


                            <div class="col-lg-12">

                                <div class="alert alert-warning">

                                    <p>Are you sure you want to Enable this consumer?</p>

                                </div>

                                <input type="hidden" id="consumer-id-to-enable" name="consumer_wallet">

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


<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

    <script>

        $('#consumer').dataTable();

    </script>

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/consumers/index.blade.php ENDPATH**/ ?>