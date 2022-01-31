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

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Agent Permission</h4>
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

                

               <a href="#" class="btn btn-cyan btn-sm" id="" data-toggle="modal" data-target="#assign-permission">Assign Permission</a>

                    <hr/>


            </div>

            <div class="col-lg-12 table-margin-top">


                <table class="table table-bordered table-striped" id="agents-all">

                    <thead>

                    <tr>
                        <th>#</th>
                        <th>Permission Name</th>
                        <th>Permission Code</th>

                        <th>Status</th>
                        <th>Actions</th>
                    </tr>

                    </thead>

                    <tbody>

                    <?php $i=1;?>
                    <?php $__currentLoopData = $permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>

                            <td><?php echo e($i); ?></td>
                            <td><?php echo e($row->pname); ?></td>

                            <td><?php echo e($row->pos_permission_id); ?></td>

                            <td><?php echo e($row->status_name); ?></td>

                            <td style="width: 300px;">

                                <a href="#" id="<?php echo e($agent_code); ?>"  data-id="<?php echo e($agent_code); ?>" class="btn btn-success edit-agent-modal"><i class="fa fa-edit"></i></a>
                                <a href="#" id="<?php echo e($row->pos_permission_id); ?>"  data-toggle="modal" data-target="#delete-permission" class="btn btn-danger delete-permission"><i class="fa fa-trash"></i></a>



                            </td>

                        </tr>
                        <?php $i++;?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    </tbody>
                </table>

            </div>

        </div>

    </div>



    <?php echo $__env->make('agents.assign-permission-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('agents.delete-permission-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>




<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>

    <script>
        $('#agents-all').dataTable();


        $('.delete-permission').on('click', function (){

            let id   = this.id;
            $('#posId').val(id);

            $('#delete-permission').modal('show');

        });


    </script>


    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/agents/roles.blade.php ENDPATH**/ ?>