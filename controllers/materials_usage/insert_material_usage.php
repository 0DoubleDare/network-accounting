<?php
session_start();
require '../../config/db.php';
require '../../app/includes/functions/material_usage.php';
require '../../app/includes/functions.php';
require '../../app/includes/auth.php';

// Проверяем авторизацию
$user = requireAuth($pdo);

insertUsageMaterials($pdo, $_POST['material_id'], $_POST['quantity'], $_POST['point_id'], $_POST['used_by'], $_POST['comment']);

// Добавляем в лог
addLog($pdo, $user['user_id'], 'Добавление расхода материала', 'material_usage', $pdo->lastInsertId());

header('Location: ../../controllers/defects/defects_view.php?point_id=' . $_POST['point_id']);
exit();
?>