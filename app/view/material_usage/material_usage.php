<?php
/**
 * Страница просмотра использованных материалов
 */
?>

<?php include '../../app/includes/header.php'; ?>

    <div class="container my-5">

        <!-- Шапка страницы -->
        <div class="row mb-4 align-items-center">
            <div class="col-12">
                <h1 class="h3 mb-1 fw-bold">Использованные материалы</h1>
                <p class="text-muted small mb-0">История расхода материалов по сетевым точкам</p>
            </div>
        </div>
        <!-- Блок кнопок управления: крупные, одинакового размера, в одну линию -->
        <div class="d-flex flex-wrap gap-2 justify-content-end mb-4">
            <!-- Синяя кнопка действия -->
            <a href="../../" class="btn btn-outline-secondary">
                &larr; На главную
            </a>

            <!-- Зелёная кнопка экспорта -->
            <a href="../export_to_csv.php?type=material_usage" class="btn btn-success">
                Экспорт в CSV
            </a>

            <!-- Строгая серая кнопка печати (функция printDiv4 на месте) -->
            <button type="button" onclick="printDiv4('printable-table')" class="btn btn-outline-secondary">
                Печать
            </button>
        </div>

        <!-- Минималистичная карточка фильтрации (в стиле примера от коллег) -->
        <div class="card border-secondary-subtle bg-white mb-4">
            <div class="card-body p-4">
                <form method="GET" action="" class="row g-3">
                    <input type="hidden" name="action" value="index">

                    <!-- Материал -->
                    <div class="col-md-4">
                        <label class="form-label small fw-medium text-muted">Материал</label>
                        <select name="material_id" class="form-select form-select-sm">
                            <option value="">Все</option>
                            <?php foreach ($materialsList as $material): ?>
                                <option value="<?= $material['id']; ?>"
                                        <?= (isset($_GET['material_id']) && $_GET['material_id'] == $material['id']) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($material['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Сетевая точка -->
                    <div class="col-md-4">
                        <label class="form-label small fw-medium text-muted">Сетевая точка</label>
                        <!-- Добавлены классы Bootstrap form-control-sm -->
                        <input
                                type="text"
                                name="point_label"
                                class="form-control form-control-sm"
                                placeholder="Поиск по названию точки"
                                value="<?= htmlspecialchars($_GET['point_label'] ?? ''); ?>"
                        >
                    </div>

                    <!-- Пользователь -->
                    <div class="col-md-4">
                        <label class="form-label small fw-medium text-muted">Пользователь</label>
                        <!-- Добавлены классы Bootstrap form-control-sm -->
                        <input
                                type="text"
                                name="used_by_login"
                                class="form-control form-control-sm"
                                placeholder="Поиск по имени пользователя"
                                value="<?= htmlspecialchars($_GET['used_by_login'] ?? ''); ?>"
                        >
                    </div>

                    <!-- Дата с -->
                    <div class="col-md-4">
                        <label class="form-label small fw-medium text-muted">Дата с</label>
                        <input type="date" name="date_from" class="form-control form-control-sm"
                               value="<?= htmlspecialchars($_GET['date_from'] ?? ''); ?>">
                    </div>

                    <!-- Дата по -->
                    <div class="col-md-4">
                        <label class="form-label small fw-medium text-muted">по</label>
                        <input type="date" name="date_to" class="form-control form-control-sm"
                               value="<?= htmlspecialchars($_GET['date_to'] ?? ''); ?>">
                    </div>

                    <!-- Кнопки управления фильтром -->
                    <div class="col-md-4 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary w-50">Применить</button>
                        <a href="?action=index" class="btn btn-outline-secondary w-50 text-center">Сбросить</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Блок вывода таблицы / результатов -->
        <?php if (empty($result['items'])): ?>
            <div class="alert alert-light border border-secondary-subtle p-4 text-center text-muted">
                <strong>Нет данных об использовании материалов.</strong>
            </div>
        <?php else: ?>

            <!-- Строгая современная таблица -->
            <div id="printable-table" class="table-responsive card border-secondary-subtle bg-white mb-3">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted small">
                    <tr>
                        <th class="ps-4">№</th>
                        <?php if (($_SESSION['user_info']['role'] ?? 'null') === 'admin'): ?>
                            <th class="ps-4">ID</th>
                        <?php endif; ?>
                        <th>Материал</th>
                        <th>Тип</th>
                        <th class="text-end">Количество</th>
                        <th>Ед. изм.</th>
                        <th>Точка</th>
                        <th>Локация</th>
                        <th>Кто использовал</th>
                        <th>Дата использования</th>
                        <th class="pe-4">Комментарий</th>
                    </tr>
                    </thead>
                    <tbody class="small">
                    <?php foreach ($result['items'] as $item): ?>
                        <tr>
                            <td class="ps-4"><?= $offset++ ?></td>
                            <?php if (($_SESSION['user_info']['role'] ?? 'null') === 'admin'): ?>
                                <th class="ps-4"><?= $item['id'] ?></th>
                            <?php endif; ?>
                            <td><strong><?= htmlspecialchars($item['material_name'] ?? '—'); ?></strong></td>
                            <td><?= htmlspecialchars($item['material_type'] ?? '—'); ?></td>
                            <td class="text-end fw-bold"><?= $item['quantity']; ?></td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <?= $item['unit'] == 'm' ? 'м' : 'шт'; ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($item['point_label'] ?? '—'); ?></td>
                            <td><?= htmlspecialchars($item['point_location'] ?? '—'); ?></td>
                            <td>
                                <span class="text-muted"><i
                                            class="fas fa-user me-1 small"></i><?php echo htmlspecialchars($item['used_by_login'] ?? '—'); ?></span>
                            </td>
                            <td class="text-muted"><?= $item['used_at']; ?></td>
                            <td class="pe-4 text-truncate" style="max-width: 150px;"
                                title="<?= htmlspecialchars($item['comment'] ?? ''); ?>">
                                <?php if (empty($item['comment'])): ?>
                                    Без комментария
                                <?php else: ?>
                                    <button type="button" class="btn btn-sm btn-outline-secondary"
                                            onclick="document.getElementById('openComment<?= $offset ?>').showModal()">
                                        Комментарий
                                    </button>
                                    <dialog id="openComment<?= $offset ?>"
                                            class="border-0 rounded-3 shadow-lg p-4 text-center"
                                            style="max-width: 500px; outline: none; background: white;">
                                        <div class="d-flex justify-content-end mb-2">
                                            <button type="button" class="btn-close"
                                                    onclick="document.getElementById('openComment<?= $offset ?>').close()"></button>
                                        </div>

                                        <p class="text"><?= $item['comment'] ?: "Без описания" ?></p>
                                        <p class="text-muted small mb-0">Нажмите Esc или крестик для
                                            закрытия</p>
                                    </dialog>
                                <?php endif; ?>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Блок пагинации и статистики -->
            <div class="d-flex justify-content-between align-items-center mt-3 small text-muted">
                <div>
                    <strong>Всего записей: <?php echo $result['total']; ?></strong>
                </div>

                <?php if ($result['totalPages'] > 1): ?>
                    <div>
                        <?php if ($result['page'] > 1): ?>
                            <a href="?action=index&page=<?php echo $result['page'] - 1; ?>&material_id=<?php echo urlencode($_GET['material_id'] ?? ''); ?>&point_id=<?php echo urlencode($_GET['point_id'] ?? ''); ?>&used_by=<?php echo urlencode($_GET['used_by'] ?? ''); ?>&date_from=<?php echo urlencode($_GET['date_from'] ?? ''); ?>&date_to=<?php echo urlencode($_GET['date_to'] ?? ''); ?>"
                               class="text-decoration-none me-2">← Предыдущая</a>
                        <?php else: ?>
                            <span class="text-muted me-2">← Предыдущая</span>
                        <?php endif; ?>

                        <span class="fw-medium text-dark">Страница <?php echo $result['page']; ?> из <?php echo $result['totalPages']; ?></span>

                        <?php if ($result['page'] < $result['totalPages']): ?>
                            <a href="?action=index&page=<?php echo $result['page'] + 1; ?>&material_id=<?php echo urlencode($_GET['material_id'] ?? ''); ?>&point_id=<?php echo urlencode($_GET['point_id'] ?? ''); ?>&used_by=<?php echo urlencode($_GET['used_by'] ?? ''); ?>&date_from=<?php echo urlencode($_GET['date_from'] ?? ''); ?>&date_to=<?php echo urlencode($_GET['date_to'] ?? ''); ?>"
                               class="text-decoration-none ms-2">Следующая →</a>
                        <?php else: ?>
                            <span class="text-muted ms-2">Следующая →</span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

        <?php endif; ?>

    </div>

<?php include '../../app/includes/footer.php'; ?>