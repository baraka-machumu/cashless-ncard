

    $(function () {

       // consumerDepositsOnLoad();

       // consumerDeposits();

    });


    function  consumerDeposits(){

        $.get('api/consumer/deposits', {count:2}, function (result) {

            setTimeout(consumerDeposits, 5000);

            console.log('live updates -------');

            console.log(result);

        });

    }

    function  consumerDepositsOnLoad(){

        $.get('api/consumer/deposits', function (result) {


            console.log(result);

        });

    }