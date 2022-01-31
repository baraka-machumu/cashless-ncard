<?php


namespace App\Helper;


class ValidationHelper
{

    static  function isValidEmail($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
