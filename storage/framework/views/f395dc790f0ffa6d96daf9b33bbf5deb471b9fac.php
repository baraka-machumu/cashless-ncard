<?php $__env->startSection('content'); ?>

    <div class="container-fluid">

        <div class="row">

            

                
                

            
        </div>

        <div class="col-lg-12 show-user-details-2">

            <span>NCARD  Wallet Info</span>

        </div>

        <div class="row">


            <div class="col-lg-12 table-margin-top">

           <table class="table table-bordered table-striped">

               <tbody>

               <tr>
                   <td>N CARD consumer balance</td> <td><?php echo e($consumerBalance); ?> TZS</td>
               </tr>
               <tr>
                   <td>N CARD active wallet</td> <td><?php echo e($active_card); ?></td>
               </tr>


               <tr>
                   <td>N CARD inactive wallet</td> <td><?php echo e($inactive_card); ?></td>
               </tr>


               </tbody>
           </table>

            </div>

        </div>

    </div>




<?php $__env->stopSection(); ?>



<?php $__env->startSection('js'); ?>

    <script>
        $('#consumer-wallet').dataTable();

    </script>

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/wallets/info.blade.php ENDPATH**/ ?>