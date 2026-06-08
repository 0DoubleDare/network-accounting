<?php
session_start();

require '../config/db.php';
require '../app/includes/functions.php';

//Пагинация
$limit = 1;
$categories = getDefectCategories($pdo);

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = $limit * ($page - 1);

//Фильтрация
$filter = "";
if (isset($_GET['category']) && $_GET['category']) {
    $filter .= " AND category = '" . $_GET['category'] . "'";
}
if (isset($_GET['severity']) && $_GET['severity']) {
    $filter .= " AND severity = '" . $_GET['severity'] . "'";
}
if (isset($_GET['status']) && $_GET['status']) {
    $filter .= " AND status = '" . $_GET['status'] . "'";
}

$sql_count = "SELECT COUNT(id) FROM defects WHERE point_id = :point_id $filter";

$stmt = $pdo->prepare($sql_count);
$stmt->execute([':point_id' => $_GET['point_id']]);
$count_defects = $stmt->fetchColumn();

//Следующая запись
$next_page = $page + 1;
//Предыдущая запись
$previous_defects = $page - 1;
//Узнаем количество страниц
$pages = ceil($count_defects / $limit);

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

    $defects = getDefectsWithFilter($pdo, $point_id, $filter, $limit, $offset);

//include '../app/includes/header.php';
    include '../app/view/defects.php';
//include '../app/includes/footer.php';
    exit();
}
?>
