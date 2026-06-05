<!-- /**
 * Реестр оборудования (список). Фильтры, пагинация, поиск, метка, тип, расположение, статус.
 */ -->
<?php
if (!isset($points)) {
    require_once __DIR__ . '/../includes/functions.php';
    require_once __DIR__ . '/../../config/db.php';
    include '../app/includes/header.php'; 
    $point_id = $_GET['point_id'] ?? $_POST['point_id'] ?? 0;
}
?>


<body>
<div class="container mt-4 w-20 p-3 border border-dark" style="background-color: #eee;">
    <h1 class="text-center">Реестр оборудования</h1>
    <a href="../app/view/insert_networck_point.php" class="btn btn-success mb-3">Добавить точку</a>
    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Метка</th>
                <th>Тип</th>
                <th>Расположение</th>
                <th>Статус</th>
                <th>Последние посещение</th>
                <th>Дата создания</th>
                <th>Кол-во дефектов</th>
                <th>Действие</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($points)): ?>
                <tr>
                    <td colspan="6">Нет данных</td>
                </tr>
            <?php else: ?>
                <?php foreach($points as $point): ?>
            <tr >
                <th><?php echo $point['id'] ?></th>
                <th><?php echo $point['label'] ?></th>
                <th><?php echo $point['type'] ?></th>
                <th><?php echo $point['location'] ?></th>
                <th><?php echo $point['status'] ?></th>
                <th>
                    <?php
                    //Посещение 
                    if (!empty($point['last_check'])) {
                        echo htmlspecialchars($point['last_check']);
                    } else {
                        echo '-';
                    }
                    ?>
                </th>
                <th><?php echo $point['point_created_at'] ?></th>
                <th>
                    <?php
                    // Получаем количество дефектов для точки
                        $sql = "SELECT COUNT(*) as defect_count FROM defects WHERE point_id = :point_id";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute(['point_id' => $point['id']]);
                        echo $stmt->fetchColumn();
                    ?>
                </th>
                
                <th>
                    <a href="../../controllers/defectscontroller.php?point_id=<?= $point['id'] ?>">Перейти к дефектам</a>
                    <a href="./deleteNetworkPoint.php?id=<?php echo htmlspecialchars($point['id']); ?>" class="btn btn-danger">Удалить</a>
                    <a href="../app/view/updateNetworkPoint.php?id=<?php echo htmlspecialchars($point['id']); ?>" class="btn btn-warning">Изменить</a>
                </th>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
<!-- Форма фильтрации -->
<div>
    <form method="get">
        <input type="hidden" name="action" value="index">
        
        <label>Метка:</label>
        <input type="text" name="label" value="<?= $_GET['label']?>">
        
        <label>Тип:</label>
        <select name="type">
            <option value="">Все</option>
            <?php foreach ($typeList as $type): ?>
                <option value="<?= $type['id'] ?>" <?= (isset($_GET['type']) && $_GET['type'] == $type['id'])?>><?= $type['display_name']?></option>
            <?php endforeach; ?>
        </select>
        
        <label>Расположение:</label>
        <input type="text" name="location" value="<?= $_GET['location']?>">
        
        <label>Статус:</label>
        <select name="status">
            <option value="">Все</option>
            <?php foreach ($statusList as $status): ?>
                <option value="<?= $status['id'] ?>" <?= (isset($_GET['status']) && $_GET['status'] == $status['id'])?>><?= htmlspecialchars($status['display_name']) ?></option>
            <?php endforeach; ?>
        </select>
        
        <button type="submit">Найти</button>
        <a href="?action=index">Сбросить</a>
    </form>
</div>
        <!-- Пагинация -->
    <?php if (isset($pages) && $pages > 0): ?>
    <div>
        <?php if ($page > 1): ?>
            <a href="?action=index&point_id=<?= $id ?>&page=<?= $page - 1 ?>">← Назад</a>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $pages; $i++): ?>
            <?php if ($i == $page): ?>
                <strong><?= $i ?></strong>
            <?php else: ?>
                <a href="?action=index&point_id=<?= $id ?>&page=<?= $i ?>"><?= $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>
        
        <?php if ($page < $pages): ?>
            <a href="?action=index&point_id=<?= $id ?>&page=<?= $page + 1 ?>">Вперёд →</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <!-- Кнопка назад на главную страницу -->
    <div class="mb-3">
        <button onclick="history.back()" class="btn btn-secondary">← Назад</button>
    </div>
    
</div>
</body>
<?php include '../app/includes/footer.php'; ?>
