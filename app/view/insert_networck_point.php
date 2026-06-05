<?php
require '../includes/functions.php';
require '../../config/db.php';
$types = getNetworkPointTypeList($pdo);
$statuses = getNetworkPointStatusList($pdo);

?>
<?php include '../includes/header.php'; ?>
</head>
<body>
    <form action="../../controllers/networckPointControler.php" method="post" enctype="multipart/form-data">
    
    <label>Название сетевой точки</label><br>
    <input type="text" name="label"><br><br>

    <label>Тип</label><br>
    <select name="type">
        <?php foreach ($types as $type): ?>
            <option value="<?= $type['id']?>"><?= $type['display_name']?></option>
        <?php endforeach; ?>
    </select><br><br>


    <label>Локация</label><br>
    <input type="text" name="location"><br><br>

    <label>Статус</label><br>
    <select name="status">
        <?php foreach ($statuses as $status): ?>
            <option value="<?= $status['id']?>"><?= $status['display_name']?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Фотография сетевой точки</label><br>
    <input type="file" name="image_path"><br><br>

    <button type="submit">Добавить</button>

    </form>
</body>
<?php include '../includes/footer.php'; ?>