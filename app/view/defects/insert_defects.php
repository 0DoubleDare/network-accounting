<?php
session_start();
require '../../../config/db.php';
require '../../../app/includes/functions.php';
// ДОБАВИТЬ ДЕФЕКТ К ТОЧКЕ
$defects = defect_category($pdo);
$current_user_id = $_SESSION['user_info']['user_id'] ?? '';

$point_id = $_GET['point_id'];
?>

<?php include '../../includes/header.php'; ?>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border">
                    <div class="card-body p-4">
                        <h3 class="mb-4">Добавление дефекта</h3>

                        <form method="post" action="../../../controllers/defects/insert_defects.php"
                              enctype="multipart/form-data">
                            <input type="hidden" name="point_id" value="<?= $point_id; ?>">
                            <input type="hidden" name="created_by" value="<?= $current_user_id; ?>">

                            <div class="mb-3">
                                <label class="form-label">Категория</label>
                                <select name="category" class="form-select">
                                    <?php foreach ($defects as $defect): ?>
                                        <option value="<?php echo $defect['id']; ?>"><?php echo htmlspecialchars($defect['display_name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Критичность</label>
                                <select name="severity" class="form-select">
                                    <option value="high">Высокая</option>
                                    <option value="medium">Средняя</option>
                                    <option value="low">Низкая</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Описание</label>
                                <textarea name="description" class="form-control" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <!--                                <label class="form-label">Статус</label>-->
                                <!--                                <select name="status" class="form-select">-->
                                <!--                                    <option value="open">Открыто</option>-->
                                <!--                                    <option value="in_progress">В процессе решения</option>-->
                                <!--                                    <option value="closed">Закрыто</option>-->
                                <!--                                </select>-->
                                <input type="hidden" value="open" name="status">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Фотография дефекта</label>
                                <input type="file" name="image_name" class="form-control" accept="image/*">
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Добавить дефект</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include '../../includes/footer.php'; ?>