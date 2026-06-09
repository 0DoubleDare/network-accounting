<?php
/**
 * Редактирование дефекта
 */
require '../../../config/db.php';
require '../../includes/functions.php';

$id = $_GET['id'] ?? 0;
$point_id = $_GET['point_id'] ?? 0;

if ($id <= 0) {
    header('Location: ../inventory/inventory_view.php?action=index');
    exit();
}

// Получаем данные дефекта
$sql = "SELECT d.*, dc.display_name AS category_name 
        FROM defects d
        LEFT JOIN defect_category dc ON d.category = dc.id
        WHERE d.id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$defect = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$defect) {
    header('Location: ../inventory/inventory_view.php?action=index');
    exit();
}

// Получаем список категорий
$categories = getDefectCategories($pdo);
?>

<?php include '../../includes/header.php'; ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border">
                <div class="card-body p-4">
                    <h3 class="mb-4">Редактирование дефекта</h3>

                    <form action="../../../controllers/defects/update_defect.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $defect['id']; ?>">
                        <input type="hidden" name="point_id" value="<?php echo $defect['point_id']; ?>">

                        <div class="mb-3">
                            <label class="form-label">Описание дефекта</label>
                            <textarea name="description" class="form-control" rows="3" required><?php echo htmlspecialchars($defect['description'] ?? ''); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Категория</label>
                            <select name="category" class="form-select">
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>" 
                                        <?php echo $cat['id'] == $defect['category'] ? 'selected' : '' ?>>
                                        <?php echo htmlspecialchars($cat['display_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Критичность</label>
                            <select name="severity" class="form-select">
                                <option value="low" <?php echo $defect['severity'] == 'low' ? 'selected' : ''; ?>>Низкая</option>
                                <option value="medium" <?php echo $defect['severity'] == 'medium' ? 'selected' : ''; ?>>Средняя</option>
                                <option value="high" <?php echo $defect['severity'] == 'high' ? 'selected' : ''; ?>>Высокая</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Статус</label>
                            <select name="status" class="form-select">
                                <option value="open" <?php echo $defect['status'] == 'open' ? 'selected' : ''; ?>>Открыт</option>
                                <option value="in_progress" <?php echo $defect['status'] == 'in_progress' ? 'selected' : ''; ?>>В работе</option>
                                <option value="closed" <?php echo $defect['status'] == 'closed' ? 'selected' : ''; ?>>Закрыт</option>
                            </select>
                        </div>

                        <?php if (!empty($defect['image_name'])): ?>
                        <div class="mb-3">
                            <label class="form-label">Текущая фотография</label><br>
                            <img src="../../storage/defects/<?php echo htmlspecialchars($defect['image_name']); ?>" 
                                alt="Фото дефекта" style="max-width: 200px;">
                        </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label">Новая фотография</label>
                            <input type="file" name="image_name" class="form-control" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Сохранить изменения</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>