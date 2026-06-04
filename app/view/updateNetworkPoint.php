<?php
require '../../config/db.php';
require '../includes/functions.php';
$id = $_GET['id'];
$networkPointInfo = networkPointInfo($pdo, $id);
$types = getNetworkPointTypeList($pdo);
$statuses = getNetworkPointStatusList($pdo);
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
    <input type="hidden" name="id" value="<?php echo $networkPointInfo['id']; ?>">

    <label>Название сетевой точки</label><br>
    <input type="text" name="label" value="<?php echo $networkPointInfo['label']; ?>"><br><br>

    <label>Тип</label><br>
        <select name="type">
            <?php foreach ($types as $type): ?>
                <option value="<?= $type['id']?>" <?= $type['id'] == $networkPointInfo['type'] ? 'selected' : ''?>>
                    <?= $type['display_name']?>
                </option>
            <?php endforeach; ?>
        </select><br><br>
    <label>Локация</label><br>
    <input type="text" name="location" value="<?php echo $networkPointInfo['location']; ?>"><br><br>

    <label>Статус</label><br>
    <select name="status" >
        <?php foreach ($statuses as $status): ?>
            <option value="<?= $status['id']?>" <?= $status['id'] == $networkPointInfo['status'] ? 'selected' : ''?>>
                <?= $status['display_name']?>
            </option>
        <?php endforeach; ?>
<!--        <option value="--><?php //echo $networkPointId['status']; ?><!--">--><?php //echo $networkPointId['status']; ?><!--</option>-->
<!--        <option value="active">active</option>-->
<!--        <option value="defect">defect</option>-->
<!--        <option value="decommissioned">decommissioned</option>-->
    </select><br><br>

    <label>Текущая фотография сетевой точки</label><br>
    <textarea type="text" name="image_path" ><?php echo $networkPointInfo['image_path']; ?></textarea><br><br>

    <label>Фотография сетевой точки</label><br>
    <input type="file" name="image_path"><br><br>

    <button type="submit">Редактировать</button>

    </form>
</body>
</html>