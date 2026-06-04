<?php
/**
 * Учёт бракованных товаров. Список того что сломалось. Добавление дефекта или редактирование
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div>
    <h1>Дефекты точки: <?= htmlspecialchars($point['label'] ?? '') ?></h1>
    <p><strong>Расположение:</strong> <?= htmlspecialchars($point['location'] ?? '—') ?></p>
    <p><strong>Статус точки:</strong> <?= $point['status'] ?? '—' ?></p>
    
    <div>
        <a href="../controllers/inventorycontroller.php?action=index">← Назад к точкам</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Категория</th>
                <th>Критичность</th>
                <th>Описание</th>
                <th>Статус</th>
                <th>Автор</th>
                <th>Дата</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($defects)): ?>
                <tr><td>Нет дефектов для этой точки</td></tr>
            <?php else: ?>
                <?php foreach ($defects as $defect): ?>
                    <tr>
                        <td><?= $defect['id'] ?></td>
                        <td><?= htmlspecialchars($defect['category'] ?? '—') ?></td>
                        <td><?= $defect['severity'] ?></td>
                        <td><?= htmlspecialchars($defect['description']) ?></td>
                        <td><?= $defect['status'] ?></td>
                        <td><?= htmlspecialchars($defect['author'] ?? '—') ?></td>
                        <td><?= $defect['created_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>    
</body>
</html>
