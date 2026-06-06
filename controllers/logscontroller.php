<?php
session_start();

if (!isset($_SESSION['user_info']) || empty($_SESSION['user_info'])) {
    $_SESSION['error'] = "Необходимо авторизоваться";
    header('Location: ../app/view/login.php');
    exit();
}

if ($_SESSION['user_info']['role'] !== 'admin') {
    $_SESSION['error'] = "Доступ запрещён. Только для администраторов";
    header('Location: ../public/dashboard.php');
    exit();
}

// require_once __DIR__ .'/../config/db.php';
// require_once __DIR__ .'/../app/includes/functions.php';
require '../config/db.php';
require '../app/includes/functions.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
//количество записей на странице 
$perPage = 20;

$filters = [
    'user_id' => isset($_GET['user_id']) && $_GET['user_id'] !== '' ? (int)$_GET['user_id'] : '',
    'role' => isset($_GET['role']) ? trim($_GET['role']) : '',
    'action' => isset($_GET['action']) ? trim($_GET['action']) : '',
    'target_table' => isset($_GET['target_table']) ? trim($_GET['target_table']) : '',
    'date_from' => isset($_GET['date_from']) ? trim($_GET['date_from']) : '',
    'date_to' => isset($_GET['date_to']) ? trim($_GET['date_to']) : ''
];

$filters = array_filter($filters, function ($value) {
    return $value !== '' && $value !== null;
});

$logUsers = getLogUsers($pdo);
$logRoles = getLogRoles($pdo);
$logActions = getLogActions($pdo);
$logTables = getLogTables($pdo);
$result = getAllLogsFiltered($pdo, $page, $perPage, $filters);

include '../app/includes/header.php';
include '../app/view/logs.php';
include '../app/includes/footer.php';
?>