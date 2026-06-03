<?php
/**
 *  Файл для проверки сессий. Здесь будет проверка зарегистрирован ли пользователь и выполнение блока кода в зависимости от результата проверки.
 *  Подключайте в тех файлах, в которых нужен зарегистрированный пользователь
*/

session_start();
require 'functions.php';
require '../config/db.php';

$user_info = checkAuthorizedUser($pdo, $_POST['login'], $_POST['password_hash']);

if(isset($user_info)){
    $_SESSION['user_info'] = $user_info;
    
    header('Location: ..\index.php');
    exit();
} else {
    echo "Ошибка логина или пароля";
}

?>