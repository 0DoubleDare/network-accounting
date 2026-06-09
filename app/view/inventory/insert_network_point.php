<?php
require '../../includes/functions.php';
require '../../../config/db.php';
$types = getNetworkPointTypeList($pdo);
$statuses = getNetworkPointStatusList($pdo);
?>

<?php include '../../includes/header.php'; ?>
    <body class="bg-white">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border">
                    <div class="card-body p-4">
                        <h3 class="mb-4">Добавление сетевой точки</h3>

                        <form action="../../../controllers/inventory/insert_network_point.php" method="post"
                              enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Название сетевой точки</label>
                                <input type="text" name="label" class="form-control" required maxlength="255">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Тип</label>
                                <select name="type" class="form-select">
                                    <?php foreach ($types as $type): ?>
                                        <option value="<?php echo (int)$type['id'] ?>">
                                            <?php echo htmlspecialchars($type['display_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Локация</label>
                                <input type="text" name="location" class="form-control" required maxlength="100">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Статус</label>
                                <select name="status" class="form-select">
                                    <?php foreach ($statuses as $status): ?>
                                        <option value="<?php echo (int)$status['id'] ?>">
                                            <?php echo htmlspecialchars($status['display_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Фотография сетевой точки</label>
                                <input type="file" name="image_name" class="form-control" accept="image/*">
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Добавить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
<?php include '../../includes/footer.php'; ?>