<?php
/**
 * Учёт бракованных товаров. Список того что сломалось. Добавление дефекта или редактирование
 */
//require '../config/db.php';
//require '../app/includes/functions.php';
?>

<?php include '../../app/includes/header.php'; ?>
<div class="container my-5">

    <!-- Шапка страницы с информацией о точке -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-3 fw-bold">Информация о точке: <?= htmlspecialchars($point['label'] ?? '') ?></h1>
            
            <?php if (!empty($point['image_name'])): ?>
                <div class="mb-3">
                    <img src="../../storage/network_points/<?= $point['image_name'] ?>" class="img-thumbnail"
                        alt="Изображение точки <?= htmlspecialchars($point['label']) ?>" style="max-height: 250px;">
                </div>
            <?php endif; ?>

            <div class="text-muted small mb-4">
                <span class="me-3"><strong>Расположение:</strong> <?= htmlspecialchars($point['location'] ?? '—') ?></span>
                <span><strong>Статус точки:</strong> <?= htmlspecialchars($point['status_name'] ?? '—') ?></span>
            </div>
            
            <!-- Навигационная панель с кнопками в едином стиле проекта -->
            <div class="d-flex flex-wrap gap-2 mb-3">
                <a href="../inventory/inventory_view.php?action=index" class="btn btn-sm btn-outline-secondary">
                    &larr; Назад к точкам
                </a>
                
                <a href="../materials_usage/materials_usage_view.php?action=index&point_label=<?= urlencode($point['label'] ?? '') ?>"
                    class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-list me-1"></i> Расход материалов по точке
                </a>
                
                <!-- Теперь ссылка передаёт ID точки в GET-параметре, и форма заполнится автоматически! -->
                <a href="../../app/view/material_usage/insert_material_usage.php?id=<?= htmlspecialchars($point['id'] ?? '') ?>" 
                    class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i> Добавить списание
                </a>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <h2 class="h4 mb-2 fw-bold text-dark">Дефекты точки</h2>

            <?php if (!empty($point['image_path'])): ?>
                <div class="mt-2">
                    <img src="../public/storage/defects/<?= htmlspecialchars($point['image_path']) ?>" alt="Фото точки"
                        class="img-thumbnail" style="max-height: 150px;">
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Навигация и Форма фильтрации -->
    <div class="row mb-4">
        <div class="col-12">

            <!-- Минималистичная карточка фильтра (наш золотой стандарт) -->
            <div class="card border-secondary-subtle bg-white">
                <div class="card-body p-4">
                    <form method="get" class="row g-3">
                        <input type="hidden" name="action" value="index">
                        <input type="hidden" name="point_id" value="<?= $point_id ?>">

                        <!-- Категория -->
                        <div class="col-md-3">
                            <label class="form-label small fw-medium text-muted">Категория</label>
                            <select name="category" class="form-select form-select-sm">
                                <option value="">Все</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['name'] ?>" <?= $_GET['category'] == $category['name'] ? 'selected' : '' ?>>
                                        <?= $category['display_name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Критичность -->
                        <div class="col-md-3">
                            <label class="form-label small fw-medium text-muted">Критичность</label>
                            <select name="severity" class="form-select form-select-sm">
                                <option value="">Все</option>
                                <option value="high" <?= ($_GET['severity'] ?? '') === 'high' ? 'selected' : '' ?>>
                                    Высокая
                                </option>
                                <option value="medium" <?= ($_GET['severity'] ?? '') === 'medium' ? 'selected' : '' ?>>
                                    Средняя
                                </option>
                                <option value="low" <?= ($_GET['severity'] ?? '') === 'low' ? 'selected' : '' ?>>
                                    Низкая
                                </option>
                            </select>
                        </div>

                        <!-- Статус -->
                        <div class="col-md-3">
                            <label class="form-label small fw-medium text-muted">Статус</label>
                            <select name="status" class="form-select form-select-sm">
                                <option value="">Все</option>
                                <option value="open" <?= ($_GET['status'] ?? '') === 'open' ? 'selected' : '' ?>>
                                    Открыт
                                </option>
                                <option value="in_progress" <?= ($_GET['status'] ?? '') === 'in_progress' ? 'selected' : '' ?>>
                                    В работе
                                </option>
                                <option value="closed" <?= ($_GET['status'] ?? '') === 'closed' ? 'selected' : '' ?>>
                                    Закрыт
                                </option>
                            </select>
                        </div>

                        <!-- Кнопки управления -->
                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-sm btn-primary w-50">Применить</button>
                            <a href="?action=index&point_id=<?= $point_id ?>&category=&severity=&status="
                            class="btn btn-sm btn-outline-secondary w-50 text-center">Сбросить</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Строгая таблица с дефектами -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="table-responsive card border-secondary-subtle bg-white">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted small">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Категория</th>
                        <th>Критичность</th>
                        <th>Описание</th>
                        <th>Статус</th>
                        <th>Автор</th>
                        <th>Дата</th>
                        <th class="pe-4 text-end">Фото дефекта</th> <!-- Выровняли заголовок по правому краю -->
                    </tr>
                    </thead>
                    <tbody class="small">
                    <?php if (empty($defects)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                Дефектов по заданным критериям не найдено.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($defects as $defect): ?>
                            <tr>
                                <td class="ps-4 fw-bold"><?= htmlspecialchars($defect['id']) ?></td>
                                <td><?= htmlspecialchars($defect['category'] ?? '—') ?></td>
                                <td>
                                    <span class="badge bg-light text-dark border"><?= htmlspecialchars($defect['severity'] ?? '—') ?></span>
                                </td>
                                <td class="text-wrap" style="max-width: 300px;"><?= htmlspecialchars($defect['description'] ?? '') ?></td>
                                <td>
                                    <span class="badge bg-light text-dark border border-secondary-subtle">
                                        <?= htmlspecialchars($defect['status'] ?? '') ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($defect['author'] ?? '—') ?></td>
                                <td class="text-muted"><?= htmlspecialchars($defect['created_at'] ?? '') ?></td>
                                <td class="pe-4 text-end"> <!-- Ячейка с кнопкой просмотра фотки -->
                                    <?php if (!empty($defect['image_name'])): ?>
                                        <!-- Уникальная кнопка открытия для конкретного ID дефекта -->
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('openImage<?= $defect['id'] ?>').showModal()">
                                            <i class="fas fa-image me-1"></i> Просмотр
                                        </button>
                                        
                                        <!-- Уникальное диалоговое окно -->
                                        <dialog id="openImage<?= $defect['id'] ?>" class="border-0 rounded-3 shadow-lg p-4 text-center" style="max-width: 500px; outline: none; background: white;">
                                            <div class="d-flex justify-content-end mb-2">
                                                <button type="button" class="btn-close" onclick="document.getElementById('openImage<?= $defect['id'] ?>').close()"></button>
                                            </div>
                                            <img src="../public/storage/defects/<?= htmlspecialchars($defect['image_name']) ?>"
                                                alt="Изображение дефекта" class="img-fluid rounded mb-2">
                                            <p class="text-muted small mb-0">Кликните на крестик или нажмите Esc для закрытия</p>
                                        </dialog>
                                    <?php else: ?>
                                        <span class="text-muted small">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Пагинация от пацанов с нашими аккуратными рамками -->
    <?php if (isset($pages) && $pages > 1): ?>
        <div class="row">
            <div class="col-12">
                <nav aria-label="Навигация по страницам">
                    <ul class="pagination justify-content-center">

                        <!-- Назад -->
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link text-secondary border-secondary-subtle small"
                                href="?action=index&point_id=<?= $point_id ?>&page=<?= $page - 1 ?>&category=<?= urlencode($_GET['category'] ?? '') ?>&severity=<?= urlencode($_GET['severity'] ?? '') ?>&status=<?= urlencode($_GET['status'] ?? '') ?>">←
                                Назад</a>
                        </li>

                        <!-- Номера страниц -->
                        <?php for ($i = 1; $i <= $pages; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <?php if ($i == $page): ?>
                                    <span class="page-link bg-secondary border-secondary text-white small"><?= $i ?></span>
                                <?php else: ?>
                                    <a class="page-link text-secondary border-secondary-subtle small"
                                        href="?action=index&point_id=<?= $point_id ?>&page=<?= $i ?>&category=<?= urlencode($_GET['category'] ?? '') ?>&severity=<?= urlencode($_GET['severity'] ?? '') ?>&status=<?= urlencode($_GET['status'] ?? '') ?>"><?= $i ?></a>
                                <?php endif; ?>
                            </li>
                        <?php endfor; ?>

                        <!-- Вперёд -->
                        <li class="page-item <?= ($page >= $pages) ? 'disabled' : '' ?>">
                            <a class="page-link text-secondary border-secondary-subtle small"
                                href="?action=index&point_id=<?= $point_id ?>&page=<?= $page + 1 ?>&category=<?= urlencode($_GET['category'] ?? '') ?>&severity=<?= urlencode($_GET['severity'] ?? '') ?>&status=<?= urlencode($_GET['status'] ?? '') ?>">
                                Вперёд →
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </div>
    <?php endif; ?>

</div>
<?php include '../../app/includes/footer.php'; ?>
