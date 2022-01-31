<!-- Modal -->


<div class="modal fade bd-example-modal-lg" id="delete-permission" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <form method="post" action="<?php echo e(url('agents/roles/disable',[$agent_code])); ?>" >
        <?php echo e(csrf_field()); ?>


        <?php echo method_field('post'); ?>

        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel">Agent Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    

                    

                    
                    <div class="row">


                        <div class="col-md-12">





                                <p>Are sure you want to delete this permission from agent?</p>
                                <input type="hidden" name="posId" id="posId">

                        </div>


                    </div>

                </div>


                <div class="modal-footer text-right">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger submit-edit-agent">save</button>
                </div>
            </div>
        </div>
    </form>

</div>

<?php /**PATH C:\xampp\htdocs\cashless\resources\views/agents/delete-permission-modal.blade.php ENDPATH**/ ?>