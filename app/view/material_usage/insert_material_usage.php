<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../../includes/functions.php';
require '../../includes/functions/material_usage.php';
require '../../../config/db.php';

$materials_id = materialstId($pdo);
$pointsId = pointId($pdo);

$current_point_id = $_GET['id'] ?? '';
$current_user_id = $_SESSION['user_info']['user_id'] ?? '';
?>

<!-- Подключаем шапку, как просили коллеги в README -->
<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="container my-5">
    <!-- Кнопка назад в общем стиле проекта -->
    <div class="mb-4">
        <button onclick="history.back()" class="btn btn-sm btn-outline-secondary">
            &larr; Назад
        </button>
    </div>

    <div class="row justify-content-center">
        <!-- Ограничим ширину формы, чтобы она не растягивалась на весь экран -->
        <div class="col-md-8 col-lg-6">
            
            <!-- Минималистичная карточка в стиле проекта -->
            <div class="card border-secondary-subtle bg-white shadow-sm">
                <div class="card-body p-4">
                    
                    <h2 class="h4 mb-4 fw-bold text-dark">Форма списания материала</h2>
                    
                    <form action="../../../controllers/materials_usage/insert_material_usage.php" method="post" class="row g-3">
                        <!-- Скрытое поле с ID пользователя -->
                        <input type="hidden" name="used_by" value="<?php echo htmlspecialchars($current_user_id); ?>">

                        <!-- Выбор материала -->
                        <div class="col-12">
                            <label class="form-label small fw-medium text-muted">Материал</label>
                            <select name="material_id" class="form-select" required>
                                <option value="">Выберите материал</option>
                                <?php foreach ($materials_id as $mat): ?>
                                    <option value="<?php echo $mat['id']; ?>"><?php echo htmlspecialchars($mat['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Количество/Длина -->
                        <div class="col-12">
                            <label class="form-label small fw-medium text-muted">Количество / Длина</label>
                            <input type="number" name="quantity" class="form-control" placeholder="Введите количество" required>
                        </div>

                        <!-- Сетевая точка -->
                        <div class="col-12">
                            <label class="form-label small fw-medium text-muted">Сетевая точка</label>
                            <select name="point_id" class="form-select" required>
                                <?php foreach ($pointsId as $pt): ?>
                                    <option value="<?php echo $pt['id']; ?>" <?php echo ($pt['id'] == $current_point_id) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($pt['label']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Комментарий -->
                        <div class="col-12 mb-2">
                            <label class="form-label small fw-medium text-muted">Комментарий</label>
                            <textarea name="comment" class="form-control" rows="3" placeholder="Укажите причину списания или детали..."></textarea>
                        </div>

                        <!-- Кнопка отправки формы (акцентный синий цвет из ТЗ) -->
                        <div class="col-12 pt-2">
                            <button type="submit" class="btn btn-primary w-100">Добавить расход</button>
                        </div>
                    </form>
                    
                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- Подключаем подвал -->
<?php include __DIR__ . '/../../includes/footer.php'; ?>
