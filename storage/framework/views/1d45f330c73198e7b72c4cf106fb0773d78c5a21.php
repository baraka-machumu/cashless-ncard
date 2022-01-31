<?php $__env->startSection('content'); ?>

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Products</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Merchant</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">


            <div class="col-lg-12">
                <?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(Session::has('alert-' . $msg)): ?>

                        <p class="alert alert-<?php echo e($msg); ?>"><?php echo e(Session::get('alert-' . $msg)); ?>

                            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                

                <a href="#" data-toggle="modal" data-target="#merchant-product-modal" class="btn btn-cyan btn-sm" id="previous">New Products <i class="fa fa-plus"></i></a>

                    <a href="<?php echo e(url('merchants/'.$tin)); ?>" class="btn btn-info btn-sm">Back</a>

                

            </div>

            <div class="col-lg-12 table-margin-top">


                <table class="table table-bordered table-striped" id="product-table">

                    <thead>
                    <tr>

                        <th>#</th>

                        <th>Product</th>
                        <th>Price</th>
                        <th>Actions</th>

                    </tr>
                    </thead>

                    <tbody>


                    <?php $i=1; ?>
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <tr>
                        <td><?php echo e($i); ?></td>

                        <td><?php echo e($row->product_name); ?></td>
                        <td><?php echo e($row->price); ?></td>


                        <td>

                            <a href="" class="btn btn-warning"><i class="fa fa-eye"></i></a>

                            <a href="#" class="btn btn-danger product-delete" id="<?php echo e($row->id); ?>"><i class="fa fa-trash"></i></a>

                        </td>


                    </tr>

                    <?php $i++; ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    </tbody>
                </table>

            </div>

        </div>

    </div>

    <?php echo $__env->make('products.add_products', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('products.remove_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

    <script>

        $('#product-table').dataTable();


        $('.product-delete').click( function () {


            let productId  =  $(this).attr('id');

            // alert(productId);
            $('#product-id').val(productId);

            $('#remove-product-modal').modal('show');

        });


        $('#merchant-product-type').change(function () {


            let productType  =  $('#merchant-product-type').val();

            console.log("serveice type= "+productType);

            if (productType === '0') {
                console.log("not");

                $('#merchant-product-price-div').hide();
            }

            else {
                console.log("yes");

                $('#merchant-product-price-div').show();

            }

        });

        let  productId = 1;
        var productArray  = [];

        $('#btn-add-merchant-product-table').click( function () {

            let product =  $('#product-name').val();
            let type =  $('#merchant-product-type').val();

            let  productTagName  =  $('#merchant-add-products').find('option:selected').text();
            let typeTagName  =  $('#merchant-product-type').find('option:selected').text();

            console.log(" product name "+product);

            let price  =  '0';

            if (type === '1') {


                price =  $('#merchant-product-price').val()

            }

            else {
                console.log("0");

                price =  "no price";


            }


            if (product!=='' && type!=='')
            {

                if(productId>=1) {
                    if (jQuery.inArray(product, productArray) !== -1) {

                        console.log("data zipo");
                        $('.err-warning-table').html("<span class='label label-warning'> Product <b>"+product+"</b> exist in your list</span>");

                        return  false;

                    }

                }

                $('#add-merchant-product-tr').append('<tr><td>'+productId+'</td><td>' +
                    '<input style="width: 150px;" class="form-control" name="product[]" readonly  value='+product+'></td>' +
                    '<td><input style="width: 110px;" class="form-control" type="text" value="'+price+'" name="price[]" readonly></td>' +
                    '<td><select style="width: 140px;" class="form-control" name="type[]" readonly><option value="'+type+'">'+typeTagName+'</option></select></td>' +
                    '<td><a  id="'+productId+' " class="btn btn-danger delete-pos" style="color: white;"><i class="fa fa-trash"></i></a></td></tr>');

                productId  =  productId+1;

                productArray.push(product);

                console.log(productArray);

                $('.err-warning-table').html('');

            }

            else {
                $('.err-warning-table').html("<span class='label label-warning'>Please Fill All Fields</span>");

                return false;
            }

        });

        $('#btn-form-submit-add-merchant-product').click( function () {

            let tbody = $(".table-pos-added tbody");

            if (tbody.children().length === 0) {

                $('.err-warning-table').html("Please Add Product To submit").addClass('label label-warning');


            }
            else {
                $("#add-merchant-product-form").submit();

            }

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/products/index.blade.php ENDPATH**/ ?>