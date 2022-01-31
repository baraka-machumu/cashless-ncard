
$(function () {

    $('#add-agent-pos').click(function (event) {

        console.log(2345678908765);

        $('#add-pos-imei').html('');

        $.ajax({

            type:'GET',
            url:'/cashless/api/agents/getall/pos',

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


    $("#add-pos-location" ).on("keyup",function() {

        console.log("keyup");
        let imei =  $('#add-pos-imei').val();
        let location=  $('#add-pos-location').val();

        console.log("imei select "+$('#add-pos-imei').val());

        if (location.length!=0 && $('#add-pos-imei').val()!=="") {
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


    $.validate({
        modules : 'sanitize',
        decimalSeparator : ',',
        rules: {
            branch: {
                required: function () {
                    return ($("#topup-branchs option:selected").val() == "0");
                }
            }
        },
        messages: {
            branch: "Year Required"
        }
    });
});

