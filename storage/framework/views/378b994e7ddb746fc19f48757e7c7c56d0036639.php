<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="show-view-merchant-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <form method="post" action="<?php echo e(url('merchants/account/disable')); ?>">

        <?php echo e(csrf_field()); ?>

        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel">Change Account Status for <span id="merchant-name-disable" style="font-size: 12px; margin-left: 4px;"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    

                    

                    
                    <div class="row">

                        <input type="hidden" id="merchant-id-to-disable" name="tin">

                        <div class="col-lg-6">

                            <table class="table table-striped">

                                <tbody id="view-merchant-table-left">

                                </tbody>

                            </table>


                        </div>
                        <div class="col-lg-6">

                            <table class="table table-striped">

                                <tbody id="view-merchant-table-right">

                                </tbody>

                            </table>


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

</div><?php /**PATH C:\xampp\htdocs\cashless\resources\views/merchants/view_merchant_modal.blade.php ENDPATH**/ ?>