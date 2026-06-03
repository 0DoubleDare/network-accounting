<?php

    session_start();
    require '../app/includes/functions.php';
    require '../config/db.php';

    $user_info = checkAuthorizedUser($pdo, $_POST['login'], $_POST['password_hash']);

    if(isset($user_info)){
        $_SESSION['user_info'] = $user_info;
//    $_SESSION['id'] = $user_info['id'];
//    $_SESSION['role'] = $user_info['role'];
//    $_SESSION['login'] = $user_info['login'];

    $_SESSION['error'] = null;

    header('Location: ../public/index.php');
    exit();
    } else {
    $_SESSION['error'] = "Ошибка логина или пароля";
    header('Location: ../app/view/login.php');
    }

?>