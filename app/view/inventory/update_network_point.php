<?php
require '../../../config/db.php';
require '../../includes/functions.php';
$id = $_GET['id'];
$networkPointInfo = networkPointInfo($pdo, $id);
$types = getNetworkPointTypeList($pdo);
$statuses = getNetworkPointStatusList($pdo);
?>


<?php include '../../includes/header.php'; ?>
    <title>Редактирование точки</title>

    <!--    <form action="../../controllers/updateNetworkPoint.php" method="post" enctype="multipart/form-data">-->
    <!--    <input type="hidden" name="id" value="--><?php //echo $networkPointInfo['id']; ?><!--">-->
    <!---->
    <!---->
    <!--    <head>-->
    <!--        <meta charset="UTF-8">-->
    <!--        <meta name="viewport" content="width=device-width, initial-scale=1.0">-->
    <!--        <title>Редактирование сетевой точки</title>-->
    <!--        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <!--    </head>-->
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border">
                    <div class="card-body p-4">
                        <h3 class="mb-4">Редактирование сетевой точки</h3>

                        <form action="../../../controllers/inventory/update_network_point.php" method="post"
                              enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $networkPointInfo['id']; ?>">


                            <div class="mb-3">
                                <label class="form-label">Название сетевой точки</label>
                                <input type="text" name="label" class="form-control"
                                    value="<?php echo htmlspecialchars($networkPointInfo['label']); ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Тип</label>
                                <select name="type" class="form-select">
                                    <?php foreach ($types as $type): ?>
                                        <option value="<?php echo (int)$type['id'] ?>" 
                                        <?php echo $type['id'] == $networkPointInfo['type'] ? 'selected' : '' ?>>
                                        <?php echo htmlspecialchars($type['display_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Локация</label>
                                <input type="text" name="location" class="form-control"
                                    value="<?php echo htmlspecialchars($networkPointInfo['location']); ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Статус</label>
                                <select name="status" class="form-select">
                                    <?php foreach ($statuses as $status): ?>
                                        <option value="<?php echo (int)$status['id'] ?>"
                                        <?php echo $status['id'] == $networkPointInfo['status'] ? 'selected' : '' ?>>
                                        <?php echo htmlspecialchars($status['display_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php if (!empty($networkPointInfo)): ?>
                                <div class="mb-3">
                                    <label class="form-label">Текущая фотография сетевой точки</label><br>
                                    <img src="../../public/storage/network_points/<?php echo htmlspecialchars($networkPointInfo['image_name']); ?>"
                                    alt="Изображение сетевой точки <?php echo htmlspecialchars($networkPointInfo['label']); ?>">
                                </div>
                            <?php endif; ?>
                            <div class="mb-3">
                                <label class="form-label">Новая отография сетевой точки</label>
                                <input type="file" name="image_name" class="form-control" accept="image/*">
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Редактировать</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include '../../includes/footer.php'; ?>