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
$current_image_name = $_POST['current_image_name'];

$upload_dir = '../../storage/defects/';
$image_name = $current_image_name;

if (!empty($_FILES['image_name']['tmp_name'])) {

    $uploaded_temp_name = uploadImage($_FILES['image_name'], $upload_dir);

    if ($uploaded_temp_name) {
        $new_ext = pathinfo($uploaded_temp_name, PATHINFO_EXTENSION);

        if (!empty($current_image_name)) {
            $filename_without_ext = pathinfo($current_image_name, PATHINFO_FILENAME);

            $extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            foreach ($extensions as $ext) {
                $old_file_path = $upload_dir . $filename_without_ext . '.' . $ext;
                if (file_exists($old_file_path)) {
                    unlink($old_file_path);
                }
            }
        } else {
            $filename_without_ext = pathinfo($uploaded_temp_name, PATHINFO_FILENAME);
        }

        $final_image_name = $filename_without_ext . '.' . $new_ext;
        $temp_file_path = $upload_dir . $uploaded_temp_name;
        $final_file_path = $upload_dir . $final_image_name;

        if ($temp_file_path !== $final_file_path && file_exists($temp_file_path)) {
            rename($temp_file_path, $final_file_path);
        }

        $image_name = $final_image_name;
    }
}

// Обновляем запись в базе данных
updateDefect($pdo, $id, $category, $severity, $description, $status, $image_name);

// Добавляем запись в лог
if (isset($_SESSION['user_info']['user_id'])) {
    addLog($pdo, $_SESSION['user_info']['user_id'], 'Редактирование дефекта', 'defects', $id);
}

header('Location: ../../controllers/defects/defects_view.php?point_id=' . $point_id);
exit();

function updateDefect($pdo, $id, $category, $severity, $description, $status, $image_name)
{
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
}
