<!-- Modal for adding pos-->
<div class="modal fade bd-example-modal-lg" id="add-pos-merchant-agent-user-modal" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl" role="document" >
        <div class="modal-content">
            <div class="modal-header h4-background">
                <h5 class="modal-title" id="exampleModalLabel">Add New Merchant agent/user</h5>
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


                                    <div class="col-md-4">

                                        <div class="form-group" id="s">

                                            <label for="merchant-agent-fname" >First Name </label> <br>

                                           <input type="text" name="first_name[]" id="merchant-agent-fname" class="form-control" required>
                                        </div>

                                        <div class="form-group" id="s">

                                            <label for="merchant-agent-lname" >Last Name </label> <br>

                                            <input type="text" name="last_name[]" id="merchant-agent-lname" class="form-control" required>

                                        </div>








                                        <div class="form-group" id="s">


                                            <label for="merchant-agent-phone_number" >Phone number </label> <br>

                                            <input type="text" name="phone_number[]" id="merchant-agent-phone_number" required class="form-control">

                                        </div>

                                        <div class="form-group" id="s">


                                            <label for="merchant-agent-phone_number" >Station Code </label> <br>


                                                <select   id="merchant-agent-station_code"  class="form-control" name="station_code[]">
                                                    <option value="">--select station---</option>

                                                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <option value="<?php echo e($row->EventCode); ?>"><?php echo e($row->EventName); ?></option>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </select>


                                        </div>
                                        <button type="button" id="btn-add-merchant-agentto-table" class="btn btn-cyan mdi mdi-plus"></button>
                                        
                                        <button  id="btn-form-submit-addpos-merchant-agent"  type="submit" class="btn btn-success">Save</button>


                                    </div>
                                    <div class="col-md-8">

                                        <form id="add-merchant-agent-users-form" method="post" action="<?php echo e(url('merchants/add-merchant-agent')); ?>">
                                            <?php echo e(csrf_field()); ?>

                                            
                                            <input type="hidden" value="<?php echo e($merchant->tin); ?>" name="tin">

                                            <input type="hidden" name="imei_no" id="pos-users-imei-no">
                                            <label class="err-warning-table"></label>

                                            <table id="table-pos-added"   class="table table-striped" style="margin-top: 10px;">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Phone number</th>
                                                    <th>Station Code</th>
                                                    <th>Action</th>

                                                </tr>
                                                </thead>
                                                <tbody id="add-merchant-agent-tr">

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
<?php /**PATH C:\xampp\htdocs\cashless\resources\views/merchants/add_posmerchant_agent_user.blade.php ENDPATH**/ ?>