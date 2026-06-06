<?php
/**
 * Учёт бракованных товаров. Список того что сломалось. Добавление дефекта или редактирование
 */
//require '../config/db.php';
//require '../app/includes/functions.php';
?>

<?php include '../app/includes/header.php'; ?>
<div class="container my-5">

    <!-- Шапка страницы с информацией о точке -->
    <div class="row mb-4">
        <h1>Информация</h1>
        <img src="../public/storage/network_points/<?= $point['image_name'] ?>"
             alt="Изображение точки <?= $point['label'] ?>">
        <div class="text-muted small">
            <span class="me-3"><strong>Расположение:</strong> <?= htmlspecialchars($point['location'] ?? '—') ?></span>
            <span><strong>Статус точки:</strong> <?= htmlspecialchars($point['status_name'] ?? '—') ?></span>
        </div>
        <!-- Кнопка назад -->
        <div class="mb-3">
            <a href="../controllers/inventorycontroller.php?action=index" class="btn btn-sm btn-outline-secondary">
                &larr; Назад к точкам
            </a>
            <!-- НОВАЯ КНОПКА: Переход к расходам материалов по этой точке -->
            <a href="../controllers/materialusageControllers.php?action=index&point_id=<?= $point_id ?>"
               class="btn btn-sm btn-info">
                Расход материалов по этой точке
            </a>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="h3 mb-2 fw-bold">Дефекты точки</h2>

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
                            <select name="severity" class="form-select">
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
                            <select name="status" class="form-select">
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
                            <button type="submit" class="btn btn-primary">Применить</button>
                            <a href="?action=index&point_id=<?= $point_id ?>&category=&severity=&status="
                               class="btn btn-outline-secondary">Сбросить</a>
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
                        <th>Действия</th>
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
                                <td class="ps-4 fw-bold"><?= htmlspecialchars($defect['id']) ?></td>
                                <td><?= htmlspecialchars($defect['category'] ?? '—') ?></td>
                                <td>
                                    <span class="fw-medium"><?= htmlspecialchars($defect['severity'] ?? '—') ?></span>
                                </td>
                                <td class="text-wrap"
                                    style="max-width: 300px;"><?= htmlspecialchars($defect['description'] ?? '') ?></td>
                                <td>
                                        <span class="badge bg-light text-dark border border-secondary-subtle">
                                            <?= htmlspecialchars($defect['status'] ?? '') ?>
                                        </span>
                                </td>
                                <td><?= htmlspecialchars($defect['author'] ?? '—') ?></td>
                                <td class="pe-4 text-muted"><?= htmlspecialchars($defect['created_at'] ?? '') ?></td>
                                <td>
                                    <?php if ($defect['status'] == 'open'): ?>
                                        <a href="../controllers/defectscontroller.php?action=change_status&defect_id=<?= $defect['id'] ?>&point_id=<?= $point_id ?>&status=in_progress">Начать
                                            работу</a>
                                    <?php elseif ($defect['status'] == 'in_progress'): ?>
                                        <a href="../controllers/defectscontroller.php?action=change_status&defect_id=<?= $defect['id'] ?>&point_id=<?= $point_id ?>&status=closed">Исправлено</a>
                                    <?php else: ?>
                                        <a href="../controllers/defectscontroller.php?action=change_status&defect_id=<?= $defect['id'] ?>&point_id=<?= $point_id ?>&status=open">
                                            Переоткрыть
                                        </a>
                                        <!--                                        Закрыто-->
                                    <?php endif; ?>

                                    <?php if (!empty($defect['image_name'])): ?>
                                        <button onclick="document.getElementById('openImage').showModal()">
                                            Открыть фотографию
                                        </button>
                                        <dialog id="openImage" onclick="this.close()">
                                            <img src="../public/storage/defects/<?= $defect['image_name'] ?>"
                                                 alt="Изображение дефекта для <?= $point['label'] ?>">
                                            <p>Нажми на меня, чтобы закрыть окно</p>
                                        </dialog>
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

    <!-- Пагинация -->
    <?php if (isset($pages) && $pages > 1): ?>
        <div class="row">
            <div class="col-12">
                <nav aria-label="Навигация по страницам">
                    <ul class="pagination justify-content-center">

                        <!-- Назад -->
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link text-dark border-secondary-subtle"
                               href="?action=index&point_id=<?= $point_id ?>&page=<?= $page - 1 ?>&category=<?= urlencode($_GET['category'] ?? '') ?>&severity=<?= urlencode($_GET['severity'] ?? '') ?>&status=<?= urlencode($_GET['status'] ?? '') ?>">←
                                Назад</a>
                        </li>

                        <!-- Номера страниц -->
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

                        <!-- Вперёд -->
                        <li class="page-item <?= ($page >= $pages) ? 'disabled' : '' ?>">
                            <a class="page-link text-dark border-secondary-subtle"
                               href="?action=index&point_id=<?= $point_id ?>&page=<?= $page + 1 ?>&category=<?= urlencode($_GET['category'] ?? '') ?>&severity=<?= urlencode($_GET['severity'] ?? '') ?>&status=<?= urlencode($_GET['status'] ?? '') ?>">Вперёд
                                →</a>
                        </li>

                    </ul>
                </nav>
            </div>
        </div>
    <?php endif; ?>

</div>
<?php include '../app/includes/footer.php'; ?>
