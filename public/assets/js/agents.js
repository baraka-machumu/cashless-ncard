
$(function () {

    $('#add-agent-pos').click(function (event) {

        console.log("showing  pos add.....");

        $('#add-pos-imei').html('');

        $.ajax({

            type:'GET',
            url:agentGetAllPos,

            success:function(data){

                console.log(data);

                console.log(543);

                // var modal = $('.edit-role-modal');

                for (let i=0; i<data.length; i++) {

                    console.log(data[i].imei_no);
                    $("#add-pos-imei").append('<option value=' + data[i].imei_no + '>' + data[i].imei_no + '</option>');

                    // $("#edit-district").val(1).change();
                }

                $("#add-pos-imei").val(1).change();

                $('#add-pos-modal').modal('show');


            },

            error:function (data) {
                console.log(data);
            }
        });

    });

    let i = 1;
    let imeiCheck  =  [];

    $('#btn-add-posto-table').prop("disabled",true);


    $("#add-pos-location" ).on("change",function() {

        console.log("keyup");
        let imei =  $('#add-pos-imei').val();
        let location=  $('#add-pos-location').val();

        console.log("imei select "+$('#add-pos-imei').val());

        if (location.length!="" && $('#add-pos-imei').val()!=="") {
            $('#btn-add-posto-table').prop("disabled", false);

        } else {
            $('#btn-add-posto-table').prop("disabled", true);

        }


    });
    $('#btn-add-posto-table').click( function () {

        let imei =  $('#add-pos-imei').val();
        let location=  $('#add-pos-location').val();

        $('#add-warning').remove();

        console.log(imeiCheck);
        if (jQuery.inArray(imei,imeiCheck)!==-1){

            $('#add-label-warning').append("<span  class='label label-warning' id='add-warning'>Already added</span>");

        } else {


            if (imei.length!=0 && location.length!=0){

                $('#btn-add-posto-table').prop("disabled",false);

                console.log('imei '+imei+' location '+location);

                $('#add-pos-tr').append('<tr><td>'+i+'</td><td>' +
                    '<input style="width: 140px;" class="form-control" type="text" value="'+imei+'" name="imei_no[]" readonly></td>' +
                    '<td><input style="width: 120px;" class="form-control" type="text" value="'+location+'" name="location[]" readonly></td>' +
                    '<td><a  id="'+imei+' " class="btn btn-danger delete-pos" style="color: white;"><i class="fa fa-trash"></i></a></td></tr>');

                i  =  i+1;
                $('.err-warning-table').html("").removeClass('label label-warning');

            }
        }
        imeiCheck.push(imei);



    });


    // remove the added pos from table
    $("#table-pos-added").delegate('tr td a ', 'click', function() {

         console.log("removing elements");
        $(this).closest ('tr').remove();

        imeiCheck =  [];

    });
    $(".table-pos-added").delegate('tr td a ', 'click', function() {

        console.log("removing elements");
        $(this).closest ('tr').remove();

        imeiCheck =  [];

    });

    $("#btn-form-submit-addpos").click( function () {

        if ($('#add-pos-location').val()===""){

            $('#add-pos-location').addClass('form-validate-error');

        }
        if (!$("#add-pos-imei option:selected").length){

            $('#select2-add-pos-imei-container').css("border", "1px solid #c63c09");

        }
        let tbody = $("#table-pos-added tbody");

        if (tbody.children().length === 0) {


            $('.err-warning-table').html("Please Add Pos To submit").addClass('label label-warning');
        }
        else {
            $("#add-pos-form").submit();

        }
    });



    // add pos merchant agent users


    $('.add-merchant-agent-user-btn').on('click',function (event) {

        console.log("merchant imei no "+this.id);

        // $('#add-pos-merchant-agent-user').html('');
        $("#pos-users-imei-no").val(this.id).change();

        $('#add-pos-merchant-agent-user-modal').modal('show');

    });

let userId = 1;
    $('#btn-add-merchant-agentto-table').click( function () {

        let firstName =  $('#merchant-agent-fname').val();
        let lastName =  $('#merchant-agent-lname').val();
        let station =  $('#merchant-agent-station_code').val();
        let phoneNumber =  $('#merchant-agent-phone_number').val();

         console.log("first name  = "+firstName+" last name = "+lastName+" email = "+station+" phone number "+phoneNumber);

        $('#add-merchant-agent-tr').append('<tr><td>'+userId+'</td><td>' +
            '<input style="width: 140px;" class="form-control" type="text" value="'+firstName+'" name="first_name[]" readonly></td>' +
            '<td><input style="width: 120px;" class="form-control" type="text" value="'+lastName+'" name="last_name[]" readonly></td>' +
            '<td><input style="width: 120px;" class="form-control" type="text" value="'+phoneNumber+'" name="phone_number[]" readonly></td>' +
            '<td><input style="width: 120px;" class="form-control" type="text" value="'+station+'" name="station_code[]" readonly></td>' +
            '<td><a  id="'+userId+' " class="btn btn-danger delete-pos" style="color: white;"><i class="fa fa-trash"></i></a></td></tr>');

        userId  =  userId+1;

    });


    $('#btn-form-submit-addpos-merchant-agent').click( function () {

        $("#add-merchant-agent-users-form").submit();

    });

// merchant service modal show

    $('#add-merchant-service-btn').click(function (event) {

        console.log("merchant service");

        // $('#add-pos-merchant-agent-user').html('');

        $('#add-pos-merchant-service-modal').modal('show');

    });

    $('#merchant-service-type').change(function () {


        let serviceType  =  $('#merchant-service-type').val();

        console.log("serveice type= "+serviceType);

        if (serviceType === '0') {
            console.log("not");

            $('#merchant-service-price-div').hide();
        }

        else {
            console.log("yes");

            $('#merchant-service-price-div').show();

        }


    });

    let  serviceId = 1;
    $('#btn-add-merchant-serviceto-table').click( function () {

        let service =  $('#merchant-add-service').val();
        let type =  $('#merchant-service-type').val();

        let serviceTagName  =  $('#merchant-add-service').find('option:selected').text();
        let typeTagName  =  $('#merchant-service-type').find('option:selected').text();

        console.log(" service name "+serviceTagName);

        let price  =  '0';

        if (type === '1') {


           price =  $('#merchant-service-price').val()

        }

        else {
            console.log("0");

          price =  "no price";


        }

        if (service!=='' && type!=='')
        {

            $('#add-merchant-service-tr').append('<tr><td>'+serviceId+'</td><td>' +
                '<select style="width: 140px;" class="form-control" name="service[]" readonly><option value="'+service+'" readonly>'+serviceTagName+'</option></select></td>' +
                // '<td><input style="width: 120px;" class="form-control" type="text" value="'+price+'" name="price[]" readonly></td>' +
                // '<td><select style="width: 140px;" class="form-control" name="type[]" readonly><option value="'+type+'">'+typeTagName+'</option></select></td>' +
                '<td><a  id="'+userId+' " class="btn btn-danger delete-pos" style="color: white;"><i class="fa fa-trash"></i></a></td></tr>');

            serviceId  =  serviceId+1;
            $('.err-warning-table').html('');

        }

         else {
             $('.err-warning-table').html("<span class='label label-warning'>Please Fill All Fields</span>");
        }

    });

    $('#btn-form-submit-add-merchant-service').click( function () {

        let tbody = $(".table-pos-added tbody");

        if (tbody.children().length === 0) {

            $('.err-warning-table').html("Please Add Pos To submit").addClass('label label-warning');
        }
        else {
            $("#add-merchant-service-form").submit();

        }

    });
});

