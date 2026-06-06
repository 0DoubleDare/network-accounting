<?php

session_start();
//require __DIR__ . '/../app/includes/functions.php';
//require __DIR__ . '/../config/db.php';
require '../config/db.php';
require '../app/includes/functions.php';

$user_info = checkAuthorizedUser($pdo, $_POST['login'], $_POST['password_hash']);

if (isset($user_info)) {
    $_SESSION['user_info'] = $user_info;

    // Добавляем запись в лог о входе
    addLoginLog($pdo, $user_info['user_id'], $user_info['role']);

    unset($_SESSION['error']);
    header('Location: ../');
    exit();
} else {
    $_SESSION['error'] = "Ошибка логина или пароля";
    header('Location: ../app/view/login.php');
    exit();
}