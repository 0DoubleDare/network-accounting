<?php
session_start();
require '../../config/db.php';
require '../../app/includes/functions.php';
require '../../app/includes/auth.php';
// Проверяем авторизацию
$user = requireAuth($pdo);

$id = $_POST['id'];
updateMaterials($pdo, $id, $_POST['name'], $_POST['type'], $_POST['unit']);

// Добавляем в лог
addLog($pdo, $user['user_id'], 'Редактирование материала', 'materials', $id);

header('Location: ./materials_view.php');
exit();
?>
