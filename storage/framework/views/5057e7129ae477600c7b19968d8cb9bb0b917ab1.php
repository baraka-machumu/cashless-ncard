<?php $__env->startSection('content'); ?>

    <div class="container-fluid">


        <div class="row">
            <div class="col-md-12">

                <h4>Consumer Reports</h4>



            </div>
            <div class="col-md-12 table-margin-top">

                <form method="get" action="<?php echo e(url('/reports/consumer-report-statement')); ?>">



                    <div class="form-row">

                        <div class="col-md-6">

                            <div class="form-group">

                                <input type="date" name="start_date" class="form-control">

                            </div>


                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <input type="date" name="end_date" class="form-control">

                            </div>


                        </div>

                        <div class="col-md-6">

                            <div class="form-group">


                                <select name="wallet_option" class="form-control">

                                    <option selected disabled>--select search option---</option>

                                    <option value="C">Card Number </option>
                                    <option value="W">Wallet Number </option>
                                    <option value="P">Phone number </option>

                                </select>
                            </div>


                        </div>


                        <div class="col-md-6">

                            <div class="form-group">

                                <input type="text" name="number" class="form-control">

                            </div>


                        </div>
                    </div>

                    <div class="form-group">

                        <button type="submit" name="get-report">Get Report</button>
                    </div>


                </form>

            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/reports/consumer/statement.blade.php ENDPATH**/ ?>