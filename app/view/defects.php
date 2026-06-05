<?php

/**
 * Учёт бракованных товаров. Список того что сломалось. Добавление дефекта или редактирование
 */
?>

<?php include '../app/includes/header.php'; ?>



<div class="container my-5">
    
    <!-- Шапка страницы с информацией о точке -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-2 fw-bold">Дефекты точки: <?= htmlspecialchars($point['label'] ?? '') ?></h1>
            <div class="text-muted small">
                <span class="me-3"><strong>Расположение:</strong> <?= htmlspecialchars($point['location'] ?? '—') ?></span>
                <span><strong>Статус точки:</strong> <?= htmlspecialchars($point['status_name'] ?? '—') ?></span>
            </div>
        </div>
    </div>
    
    <!-- Навигация и Форма фильтрации -->
    <div class="row mb-4">
        <div class="col-12">
            
            <!-- Кнопка назад -->
            <div class="mb-3">
                <a href="../controllers/inventorycontroller.php?action=index" class="btn btn-sm btn-outline-secondary">
                    &larr; Назад к точкам
                </a>
            </div>

            <!-- Минималистичная карточка фильтра -->
            <div class="card border-secondary-subtle">
                <div class="card-body p-4">
                    <form method="get" class="row g-3">
                        <input type="hidden" name="action" value="index">
                        <input type="hidden" name="point_id" value="<?= $point_id ?>">
                        
                        <!-- Категория -->
                        <div class="col-md-3">
                            <label class="form-label small fw-medium text-muted">Категория</label>
                            <select name="category" class="form-select">
                                <option value="">Все</option>
                                <option value="Скрутка" <?= ($_GET['category'] ?? '') === 'Скрутка' ? 'selected' : '' ?>>Скрутка</option>
                                <option value="Крепление" <?= ($_GET['category'] ?? '') === 'Крепление' ? 'selected' : '' ?>>Крепление</option>
                                <option value="Кабель" <?= ($_GET['category'] ?? '') === 'Кабель' ? 'selected' : '' ?>>Кабель</option>
                                <option value="Механический" <?= ($_GET['category'] ?? '') === 'Механический' ? 'selected' : '' ?>>Механический</option>
                                <option value="Электрический" <?= ($_GET['category'] ?? '') === 'Электрический' ? 'selected' : '' ?>>Электрический</option>
                            </select>
                        </div>
                        
                        <!-- Критичность -->
                        <div class="col-md-3">
                            <label class="form-label small fw-medium text-muted">Критичность</label>
                            <select name="severity" class="form-select">
                                <option value="">Все</option>
                                <option value="high" <?= ($_GET['severity'] ?? '') === 'high' ? 'selected' : '' ?>>Высокая</option>
                                <option value="medium" <?= ($_GET['severity'] ?? '') === 'medium' ? 'selected' : '' ?>>Средняя</option>
                                <option value="low" <?= ($_GET['severity'] ?? '') === 'low' ? 'selected' : '' ?>>Низкая</option>
                            </select>
                        </div>
                        
                        <!-- Статус -->
                        <div class="col-md-3">
                            <label class="form-label small fw-medium text-muted">Статус</label>
                            <select name="status" class="form-select">
                                <option value="">Все</option>
                                <option value="open" <?= ($_GET['status'] ?? '') === 'open' ? 'selected' : '' ?>>Открыт</option>
                                <option value="in_progress" <?= ($_GET['status'] ?? '') === 'in_progress' ? 'selected' : '' ?>>В работе</option>
                                <option value="closed" <?= ($_GET['status'] ?? '') === 'closed' ? 'selected' : '' ?>>Закрыт</option>
                            </select>
                        </div>
                        
                        <!-- Кнопки управления -->
                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <button type="button" class="btn btn-primary">Применить</button>
                            <a href="?action=index&point_id=<?= $point_id ?>" class="btn btn-outline-secondary">Сбросить</a>
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
                            <th class="pe-4">Дата</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        <?php if (empty($defects)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    Дефектов по заданным критериям не найдено.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($defects as $defect): ?>
                                <tr>
                                    <td class="ps-4 fw-bold"><?= $defect['id'] ?></td>
                                    <td><?= htmlspecialchars($defect['category'] ?? '—') ?></td>
                                    <td>
                                        <span class="fw-medium"><?= htmlspecialchars($defect['severity'] ?? '—') ?></span>
                                    </td>
                                    <td class="text-wrap" style="max-width: 300px;"><?= htmlspecialchars($defect['description'] ?? '') ?></td>
                                    <td>
                                        <span class="badge bg-light text-dark border border-secondary-subtle">
                                            <?= htmlspecialchars($defect['status'] ?? '') ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($defect['author'] ?? '—') ?></td>
                                    <td class="pe-4 text-muted"><?= htmlspecialchars($defect['created_at'] ?? '') ?></td>
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
                    
                    <!-- Назад -->
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link text-dark border-secondary-subtle" href="?action=index&point_id=<?= $point_id ?>&page=<?= $page - 1 ?>&category=<?= urlencode($_GET['category'] ?? '') ?>&severity=<?= urlencode($_GET['severity'] ?? '') ?>&status=<?= urlencode($_GET['status'] ?? '') ?>">← Назад</a>
                    </li>
                    
                    <!-- Номера страниц -->
                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <?php if ($i == $page): ?>
                                <span class="page-link bg-dark border-dark text-white"><?= $i ?></span>
                            <?php else: ?>
                                <a class="page-link text-dark border-secondary-subtle" href="?action=index&point_id=<?= $point_id ?>&page=<?= $i ?>&category=<?= urlencode($_GET['category'] ?? '') ?>&severity=<?= urlencode($_GET['severity'] ?? '') ?>&status=<?= urlencode($_GET['status'] ?? '') ?>"><?= $i ?></a>
                            <?php endif; ?>
                        </li>
                    <?php endfor; ?>
                    
                    <!-- Вперёд -->
                    <li class="page-item <?= ($page >= $pages) ? 'disabled' : '' ?>">
                        <a class="page-link text-dark border-secondary-subtle" href="?action=index&point_id=<?= $point_id ?>&page=<?= $page + 1 ?>&category=<?= urlencode($_GET['category'] ?? '') ?>&severity=<?= urlencode($_GET['severity'] ?? '') ?>&status=<?= urlencode($_GET['status'] ?? '') ?>">Вперёд →</a>
                    </li>

                </ul>
            </nav>
        </div>
    </div>
    <?php endif; ?>

</div>
<?php include '../app/includes/footer.php'; ?>
<!-- Скрипты Bootstrap -->
