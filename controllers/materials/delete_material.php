<?php
session_start();
require '../../config/db.php';
require '../../app/includes/functions.php';
require '../../app/includes/auth.php';

// Проверяем авторизацию
$user = requireAuth($pdo);

$id = $_POST['id'];
$material_id = $id;

deleteMaterials($pdo, $id);

// Добавляем в лог
addLog($pdo, $user['user_id'], 'Удаление материала', 'materials', $material_id);

header('Location: ../app/view/materials.php');
exit();
?>