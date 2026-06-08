<?php
session_start();
require '../../config/db.php';
require '../../app/includes/functions.php';
require '../../app/includes/auth.php';
// Проверяем авторизацию
$user = requireAuth($pdo);

insertMaterials($pdo, $_POST['name'], $_POST['type'], $_POST['unit']);

// Добавляем в лог
addLog($pdo, $user['user_id'], 'Добавление материала', 'materials', $pdo->lastInsertId());

header('Location: ./materials_view.php');
exit();
?>