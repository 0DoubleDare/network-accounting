<?php

session_start();
require __DIR__ . '/../app/includes/functions.php';
require __DIR__ . '/../config/db.php';

$action = $_POST['action'] ?? '';

if ($action === 'register' || (isset($_POST['password']) && isset($_POST['password_confirm']))) {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if ($password === $password_confirm) {
        if (strlen($login) < 3) {
            $_SESSION['error'] = "Логин должен содержать минимум 3 символа";
            header('Location: ../app/view/registration.php');
            exit();
        }
        if (strlen($password) < 4) {
            $_SESSION['error'] = "Пароль должен содержать минимум 4 символа";
            header('Location: ../app/view/registration.php');
            exit();
        }
        if (checkUserExists($pdo, $login)) {
            $_SESSION['error'] = "Пользователь с таким логином уже существует";
            header('Location: ../app/view/registration.php');
            exit();
        }

$password_hash = md5($password);

        if (registerUser($pdo, $login, $password_hash)) {
            unset($_SESSION['error']);
            $_SESSION['message'] = "Регистрация прошла успешно! Теперь вы можете войти.";
            header('Location: ../app/view/login.php');
            exit();
        } else {
            $_SESSION['error'] = "Ошибка при регистрации";
            header('Location: ../app/view/registration.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Пароли не совпадают";
        header('Location: ../app/view/registration.php');
        exit();
    }
}

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
    exit();
    }