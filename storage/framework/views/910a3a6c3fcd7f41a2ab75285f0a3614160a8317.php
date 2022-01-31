<?php $__env->startSection('content'); ?>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Aggregator</h4>
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

                

                <a href="<?php echo e(url('aggregators/create')); ?>" class="btn btn-cyan btn-sm" id="previous">New aggregator  agent</a>

                <hr/>

                <form class="row" method="post" action="<?php echo e(url('agents/get-by-phonenumber')); ?>">

                    <?php echo e(csrf_field()); ?>


                    <div class="col-md-8">
                        <input type="text" name="phone_number" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-info btn-block">Search by phone number</button>
                    </div>
                </form>

                <hr/>

            </div>

            <div class="col-lg-12 table-margin-top">


                <table class="table table-bordered table-striped" id="agents-all">

                    <thead>

                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Agent Code</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>

                    </thead>

                    <tbody>

                    <?php $i=1;?>
                    <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>

                            <td><?php echo e($i); ?></td>
                            <td><?php echo e($agent->name); ?></td>
                            <td><?php echo e($agent->code); ?></td>
                            <td><?php echo e($agent->phone_number); ?></td>
                            <td><?php echo e($agent->email); ?></td>
                            

                            <td>

                                <a href="<?php echo e(url('aggregators/view',[$agent->code])); ?>" class="btn btn-info "><i class="fa fa-eye"></i></a>

                                <a href="<?php echo e(url('aggregators/users',[$agent->code])); ?>" class=" btn btn-info "><i class="fa fa-users"></i></a>

                                <a href="<?php echo e(url('aggregators/set-commission',[$agent->code])); ?>" class="btn btn-primary " ><i class="fa fa-money-bill-alt"></i></a>

                            </td>

                        </tr>
                        <?php $i++;?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    </tbody>
                </table>

            </div>

        </div>

    </div>



<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>

    <script>
        $('#agents-all').dataTable();

    </script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/aggregator/index.blade.php ENDPATH**/ ?>