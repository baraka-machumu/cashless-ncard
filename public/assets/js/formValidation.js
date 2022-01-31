


$(function () {


    $('#login-btn').prop('disabled',true);

    $('#login-email').keyup( function () {


        var emailLenth  = $('#login-email').val().length;

        var passwordLength  = $('#login-password').val().length;

        console.log("e length :"+emailLenth+" pa length "+passwordLength);

        if (emailLenth<=4 && passwordLength<=0){

            $('#login-btn').prop('disabled',true);
        } else {

            $('#login-btn').prop('disabled',false);

    }


    });

    $('#login-password').keyup( function () {


        var passwordLength  = $('#login-password').val().length;

        if (passwordLength===0){

            $('#login-btn').prop('disabled',true);
        } else {

            $('#login-btn').prop('disabled',false);

        }


    });



});

