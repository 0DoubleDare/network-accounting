<?php
session_start();

require '../config/db.php';
require '../app/includes/functions.php';

$action = $_GET['action'] ?? 'index';

if ($action === 'index') {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    $perPage = 10;
    
    $filters = [
        'material_id' => isset($_GET['material_id']) && $_GET['material_id'] !== '' ? (int)$_GET['material_id'] : '',
        'point_id' => isset($_GET['point_id']) && $_GET['point_id'] !== '' ? (int)$_GET['point_id'] : '',
        'used_by' => isset($_GET['used_by']) && $_GET['used_by'] !== '' ? (int)$_GET['used_by'] : '',
        'date_from' => isset($_GET['date_from']) ? trim($_GET['date_from']) : '',
        'date_to' => isset($_GET['date_to']) ? trim($_GET['date_to']) : ''
    ];
    $filters = array_filter($filters, function($value) {
        return $value !== '' && $value !== null;
    });
// фильтрация
    $materialsList = getMaterialsForFilter($pdo);
    $pointsList = getPointsForFilter($pdo);
    $usersList = getUsersForFilter($pdo);
// плагинация
    $result = getAllMaterialUsageFiltered($pdo, $page, $perPage, $filters);
    
    include '../app/view/material_usage.php';
    exit();
}
?>