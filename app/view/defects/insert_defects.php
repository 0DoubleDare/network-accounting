<?php
session_start();
require '../../../config/db.php';
require '../../../app/includes/functions.php';

// ДОБАВИТЬ ДЕФЕКТ К ТОЧКЕ
$defects = defect_category($pdo);
$current_user_id = $_SESSION['user_info']['user_id'] ?? '';
$point_id = $_GET['point_id'] ?? '';
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
                    
                    <h2 class="h4 mb-4 fw-bold text-dark">Добавление дефекта</h2>
                    
                    <form method="post" action="../../../controllers/defects/insert_defects.php" enctype="multipart/form-data" class="row g-3">
                        <!-- Скрытые поля -->
                        <input type="hidden" name="point_id" value="<?php echo htmlspecialchars($point_id); ?>">
                        <input type="hidden" name="created_by" value="<?php echo htmlspecialchars($current_user_id); ?>">

                        <!-- Категория дефекта -->
                        <div class="col-12">
                            <label class="form-label small fw-medium text-muted">Категория</label>
                            <select name="category" class="form-select" required>
                                <option value="">Выберите категорию</option>
                                <?php foreach ($defects as $defect): ?>
                                    <option value="<?php echo $defect['id']; ?>">
                                        <?php echo htmlspecialchars($defect['display_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Критичность и статус в одной строке -->
                        <div class="col-md-6">
                            <label class="form-label small fw-medium text-muted">Критичность</label>
                            <select name="severity" class="form-select" required>
                                <option value="high">Высокий</option>
                                <option value="medium">Средний</option>
                                <option value="low">Низкий</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-medium text-muted">Статус</label>
                            <select name="status" class="form-select" required>
                                <option value="open">Открыто</option>
                                <option value="in_progress">В процессе решения</option>
                                <option value="closed">Закрыто</option>
                            </select>
                        </div>

                        <!-- Описание -->
                        <div class="col-12">
                            <label class="form-label small fw-medium text-muted">Описание</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Опишите проблему подробнее..." required></textarea>
                        </div>

                        <!-- Загрузка изображения -->
                        <div class="col-12">
                            <label class="form-label small fw-medium text-muted">Изображение (опционально)</label>
                            <input type="file" name="image_name" class="form-control" accept="image/*">
                            <div class="form-text small text-muted mt-1">Поддерживаются JPG, PNG, GIF</div>
                        </div>

                        <!-- Кнопка отправки формы (акцентный синий цвет из ТЗ) -->
                        <div class="col-12 pt-2">
                            <button type="submit" class="btn btn-primary w-100">Добавить дефект</button>
                        </div>
                    </form>
                    
                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- Подключаем подвал -->
<?php include __DIR__ . '/../../includes/footer.php'; ?>
