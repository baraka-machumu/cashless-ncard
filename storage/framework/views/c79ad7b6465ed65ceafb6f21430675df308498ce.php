

<div class="modal fade bd-example-modal-lg" id="show-balance-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">


        <div class="modal-dialog modal-md" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel">Check Balance <span id="consumer-name-disable" style="font-size: 12px; margin-left: 4px;"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">


                        <div class="col-md-12">

                            <div class="text-center">



                                <div class="img-load">
                                    <img src="<?php echo e(url('public/assets/images/loading2.gif')); ?>" height="50" width="50">

                                </div>

                            </div>

                            <div style="text-align: center">
                                <span class="balance-res"></span>

                            </div>
                        </div>



                        <div class="col-lg-12">

                            <input type="hidden" id="consumer-id-to-disable" name="consumer_wallet">

                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>


</div>
<?php /**PATH C:\xampp\htdocs\cashless\resources\views/tpesa/check_balance.blade.php ENDPATH**/ ?>