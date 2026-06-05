<?php
require '../includes/functions.php';
require '../../config/db.php';
$types = getNetworkPointTypeList($pdo);
$statuses = getNetworkPointStatusList($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавление сетевой точки</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-white">
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border">
                <div class="card-body p-4">
                    <h3 class="mb-4">Добавление сетевой точки</h3>

                    <form action="../../controllers/networckPointControler.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Название сетевой точки</label>
                            <input type="text" name="label" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Тип</label>
                            <select name="type" class="form-select">
                                <?php foreach ($types as $type): ?>
                                    <option value="<?= $type['id']?>"><?= $type['display_name']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Локация</label>
                            <input type="text" name="location" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Статус</label>
                            <select name="status" class="form-select">
                                <?php foreach ($statuses as $status): ?>
                                    <option value="<?= $status['id']?>"><?= $status['display_name']?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Фотография сетевой точки</label>
                            <input type="file" name="image_path" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>