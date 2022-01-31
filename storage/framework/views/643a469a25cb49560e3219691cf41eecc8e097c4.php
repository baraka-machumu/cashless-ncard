


<?php $__env->startSection('stylesheets'); ?>

    <style>

        .dash-backg{

            background-color: #e8ecef;
        }

        .pos-dash{
            height: 200px;

        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>



    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12" style="margin-bottom: 10px;">
            <div class="col-md-12" style="border: 2px solid #cdd1d3; margin-top: 5px; height: 50px; ">
                <h4 class="page-title" style="line-height: 50px;">Dashboard</h4>
            </div>
        </div>
            
            <div class="col-md-2 col-lg-2 col-xlg-3">
                <div class="card card-hover">
                    <div class="box dash-backg text-center"  style="min-height: 151px;">
                       <div style="background-color: #0b8084; color: white;  width: 100%; margin: 0; padding: 0; height: 40px;">

                           <h6 class="" style="color: white;line-height: 40px;" >Active cards</h6>

                       </div>
                        <hr>
                        <h1 class="font-light text-black-50"><?php echo e($data['active_cards']); ?></h1>

                    </div>
                </div>
            </div>

            
            <div class="col-md-2 col-lg-2 col-xlg-3">
                <div class="card card-hover">
                    <div class="box dash-backg text-center"  style="min-height: 151px;">

                        <div style="background-color: #d65906;width: 100%; margin: 0; padding: 0; height: 40px;">

                            <h6 class="" style="color: white;line-height: 40px;">Wallets</h6>

                        </div>


                    <hr>

                    <h1 class="font-light text-black-50"><?php echo e($data['consumers']); ?></h1>
                    </div>

                </div>
            </div>

            
            <div class="col-md-2 col-lg-2 col-xlg-3">
                <div class="card card-hover">
                    <div class="box dash-backg text-center"  style="min-height: 151px;">

                        <div style="background-color: #1C729E;width: 100%; margin: 0; padding: 0; height: 40px;">

                        <h6 class="" style="color: white;line-height: 40px;">Merchants</h6>
                        </div>

                        <hr>
                        <h1 class="font-light text-black-50"><?php echo e($data['merchants']); ?></h1>
                    </div>
                </div>
            </div>

            
            <div class="col-md-2 col-lg-2 col-xlg-3">
                <div class="card card-hover">
                    <div class="box dash-backg text-center"  style="min-height: 151px;">
                        <div style="background-color: #5912a5;width: 100%; margin: 0; padding: 0; height: 40px;">

                        <h6 class="" style="color: white;line-height: 40px;">Agents</h6>

                        </div>
                        <hr>
                        <h1 class="font-light text-black-50"><?php echo e($data['agents']); ?></h1>
                    </div>
                </div>
            </div>

            
            <div class="col-md-4 col-lg-4 col-xlg-2">
                <div class="card card-hover">
                    <div class="box dash-backg text-center">
                        <div style="background-color: #0b8084;width: 100%; margin: 0; padding: 0; height: 40px;">
                        <h6 class="" style="color: white;line-height: 40px;">Transaction</h6>
                        </div>
                        <hr>
                        <div style="float: left;padding-left: 25px;">
                            <span>deposits</span>
                            <p style="font-weight: bold"><?php echo e(number_format('221121212200')); ?></p>
                        </div>
                        <div style="width: 2px; height: 50px; background-color: #caccce; float: left; margin-left: 20%;"></div>
                        <div style="float: right;padding-right: 25px;">
                            <span>payments</span>
                            <p style="font-weight: bold"><?php echo e(number_format('221121212200')); ?></p>
                        </div>

                    </div>
                </div>
            </div>


            
            <div class="col-md-3 col-lg-2 col-xlg-2 pos-dash" style="">
                <div class="card card-hover">
                    <div class="box dash-backg text-center">

                        <div style="background-color: #1C729E;width: 100%; margin: 0; padding: 0; height: 40px;">

                        <h6 class="" style="color: white;line-height: 40px;">Pos</h6>
                        </div>
                        <hr>
                        <span class="font-light text-black-50">233233</span>
                    </div>
                </div>
            </div>



            
            <div class="col-md-3 col-lg-3 col-xlg-3 pos-dash" style="">
                <div class="card card-hover">
                    <div class="box dash-backg text-center">
                        <div style="background-color: #1C729E;width: 100%; margin: 0; padding: 0; height: 40px;">

                        <h6 class="" style="color: white;line-height: 40px;">N CARD  Collection</h6>

                        </div>
                        <hr>
                        <span class="font-light text-black-50">233233</span>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xlg-7 col-lg-7">
                <table class="table table-striped table-bordered"  style="min-height: 113px;">
                    <tbody>
                    <tr style="background-color:#c1054a ">
                        <td colspan="2" style="color: white;">Collection Summary</td>
                    </tr>
                    <tr>
                        <td>Total Merchant collection</td><td>222</td>
                    </tr>
                    <tr>
                        <td>Total Ncard commission</td><td>22200</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>





        <div class="row" style="margin-top: -50px;">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body" style="background-color: #1C729E">
                        <h4 class="card-title m-b-0" style="color: white;">Graph for deposits</h4>
                    </div>

                    <canvas id="myChart" width="400" height="250"></canvas>
                </div>

            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body" style="background-color: #1C729E">
                        <h5 class="card-title m-b-0" style="color: white;">Graph for payment</h5>
                    </div>

                    <canvas id="myChartPayment" width="400" height="250"></canvas>

                </div>

            </div>
        </div>


        <div class="row">

            <div class="col-md-12">
                <div class="card">

                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <tbody>

                            <tr style="background-color:#1C729E ">
                                <td colspan="2" style="color: white;">Summary</td>
                            </tr>
                            <tr>
                                <td>Failed Deposits</td><td>22</td>
                            </tr>

                            <tr>
                                <td>Today deposits</td><td>22</td>
                            </tr>

                            <tr>
                                <td>Today payments</td><td>22</td>
                            </tr>

                            <tr>
                                <td>Total Collections</td><td>2200</td>
                            </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

    <script>
        var ctx = document.getElementById('myChart');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of deposits',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        //dashboard show payments.
        var ctxPayment = document.getElementById('myChartPayment');
        var myChartPayment = new Chart(ctxPayment, {
            type: 'line',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Payments',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cashless\resources\views/dashboard.blade.php ENDPATH**/ ?>