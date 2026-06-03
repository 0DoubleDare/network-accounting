<?php
session_start();
// У МЕНЯ ПУТИ ЗАРАБОТАЛИ ТОЛЬКО С ТАКОЙ КОМАНДОЙ, У МЕНЯ РЕГИСТРАЦИЯ ОТКРЫВАЛАСЬ ДВА РАЗА В APP
require_once $_SERVER['DOCUMENT_ROOT'] . '/network-accounting/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/network-accounting/app/includes/functions.php';

function getError() {
    if (isset($_SESSION['error'])) {
        $error = $_SESSION['error'];
        unset($_SESSION['error']);
        return $error;
    }
    return null;
}

function getMessage() {
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
        return $message;
    }
    return null;
}

// Обработка регистрации
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if ($password === $password_confirm) {
        if (strlen($login) < 3) {
            $_SESSION['error'] = "Логин должен содержать минимум 3 символа";
            header('Location: /network-accounting/app/view/registration.php');
            exit();
        }
        if (strlen($password) < 4) {
            $_SESSION['error'] = "Пароль должен содержать минимум 4 символа";
            header('Location: /network-accounting/app/view/registration.php');
            exit();
        }
        if (checkUserExists($pdo, $login)) {
            $_SESSION['error'] = "Пользователь с таким логином уже существует";
            header('Location: /network-accounting/app/view/registration.php');
            exit();
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        if (registerUser($pdo, $login, $password_hash)) {
            unset($_SESSION['error']);
            $_SESSION['message'] = "Регистрация прошла успешно";
            header('Location: /network-accounting/public/index.php');
            exit();
        } else {
            $_SESSION['error'] = "Ошибка при регистрации";
            header('Location: /network-accounting/app/view/registration.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Пароли не совпадают";
        header('Location: /network-accounting/app/view/registration.php');
        exit();
    }
}
?>