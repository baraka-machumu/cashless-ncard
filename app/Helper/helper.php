<?php


 function base_url(){

     if (app()->environment()=='local'){

         return Config('api.TEST-TICKET');
     }

     else if(app()->environment()=='production'){

         return Config('api.LIVE-TICKET');

     }
 }


function base_url_web_portal(){

    if (app()->environment()=='local'){

        return Config('api.TEST-TICKET-WEB-PORTAL');
    }

    else if(app()->environment()=='production'){

        return Config('api.LIVE-TICKET-WEB-PORTAL');

    }



    function jasper_report_url(){

        if (app()->environment()=='local'){

            return Config('api.TEST_JASPER_SERVER');
        }

        else if(app()->environment()=='production'){

            return Config('api.LIVE_JASPER_SERVER');

        }

    }
}
