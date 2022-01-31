<?php


namespace App\Helper;


class DataEncryption
{


    public  static function  agentPinEncryption($pin){

        $token = $pin;

        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));
        $crypted_token = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);
        unset($token, $cipher_method, $enc_key, $enc_iv);

        return $crypted_token;

    }

}
