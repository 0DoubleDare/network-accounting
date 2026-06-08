<?php
session_start();

require '../config/db.php';
require '../app/includes/functions.php';


$action = $_GET['action'] ?? 'index';

if ($action === 'index') {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    $perPage = 3;
    
    $filters = [
        'name' => isset($_GET['name']) ? trim($_GET['name']) : '',
        'type' => isset($_GET['type']) ? trim($_GET['type']) : '',
        'unit' => isset($_GET['unit']) ? trim($_GET['unit']) : ''
    ];
    $filters = array_filter($filters, function($value) {
        return $value !== '' && $value !== null;
    });
// фильтрация
    $materialTypes = getMaterialTypeList($pdo);
    $materialUnits = getMaterialUnits($pdo);
// плагинация
    $result = getAllMaterialsFiltered($pdo, $page, $perPage, $filters);

    
    include '../app/view/materials.php';
    
    exit();
}
?>