


<div class="modal fade bd-example-modal-lg" id="show-topup-agent-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <form method="post" action="<?php echo e(url('/agents/store-topup')); ?>" id="form-topup-agent"  enctype="multipart/form-data">

        <?php echo e(csrf_field()); ?>

        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel">Top Up Agent</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    

                    

                    

                    <div class="loading">

                        <div class="inner-load">

                            <span> Please wait ..</span> <img src="<?php echo e(url(asset('assets/images/saveloading.gif'))); ?>">

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="amount">Amont</label>
                                <input type="text"  required class="form-control" name="amount" id="amount" placeholder="Amount">

                            </div>
                            <div class="form-group">

                                <label for="reference">Aggregator Tpesa account</label>

                                <input type="text" required  class="form-control" value="<?php echo e($agent_wallet->aggregator_code); ?>" name="aggregator_code"
                                       id="reference" readonly>

                            </div>

                        </div>
                        <div class="col-md-6">

                            <div class="form-group">

                                <label for="reference">Customer Tpesa Account</label>
                                <input type="text" class="form-control" readonly  value="<?php echo e($agent_wallet->tpesa_account); ?>" name="agent_code" id="agent_code">

                            </div>

                            <input type="hidden" value="<?php echo e($agent_code); ?>" name="agent_code_ncard">
                            <div class="form-group">

                                <button type="submit" style="margin-top: 28px;" class="btn btn-success save-agent" id="save-agent" name="">Save</button>
                                <a  href="<?php echo e(url()->previous()); ?>" style="margin-top: 28px;" class="btn btn-info" >
                                    <i class="fa fa-backward" aria-hidden="true"></i>
                                </a>

                            </div>

                        </div>
                    </div>

                </div>


                <div class="modal-footer">

                </div>
            </div>
        </div>
    </form>

</div>
<?php /**PATH C:\xampp\htdocs\cashless\resources\views/agents/topup_modal.blade.php ENDPATH**/ ?>