
$(function () {

    //TODO LIST  make datatables

    profileAssignPermissions();
    showConsumewrWalletModal();
    editAgentDetails();
    topupAgent();
    EditReport();
    EditRole();
    DisableAgent();
    EnableAgent();

    disableConsumer();

    enableConsumer();

    disableMerchant();

    enableMerchant();

    DisableAgentPos();

    EnableAgentPos();

    editMerchantDetails();
    viewDetailsForMerchant();


    $('.edit-permissions').click(function (event) {


        let id  =  $(this).attr('id');

        $.ajax({

            type:'GET',

            url:'permissions/getpermission-data/'+id,

            data:{id:id},

            success:function(data){

                console.log("id from response " +data);

                console.log(543);


                // var modal = $('.edit-role-modal');

                $('#edit_permission_name').val(data);

                $('#permission_id').val(id);

                $('#edit-permission-modal').modal('show');


            },

            error:function (data) {

                console.log(data);

                $("#role_name").val(data);


            }

        });


    });

    // select2 js
    //
    $('.region').select2({
        placeholder: "Select region",
        allowClear: true
    });

    $('.profile').select2({
        placeholder: "Select Profile",
        allowClear: true
    });

    $('.gender').select2({
        placeholder: "Select Gender",
        allowClear: true
    });

    $('.role').select2({
        placeholder: "Select Role",
        allowClear: true
    });


    $('.district').select2({
        placeholder: "Select district",
        allowClear: true
    });

    $('.bank').select2({
        placeholder: "Select Bank",
        allowClear: true
    });


    $('.branch').select2({
        placeholder: "Select Bank Branch",
        allowClear: true
    });
    $('#topup-banks').select2({
        placeholder: "Select Bank",
        allowClear: true
    });
    $('#topup-branchs').select2({
        placeholder: "Select Bank Branch",
        allowClear: true
    });

    $('.service').select2({
        placeholder: "Select Service Name",
        allowClear: true
    });
    $('.pos').select2({
        placeholder: "Select Pos",
        tags: true,
        dropdownParent: $("#add-pos-modal"),
        allowClear: true
    });

    $('.merchant-location-pos').select2({
        placeholder: "Select location",
        allowClear: true
    });
    $('.select2-merchant-service').select2({
        placeholder: "Select Service",
        allowClear: true
    });
    $('.select2-merchant-service-type').select2({
        placeholder: "Select Service type",
        allowClear: true
    });

    $('.region').change(function () {


        console.log("here");
        $('.district').children().remove();

        var id  =  $(this).val();

        var districts  =  [];

        $.get(district_url,{id:id}, function(data) {

            console.log(data[0].name);

            for (var i=0; i<data.length; i++){

                console.log("loop: "+ data[i].name);

                $(".district").append('<option value='+data[i].id+'>'+data[i].name+'</option>');
            }

        });

    });


    //mecharn on chnage region
    $('#mregion').change(function () {

        $('#mdistrict').children().remove();

        var id  =  $('#mregion').val();

        var districts  =  [];

        $.get( "districts/get-all",{id:id}, function(data) {

            console.log(data[0].name);

            for (var i=0; i<data.length; i++){

                console.log("loop: "+ data[i].name);

                $("#mdistrict").append('<option value='+data[i].id+'>'+data[i].name+'</option>');
            }

        });

    });


    //banks on chnage branches
    $('#topup-bank').change(function () {

        $('#topup-branch').children().remove();

        var id  =  $('#topup-bank').val();

        console.log('bank '+id);


        var districts  =  [];

        $.get( "branches/get-all",{id:id}, function(data) {

            console.log(data[0].name);

            for (var i=0; i<data.length; i++){

                console.log("loop: "+ data[i].name);

                $("#mbranch").append('<option value='+data[i].id+'>'+data[i].name+'</option>');
            }

        });

    });

    //banks on chnage branches
    $('.bank').change(function () {

        $('#mbranch').children().remove();

        var id  =  $('.bank').val();

        console.log('bank '+id);


        var districts  =  [];

        $.get( "branches/get-all",{id:id}, function(data) {

            console.log(data);

            for (let i=0; i<data.length; i++){

                console.log("loop: "+ data[i].name);

                $(".branch").append('<option value='+data[i].id+'>'+data[i].name+'</option>');
            }

        });

    });
    ///edit merchant



    $('.edit-merchant-form').click(function (event) {

        var id  =  $(this).attr('id');

        console.log("id from click : " +id);

        $.ajax({

            type:'GET',

            url:'merchants/get-merchant-data/'+id,

            data:{id:id},

            success:function(data){

                console.log(data);

                console.log(543);

                // var modal = $('.edit-role-modal');

                $('#edit-mname').val(data.name);

                $('#edit-mtin').val(data.tin);
                $('#edit-location').val(data.location_address);
                $('#edit-email').val(data.email);
                $('#edit-telephone_number').val(data.phone_number);
                $('#mid').val(data.id);

                $("#edit-region").val(data.region_id).change();

                console.log("new default id "+data.district_id);

                $.get( "districts/get-all",{id:data.district_id}, function(data) {

                    console.log(data[0].name);

                    for (var i=0; i<data.length; i++){

                        console.log("loop: "+ data[i].name);

                        $("#edit-district").append('<option value='+data[i].id+'>'+data[i].name+'</option>');
                    }

                });
                console.log("new default id "+data.district_id);

                $("#edit-district").val(1).change();

                $('#edit-merchant-modal').modal('show');

            },
            error:function (data) {

                console.log(data);

                $("#role_name").val(data);

            }

        });

    });

    $('#edit-region').change(function () {

        $('#edit-district').children().remove();

        var id  =  $(this).val();

        console.log("edit region id "+id);

        var districts  =  [];

        $.get( "districts/get-all",{id:id}, function(data) {

            console.log(data[0].name);

            for (var i=0; i<data.length; i++){

                console.log("loop: "+ data[i].name);

                $("#edit-district").append('<option value='+data[i].id+'>'+data[i].name+'</option>');
            }

        });

    });

    // $('.table').DataTable();


});

function EditRole() {

    $('.edit-roles').click(function (event) {

        var id  =  $(this).attr('id');

        $.ajax({

            type:'GET',

            url:'roles/getrole-data/'+id,

            data:{id:id},

            success:function(data){

                console.log("name from response " +data);

                console.log(543);


                var modal = $('.edit-role-modal');

                $('.role_name').val(data);

                $('#role_id').val(id);

                $('#edit-role-modal').modal('show');


            },

            error:function (data) {

                console.log(data);

                $("#role_name").val(data);


            }

        });


    })


}


function DisableAgent() {

    $('.disable-agent').click(function (event) {

        let id  =  $(this).attr('id');

        $('#agent-id-to-disable').val(id);
        console.log('id for disable agent account '+id);
        $('#show-agent-disable-modal').modal('show');

    });

}

function EnableAgent() {

    $('.enable-agent').click(function (event) {

        let id  =  $(this).attr('id');

        $('#agent-id-to-enable').val(id);
        console.log('id for enable consumer account '+id);
        $('#show-agent-enable-modal').modal('show');

    });

}
function EditReport() {

    console.log('report');

    $('.edit-reports').click(function (event) {

        var id  =  $(this).attr('id');

        $.ajax({

            type:'GET',

            url:'configuration/get-report-by-id/'+id,

            data:{id:id},

            success:function(result){

                console.log(result);

                var modal = $('.edit-report-modal');

                $('#report_name').val(result.data.name);
                $('.report_url').val(result.data.report_url);
                $('.has_param').val(result.data.has_parameter);

                $("#viewParams2").click(function() {
                    if ($(this).val() === "1") {
                        $('#viewParamsDiv2').show();

                    } else {

                        $('.uncheck').prop('checked',false);

                        $('#viewParamsDiv2').hide();

                    }
                });
                $("#viewParams2").trigger("change");

                $(".report_types").val(result.data.report_type).change();

                var params  =  result.params;

                console.log(params);

                for ( i =0; i<params.length; i++){

                    console.log(params[i].parameter_id);
                    $("input[value='" + params[i].parameter_id + "']").prop('checked', true);

                }

                $('#report_id').val(id);

                $('#edit-report-modal').modal('show');

            },
            error:function (data) {

                console.log(data);

                $("#report_name").val(data);

            }

        });

    })

}

function enableConsumer() {

    $('.enable-consumer').click(function (event) {

        let id  =  $(this).attr('id');

        console.log("--------");
        let name  = $('#c-'+id).val();

        $('#consumer-id-to-enable').val(id);
        console.log('id for enable consumer account '+id);
        $('#consumer-name-enable').html(name).change();

        $('#show-consumer-enable-modal').modal('show');



    });


}

function disableConsumer() {

    $('.disable-consumer').click(function (event) {

        let id  =  $(this).attr('id');

        let name  = $('#c-'+id).val();

        console.log("consumer name "+name);
        $('#consumer-id-to-disable').val(id).change();
        $('#consumer-name-disable').html(name).change();
        console.log('id for enable consumer account '+id);
        $('#show-consumer-disable-modal').modal('show');



    });


}



function disableMerchant() {

    $('.disable-merchant').click(function (event) {

        let id  =  $(this).attr('id');

        let name  = $('#merchant-name').val();

        console.log("merchnat name "+name);
        $('#merchant-id-to-disable').val(id).change();
        $('#merchant-name-disable').html(name).change();
        console.log('id for disable merchant account '+id);
        $('#show-merchant-disable-modal').modal('show');



    });


}

function enableMerchant() {

    $('.enable-merchant').click(function (event) {

        let id  =  $(this).attr('id');

        let name  = $('#merchant-name').val();

        console.log("merchnat name "+name);
        $('#merchant-id-to-enable').val(id).change();
        $('#merchant-name-disable').html(name).change();
        console.log('id for enable merchant account '+id);
        $('#show-merchant-enable-modal').modal('show');



    });


}



function DisableAgentPos() {

    $('.disable-pos-agent').click(function (event) {

        let id  =  $(this).attr('id');

        $('#pos-id-to-disable').val(id);
        console.log('id for disable pos  '+id);
        $('#show-posagent-disable-modal').modal('show');



    });


}


function EnableAgentPos() {

    $('.enable-pos-agent').click(function (event) {

        let id  =  $(this).attr('id');

        $('#pos-id-to-enable').val(id);
        console.log('id for disable pos  '+id);
        $('#show-posagent-enable-modal').modal('show');

    });

}


function editMerchantDetails() {


    $('.edit-merchant-modal').click(function (event) {

        let id  =  this.id;

        $.ajax({

            type:'GET',

            url:'merchants/get-merchant-data/'+id,

            success:function(result){

                console.log(result.data.name);

                $(".mname").val(result.data.name).change();
                $(".mtelephone_number").val(result.data.phone_number).change();
                $(".tin").val(result.data.tin).change();
                $(".location").val(result.data.location).change();
                $(".account").val(result.data.account_number).change();
                $(".region").val(result.data.region_id).change();
                $(".bank").val(result.data.bank_id).change();
                $(".branch").val(result.data.branch_id).change();
                $(".email").val(result.data.email).change();
                $(".service").val(result.data.service_id).change();

                $(".dname").html(result.data.name).change();
                // $(".edit-merchant_type").html(result.data.merchant_type).change();

                console.log('id for merchant type '+result.data.merchant_type);
                $("#edit-merchant_types select").val(result.data.merchant_type);
                $('#edit-merchant_types option[value='+result.data.merchant_type+']').attr('selected','selected');
                $('#show-edit-merchant-modal').modal('show');


                submitEditMerchnat(id);
            },
        });




    });

}






function  submitEditMerchnat(id) {

    $(".submit-edit-merchant-form").on("click", function(e){
        e.preventDefault();
        $('#form-edit-merchant').attr('action', "merchants/"+id).submit();
    });
}


function topupAgent() {


    $('.topup-agent').click(function (event) {

        let id  =  $(this).attr('id');

        console.log(id);

        $('#show-topup-agent-modal').modal('show');



    });

}

function  viewDetailsForMerchant() {


    $('.view-merchant').click(function (event) {

        let id  =  $(this).attr('id');

        $('#view-merchant-table-left').html('');
        $('#view-merchant-table-right').html('');

        console.log("id "+id);
        $.ajax({

            type:'GET',

            url:'merchants/get-merchant-data/'+id,

            success:function(result){

                console.log(result.data.name);


                let tableLeft  =  '<tr><th>Merchant Name</th><td>'+result.data.name+'</td>' +
                    '<tr><th>Tin Number</th><td>'+result.data.tin+'</td>' +
                    '<tr><th>Email Number</th><td>'+result.data.email+'</td>'+
                    '<tr><th>Phone Number</th><td>'+result.data.phone_number+'</td>';

                $('#view-merchant-table-left').append(tableLeft);


                let tableRight  =  '<tr><th>Account Number</th><td>'+result.data.account_number+'</td>' +
                    '<tr><th> Merchant Location</th><td>'+result.data.location+'</td>' +
                    '<tr><th>Email Number</th><td>'+result.data.email+'</td>'+
                    '<tr><th>Phone Number</th><td>'+result.data.phone_number+'</td>';

                $('#view-merchant-table-right').append(tableRight);

                $(".dname").html(result.data.name).change();

                console.log('id for merchant '+id);
                $('#show-view-merchant-modal').modal('show');

            },
        });




    });

}


 function editAgentDetails(){

$('.edit-agent-modal').click(function (event) {

    let id  =  $(this).attr('id');

    console.log(id);

    $.ajax({

        type:'GET',

        url:'agents/getall/details/'+id,

        success:function(result){

            // console.log(result.data.name);

            $(".first_name").val(result.data.first_name).change();
            $(".last_name").val(result.data.last_name).change();
            $(".gender").val(result.data.gender_id).change();
            $(".middle_name").val(result.data.middle_name).change();
            $(".region").val(result.data.region_id).change();
            $(".bank").val(result.data.bank_id).change();
            $(".branch").val(result.data.branch_id).change();
            $(".email").val(result.data.email).change();
            $(".phone_number").val(result.data.phone_number).change();
            $(".location").val(result.data.location).change();
            $(".agent_code").val(result.data.agent_code).change();

            $(".dname").html(result.data.name).change();

            console.log('id for merchant '+id);
            $('#show-edit-agent-modal').modal('show');


            submitEditAgent(id);
        },
    });




});

}


function  submitEditAgent(id) {

    $(".submit-edit-agent").on("click", function(e){
        e.preventDefault();
        $('#edit-agent-form').attr('action', "agents/"+id).submit();
    });
}


function  showConsumewrWalletModal() {

    $('.consumer-wallet-modal').click(function (event) {

        let id  =  $(this).attr('id');

        console.log(id);

        $.ajax({

            type:'GET',

            url:'consumer/details/'+id,

            success:function(result){

                console.log(result);

                let tableLeft  =  '<tr><th>Full Name</th><td>'+result.data.first_name+' '+result.data.last_name+'</td>' +
                    '<tr><th>Joining date</th><td>'+result.data.created_at+'</td>' +
                    '<tr><th>Status</th><td>'+result.data.status_name+'</td></tr>';

                $('#consumer-wallet-details-left').html(tableLeft);

                let tableRight  =  '<tr><th>Account balance</th><td>'+result.data.amount+'</td>' +
                    '<tr><th>Total payment</th><td>'+result.payments+'</td>' +
                    '<tr><th>Total deposits</th><td>'+result.deposits+'</td></tr>';
                //
                $('#consumer-wallet-details-right').html(tableRight);
                //
                $(".dname").html(result.data.first_name+'  '+result.data.last_name).change();

                console.log('id for merchant '+id);
                $('#show-consumer-wallet-details-modal').modal('show');

                submitEditAgent(id);
            },
        });

    });


}



function  profileAssignPermissions() {


    $('.profile-btn').click(function (event) {

        let id  =  $(this).attr('id');

        $('.profile_id').val(id);
        $('#assign-permissions-profile-modal').modal('show');


    });



    }

