
<table>
    <thead>

    <tr>

        <th colspan="3">N-CARD MERCHANT REVENUE SUMMARY REPORT</th>

    </tr>

    <tr>
        <th  colspan="3" style="font-weight: bold">From Date : <?php echo e($date_from); ?> </th>


    </tr>

    <tr>
        <th   colspan="3" style="font-weight: bold">To Date : <?php echo e($date_to); ?></th>

    </tr>
    <tr>
        <th style="font-weight: bold">Name</th>
        <th style="font-weight: bold">Merchant ID</th>
        <th style="font-weight: bold">Amount</th>
    </tr>
    </thead>
    <tbody>

    <?php $sum  = 0; ?>
    <?php $__currentLoopData = $dataRevenue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($row->name); ?></td>
            <td><?php echo e($row->merchantTin); ?></td>
            <td><?php echo e(number_format($row->amount ,2,'.',',')); ?></td>

        </tr>

        <?php  $sum  =  $sum+ $row->amount;?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


    <tr>
        <th style="font-weight: bold;" colspan="2">Total </th> <td style="font-weight: bold;"><?php echo e(number_format($sum ,2,'.',',')); ?></td>

    </tr>
    </tbody>
</table>
<?php /**PATH C:\xampp\htdocs\cashless\resources\views/reports/revenue_by_all_merchant.blade.php ENDPATH**/ ?>