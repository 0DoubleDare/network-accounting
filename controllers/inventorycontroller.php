<?php
session_start();

require '../config/db.php';
require '../app/includes/functions.php';

// Пагинация
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Фильтрация
$filter = "";
$params = [];

if (!empty($_GET['label'])) {
    $filter .= " AND network_points.label LIKE :label";
    $params[':label'] = '%' . $_GET['label'] . '%';
}
if (!empty($_GET['type'])) {
    $filter .= " AND network_points.type = :type";
    $params[':type'] = $_GET['type'];
}
if (!empty($_GET['location'])) {
    $filter .= " AND network_points.location LIKE :location";
    $params[':location'] = '%' . $_GET['location'] . '%';
}
if (!empty($_GET['status'])) {
    $filter .= " AND network_points.status = :status";
    $params[':status'] = $_GET['status'];
}

// Подсчёт количества для пагинации
$sql_count = "SELECT COUNT(*) FROM network_points WHERE 1=1 $filter";
$stmt = $pdo->prepare($sql_count);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->execute();
$count_network_points = $stmt->fetchColumn();
$pages = ceil($count_network_points / $limit);

$action = $_GET['action'] ?? 'index';

if ($action === 'index') {
    $typeList = getNetworkPointTypeList($pdo);
    $statusList = getNetworkPointStatusList($pdo);
    
    // Главная функция Вывод + фильтрация (выполняет 2 действия)
    $points = getAllInventoryFiltered($pdo, $filter, $limit, $offset, $params);
    
    include '../app/includes/header.php';
    include '../app/view/inventory.php';
    include '../app/includes/footer.php';
    exit();
}
?>