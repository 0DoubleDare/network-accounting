<?php
/**
 * Журнал действий. Кто, когда и что делал в системе (т.е. кто добавил, кто удалил)
 */
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 mb-0" style="color: #000;">Журнал действий системы</h1>
        <a href="../" class="btn btn-outline-primary" style="color: #000;">← Назад</a>
    </div>

    <!-- Форма фильтрации -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0" style="color: #fff;">Фильтры</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="" class="row g-3">
                <div class="col-md-3">
                    <select name="user_id" class="form-select" style="color: #000;">
                        <option value="">Все пользователи</option>
                        <?php foreach ($logUsers as $user): ?>
                            <option value="<?= $user['id'] ?>" <?= isset($_GET['user_id']) && $_GET['user_id'] == $user['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($user['login']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="role" class="form-select" style="color: #000;">
                        <option value="">Все роли</option>
                        <?php foreach ($logRoles as $role): ?>
                            <option value="<?= htmlspecialchars($role) ?>" <?= isset($_GET['role']) && $_GET['role'] == $role ? 'selected' : '' ?>>
                                <?= htmlspecialchars($role) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="action" class="form-select" style="color: #000;">
                        <option value="">Все действия</option>
                        <?php foreach ($logActions as $action): ?>
                            <option value="<?= htmlspecialchars($action) ?>" <?= isset($_GET['action']) && $_GET['action'] == $action ? 'selected' : '' ?>>
                                <?= htmlspecialchars($action) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="target_table" class="form-select" style="color: #000;">
                        <option value="">Все таблицы</option>
                        <?php foreach ($logTables as $table): ?>
                            <option value="<?= htmlspecialchars($table) ?>" <?= isset($_GET['target_table']) && $_GET['target_table'] == $table ? 'selected' : '' ?>>
                                <?= htmlspecialchars($table) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <input type="date" name="date_from" class="form-control" style="color: #000;"
                           value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>">
                </div>

                <div class="col-md-2">
                    <input type="date" name="date_to" class="form-control" style="color: #000;"
                           value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary" style="color: #fff;">Фильтр</button>
                    <a href="../controllers/exportcontroller.php?type=logs">Экспорт</a>
                    <a href="?" class="btn btn-outline-secondary" style="color: #000;">Сбросить</a>
                </div>
            </form>
        </div>
    </div>

    <?php if (empty($result['logs'])): ?>
        <div class="alert alert-info" style="color: #000;">Журнал действий пуст</div>
    <?php else: ?>
        <p style="color: #000;">Всего записей: <?= $result['total'] ?></p>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                <tr style="color: #000;">
                    <th>ID</th>
                    <th>Пользователь</th>
                    <th>Роль</th>
                    <th>Действия</th>
                    <th>Таблица</th>
                    <th>ID запись</th>
                    <th>Дата и время</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($result['logs'] as $log): ?>
                    <tr style="color: #000;">
                        <td><?= htmlspecialchars($log['id']) ?></td>
                        <td><?= htmlspecialchars($log['login'] ?? 'Система') ?></td>
                        <td><?= htmlspecialchars($log['role'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($log['action']) ?></td>
                        <td><?= htmlspecialchars($log['target_table'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($log['target_id'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($log['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if ($result['totalPages'] > 1): ?>
            <div class="mt-3">
                <?php
                $currentUrl = strtok($_SERVER['REQUEST_URI'], '?');
                $queryParams = $_GET;

                if ($result['page'] > 1): ?>
                    <a href="<?= $currentUrl . '?' . http_build_query(array_merge($queryParams, ['page' => $result['page'] - 1])) ?>"
                       class="btn btn-outline-primary" style="color: #000;">← Предыдущая</a>
                <?php else: ?>
                    <button class="btn btn-outline-secondary" disabled style="color: #000;">← Предыдущая</button>
                <?php endif; ?>

                <span class="mx-3"
                      style="color: #000;">Страница <?= $result['page'] ?> из <?= $result['totalPages'] ?></span>

                <?php if ($result['page'] < $result['totalPages']): ?>
                    <a href="<?= $currentUrl . '?' . http_build_query(array_merge($queryParams, ['page' => $result['page'] + 1])) ?>"
                       class="btn btn-outline-primary" style="color: #000;">Следующая →</a>
                <?php else: ?>
                    <button class="btn btn-outline-secondary" disabled style="color: #000;">Следующая →</button>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>