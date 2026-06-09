<?php
/**
 * Функции редактирования
 */
session_start();
require '../../config/db.php';
require '../../app/includes/functions.php';

$id = $_POST['id'];
$point_id = $_POST['point_id'];
$category = $_POST['category'];
$severity = $_POST['severity'];
$description = $_POST['description'];
$status = $_POST['status'];

// Обработка загрузки изображения
$image_name = null;
if (isset($_FILES['image_name']) && $_FILES['image_name']['error'] === UPLOAD_ERR_OK) {
    $image_name = uploadImage($_FILES['image_name'], '../../storage/defects/');
}

updateDefect($pdo, $id, $category, $severity, $description, $status, $image_name);

// Добавляем запись в лог
if (isset($_SESSION['user_info']['user_id'])) {
    addLog($pdo, $_SESSION['user_info']['user_id'], 'Редактирование дефекта', 'defects', $id);
}

header('Location: ../../controllers/defects/defects_view.php?point_id=' . $point_id);
exit();

function updateDefect($pdo, $id, $category, $severity, $description, $status, $image_name)
{
    if ($image_name) {
        $sql = "UPDATE defects SET category = :category, severity = :severity, description = :description, status = :status, image_name = :image_name WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':category' => $category,
            ':severity' => $severity,
            ':description' => $description,
            ':status' => $status,
            ':image_name' => $image_name,
            ':id' => $id
        ]);
    } else {
        $sql = "UPDATE defects SET category = :category, severity = :severity, description = :description, status = :status WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':category' => $category,
            ':severity' => $severity,
            ':description' => $description,
            ':status' => $status,
            ':id' => $id
        ]);
    }
    return true;
}
?>