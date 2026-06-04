<?php
session_start();

if (!isset($_SESSION['user_info']) || empty($_SESSION['user_info'])) {
    $_SESSION['error'] = "Необходимо авторизоваться";
    header('Location: ../app/view/login.php');
    exit();
}

if ($_SESSION['user_info']['role'] !== 'admin') {
    $_SESSION['error'] = "Доступ запрещён. Только для администраторов";
    header('Location: ../public/index.php');
    exit();
}

// require_once __DIR__ .'/../config/db.php';
// require_once __DIR__ .'/../app/includes/functions.php';
require '../config/db.php';
require '../app/includes/functions.php';

$action = $_GET['action'] ?? 'index';

if ($action === 'index') {
    $logs = getAllLogs($pdo);
    
    include '../app/includes/header.php';
    include '../app/view/logs.php';
    include '../app/includes/footer.php';
    exit();
}