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
    <form method="post" action="../../../controllers/defects/insert_defects.php">
        <input type="hidden" name="point_id" value="<?php echo htmlspecialchars($point_id); ?>">
                <input type="hidden" name="created_by" value="<?php echo htmlspecialchars($current_user_id); ?>">

    <label>Категория</label><br>
        <select name="category">
            <?php foreach($defects as $defect): ?>
            <option value="<?php echo $defect['id']; ?>"><?php echo htmlspecialchars($defect['display_name']); ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <label>Критичность</label><br>
        <select name="severity">
            <option value="high">high</option>
            <option value="medium">medium</option>
            <option value="low">low</option>
        </select><br><br>

        <label>Описание</label><br>
        <textarea name="description"></textarea><br><br>

        <label>Статус</label><br>
        <select name="status">
            <option value="open">open</option>
            <option value="in_progress">in_progress</option>
            <option value="closed">closed</option>
        </select><br><br>

        

        <input type="file" name="image_name"><br><br>

        <button type="submit">Добавить дефект</button>
    </form>
</body>
</html>