



$(document).ready(function (e) {


    $('#next').click(function (e) {

        getTips();

    });

});



function  getTips() {

    var tips  =  [

        ["Assigning Roles","Click on the sidebar menu Management Setting, then choose Roles search user you want then assign role"],
        ["Assigning Permission","Click on the sidebar menu Management Setting, then choose Roles search user you want then assign role"],
        ["Assigning Profile","Click on the sidebar menu Management Setting, then choose Roles search user you want then assign role"],
        ["Registering Merchants","Click on the sidebar menu Management Setting, then choose Roles search user you want then assign role"],
        ["Registering Agent","Click on the sidebar menu Management Setting, then choose Roles search user you want then assign role"],
        ["Registering Services","Click on the sidebar menu Management Setting, then choose Roles search user you want then assign role"],
        ["View Transactions","Click on the sidebar menu Management Setting, then choose Roles search user you want then assign role"],
        ["view Errors","Click on the sidebar menu Management Setting, then choose Roles search user you want then assign role"],
        ["View Reversals","Click on the sidebar menu Management Setting, then choose Roles search user you want then assign role"],
        ["View All Merchants","Click on the sidebar menu Management Setting, then choose Roles search user you want then assign role"],
        ["View All Agents","Click on the sidebar menu Management Setting, then choose Roles search user you want then assign role"],

    ];

    let saverArray  = [];

    let  random  =  tips[Math.floor(Math.random()*tips.length)];


    if(jQuery.inArray(random,saverArray)==-1){

        saverArray.push(random);

        $('#tip-heading').html(random[0]);

        $('#tips-detail').html(random[1]);

        console.log(random[0]);

        console.log(saverArray);

    }




}