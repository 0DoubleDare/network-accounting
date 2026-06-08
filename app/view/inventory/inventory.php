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
            <h1 class="h3 mb-1 fw-bold">Реестр оборудования</h1>
            <p class="text-muted small mb-0">Список сетевых точек, фильтрация и учёт</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="../../app/view/inventory/insert_network_point.php" class="btn btn-success mb-3">Добавить точку</a>
            <a href="../export_to_csv.php?type=network_points" class="btn btn-outline-secondary mb-3 ms-2">Экспорт</a>
        </div>
    </div>

    <!-- Минималистичная карточка фильтра -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-secondary-subtle bg-white">
                <div class="card-body p-4">
                    <form method="get" class="row g-3">
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

                        <!-- Кнопки управления фильтром -->
                        <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                            <button type="submit" class="btn btn-sm btn-primary">Найти</button>
                            <a href="?action=index" class="btn btn-sm btn-outline-secondary">Сбросить</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Строгая таблица с оборудованием -->
    <div class="row mb-4">
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
                                <td><strong><?= htmlspecialchars($point['label']) ?></strong></td>
                                <td><?= htmlspecialchars($point['type']) ?></td>
                                <td><?= htmlspecialchars($point['location']) ?></td>
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
                                    <a href="../defects/defects_view.php?point_id=<?= $point['id'] ?>">Подробнее</a>
                                    <a href="../../app/view/inventory/update_network_point.php?id=<?php echo htmlspecialchars($point['id']); ?>"
                                       class="btn btn-outline-secondary btn-sm ms-2">Изменить</a>
                                    <a href="./delete_network_point.php?id=<?php echo htmlspecialchars($point['id']); ?>"
                                       class="btn btn-outline-danger btn-sm ms-2" onclick="return confirm('Удалить?')">Удалить</a>
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
    <?php if (isset($pages) && $pages > 0): ?>
        <div class="mb-4">
            <?php if ($page > 1): ?>
                <a href="?action=index&point_id=<?= $point_id ?>&page=<?= $page - 1 ?>">← Назад</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <?php if ($i == $page): ?>
                    <strong><?= $i ?></strong>
                <?php else: ?>
                    <a href="?action=index&point_id=<?= $point_id ?>&page=<?= $i ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page < $pages): ?>
                <a href="?action=index&point_id=<?= $point_id ?>&page=<?= $page + 1 ?>">Вперёд →</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Кнопка назад -->
    <div class="mb-3">
        <button onclick="history.back()" class="btn btn-secondary">← Назад</button>
    </div>

</div>

<?php include '../../app/includes/footer.php'; ?>