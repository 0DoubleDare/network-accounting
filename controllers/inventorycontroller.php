<?php
require __DIR__ . '/../app/includes/functions.php';

$action = $_GET['action'] ?? 'index';

if($action === 'index'){
    $points = getAllInventory($pdo);
    include '../app/view/inventory.php';
    exit();
}
?>