<?php
/**
 * Страница просмотра использованных материалов
 */
?>

<?php include '../app/includes/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 mb-0">Использованные материалы</h1>
        <a href="../" class="btn btn-outline-secondary">← Назад</a>
    </div>

    <div class="mb-3">
        <a href="../controllers/exportcontroller.php?type=material_usage" class="btn btn-success">Экспорт</a>
    </div>

    <!-- Форма фильтрации -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Фильтры</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="" class="row g-3">
                <input type="hidden" name="action" value="index">

                <div class="col-md-4">
                    <label class="form-label">Материал</label>
                    <select name="material_id" class="form-select">
                        <option value="">Все</option>
                        <?php foreach ($materialsList as $material): ?>
                            <option value="<?php echo $material['id']; ?>"
                                    <?php echo (isset($_GET['material_id']) && $_GET['material_id'] == $material['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($material['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Сетевая точка</label>
                    <input type="text" name="point_label" class="form-control"
                           placeholder="Поиск по названию точки"
                           value="<?php echo htmlspecialchars($_GET['point_label'] ?? ''); ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Пользователь</label>
                    <input type="text" name="used_by_login" class="form-control"
                           placeholder="Поиск по логину пользователя"
                           value="<?php echo htmlspecialchars($_GET['used_by_login'] ?? ''); ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Дата с</label>
                    <input type="date" name="date_from" class="form-control"
                           value="<?php echo htmlspecialchars($_GET['date_from'] ?? ''); ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Дата по</label>
                    <input type="date" name="date_to" class="form-control"
                           value="<?php echo htmlspecialchars($_GET['date_to'] ?? ''); ?>">
                </div>

                <div class="col-md-12 d-flex gap-2 align-items-end">
                    <button type="submit" class="btn btn-primary">Применить</button>
                    <a href="?action=index" class="btn btn-outline-secondary">Сбросить</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Таблица -->
    <?php if (empty($result['items'])): ?>
        <div class="alert alert-info">Нет данных об использовании материалов.</div>
    <?php else: ?>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <p class="mb-0 text-muted">Всего записей: <strong><?php echo $result['total']; ?></strong></p>
            <p class="mb-0 text-muted">Страница <?php echo $result['page']; ?> из <?php echo $result['totalPages']; ?></p>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Материал</th>
                        <th>Тип</th>
                        <th>Количество</th>
                        <th>Ед. изм.</th>
                        <th>Точка</th>
                        <th>Локация</th>
                        <th>Кто использовал</th>
                        <th>Дата использования</th>
                        <th>Комментарий</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result['items'] as $item): ?>
                        <tr>
                            <td><?php echo $item['id']; ?></td>
                            <td><?php echo htmlspecialchars($item['material_name'] ?? '—'); ?></td>
                            <td><?php echo htmlspecialchars($item['material_type'] ?? '—'); ?></td>
                            <td class="text-end"><?php echo $item['quantity']; ?></td>
                            <td><?php echo $item['unit'] == 'm' ? 'м' : 'шт'; ?></td>
                            <td><?php echo htmlspecialchars($item['point_label'] ?? '—'); ?></td>
                            <td><?php echo htmlspecialchars($item['point_location'] ?? '—'); ?></td>
                            <td><?php echo htmlspecialchars($item['used_by_login'] ?? '—'); ?></td>
                            <td><?php echo $item['used_at']; ?></td>
                            <td><?php echo htmlspecialchars($item['comment'] ?? ''); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Пагинация -->
        <?php if ($result['totalPages'] > 1): ?>
            <nav class="mt-3">
                <ul class="pagination justify-content-center">
                    <?php if ($result['page'] > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?action=index&page=<?php echo $result['page'] - 1; ?>&material_id=<?php echo urlencode($_GET['material_id'] ?? ''); ?>&point_label=<?php echo urlencode($_GET['point_label'] ?? ''); ?>&used_by_login=<?php echo urlencode($_GET['used_by_login'] ?? ''); ?>&date_from=<?php echo urlencode($_GET['date_from'] ?? ''); ?>&date_to=<?php echo urlencode($_GET['date_to'] ?? ''); ?>">← Предыдущая</a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled"><span class="page-link">← Предыдущая</span></li>
                    <?php endif; ?>

                    <li class="page-item active"><span class="page-link bg-primary border-primary"><?php echo $result['page']; ?></span></li>

                    <?php if ($result['page'] < $result['totalPages']): ?>
                        <li class="page-item">
                            <a class="page-link" href="?action=index&page=<?php echo $result['page'] + 1; ?>&material_id=<?php echo urlencode($_GET['material_id'] ?? ''); ?>&point_label=<?php echo urlencode($_GET['point_label'] ?? ''); ?>&used_by_login=<?php echo urlencode($_GET['used_by_login'] ?? ''); ?>&date_from=<?php echo urlencode($_GET['date_from'] ?? ''); ?>&date_to=<?php echo urlencode($_GET['date_to'] ?? ''); ?>">Следующая →</a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled"><span class="page-link">Следующая →</span></li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php include '../app/includes/footer.php'; ?>