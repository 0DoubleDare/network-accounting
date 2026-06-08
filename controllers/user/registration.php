<?php

session_start();
//require __DIR__ . '/../app/includes/functions.php';
//require __DIR__ . '/../config/db.php';
require '../../config/db.php';
require '../../app/includes/functions.php';

$action = $_POST['action'] ?? '';
$registration_form_path = 'Location: ../../app/view/user/registration.php';

if ($action === 'register' || (isset($_POST['password']) && isset($_POST['password_confirm']))) {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if ($password === $password_confirm) {
        if (strlen($login) < 3) {
            $_SESSION['error'] = "Логин должен содержать минимум 3 символа";
            header($registration_form_path);
            exit();
        }
        if (strlen($password) < 4) {
            $_SESSION['error'] = "Пароль должен содержать минимум 4 символа";
            header($registration_form_path);
            exit();
        }
        if (checkUserExists($pdo, $login)) {
            $_SESSION['error'] = "Пользователь с таким логином уже существует";
            header($registration_form_path);
            exit();
        }

        $password_hash = md5($password);

        if ($user_info = registerUser($pdo, $login, $password_hash)) {
            unset($_SESSION['error']);

// Добавляем запись в лог о регистрации
            addRegistrationLog($pdo, $user_info['id']);

//$_SESSION['message'] = "Регистрация прошла успешно! Теперь вы можете войти.";
            $_SESSION['user_info'] = $user_info;
            header('Location: ../../');
            exit();
        } else {
            $_SESSION['error'] = "Ошибка при регистрации";
            header($registration_form_path);
            exit();
        }
    } else {
        $_SESSION['error'] = "Пароли не совпадают";
        header($registration_form_path);
        exit();
    }
}