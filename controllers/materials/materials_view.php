<?php
session_start();

require '../../config/db.php';
require '../../app/includes/functions.php';
require '../../app/includes/functions/material_usage.php';

$action = $_GET['action'] ?? 'index';

if ($action === 'index') {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    $perPage = 25;

    $filters = [
        'name' => isset($_GET['name']) ? trim($_GET['name']) : '',
        'type' => isset($_GET['type']) ? trim($_GET['type']) : '',
        'unit' => isset($_GET['unit']) ? trim($_GET['unit']) : ''
    ];
    $filters = array_filter($filters, function ($value) {
        return $value !== '' && $value !== null;
    });
// фильтрация
    $materialTypes = getMaterialTypeList($pdo);
    $materialUnits = getMaterialUnits($pdo);
// пагинация
    $result = getAllMaterialsFiltered($pdo, $page, $perPage, $filters);


    $offset = ($page - 1) * $perPage + 1;
    include '../../app/view/materials/materials.php';

    exit();
} else if ($action === 'delete') {
    $id = $_GET['id'];
    if (!checkMaterialIsUse($pdo, $id)) {
        deleteMaterials($pdo, $id);
    }
    header('Location: ./materials_view.php?action=index');
}

?>