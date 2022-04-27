<?php

use Nowakowskir\JWT\JWT;
use Nowakowskir\JWT\TokenDecoded;
use Nowakowskir\JWT\TokenEncoded;

require_once('./vendor/autoload.php');

class RSA
{
    public static function setRSA()
    {

        $rsa;


        $res = openssl_pkey_new();

        $details = openssl_pkey_get_details($res);

        openssl_pkey_export($res, $privateKey);

        openssl_pkey_export_to_file($res, "./rsaPrivateKey.key");

        $privateKey = file_get_contents("./rsaPrivateKey.key");

        $res = openssl_pkey_get_private($privateKey);

        $publicKey = openssl_pkey_get_details($res)["key"];

        $rsa = [
            'public'=> $publicKey,
            'private'=> $privateKey,
        ];
       
        return $rsa;
    }

    public static function getRSA($privateKey)
    {

        $rsa;

        $res = openssl_pkey_get_private($privateKey);

        $publicKey = openssl_pkey_get_details($res)["key"];


        $rsa = [
            'public'=> $publicKey,
            'private'=> $privateKey,
        ];


        return $rsa;
    }
}

