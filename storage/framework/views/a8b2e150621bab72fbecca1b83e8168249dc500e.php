<?php $__env->startSection('content'); ?>



    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Reports</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Reports</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Configurations</li>
                        </ol>
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
        <div class="row">

            <div class="col-lg-12">

                
                <button type="button" data-toggle="modal" data-target="#create-report-modal" class="btn btn-cyan btn-sm" id="previous">New Report</button>



            </div>


            <div class="container-fluid table-margin-top">
                <table class="table table-striped table-bordered table-condensed" id="#datatable">

                    <thead>

                    <tr>
                        <th>#</th>
                        <th>name</th>
                        <th>Report type</th>
                        <th>Report url</th>
                        <th>Action</th>

                    </tr>
                    </thead>

                    <tbody>

                    <?php $i =1;?>
                    <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>

                            <td><?php echo e($i); ?></td>
                            <td><?php echo e($report->name); ?></td>
                            <td><?php echo e($report->rname); ?></td>
                            <td><?php echo e($report->report_url); ?></td>
                            <td>
                                <a id="<?php echo e($report->id); ?>" data-id="<?php echo e($report->id); ?>" href="#" class="btn btn-success edit-reports"><i class="fa fa-edit"></i></a>
                            <a href="<?php echo e(url('reports/consumer-report',$report->id)); ?>" class="btn btn-cyan"><i class="fa fa-eye"></i></a>
                                <a href="#" class="btn btn-warning"><i class="fa fa-trash"></i></a> </td>


                        </tr>
                        <?php $i++;?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>


            </div>

            

            <div class="modal fade bd-example-modal-lg" id="create-report-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                <form method="post" id="editForm" action="<?php echo e(url("reports/configuration")); ?>" >
                    <?php echo e(csrf_field()); ?>

                    <div class="modal-dialog modal-md" role="document" >
                        <div class="modal-content">
                            <div class="modal-header modal-background">
                                <h5 class="modal-title" id="exampleModalLabel">Create Report</h5>
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

                                                            <label for="name">Report Name</label>
                                                            <input type="text" class="form-control" name="name" id="name" placeholder="Report Name">

                                                        </div>
                                                        <div class="form-group">

                                                            <label for="report_types">Report Type</label>

                                                            <select class="form-control" name="report_type"  id="report_types" data-parsley-required="true">
                                                                <option>Select Report type</option>
                                                                <?php $__currentLoopData = $report_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    {
                                                                    <option value="<?php echo e($report_type->id); ?>"><?php echo e($report_type->name); ?></option>
                                                                    }
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>

                                                        </div>

                                                        <div class="form-group">
                                                            <label for="report_url">Report url</label>
                                                            <input type="text" class="form-control" name="report_url" id="report_url" placeholder="report url">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="viewParams">Does a report has parameter?</label>
                                                            <select class="form-control" id="viewParams" name="has_param">
                                                                <?php $__currentLoopData = $has_params; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $has_param): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($has_param->id); ?>"><?php echo e($has_param->description); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group" id="viewParamsDiv">

                                                            <table class="table table-bordered">

                                                                <thead>

                                                                <tr>
                                                                    <th><input type="checkbox" name="params" style="width: 20px; height: 20px;"></th>
                                                                    <th>Select Parameter Name</th>

                                                                </tr>

                                                                <tbody>

                                                                <?php $__currentLoopData = $params; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $param): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                                    <tr>
                                                                        <td><input type="checkbox" class="form-control check-params uncheck" value="<?php echo e($param->id); ?>" name="params[]"   style="width: 20px; height: 20px;"></td>
                                                                        <td><?php echo e($param->name); ?></td>

                                                                    </tr>

                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                                </thead>

                                                            </table>

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
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>

    <!-- Modal Edit-->
    <div class="modal fade bd-example-modal-lg" id="edit-report-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form method="post" action="<?php echo e(url('reports/configuration/update')); ?>" >
            <?php echo e(csrf_field()); ?>

            
            <div class="modal-dialog modal-md" role="document" >
                <div class="modal-content">
                    <div class="modal-header modal-background">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Report Name</h5>
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

                                                    <label for="report_name">Report Name</label>
                                                    <input type="text" class="form-control report_name" name="report_name" id="report_name" placeholder="Report Name">

                                                    <input type="hidden" name="report_id"  id="report_id">

                                                </div>

                                                <div class="form-group">

                                                    <label for="report_types">Report Type</label>

                                                    <select class="form-control report_types" name="report_type">
                                                        <?php $__currentLoopData = $report_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            {
                                                            <option value="<?php echo e($report_type->id); ?>"><?php echo e($report_type->name); ?></option>
                                                            }
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>

                                                </div>
                                                <div class="form-group">

                                                    <label for="report_url">Report Url</label>
                                                    <input type="text" class="form-control report_url" name="report_url" id="report_url" placeholder="Report Name">

                                                </div>
                                                <div class="form-group">
                                                    <label for="viewParams2">Does a report has parameter?</label>
                                                    <select class="form-control has_param" id="viewParams2" name="has_param">
                                                        <?php $__currentLoopData = $has_params; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $has_param): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($has_param->id); ?>"><?php echo e($has_param->description); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>

                                                <div class="form-group" id="viewParamsDiv2">

                                                    <table class="table table-bordered">

                                                        <thead>

                                                        <tr>
                                                            <th><input type="checkbox" name="params" style="width: 20px; height: 20px;"></th>
                                                            <th>Select Parameter Name</th>

                                                        </tr>

                                                        <tbody>

                                                        <?php $__currentLoopData = $params; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $param): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                            <tr>
                                                                <td><input type="checkbox" class="form-control  check-params uncheck" value="<?php echo e($param->id); ?>" name="params[]"   style="width: 20px; height: 20px;"></td>
                                                                <td><?php echo e($param->name); ?></td>

                                                            </tr>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>
                                                        </thead>

                                                    </table>



                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>


    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/reports/index.blade.php ENDPATH**/ ?>