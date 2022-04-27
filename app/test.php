<?php

use Nowakowskir\JWT\JWT;
use Nowakowskir\JWT\TokenDecoded;
use Nowakowskir\JWT\TokenEncoded;

require_once('./vendor/autoload.php');


$res = openssl_pkey_new();

$details = openssl_pkey_get_details($res);

echo($details["key"]);

echo("<br>");
echo("<br>");
echo("<br>");
echo("<br>");
echo("<br>");

openssl_pkey_export($res, $privateKey);

echo $privateKey;

echo("<br>");
echo("<br>");
echo("<br>");
echo("<br>");
echo("<br>");

openssl_pkey_export_to_file($res, "./rsaPrivateKey.key");

$privateKey = file_get_contents("./rsaPrivateKey.key");

$res = openssl_pkey_get_private($privateKey);

$publicKey = openssl_pkey_get_details($res)["key"];

echo $publicKey;


echo("<br>");
echo("<br>");
echo("<br>");
echo("<br>");
echo("<br>");

$header = [
  'typ'=>'JWT',
  'alg'=>'RS256'
];

$payload =[
  'username'=>'Meow',
  'role'=>'admin',
  'id'=>100,
];

$tokenDecoded = new TokenDecoded($payload, $header);
$tokenEncoded = $tokenDecoded->encode($privateKey, JWT::ALGORITHM_RS256);

$payload2 = $tokenEncoded->decode()->getPayload();


var_dump($payload2);

echo("<br>");
echo("<br>");
echo("<br>");
echo("<br>");
echo("<br>");

echo 'Your token is: ' . $tokenEncoded->toString();

echo("<br>");
echo("<br>");
echo("<br>");
echo("<br>");
echo("<br>");

try {
  $tokenEncoded->validate($publicKey, JWT::ALGORITHM_RS256);
  echo('Clé vérifié');
} catch(Exception $e) {
  echo('Clé invalide');
}


