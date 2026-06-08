<?php
session_start(); 
require '../includes/functions.php';
require '../../config/db.php';

$materials_id = materialstId($pdo);
$pointsId = pointId($pdo);


$current_point_id = $_GET['id'] ?? ''; 

$current_user_id = $_SESSION['user_info']['user_id'] ?? ''; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Добавить расход материала</title>
</head>
<body>
    <h2>Форма списания материала</h2>
    
    <form action="../../controllers/insertUsegeMaterial.php" method="post">
        
        <input type="hidden" name="used_by" value="<?php echo htmlspecialchars($current_user_id); ?>">

        <label>Материал</label><br>
        <select name="material_id" required>
            <option value="">Выберите материал</option>
            <?php foreach($materials_id as $mat): ?>
                <option value="<?php echo $mat['id']; ?>"><?php echo htmlspecialchars($mat['name']); ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Количество/Длина</label><br>
        <input type="text" name="quantity" required><br><br>

        <label>Сетевая точка</label><br>
        <select name="point_id" required>
            <?php foreach($pointsId as $pt): ?>
                <option value="<?php echo $pt['id']; ?>" <?php echo ($pt['id'] == $current_point_id) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($pt['label']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>
        
        <label>Комментарий</label><br>
        <textarea name="comment"></textarea><br><br>

        <button type="submit">Добавить</button>
    </form>
</body>
</html>
