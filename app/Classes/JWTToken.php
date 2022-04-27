<?php

use Nowakowskir\JWT\JWT;
use Nowakowskir\JWT\TokenDecoded;
use Nowakowskir\JWT\TokenEncoded;

require_once('./vendor/autoload.php');

class JWTToken
{
    public static function setJWT(string $token, string $username, string $role, int $id, $rsa)
    {

        $jwt;

        $publicKey = $rsa['public'];
        $privateKey = $rsa['private'];

        $header = [
            'typ'=>'JWT',
            'alg'=>'RS256'
        ];

        $payload =[
            'username'=>$username,
            'role'=>$role,
            'id'=>$id,
            'token'=>$token,
            'public'=>$publicKey,
            'private'=>$privateKey,     
            'exp'=>time() + 600,
        ];

        $tokenDecoded = new TokenDecoded($payload, $header);
        $tokenEncoded = $tokenDecoded->encode($privateKey, JWT::ALGORITHM_RS256);

        $payload2 = $tokenEncoded->decode()->getPayload();


        try {
            $tokenEncoded->validate($publicKey, JWT::ALGORITHM_RS256);
            $jwt = $tokenEncoded->toString();
        } catch(Exception $e) {

        }

                
        return $payload2;
    }
}
