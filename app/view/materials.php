<?php
/**
 * Учёт расходников. Кабели (м.), коннекторы (шт.), розетки (шт.).
 */
?>
<?php include '../app/includes/header.php'; ?>

<h1>Учёт материалов</h1>
<p>
    <a href="../public/index.php">Назад</a>
</p>
<p>
    <a href="?action=add">
        <button type="button">Добавить материал</button>
    </a>
</p>

<!-- Форма фильтрации -->
<form method="GET" action="">
    <table border="0" cellpadding="5">
        <tr>
            <td>
                <label>Название:</label><br>
                <input type="text" name="name" value="<?php echo htmlspecialchars($_GET['name'] ?? ''); ?>" placeholder="Поиск по названию">
            </td>
            <td>
                <label>Тип:</label><br>
                <select name="type">
                    <option value="">Все типы</option>
                    <?php foreach ($materialTypes as $type): ?>
                        <option value="<?php echo $type['id']; ?>" <?php echo (isset($_GET['type']) && $_GET['type'] == $type['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($type['display_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td>
                <label>Единица измерения:</label><br>
                <select name="unit">
                    <option value="">Все</option>
                    <?php foreach ($materialUnits as $unit): ?>
                        <option value="<?php echo htmlspecialchars($unit); ?>" <?php echo (isset($_GET['unit']) && $_GET['unit'] == $unit) ? 'selected' : ''; ?>>
                            <?php echo ($unit == 'm') ? 'метр' : 'штука'; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td>
                <br>
                <button type="submit">Фильтр</button>
                <a href="?">Сбросить</a>
            </td>
        </tr>
    </table>
</form>

<br>

<?php if (empty($result['materials'])): ?>
    <p>Нет данных</p>
<?php else: ?>
<p>Всего записей: <?php echo $result['total']; ?></p>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Тип</th>
                <th>Единица измерения</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($result['materials'] as $material): ?>
            <tr>
                <td><?php echo $material['id']; ?></td>
                <td><?php echo htmlspecialchars($material['name']); ?></td>
                <td><?php echo htmlspecialchars($material['type_name']); ?></td>
                <td>
                    <?php 
                    if ($material['unit'] == 'm') {
                        echo 'метр';
                    } else {
                        echo 'штука';
                    }
                    ?>
                </td>
                <td>
                    <a href="?action=edit&id=<?php echo $material['id']; ?>">
                        <button type="button">Изменить</button>
                    </a>
                    <a href="?action=delete&id=<?php echo $material['id']; ?>">
                        <button type="button">Удалить</button>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<!-- Пагинация -->
    <?php if ($result['totalPages'] > 1): ?>
        <p>
            <?php
            $currentUrl = strtok($_SERVER['REQUEST_URI'], '?');
            $queryParams = $_GET;
            unset($queryParams['page']);
            
            if ($result['page'] > 1): ?>
                <a href="<?php echo $currentUrl . '?' . http_build_query(array_merge($queryParams, ['page' => $result['page'] - 1])); ?>">← Предыдущая</a>
            <?php else: ?>
                <span>← Предыдущая</span>
            <?php endif; ?>
            
            <span> Страница <?php echo $result['page']; ?> из <?php echo $result['totalPages']; ?> </span>
            
            <?php if ($result['page'] < $result['totalPages']): ?>
                <a href="<?php echo $currentUrl . '?' . http_build_query(array_merge($queryParams, ['page' => $result['page'] + 1])); ?>">Следующая →</a>
            <?php else: ?>
                <span>Следующая →</span>
            <?php endif; ?>
        </p>
    <?php endif; ?>
<?php endif; ?>

<?php include '../app/includes/footer.php'; ?>