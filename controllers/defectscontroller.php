<?php
session_start();

require dirname(__DIR__) . '/config/db.php';
require dirname(__DIR__) . '/app/includes/functions.php';

$action = $_GET['action'] ?? 'index';
$point_id = $_GET['point_id'] ?? 0;

if ($action === 'index') {
    if ($point_id <= 0) {
        header('Location: ../controllers/inventorycontroller.php?action=index');
        exit();
    }
    
    $point = getIDDefects($pdo, $point_id);

    if (!$point) {
        header('Location: ../controllers/inventorycontroller.php?action=index');
        exit();
    }
    
    $defects = getAllDefects($pdo, $point_id);
include '../app/includes/header.php';
include '../app/view/defects.php';
include '../app/includes/footer.php';
    exit();
}