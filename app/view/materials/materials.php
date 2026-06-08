<?php
/**
 * Учёт расходников. Кабели (м.), коннекторы (шт.), розетки (шт.).
 */
?>

<?php include '../../app/includes/header.php'; ?>

    <div class="container my-5">

        <!-- Шапка страницы -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3 mb-2 fw-bold">Учёт материалов</h1>
                <div class="text-muted small">
                    <span>Управление расходными материалами: кабели, коннекторы, розетки</span>
                </div>
            </div>
        </div>

        <!-- Навигация и кнопка добавления -->
        <div class="row mb-4">
            <div class="col-12">

                <!-- Кнопка назад и добавления -->
                <div class="mb-3 d-flex gap-2">
                    <a href="../../" class="btn btn-sm btn-outline-secondary">
                        &larr; Назад
                    </a>
                    <a href="../../app/view/materials/insert_material.php" class="btn btn-sm btn-primary">
                        + Добавить материал
                    </a>
                    <a href="../export_to_csv.php?type=materials" class="btn btn-sm btn-success">
                        Экспорт в CSV
                    </a>
                    <div>
                        <button onclick="printDiv2('printable-table2')">Печать</button>
                    </div>
                </div>

                <!-- Карточка фильтра -->
                <div class="card border-secondary-subtle">
                    <div class="card-body p-4">
                        <form method="GET" action="" class="row g-3">
                            <!-- Название -->
                            <div class="col-md-4">
                                <label class="form-label small fw-medium text-muted">Название</label>
                                <input type="text" name="name" class="form-control"
                                    value="<?php echo htmlspecialchars($_GET['name'] ?? ''); ?>"
                                    placeholder="Поиск по названию">
                            </div>

                            <!-- Тип -->
                            <div class="col-md-4">
                                <label class="form-label small fw-medium text-muted">Тип</label>
                                <select name="type" class="form-select">
                                    <option value="">Все типы</option>
                                    <?php foreach ($materialTypes as $type): ?>
                                        <option value="<?php echo $type['id']; ?>"
                                                <?php echo (isset($_GET['type']) && $_GET['type'] == $type['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($type['display_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Единица измерения -->
                            <div class="col-md-4">
                                <label class="form-label small fw-medium text-muted">Единица измерения</label>
                                <select name="unit" class="form-select">
                                    <option value="">Все</option>
                                    <?php foreach ($materialUnits as $unit): ?>
                                        <option value="<?php echo htmlspecialchars($unit); ?>"
                                                <?php echo (isset($_GET['unit']) && $_GET['unit'] == $unit) ? 'selected' : ''; ?>>
                                            <?php echo ($unit == 'm') ? 'метр' : 'штука'; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Кнопки управления -->
                            <div class="col-12 d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Применить фильтр</button>
                                <a href="?" class="btn btn-outline-secondary">Сбросить</a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <?php if (isset($result['totalPages']) && $result['totalPages'] > 1): ?>
            <div class="row">
                <div class="col-12">
                    <nav aria-label="Навигация по страницам">
                        <ul class="pagination justify-content-center">

                            <!-- Предыдущая -->
                            <li class="page-item <?php echo ($result['page'] <= 1) ? 'disabled' : ''; ?>">
                                <?php if ($result['page'] > 1): ?>
                                    <?php
                                    $currentUrl = strtok($_SERVER['REQUEST_URI'], '?');
                                    $queryParams = $_GET;
                                    unset($queryParams['page']);
                                    ?>
                                    <a class="page-link text-dark border-secondary-subtle"
                                        href="<?php echo $currentUrl . '?' . http_build_query(array_merge($queryParams, ['page' => $result['page'] - 1])); ?>">
                                        ← Назад
                                    </a>
                                <?php else: ?>
                                    <span class="page-link text-muted border-secondary-subtle">← Назад</span>
                                <?php endif; ?>
                            </li>

                            <!-- Номера страниц -->
                            <?php for ($i = 1; $i <= $result['totalPages']; $i++): ?>
                                <li class="page-item <?php echo ($i == $result['page']) ? 'active' : ''; ?>">
                                    <?php if ($i == $result['page']): ?>
                                        <span class="page-link bg-dark border-dark text-white"><?php echo $i; ?></span>
                                    <?php else: ?>
                                        <?php
                                        $currentUrl = strtok($_SERVER['REQUEST_URI'], '?');
                                        $queryParams = $_GET;
                                        unset($queryParams['page']);
                                        ?>
                                        <a class="page-link text-dark border-secondary-subtle"
                                            href="<?php echo $currentUrl . '?' . http_build_query(array_merge($queryParams, ['page' => $i])); ?>">
                                            <?php echo $i; ?>
                                        </a>
                                    <?php endif; ?>
                                </li>
                            <?php endfor; ?>

                            <!-- Следующая -->
                            <li class="page-item <?php echo ($result['page'] >= $result['totalPages']) ? 'disabled' : ''; ?>">
                                <?php if ($result['page'] < $result['totalPages']): ?>
                                    <?php
                                    $currentUrl = strtok($_SERVER['REQUEST_URI'], '?');
                                    $queryParams = $_GET;
                                    unset($queryParams['page']);
                                    ?>
                                    <a class="page-link text-dark border-secondary-subtle"
                                        href="<?php echo $currentUrl . '?' . http_build_query(array_merge($queryParams, ['page' => $result['page'] + 1])); ?>">
                                        Вперёд →
                                    </a>
                                <?php else: ?>
                                    <span class="page-link text-muted border-secondary-subtle">Вперёд →</span>
                                <?php endif; ?>
                            </li>

                        </ul>
                    </nav>
                </div>
            </div>
        <?php endif; ?>
        <!-- Таблица с материалами -->
        <div id="printable-table2" class="row mb-4">
            <div class="col-12">
                <div class="table-responsive card border-secondary-subtle bg-white">
                    <div class="card-body p-0">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-muted small">
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Название</th>
                                <th>Тип</th>
                                <th>Единица измерения</th>
                                <th class="pe-4">Действия</th>
                            </tr>
                            </thead>
                            <tbody class="small">
                            <?php if (empty($result['materials'])): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        Материалы не найдены
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($result['materials'] as $material): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold"><?php echo $material['id']; ?></td>
                                        <td><?php echo htmlspecialchars($material['name']); ?></td>
                                        <td><?php echo htmlspecialchars($material['type_name']); ?></td>
                                        <td>
                                            <?php
                                            if ($material['unit'] == 'm') {
                                                echo '<span class="badge bg-light text-dark border border-secondary-subtle">метр</span>';
                                            } else {
                                                echo '<span class="badge bg-light text-dark border border-secondary-subtle">штука</span>';
                                            }
                                            ?>
                                        </td>
                                        <td class="pe-4">
                                            <?php if (isset($_SESSION['user_info']) && !empty($_SESSION['user_info'])): ?>
                                            <a href="../../app/view/materials/update_material.php?id=<?php echo $material['id']; ?>"
                                            class="btn btn-sm btn-outline-secondary me-1">
                                                Изменить
                                            </a>
                                            <a href="?action=delete&id=<?php echo $material['id']; ?>"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Удалить материал?')">
                                                Удалить
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-outline-secondary me-1" disabled>Изменить</button>
                                            <button class="btn btn-sm btn-outline-danger" disabled>Удалить</button>
                                        <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Информация о количестве записей -->
                <?php if (!empty($result['materials'])): ?>
                    <div class="mt-2 text-muted small">
                        Всего записей: <?php echo $result['total']; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Пагинация -->
        <?php if (isset($result['totalPages']) && $result['totalPages'] > 1): ?>
            <div class="row">
                <div class="col-12">
                    <nav aria-label="Навигация по страницам">
                        <ul class="pagination justify-content-center">

                            <!-- Предыдущая -->
                            <li class="page-item <?php echo ($result['page'] <= 1) ? 'disabled' : ''; ?>">
                                <?php if ($result['page'] > 1): ?>
                                    <?php
                                    $currentUrl = strtok($_SERVER['REQUEST_URI'], '?');
                                    $queryParams = $_GET;
                                    unset($queryParams['page']);
                                    ?>
                                    <a class="page-link text-dark border-secondary-subtle"
                                       href="<?php echo $currentUrl . '?' . http_build_query(array_merge($queryParams, ['page' => $result['page'] - 1])); ?>">
                                        ← Назад
                                    </a>
                                <?php else: ?>
                                    <span class="page-link text-muted border-secondary-subtle">← Назад</span>
                                <?php endif; ?>
                            </li>

                            <!-- Номера страниц -->
                            <?php for ($i = 1; $i <= $result['totalPages']; $i++): ?>
                                <li class="page-item <?php echo ($i == $result['page']) ? 'active' : ''; ?>">
                                    <?php if ($i == $result['page']): ?>
                                        <span class="page-link bg-dark border-dark text-white"><?php echo $i; ?></span>
                                    <?php else: ?>
                                        <?php
                                        $currentUrl = strtok($_SERVER['REQUEST_URI'], '?');
                                        $queryParams = $_GET;
                                        unset($queryParams['page']);
                                        ?>
                                        <a class="page-link text-dark border-secondary-subtle"
                                           href="<?php echo $currentUrl . '?' . http_build_query(array_merge($queryParams, ['page' => $i])); ?>">
                                            <?php echo $i; ?>
                                        </a>
                                    <?php endif; ?>
                                </li>
                            <?php endfor; ?>

                            <!-- Следующая -->
                            <li class="page-item <?php echo ($result['page'] >= $result['totalPages']) ? 'disabled' : ''; ?>">
                                <?php if ($result['page'] < $result['totalPages']): ?>
                                    <?php
                                    $currentUrl = strtok($_SERVER['REQUEST_URI'], '?');
                                    $queryParams = $_GET;
                                    unset($queryParams['page']);
                                    ?>
                                    <a class="page-link text-dark border-secondary-subtle"
                                       href="<?php echo $currentUrl . '?' . http_build_query(array_merge($queryParams, ['page' => $result['page'] + 1])); ?>">
                                        Вперёд →
                                    </a>
                                <?php else: ?>
                                    <span class="page-link text-muted border-secondary-subtle">Вперёд →</span>
                                <?php endif; ?>
                            </li>

                        </ul>
                    </nav>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php include '../../app/includes/footer.php'; ?>