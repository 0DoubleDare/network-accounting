<?php
session_start();
require '../../config/db.php';
require '../../app/includes/functions.php';
require '../../app/includes/auth.php';
// Проверяем авторизацию
$user = requireAuth($pdo);

$image_name = uploadImage($_FILES['image_name'], "../../storage/network_points/");
insertNetworkPoint($pdo, $_POST['label'], $_POST['type'], $_POST['location'], $_POST['status'], $image_name);

// Добавляем в лог действие
addLog($pdo, $user['user_id'], 'Добавление сетевой точки', 'network_points', $pdo->lastInsertId());

header('Location: ./inventory_view.php');
exit();
?>