<?php $__env->startSection('stylesheets'); ?>
    <style>

        .checkbox-custom {

            height: 15px;
            width: 60px;
            margin-left: 0;
        }

        .perm-role-span {
            height: 10px;
            width: 70px;
            margin-left: 0;
            margin-top: -2px;
        }
        .rol-perm-list{

            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        ul {
            list-style-type: none;
        }
        . .rol-perm-list li {

            list-style-type: none;
        }
    </style>

    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12">
                <?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(Session::has('alert-' . $msg)): ?>

                        <p class="alert alert-<?php echo e($msg); ?>"><?php echo e(Session::get('alert-' . $msg)); ?>

                            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>

            <div class="col-lg-12 table-margin-top">

                <div class="row">
                    <div class="col-md-4" >
                        <div class="form-group">

                            <label>N-CARD ACCOUNT</label>

                            <select type="text" class="form-control" id="accountNumber" name="accountNumber">

                                <option value="" selected disabled>--select account ---</option>
                                <?php $__currentLoopData = $account; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <option  value="<?php echo e($row->wallet_number); ?>"><?php echo e($row->name); ?></option>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                        </div>
                    </div>

                    <div class="col-md-2">

                        <div class="form-group" style=" margin-top: 30px;">

                            <button type="button" id="btn-check-balance" class="btn btn-primary mdi mdi-search-web">Check Balance</button>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <?php echo $__env->make('tpesa.check_balance', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>

    <script>

        $(function (){

            let urlBalance  =  '<?php echo e(url('t-pesa/check-balance')); ?>';

            console.log(urlBalance)
            $('.img-load').hide();

            $('#btn-check-balance').click( function (){

                $('.balance-res').html("")

                $('#show-balance-modal').modal('show');
                $('.img-load').show();

                let accountNumber  =  $('#accountNumber').val();

                $.get(urlBalance+'/'+accountNumber, function (data){
                    console.log('result');
                    console.log(data);

                    if (data.resultcode=='0'){
                        $('.img-load').hide();

                        $('.balance-res').html('Balance is '+data.balance+' TZS')

                    } else {
                        $('.img-load').hide();

                        $('.balance-res').html(data.message)

                    }
                    console.log(data);

                });

            });



        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/tpesa/index.blade.php ENDPATH**/ ?>