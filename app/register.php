<?php

require_once 'headers.php';
require_once 'Classes/PDOFactory.php';
require_once 'Classes/TokenHelper.php';
require_once 'Classes/User.php';
require_once 'Classes/CookieHelper.php';
require_once 'Classes/JWTToken.php';
require_once 'Classes/RSA.php';

$username = $_REQUEST['username'] ?? '';
$password = $_REQUEST['password'] ?? '';
$role = "user";

if (!$username || !$password) {
    echo json_encode([
        'status' => 'error',
        'message' => 'username or password parameters missing'
    ]);
    exit;
}


$pdo = (new PDOFactory())->getPdo();
$query = $pdo->prepare('SELECT COUNT(*) FROM `User` WHERE `username` = :username');
$query->bindValue('username', $username, PDO::PARAM_STR);
$query->execute();

$userAlreadyExists = (bool)$query->fetchAll(PDO::FETCH_ASSOC)[0]["COUNT(*)"];

if ($userAlreadyExists) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Username already exists'
    ]);
    exit;
}

$rsa = RSA::setRSA();

$insert = $pdo->prepare('INSERT INTO User (`username`, `password`, token, `role`, `privateKey`   ) VALUES (:username, :password, :token, :role, :privateKey)');
$insert->bindValue('username', $username, PDO::PARAM_STR);
$insert->bindValue('password', password_hash($password, PASSWORD_BCRYPT), PDO::PARAM_STR);
$insert->bindValue('token', TokenHelper::buildToken(), PDO::PARAM_STR);
$insert->bindValue('role', $role, PDO::PARAM_STR);
$insert->bindValue('privateKey', $rsa['private'], PDO::PARAM_STR);

if ($insert->execute()) {
    $lastInsertId = $pdo->lastInsertId();
    $return = $pdo->query("SELECT * FROM User WHERE id = {$lastInsertId}");
    $return->setFetchMode(PDO::FETCH_CLASS, User::class);
    /** @var User $newUser */
    $newUser = $return->fetch();

    $jwt = JWTToken::setJWT($newUser->getToken(), $newUser->getUsername(), $newUser->getRole(), $newUser->getID(), $rsa);

    CookieHelper::setCookie($newUser->getToken(), $newUser->getUsername(), $newUser->getRole(), $newUser->getID(), $jwt);

    echo json_encode([
        'status' => 'success',
        'username' => $newUser->getUsername(),
        'token' => $newUser->getToken(),
        'role' => $newUser->getRole(),
        'privateKey' => $rsa['private'],
    ]);
    exit;
}

