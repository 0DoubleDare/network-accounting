<?php
require '../../config/db.php';
require '../includes/functions.php';
$id = $_GET['id'];
$networkPointId = networkPointId($pdo, $id)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form action="../../controllers/updateNetworkPoint.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $networkPointId['id']; ?>">

    <label>Название сетевой точки</label><br>
    <input type="text" name="label" value="<?php echo $networkPointId['label']; ?>"><br><br>

    <label>Тип</label><br>
    <select name="type">
        <option value="<?php echo $networkPointId['type']; ?>"><?php echo $networkPointId['type']; ?></option>
        <option value="socket">socket</option>
        <option value="switch">switch</option>
        <option value="cable_run">cable_run</option>
        <option value="patch_cord">patch_cord</option>
    </select><br><br>

    <label>Локация</label><br>
    <input type="text" name="location" value="<?php echo $networkPointId['location']; ?>"><br><br>

    <label>Статус</label><br>
    <select name="status" >
        <option value="<?php echo $networkPointId['status']; ?>"><?php echo $networkPointId['status']; ?></option>
        <option value="active">active</option>
        <option value="defect">defect</option>
        <option value="decommissioned">decommissioned</option>
    </select><br><br>

    <label>Текущая фотография сетевой точки</label><br>
    <textarea type="text" name="image_path" ><?php echo $networkPointId['image_path']; ?></textarea><br><br>

    <label>Фотография сетевой точки</label><br>
    <input type="file" name="image_path"><br><br>

    <button type="submit">Редактировать</button>

    </form>
</body>
</html>