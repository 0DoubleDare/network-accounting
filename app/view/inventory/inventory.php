<!-- /**
 * Реестр оборудования (список). Фильтры, пагинация, поиск, метка, тип, расположение, статус.
 */ -->
<?php
if (!isset($points)) {
    require_once __DIR__ . '/../includes/functions.php';
    require_once __DIR__ . '/../../config/db.php';
    $point_id = $_GET['point_id'] ?? $_POST['point_id'] ?? 0;
}

?>

<?php include '../../app/includes/header.php'; ?>

<div class="container my-5">

    <!-- Шапка страницы -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h1 class="h3 mb-1 fw-bold">Реестр сетевых точек</h1>
            <p class="text-muted small mb-0">Список сетевых точек, фильтрация и учёт</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="../../app/view/inventory/insert_network_point.php" class="btn btn-primary">+ Добавить точку</a>
            <a href="../export_to_csv.php?type=network_points" class="btn btn-success ms-2">Экспорт в CSV</a>
            <button type="button" onclick="printDiv('printable-table')" class="btn btn-outline-secondary ms-2">Печать
            </button>
        </div>


    </div>

    <!-- Минималистичная карточка фильтра -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-secondary-subtle bg-white">
                <div class="card-body p-4">
                    <form method="get" class="row g-3" style="justify-content: center">
                        <input type="hidden" name="action" value="index">

                        <!-- Метка -->
                        <div class="col-md-3">
                            <label class="form-label small fw-medium text-muted">Метка</label>
                            <input type="text" name="label" class="form-control form-control-sm"
                                   value="<?= htmlspecialchars($_GET['label'] ?? '') ?>">
                        </div>

                        <!-- Тип -->
                        <div class="col-md-3">
                            <label class="form-label small fw-medium text-muted">Тип оборудования</label>
                            <select name="type" class="form-select form-select-sm">
                                <option value="">Все</option>
                                <?php if (isset($typeList)): ?>
                                    <?php foreach ($typeList as $type): ?>
                                        <option value="<?= $type['id'] ?>" <?= (isset($_GET['type']) && $_GET['type'] == $type['id']) ? 'selected' : '' ?>><?= htmlspecialchars($type['display_name']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- Расположение -->
                        <div class="col-md-3">
                            <label class="form-label small fw-medium text-muted">Расположение</label>
                            <input type="text" name="location" class="form-control form-control-sm"
                                   value="<?= htmlspecialchars($_GET['location'] ?? '') ?>">
                        </div>

                        <!-- Статус -->
                        <div class="col-md-3">
                            <label class="form-label small fw-medium text-muted">Статус</label>
                            <select name="status" class="form-select form-select-sm">
                                <option value="">Все</option>
                                <?php if (isset($statusList)): ?>
                                    <?php foreach ($statusList as $status): ?>
                                        <option value="<?= $status['id'] ?>" <?= (isset($_GET['status']) && $_GET['status'] == $status['id']) ? 'selected' : '' ?>><?= htmlspecialchars($status['display_name']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
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
                        <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">Найти</button>
                            <a href="?action=index" class="btn btn-outline-secondary">Сбросить</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php if (isset($pages) && $pages > 1): ?>
        <div class="mb-4">
            <nav>
                <ul class="pagination justify-content-center">

                    <!-- Угарная кнопка назад -->
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <?php
                        // Копируем текущие GET-параметры, принудительно задаем action и новую страницу
                        $prevParams = array_merge($_GET, ['action' => 'index', 'page' => max(1, $page - 1)]);
                        ?>
                        <a class="page-link text-primary" href="?<?= http_build_query($prevParams) ?>">
                            &larr; Назад
                        </a>
                    </li>

                    <!-- Номера страниц -->
                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <?php
                            $pageParams = array_merge($_GET, ['action' => 'index', 'page' => $i]);
                            ?>
                            <a class="page-link" href="?<?= http_build_query($pageParams) ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <!-- Угарная кнопка вперёд -->
                    <li class="page-item <?= ($page >= $pages) ? 'disabled' : '' ?>">
                        <?php
                        $nextParams = array_merge($_GET, ['action' => 'index', 'page' => min($pages, $page + 1)]);
                        ?>
                        <a class="page-link text-primary" href="?<?= http_build_query($nextParams) ?>">
                            Вперёд &rarr;
                        </a>
                    </li>

                </ul>
            </nav>
        </div>

    <?php endif; ?>
    <!-- Строгая таблица с оборудованием -->
    <div id="printable-table" class="row mb-4">
        <div class="col-12">
            <div class="table-responsive card border-secondary-subtle bg-white">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted small">
                    <tr>
                        <th class="ps-4">№</th>
                        <?php if (($_SESSION['user_info']['role'] ?? 'null') === 'admin'): ?>
                            <th class="ps-4">ID</th>
                        <?php endif; ?>
                        <th>Метка</th>
                        <th>Тип</th>
                        <th>Расположение</th>
                        <th>Статус</th>
                        <th>Последнее посещение</th>
                        <th>Дата создания</th>
                        <th>Кол-во дефектов</th>
                        <th class="pe-4">Действие</th>
                    </tr>
                    </thead>
                    <tbody class="small">
                    <?php if (empty($points)): ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">Нет данных</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($points as $point): ?>
                            <tr>
                                <td class="ps-4"><?= $offset++ + 1 ?></td>
                                <?php if (($_SESSION['user_info']['role'] ?? 'null') == 'admin'): ?>
                                    <td class="ps-4"><?= $point['id'] ?></td>
                                <?php endif; ?>
                                <td><strong class="text-truncate d-inline-block"
                                            style="max-width: 125px"><?= htmlspecialchars($point['label']) ?></strong>
                                </td>
                                <td><?= htmlspecialchars($point['type']) ?></td>
                                <td>
                            <span class="text-truncate d-inline-block"
                                  style="max-width: 125px"><?= htmlspecialchars($point['location']) ?></span>
                                </td>
                                <td>
                                    <span style="color: <?= $point['status'] == 'Активный' ? 'green' : 'red' ?>"><?= htmlspecialchars($point['status']) ?></span>
                                </td>
                                <td>
                                    <?php
                                    if (!empty($point['last_check'])) {
                                        echo htmlspecialchars($point['last_check']);
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($point['point_created_at']) ?></td>
                                <td>
                                    <?php
                                    $sql = "SELECT COUNT(*) as defect_count FROM defects WHERE point_id = :point_id";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute(['point_id' => $point['id']]);
                                    echo $stmt->fetchColumn();
                                    ?>
                                </td>
                                <td class="pe-4">
                                    <a href="../defects/defects_view.php?point_id=<?= $point['id'] ?>"
                                       class="btn btn-primary btn-sm ms-2">Подробнее</a>
                                    <?php if (isset($_SESSION['user_info']) && !empty($_SESSION['user_info'])): ?>
                                        <a href="../../app/view/inventory/update_network_point.php?id=<?php echo htmlspecialchars($point['id']); ?>"
                                           class="btn btn-outline-secondary btn-sm ms-2">Изменить</a>
                                        <a href="./delete_network_point.php?id=<?php echo htmlspecialchars($point['id']); ?>"
                                           class="btn btn-outline-danger btn-sm ms-2"
                                           onclick="return confirm('Удалить точку?')">Удалить</a>
                                    <?php else: ?>
                                        <button class="btn btn-outline-secondary btn-sm ms-2" disabled
                                                title="Доступно только зарегистрированным пользователям">Изменить
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm ms-2" disabled
                                                title="Доступно только зарегистрированным пользователям">Удалить
                                        </button>
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

    <!-- Пагинация ссылками -->
    <!-- Простая и лёгкая пагинация Bootstrap 5 -->
    <?php if (isset($pages) && $pages > 1): ?>
        <div class="mb-4">
            <nav>
                <ul class="pagination justify-content-center">

                    <!-- Угарная кнопка назад -->
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <?php
                        // Копируем текущие GET-параметры, принудительно задаем action и новую страницу
                        $prevParams = array_merge($_GET, ['action' => 'index', 'page' => max(1, $page - 1)]);
                        ?>
                        <a class="page-link text-primary" href="?<?= http_build_query($prevParams) ?>">
                            &larr; Назад
                        </a>
                    </li>

                    <!-- Номера страниц -->
                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <?php
                            $pageParams = array_merge($_GET, ['action' => 'index', 'page' => $i]);
                            ?>
                            <a class="page-link" href="?<?= http_build_query($pageParams) ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <!-- Угарная кнопка вперёд -->
                    <li class="page-item <?= ($page >= $pages) ? 'disabled' : '' ?>">
                        <?php
                        $nextParams = array_merge($_GET, ['action' => 'index', 'page' => min($pages, $page + 1)]);
                        ?>
                        <a class="page-link text-primary" href="?<?= http_build_query($nextParams) ?>">
                            Вперёд &rarr;
                        </a>
                    </li>

                </ul>
            </nav>
        </div>

    <?php endif; ?>

    <!-- Компактная кнопка Назад -->
    <div class="mb-3">
        <button onclick="history.back()" class="btn btn-sm btn-outline-secondary">
            &larr; Назад к списку
        </button>
    </div>

</div> <!-- /container -->


<?php include '../../app/includes/footer.php'; ?>