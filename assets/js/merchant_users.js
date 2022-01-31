//
//
//
//
// $(function () {
//
//
//
//
//     var BASEURL = "{!! url('/') !!}";
//
//     $('.edit-merchant-user').click(function (event) {
//
//
//         console.log(2345678908765);
//         var id  =  $(this).attr('id');
//
//         $.ajax({
//
//             type:'GET',
//
//             url: 'get-merchant-users-data',
//
//             data:{id:id},
//
//             success:function(data){
//
//                 console.log(data);
//
//                 console.log(543);
//
//                 // var modal = $('.edit-role-modal');
//
//                 $('#edit-mu-first-name').val(data[0].first_name);
//
//                 $('#edit-mu-last-name').val(data[0].last_name);
//                 $('#edit-mu-middle-name').val(data[0].middle_name);
//                 $('#edit-mu-email').val(data[0].email);
//                 $('#edit-mu-phone-number').val(data[0].phone_number);
//                 $('#m-user-id').val(data[0].id);
//
//                 $('#span-name').text(data[0].first_name+' '+data[0].last_name);
//
//                 $("#edit-mu-user-profile").val(data[0].profile_id).change();
//
//                 $("#edit-mu-gender").val(data[0].gender_id).change();
//
//
//                 $('#edit-merchant-user-modal').modal('show');
//
//
//             },
//
//             error:function (data) {
//
//                 console.log(data);
//
//                 $("#role_name").val(data);
//
//
//             }
//
//         });
//
//
//     });
//
//     // select2 js
//     //
//     $('.profile').select2({
//         placeholder: "Select Profile",
//         allowClear: true
//     });
//
//
//
//     $('.region').change(function () {
//
//         $('.district').children().remove();
//
//         var id  =  $(this).val();
//
//         var districts  =  [];
//
//         $.get( "districts/get-all",{id:id}, function(data) {
//
//             console.log(data[0].name);
//
//             for (var i=0; i<data.length; i++){
//                 alert("Testing");
//                 console.log("loop: "+ data[i].name);
//
//                 $("#district").append('<option value='+data[i].id+'>'+data[i].name+'</option>');
//             }
//
//         });
//
//     });
//
//
//     ///edit merchant
//
//
//
//     $('.edit-merchant-form').click(function (event) {
//
//
//         console.log(2345678908765);
//         var id  =  $(this).attr('id');
//
//         console.log("id from click : " +id);
//
//         $.ajax({
//
//             type:'GET',
//
//             url:'merchants/get-merchant-data/'+id,
//
//             data:{id:id},
//
//
//             success:function(data){
//
//                 console.log(data);
//
//                 console.log(543);
//
//
//                 // var modal = $('.edit-role-modal');
//
//                 $('#edit-mname').val(data.name);
//
//                 $('#edit-mtin').val(data.tin);
//                 $('#edit-location').val(data.location_address);
//                 $('#edit-email').val(data.email);
//                 $('#edit-telephone_number').val(data.phone_number);
//                 $('#mid').val(data.id);
//
//                 $("#edit-region").val(data.region_id).change();
//
//                 console.log("new default id "+data.district_id);
//
//                 $.get( "districts/get-all",{id:data.district_id}, function(data) {
//
//                     console.log(data[0].name);
//
//                     for (var i=0; i<data.length; i++){
//
//                         console.log("loop: "+ data[i].name);
//
//                         $("#edit-district").append('<option value='+data[i].id+'>'+data[i].name+'</option>');
//
//
//                     }
//
//
//
//                 });
//                 console.log("new default id "+data.district_id);
//
//                 $("#edit-district").val(1).change();
//
//
//
//                 $('#edit-merchant-modal').modal('show');
//
//             },
//
//             error:function (data) {
//
//                 console.log(data);
//
//                 $("#role_name").val(data);
//
//
//             }
//
//         });
//
//
//     });
//
//
//
//     $('#edit-region').change(function () {
//
//         $('#edit-district').children().remove();
//
//         var id  =  $(this).val();
//
//         console.log("edit region id "+id);
//
//         var districts  =  [];
//
//         $.get( "districts/get-all",{id:id}, function(data) {
//
//             console.log(data[0].name);
//
//             for (var i=0; i<data.length; i++){
//
//                 console.log("loop: "+ data[i].name);
//
//                 $("#edit-district").append('<option value='+data[i].id+'>'+data[i].name+'</option>');
//             }
//
//         });
//
//     });
//
//
//
// });
//
//
//
//
