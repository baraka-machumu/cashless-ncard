








<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="remove-product-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <form method="post" action="<?php echo e(url('merchant-products/remove')); ?>">

        <?php echo e(csrf_field()); ?>


        <input type="hidden" value="<?php echo e($tin); ?>" name="tin">
        <input type="hidden" value="<?php echo e($service_id); ?>" name="service_id">

        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel"> Remove from list <span id="merchant-name-disable" style="font-size: 12px; margin-left: 4px;"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    

                    

                    
                    <div class="row">

                        <div class="col-lg-12">

                            <div class="alert alert-warning">

                                <p>Are you sure you want to remove this form list?</p>

                            </div>

                            <input type="hidden" id="product-id" name="product_id">

                        </div>



                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Remove</button>
                </div>


                <div class="modal-footer">

                </div>
            </div>
        </div>
    </form>

</div>

<?php /**PATH C:\xampp\htdocs\cashless\resources\views/products/remove_modal.blade.php ENDPATH**/ ?>