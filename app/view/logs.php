<?php
/**
 * Журнал действий. Кто, когда и что делал в системе
 */
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Журнал действий системы</h2>
        <button onclick="history.back()" class="btn btn-secondary">Назад</button>
    </div>

    <?php if (empty($logs)): ?>
        <div class="alert alert-info">Журнал действий пуст</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Пользователь</th>
                        <th>Роль</th>
                        <th>Действие</th>
                        <th>Таблица</th>
                        <th>ID записи</th>
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
        </div>
    <?php endif; ?>
</div>