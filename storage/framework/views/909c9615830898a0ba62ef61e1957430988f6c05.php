
<!-- Modal for adding pos-->
<div class="modal fade bd-example-modal-lg" id="merchant-product-modal" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl" role="document" >
        <div class="modal-content">
            <div class="modal-header h4-background">
                <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
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

                                    <div class="col-md-3">

                                        <div class="form-group" id="s">

                                            <label for="merchant-add-service" >Name</label> <br>

                                            <input type="text" name="product-name"  id="product-name" class="form-control">


                                        </div>

                                        <div class="form-group" id="s">

                                            <label for="merchant-product-type" >Select type </label> <br>
                                            <select  data-validation="required" data-validation-error-msg-required="product name required" class="select2 form-control custom-select select2-merchant-service-type" name="service"  id="merchant-product-type" style="width: 100%; height:36px;">

                                                <option></option>
                                                <option value="1">Pre defined product</option>
                                                <option value="0">Not predefined product</option>

                                            </select>

                                        </div>

                                        <div class="form-group" id="merchant-product-price-div">

                                            <label for="merchant-product-price" >Price </label> <br>

                                            <input type="text" name="price" id="merchant-product-price" class="form-control">

                                        </div>


                                        <button type="button" id="btn-add-merchant-product-table" class="btn btn-cyan mdi mdi-plus"></button>
                                        
                                        <button  id="btn-form-submit-add-merchant-product"  type="submit" class="btn btn-success">Save</button>


                                    </div>
                                    <div class="col-md-9">

                                        <form id="add-merchant-product-form" method="post" action="<?php echo e(url('merchant-products/store')); ?>">
                                            <?php echo e(csrf_field()); ?>

                                            
                                            <input type="hidden" value="<?php echo e($tin); ?>" name="tin">
                                            <input type="hidden" value="<?php echo e($service_id); ?>" name="service_id">
                                            <label class="err-warning-table"></label>

                                            <table id="table-pos-added"   class="table table-striped table-pos-added" style="margin-top: 10px;">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Product</th>
                                                    <th>Price</th>
                                                    <th>Type</th>
                                                    <th>Action</th>

                                                </tr>
                                                </thead>
                                                <tbody id="add-merchant-product-tr">

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


<?php /**PATH C:\xampp\htdocs\cashless\resources\views/products/add_products.blade.php ENDPATH**/ ?>