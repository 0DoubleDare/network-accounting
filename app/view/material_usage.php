<?php
/**
 * Страница просмотра использованных материалов
 */
?>

<?php include '../app/includes/header.php'; ?>

<h1>Использованные материалы</h1>

<p>
    <a href="../public/index.php">назад</a>
</p>

<!-- Форма фильтрации -->
<form method="GET" action="">
    <input type="hidden" name="action" value="index">
    
    <table border="0" cellpadding="5">
        <tr>
            <td><label>Материал:</label></td>
            <td>
                <select name="material_id">
                    <option value="">Все</option>
                    <?php foreach ($materialsList as $material): ?>
                        <option value="<?php echo $material['id']; ?>" 
                            <?php echo (isset($_GET['material_id']) && $_GET['material_id'] == $material['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($material['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
            
            <td><label>Сетевая точка:</label></td>
            <td>
                <select name="point_id">
                    <option value="">Все</option>
                    <?php foreach ($pointsList as $point): ?>
                        <option value="<?php echo $point['id']; ?>" 
                            <?php echo (isset($_GET['point_id']) && $_GET['point_id'] == $point['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($point['label'] . ' (' . $point['location'] . ')'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><label>Пользователь:</label></td>
            <td>
                <select name="used_by">
                    <option value="">Все</option>
                    <?php foreach ($usersList as $user): ?>
                        <option value="<?php echo $user['id']; ?>" 
                            <?php echo (isset($_GET['used_by']) && $_GET['used_by'] == $user['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($user['login']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
            
            <td><label>Дата с:</label></td>
            <td><input type="date" name="date_from" value="<?php echo htmlspecialchars($_GET['date_from'] ?? ''); ?>"></td>
            
            <td><label>по:</label></td>
            <td><input type="date" name="date_to" value="<?php echo htmlspecialchars($_GET['date_to'] ?? ''); ?>"></td>
            
            <td>
                <button type="submit">Применить</button>
                <a href="?action=index">Сбросить</a>
            </td>
        </tr>
    </table>
</form>

<br>

<!-- Таблица  -->
<?php if (empty($result['items'])): ?>
    <p><strong>Нет данных об использовании материалов.</strong></p>
<?php else: ?>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr bgcolor="#f0f0f0">
                <th>ID</th>
                <th>Материал</th>
                <th>Тип</th>
                <th>Количество</th>
                <th>Ед. изм.</th>
                <th>Точка</th>
                <th>Локация</th>
                <th>Кто использовал</th>
                <th>Дата использования</th>
                <th>Комментарий</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result['items'] as $item): ?>
                <tr>
                    <td><?php echo $item['id']; ?></td>
                    <td><?php echo htmlspecialchars($item['material_name'] ?? '—'); ?></td>
                    <td><?php echo htmlspecialchars($item['material_type'] ?? '—'); ?></td>
                    <td align="right"><?php echo $item['quantity']; ?></td>
                    <td><?php echo $item['unit'] == 'm' ? 'м' : 'шт'; ?></td>
                    <td><?php echo htmlspecialchars($item['point_label'] ?? '—'); ?></td>
                    <td><?php echo htmlspecialchars($item['point_location'] ?? '—'); ?></td>
                    <td><?php echo htmlspecialchars($item['used_by_login'] ?? '—'); ?></td>
                    <td><?php echo $item['used_at']; ?></td>
                    <td><?php echo htmlspecialchars($item['comment'] ?? ''); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <!-- Пагинация -->
    <?php if ($result['totalPages'] > 1): ?>
        <p>
            <?php if ($result['page'] > 1): ?>
                <a href="?action=index&page=<?php echo $result['page'] - 1; ?>&material_id=<?php echo urlencode($_GET['material_id'] ?? ''); ?>&point_id=<?php echo urlencode($_GET['point_id'] ?? ''); ?>&used_by=<?php echo urlencode($_GET['used_by'] ?? ''); ?>&date_from=<?php echo urlencode($_GET['date_from'] ?? ''); ?>&date_to=<?php echo urlencode($_GET['date_to'] ?? ''); ?>">← Предыдущая</a>
            <?php else: ?>
                ← Предыдущая
            <?php endif; ?>
            
            &nbsp; Страница <?php echo $result['page']; ?> из <?php echo $result['totalPages']; ?> &nbsp;
            
            <?php if ($result['page'] < $result['totalPages']): ?>
                <a href="?action=index&page=<?php echo $result['page'] + 1; ?>&material_id=<?php echo urlencode($_GET['material_id'] ?? ''); ?>&point_id=<?php echo urlencode($_GET['point_id'] ?? ''); ?>&used_by=<?php echo urlencode($_GET['used_by'] ?? ''); ?>&date_from=<?php echo urlencode($_GET['date_from'] ?? ''); ?>&date_to=<?php echo urlencode($_GET['date_to'] ?? ''); ?>">Следующая →</a>
            <?php else: ?>
                Следующая →
            <?php endif; ?>
        </p>
    <?php endif; ?>
    
    <p><strong>Всего записей: <?php echo $result['total']; ?></strong></p>
    
<?php endif; ?>

<?php include '../app/includes/footer.php'; ?>