
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="disable-role-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <form method="post" action="<?php echo e(url('access/roles/disable')); ?>">

        <?php echo e(csrf_field()); ?>

        <div class="modal-dialog modal-md" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel">Disable Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body" style="height: 60px;">

                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <div class="alert alert-warning">

                                                    <P>Are you sure , you want to disable this role ?</P>

                                                </div>

                                                <input type="hidden" class="form-control"b name="roleId" id="submit-roleId" value="">

                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Disable</button>
                </div>
            </div>
        </div>
    </form>

</div>


<?php $__env->startSection('js'); ?>

    <script>


        $('.disabled-role').click(function () {


            let roleId  =    $(this).attr('id');

            console.log("role id "+roleId);


            $('#submit-roleId').val(roleId);

            $('#disable-role-modal').modal('show');

        });

    </script>

<?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\cashless\resources\views/roles/role_disable.blade.php ENDPATH**/ ?>