<?php
session_start();

require '../../config/db.php';
require '../../app/includes/functions.php';

$action = $_GET['action'] ?? 'index';

if ($action === 'index') {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    $perPage = 25;

    $filters = [
        'material_id' => isset($_GET['material_id']) && $_GET['material_id'] !== '' ? (int)$_GET['material_id'] : '',
        'point_label' => isset($_GET['point_label']) ? trim($_GET['point_label']) : '',
        'used_by_login' => isset($_GET['used_by_login']) ? trim($_GET['used_by_login']) : '',
        'date_from' => isset($_GET['date_from']) ? trim($_GET['date_from']) : '',
        'date_to' => isset($_GET['date_to']) ? trim($_GET['date_to']) : ''
    ];
    $filters = array_filter($filters, function ($value) {
        return $value !== '' && $value !== null;
    });
// фильтрация
    $materialsList = getMaterialsForFilter($pdo);

// плагинация
    $result = getAllMaterialUsageFiltered($pdo, $page, $perPage, $filters);

    $offset = ($page - 1) * $perPage + 1;
    include '../../app/view/material_usage/material_usage.php';
    exit();
}
?>