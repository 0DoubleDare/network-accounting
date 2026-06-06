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

// контроллер для для работы с режимами действиями дефектов
if ($action === 'change_status') {
    $defect_id = $_GET['defect_id'] ?? 0;
    $new_status = $_GET['status'] ?? '';
    $point_id = $_GET['point_id'] ?? 0;
    // Проверяем, что статус допустимый
    $allowed_statuses = ['open', 'in_progress', 'closed'];
    if ($defect_id > 0 && in_array($new_status, $allowed_statuses)) {
        try {
            $sql = "UPDATE defects SET status = :status WHERE id = :defect_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':status' => $new_status,
                ':defect_id' => $defect_id
            ]);
            // Добавляем запись в лог
            if (isset($_SESSION['user_info']['user_id'])) {
                $status_text = '';
                if ($new_status == 'in_progress') $status_text = 'Начат';
                elseif ($new_status == 'closed') $status_text = 'Закрыт';
                addLog($pdo, $_SESSION['user_info']['user_id'], 'Изменение статуса дефекта на "' . $status_text . '"', 'defects', $defect_id);
            }
        } catch (PDOException $e) {
            error_log("Error changing defect status: " . $e->getMessage());
        }
    }
    // Перенаправляем обратно на страницу дефектов с сохранением фильтров и пагинации
    $redirect_url = "defectscontroller.php?action=index&point_id=" . $point_id . "&page=" . ($_GET['page'] ?? 1);
    if (isset($_GET['category']) && $_GET['category']) {
        $redirect_url .= "&category=" . urlencode($_GET['category']);
    }
    if (isset($_GET['severity']) && $_GET['severity']) {
        $redirect_url .= "&severity=" . urlencode($_GET['severity']);
    }
    header('Location: ' . $redirect_url);
    exit();
}

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
