<?php

require_once 'headers.php';
require_once 'Classes/PDOFactory.php';
require_once 'Classes/User.php';
require_once 'Classes/CookieHelper.php';

$username = $_SERVER['PHP_AUTH_USER'] ?? '';
$password = $_SERVER['PHP_AUTH_PW'] ?? '';

if (!$username || !$password) {
    echo json_encode([
        'status' => 'error',
        'message' => 'username or password parameters missing'
    ]);
    exit;
}


$pdo = (new PDOFactory())->getPdo();
$query = $pdo->prepare('SELECT * FROM `User` WHERE `username` = :username');
$query->bindValue('username', $username, PDO::PARAM_STR);
$query->setFetchMode(PDO::FETCH_CLASS, User::class);
if ($query->execute()) {
    /** @var User $user */
    $user = $query->fetch();
    if ($user && password_verify($password, $user->getPassword())) {

        CookieHelper::setCookie($user->getToken(), $user->getUsername());

        echo json_encode([
            'status' => 'success',
            'username' => $user->getUsername(),
            'token' => $user->getToken()
        ]);
        exit;
    }
    echo json_encode([
        'status' => 'error',
        'message' => 'Wrong credentials'
    ]);
}

exit;
