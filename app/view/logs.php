<?php
/**
 * Журнал действий. Кто, когда и что делал в системе (т.е. кто добавил, кто удалил)
 */

?>
<h1>Журнал действий системы</h1>
    <button onclick="history.back()">Назад</button>
<?php if (empty($logs)): ?>
    <p>Журнал действий пуст</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Пользователь</th>
                <th>Роль</th>
                <th>Действия</th>
                <th>Табилица</th>
                <th>ID запись</th>
                <th>Дата и время</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?php echo htmlspecialchars($log['id']); ?></td>
                    <td><?php echo htmlspecialchars($log['login'] ?? 'Система'); ?></td>
                    <td><?php echo htmlspecialchars($log['role'] ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($log['action']); ?></td>
                    <td><?php echo htmlspecialchars($log['target_table'] ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($log['target_id'] ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($log['created_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
