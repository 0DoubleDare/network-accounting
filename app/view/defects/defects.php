<?php
/**
 * Учёт бракованных товаров. Список того что сломалось. Добавление дефекта или редактирование
 */
?>

<?php include __DIR__ . '/../../includes/header.php'; ?>
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

            <!-- Навигационная панель с кнопками -->
            <div class="d-flex flex-wrap gap-2 mb-3">
                <a href="../inventory/inventory_view.php?action=index" class="btn btn-sm btn-outline-secondary">
                    &larr; Назад к точкам
                </a>
                <a href="../materials_usage/materials_usage_view.php?action=index&point_label=<?= urlencode($point['label'] ?? '') ?>"
                    class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-list me-1"></i> Расход материалов по точке
                </a>
                <a href="../../app/view/material_usage/insert_material_usage.php?id=<?= htmlspecialchars($point['id'] ?? '') ?>"
                    class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i> Добавить списание
                </a>
            </div>
        </div>
    </div>

    <!-- Дефекты точки -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="h4 mb-2 fw-bold text-dark">Дефекты точки</h2>
            <a href="/network-accounting/app/view/defects/insert_defects.php?point_id=<?= $point_id ?>" class="btn btn-sm btn-primary mb-3">+ Добавить дефект</a>
        </div>
    </div>

    <!-- Форма фильтрации -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-secondary-subtle">
                <div class="card-body p-4">
                    <form method="get" class="row g-3">
                        <input type="hidden" name="action" value="index">
                        <input type="hidden" name="point_id" value="<?= $point_id ?>">

                        <div class="col-md-3">
                            <label class="form-label small fw-medium text-muted">Категория</label>
                            <select name="category" class="form-select">
                                <option value="">Все</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['name'] ?>" <?= $category['name'] ? 'selected' : '' ?>>
                                        <?= $category['display_name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-medium text-muted">Критичность</label>
                            <select name="severity" class="form-select">
                                <option value="">Все</option>
                                <option value="high" <?= ($_GET['severity'] ?? '') === 'high' ? 'selected' : '' ?>>Высокая</option>
                                <option value="medium" <?= ($_GET['severity'] ?? '') === 'medium' ? 'selected' : '' ?>>Средняя</option>
                                <option value="low" <?= ($_GET['severity'] ?? '') === 'low' ? 'selected' : '' ?>>Низкая</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-medium text-muted">Статус</label>
                            <select name="status" class="form-select">
                                <option value="">Все</option>
                                <option value="open" <?= ($_GET['status'] ?? '') === 'open' ? 'selected' : '' ?>>Открыт</option>
                                <option value="in_progress" <?= ($_GET['status'] ?? '') === 'in_progress' ? 'selected' : '' ?>>В работе</option>
                                <option value="closed" <?= ($_GET['status'] ?? '') === 'closed' ? 'selected' : '' ?>>Закрыт</option>
                            </select>
                        </div>

                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-sm btn-primary">Применить</button>
                            <a href="?action=index&point_id=<?= $point_id ?>" class="btn btn-sm btn-outline-secondary">Сбросить</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Таблица с дефектами -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="table-responsive card border-secondary-subtle bg-white">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted small">
                    <tr>
                        <th>№</th>
                        <?php if (($_SESSION['user_info']['role'] ?? 'null') === 'admin'): ?>
                            <th class="ps-4">ID</th>
                        <?php endif; ?>
                        <th>Категория</th>
                        <th>Критичность</th>
                        <th>Описание</th>
                        <th>Статус</th>
                        <th>Автор</th>
                        <th class="pe-4">Дата</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody class="small">

                    
                        
                    

                    <?php if (empty($defects)): ?>
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">
                                Дефектов по заданным критериям не найдено.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($defects as $defect): ?>
                            <tr>
                                <td class="ps-4"><?= $offset++ + 1 ?></td>
                                <?php if (($_SESSION['user_info']['role'] ?? 'null') == 'admin'): ?>
                                <td class="ps-4 fw-bold"><?= htmlspecialchars($defect['id']) ?></td>
                                <?php endif; ?>
                                <td><?= htmlspecialchars($defect['category'] ?? '—') ?></td>
                                <td><?= htmlspecialchars($defect['severity'] ?? '—') ?></td>
                                <td><?= htmlspecialchars($defect['description'] ?? '') ?></td>
                                <td>
                                    <?php
                                    $status = $defect['status'] ?? '';
                                    if ($status == 'open') {
                                        $statusColor = 'green';
                                        $statusText = 'Открыт';
                                    } elseif ($status == 'in_progress') {
                                        $statusColor = 'orange';
                                        $statusText = 'В работе';
                                    } elseif ($status == 'closed') {
                                        $statusColor = 'red';
                                        $statusText = 'Закрыт';
                                    } else {
                                        $statusColor = 'black';
                                        $statusText = htmlspecialchars($status);
                                    }
                                    ?>
                                    <span style="color: <?= $statusColor ?>; font-weight: 500;"><?= $statusText ?></span>
                                </td>
                                <td><?= htmlspecialchars($defect['author'] ?? '—') ?></td>
                                <td><?= htmlspecialchars($defect['created_at'] ?? '') ?></td>
                                <td class="pe-4 text-end">
                                    <?php if (!empty($defect['image_name'])): ?>
                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                                onclick="document.getElementById('openImage<?= $defect['id'] ?>').showModal()">
                                            <i class="fas fa-image me-1"></i> Просмотр
                                        </button>
                                        <dialog id="openImage<?= $defect['id'] ?>"
                                                class="border-0 rounded-3 shadow-lg p-4 text-center"
                                                style="max-width: 500px; outline: none; background: white;">
                                            <div class="d-flex justify-content-end mb-2">
                                                <button type="button" class="btn-close"
                                                        onclick="document.getElementById('openImage<?= $defect['id'] ?>').close()"></button>
                                            </div>
                                            <img src="../public/storage/defects/<?= htmlspecialchars($defect['image_name']) ?>"
                                                alt="Изображение дефекта" class="img-fluid rounded mb-2">
                                            <p class="text-muted small mb-0">Нажмите Esc или крестик для закрытия</p>
                                        </dialog>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td class="pe-4">
                                    <?php if ($defect['status'] == 'open'): ?>
                                        <a href="?action=change_status&defect_id=<?= $defect['id'] ?>&point_id=<?= $point_id ?>&status=in_progress" class="btn btn-sm btn-link">Начать работу</a>
                                    <?php elseif ($defect['status'] == 'in_progress'): ?>
                                        <a href="?action=change_status&defect_id=<?= $defect['id'] ?>&point_id=<?= $point_id ?>&status=closed" class="btn btn-sm btn-link">Исправлено</a>
                                    <?php else: ?>
                                        <a href="?action=change_status&defect_id=<?= $defect['id'] ?>&point_id=<?= $point_id ?>&status=open" class="btn btn-sm btn-link">Переоткрыть</a>
                                    <?php endif; ?>
                                    <a href="../../app/view/defects/update_defects.php?id=<?= $defect['id'] ?>&point_id=<?= $point_id ?>" class="btn btn-sm btn-outline-secondary">Изменить</a>
                                    <a href="../../controllers/defects/delete_defect.php?id=<?= $defect['id'] ?>&point_id=<?= $point_id ?>" 
                                        class="btn btn-sm btn-outline-danger" 
                                        onclick="return confirm('Удалить дефект?')">Удалить</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Пагинация -->
    <?php if (isset($pages) && $pages > 1): ?>
        <div class="row">
            <div class="col-12">
                <nav aria-label="Навигация по страницам">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link text-dark border-secondary-subtle"
                                href="?action=index&point_id=<?= $point_id ?>&page=<?= $page - 1 ?>&category=<?= urlencode($_GET['category'] ?? '') ?>&severity=<?= urlencode($_GET['severity'] ?? '') ?>&status=<?= urlencode($_GET['status'] ?? '') ?>">← Назад</a>
                        </li>
                        <?php for ($i = 1; $i <= $pages; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <?php if ($i == $page): ?>
                                    <span class="page-link bg-dark border-dark text-white"><?= $i ?></span>
                                <?php else: ?>
                                    <a class="page-link text-dark border-secondary-subtle"
                                        href="?action=index&point_id=<?= $point_id ?>&page=<?= $i ?>&category=<?= urlencode($_GET['category'] ?? '') ?>&severity=<?= urlencode($_GET['severity'] ?? '') ?>&status=<?= urlencode($_GET['status'] ?? '') ?>"><?= $i ?></a>
                                <?php endif; ?>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= ($page >= $pages) ? 'disabled' : '' ?>">
                            <a class="page-link text-dark border-secondary-subtle"
                                href="?action=index&point_id=<?= $point_id ?>&page=<?= $page + 1 ?>&category=<?= urlencode($_GET['category'] ?? '') ?>&severity=<?= urlencode($_GET['severity'] ?? '') ?>&status=<?= urlencode($_GET['status'] ?? '') ?>">Вперёд →</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>