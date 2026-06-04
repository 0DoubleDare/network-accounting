<?php
/**
 * Журнал действий. Кто, когда и что делал в системе (т.е. кто добавил, кто удалил)
 */
?>

<h1>Журнал действий системы</h1>

<form method="GET" action="">
    <select name="user_id">
        <option value="">Все пользователи</option>
        <?php foreach ($logUsers as $user): ?>
            <option value="<?= $user['id'] ?>" <?= isset($_GET['user_id']) && $_GET['user_id'] == $user['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($user['login']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    
    <select name="role">
        <option value="">Все роли</option>
        <?php foreach ($logRoles as $role): ?>
            <option value="<?= htmlspecialchars($role) ?>" <?= isset($_GET['role']) && $_GET['role'] == $role ? 'selected' : '' ?>>
                <?= htmlspecialchars($role) ?>
            </option>
        <?php endforeach; ?>
    </select>
    
    <select name="action">
        <option value="">Все действия</option>
        <?php foreach ($logActions as $action): ?>
            <option value="<?= htmlspecialchars($action) ?>" <?= isset($_GET['action']) && $_GET['action'] == $action ? 'selected' : '' ?>>
                <?= htmlspecialchars($action) ?>
            </option>
        <?php endforeach; ?>
    </select>
    
    <select name="target_table">
        <option value="">Все таблицы</option>
        <?php foreach ($logTables as $table): ?>
            <option value="<?= htmlspecialchars($table) ?>" <?= isset($_GET['target_table']) && $_GET['target_table'] == $table ? 'selected' : '' ?>>
                <?= htmlspecialchars($table) ?>
            </option>
        <?php endforeach; ?>
    </select>
    
    <input type="date" name="date_from" value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>">
    <input type="date" name="date_to" value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>">
    
    <button type="submit">Фильтр</button>
    <a href="?">Сбросить</a>
</form>

<a href="../public/index.php"><button>Назад</button></a>

<?php if (empty($result['logs'])): ?>
    <p>Журнал действий пуст</p>
<?php else: ?>
    <p>Всего записей: <?= $result['total'] ?></p>
    
    <table border="1">
        <thead>
            <tr>
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
                <tr>
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
    
<?php if ($result['totalPages'] > 1): ?>
    <div style="margin-top: 20px;">
        <?php
        $currentUrl = strtok($_SERVER['REQUEST_URI'], '?');
        $queryParams = $_GET;
        
        if ($result['page'] > 1): ?>
            <a href="<?= $currentUrl . '?' . http_build_query(array_merge($queryParams, ['page' => $result['page'] - 1])) ?>">
                <button>← Предыдущая</button>
            </a>
        <?php else: ?>
            <button disabled>← Предыдущая</button>
        <?php endif; ?>
        
        <span style="margin: 0 15px;">Страница <?= $result['page'] ?> из <?= $result['totalPages'] ?></span>
        
        <?php if ($result['page'] < $result['totalPages']): ?>
            <a href="<?= $currentUrl . '?' . http_build_query(array_merge($queryParams, ['page' => $result['page'] + 1])) ?>">
                <button>Следующая →</button>
            </a>
        <?php else: ?>
            <button disabled>Следующая →</button>
        <?php endif; ?>
    </div>
<?php endif; ?>
    
<?php endif; ?>