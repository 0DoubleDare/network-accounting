<?php
require '../../config/db.php';
require '../includes/functions.php';
$id = $_GET['id'];
$idMaterials = materialsId($pdo, $id);
$typeId = materialTypeId($pdo, $id);
$types = materialType($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post" action="../../controllers/updateMaterialsControllers.php">
    <input type="hidden" name="id" value="<?php echo $idMaterials['id']; ?>">
    
    <label>Название</label><br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($idMaterials['name']); ?>"><br><br>

        <label>тип</label><br>
        <select name="type">
            <?php foreach($types as $type): ?>
            <option value="<?= $type['id']?>"><?php echo htmlspecialchars($type['name']); ?></option>
            <?php endforeach; ?>
        </select><br><br>
        
        <label>Единица измерения</label><br>
        <select name="unit">
            <option value="m">m</option>
            <option value="pcs">pcs</option>
        </select><br><br>

        <button type="submit">Добавить</button>


    </form>
</body>
</html>