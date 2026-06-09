<?php
/**
 *  Файл для проверки сессий. Здесь будет проверка зарегистрирован ли пользователь и выполнение блока кода в зависимости от результата проверки.
 *  Подключайте в тех файлах, в которых нужен зарегистрированный пользователь
*/

function requireAuth($pdo) {
    // Проверяем, есть ли сессия
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Проверяем, авторизован ли пользователь
    if (!isset($_SESSION['user_info']) || empty($_SESSION['user_info'])) {
        $_SESSION['error'] = "Данное действие доступно только для зарегистрированных пользователей";
        header('Location: /network-accounting/app/view/user/login.php');
        exit();
    }
    return $_SESSION['user_info'];
}

// Функция для проверки прав администратора
function requireAdmin($pdo) {
    $user = requireAuth($pdo);
    if ($user['role'] !== 'admin') {
        $_SESSION['error'] = "Доступ запрещён. Требуются права администратора";
        header('Location: /network-accounting/');
        exit();
    }
    return $user;
}

?>