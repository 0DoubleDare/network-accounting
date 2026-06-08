<?php
session_start();
require '../../config/db.php';
require '../../app/includes/functions.php';
require '../../app/includes/auth.php';
// Проверяем авторизацию
$user = requireAuth($pdo);

$id = $_POST['id'];
updateNetworkPoint($pdo, $id, $_POST['label'], $_POST['type'], $_POST['location'], $_POST['status'], $_FILES['image_name']);

// Добавляем в лог действие
addLog($pdo, $user['user_id'], 'Редактирование сетевой точки', 'network_points', $id);

header('Location: ./inventory_view.php');
exit();
?>