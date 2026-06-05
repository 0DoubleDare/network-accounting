<?php
/**
 * Учёт бракованных товаров. Список того что сломалось. Добавление дефекта или редактирование
 */
?>


<body>
<div>
    <h1>Дефекты точки: <?= htmlspecialchars($point['label'] ?? '') ?></h1>
    <p><strong>Расположение:</strong> <?= htmlspecialchars($point['location'] ?? '—') ?></p>
    <p><strong>Статус точки:</strong> <?= $point['status_name'] ?? '—' ?></p>
    <p><strong>Фото:</strong> <?php $point['image_path'] ?? '' ?>
            <img src="../public/storage/defects/картинкаа крутогоо котаа.webp"></p>
    
    <div>
        <a href="../controllers/inventorycontroller.php?action=index">← Назад к точкам</a>
        <!-- Форма фильтрации -->
<div>
    <form method="get">
        <input type="hidden" name="action" value="index">
        <input type="hidden" name="point_id" value="<?= $point_id ?>">
        
        <label>Категория:</label>
        <select name="category">
            <option value="">Все</option>
            <option value="Скрутка">Скрутка</option>
            <option value="Крепление">Крепление</option>
            <option value="Кабель">Кабель</option>
            <option value="Механический">Механический</option>
            <option value="Электрический">Электрический</option>
        </select>
        
        <label>Критичность:</label>
        <select name="severity">
            <option value="">Все</option>
            <option value="high">Высокая</option>
            <option value="medium">Средняя</option>
            <option value="low">Низкая</option>
        </select>
        
        <label>Статус:</label>
        <select name="status">
            <option value="">Все</option>
            <option value="open">Открыт</option>
            <option value="in_progress">В работе</option>
            <option value="closed">Закрыт</option>
        </select>
        
        <button type="submit">Применить фильтр</button>
        <a href="?action=index&point_id=<?= $point_id ?>">Сбросить</a>
    </form>
</div>
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
    
    <!-- Пагинация -->
    <?php if (isset($pages) && $pages > 0): ?>
    <div>
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
</div>    
</body>
