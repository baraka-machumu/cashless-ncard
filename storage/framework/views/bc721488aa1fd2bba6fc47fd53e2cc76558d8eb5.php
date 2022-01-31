

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="user-status-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <?php echo e(csrf_field()); ?>

        <div class="modal-dialog modal-md" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel">Disable user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo e(url('access/users/disable')); ?>" method="post">
                    <?php echo e(csrf_field()); ?>



                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">

                                <div class="row" style="height: 60px;">


                                    <div class="col-md-12">
                                        <div class="alert alert-danger">
                                            <p>Are you sure you want to disabled this user?</p>

                                        </div>
                                    </div>

                                        <input type="hidden" id="userId" name="userId">

                                </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
                </form>

            </div>

        </div>


</div>

<?php $__env->startSection('js'); ?>

    <script>

        $('.user-status').click( function (e) {

            e.preventDefault();
            let userId  =  $(this).attr('id');

            $('#userId').val(userId);

            $('#user-status-modal').modal('show');

        });



    </script>

    <?php $__env->stopSection(); ?>
<?php /**PATH C:\xampp\htdocs\cashless\resources\views/users/disabled.blade.php ENDPATH**/ ?>