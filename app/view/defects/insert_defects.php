<?php
session_start();
require '../../../config/db.php';
require '../../../app/includes/functions.php';
// ДОБАВИТЬ ДЕФЕКТ К ТОЧКЕ
$defects = defect_category($pdo);
$current_user_id = $_SESSION['user_info']['user_id'] ?? '';

$point_id = $_GET['point_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="post" action="/network-accounting/controllers/defects/insert_defects.php" enctype="multipart/form-data">
    <input type="hidden" name="point_id" value="<?= $point_id; ?>">
    <input type="hidden" name="created_by" value="<?= $current_user_id; ?>">

    <label>Категория</label><br>
    <select name="category">
        <?php foreach ($defects as $defect): ?>
            <option value="<?php echo $defect['id']; ?>"><?php echo htmlspecialchars($defect['display_name']); ?></option>
        <?php endforeach; ?>
    </select><br><br>
    <label>Критичность</label><br>
    <select name="severity">
        <option value="high">Высокий</option>
        <option value="medium">Средний</option>
        <option value="low">Низкий</option>
    </select><br><br>

    <label>Описание</label><br>
    <textarea name="description"></textarea><br><br>

    <label>Статус</label><br>
    <select name="status">
        <option value="open">Открыто</option>
        <option value="in_progress">В процессе решения</option>
        <option value="closed">Закрыто</option>
    </select><br><br>

    <input type="file" name="image_name" accept="image/*"><br><br>

    <button type="submit">Добавить дефект</button>
</form>
</body>
</html>