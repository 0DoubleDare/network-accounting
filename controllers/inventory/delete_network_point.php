<?php

session_start();
require '../../config/db.php';
require '../../app/includes/functions.php';
require '../../app/includes/auth.php';
// Проверяем авторизацию
$user = requireAuth($pdo);

$id = $_GET['id'];

// Сохраняем ID для лога
$point_id = $id;

deleteNetworkPoint($pdo, $id);

// Добавляем в лог действие
addLog($pdo, $user['user_id'], 'Удаление сетевой точки', 'network_points', $point_id);

header('Location: ./inventory_view.php');
exit();
?>

