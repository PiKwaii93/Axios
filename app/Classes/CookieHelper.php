<?php

class CookieHelper
{
    public static function setCookie(string $token, string $username, string $role, int $id,  $jwt): void
    {

        $cookieUser = "{$username};{$role};{$id}" ;

        $stock = "";

        foreach ($jwt as $value) {
            $stock = $stock.$value.";";
        };

        

        setcookie('hetic_token', $token, time() + 2000, '/', 'localhost', false, false);
        setcookie('hetic_username', $cookieUser, time() + 2000, '/', 'localhost', false, false);
        setcookie('hetic_JWT', $stock, time() + 2000, '/', 'localhost', false, false);

    }
}

