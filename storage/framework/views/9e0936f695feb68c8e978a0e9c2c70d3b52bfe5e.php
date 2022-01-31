<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="show-merchant-enable-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <form method="post" action="<?php echo e(url('merchants/account/enable')); ?>">

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

                                <p>Are you sure you want to Enable this Merchant?</p>

                            </div>

                            <input type="hidden" id="merchant-id-to-enable" name="tin">

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

<?php /**PATH C:\xampp\htdocs\cashless\resources\views/merchants/enable_modal.blade.php ENDPATH**/ ?>