<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="merchant-commission-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <form method="post" action="<?php echo e(url('merchants/set-commission',[$tin])); ?>">

        <?php echo e(csrf_field()); ?>

        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel">Set Commission <span id="merchant-name"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">


                        <div class="col-md-12">

                            <div class="form-group">

                                <input type="number" class="form-control"  name="percentage">

                            </div>


                        </div>



                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>


                <div class="modal-footer">

                </div>
            </div>
        </div>
    </form>

</div>


<?php /**PATH C:\xampp\htdocs\cashless\resources\views/merchants/commission_modal.blade.php ENDPATH**/ ?>