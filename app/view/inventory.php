<!-- /**
 * Реестр оборудования (список). Фильтры, пагинация, поиск, метка, тип, расположение, статус.
 */ -->
<?php
if (!isset($points)) {
    require_once __DIR__ . '/../includes/functions.php';
    require_once __DIR__ . '/../../config/db.php';
    $points = getAllInventory($pdo);
    $point_id = $_GET['point_id'] ?? $_POST['point_id'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Инвентарь</title>
</head>
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
                    <a href="../controllers/defectscontroller.php?point_id=<?= $point['id'] ?>">Перейти к дефектам</a>
                    <a href="./deleteNetworkPoint.php?id=<?php echo htmlspecialchars($point['id']); ?>" class="btn btn-danger">Удалить</a>
                    <a href="../app/view/updateNetworkPoint.php?id=<?php echo htmlspecialchars($point['id']); ?>" class="btn btn-warning">Изменить</a>
                </th>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <!-- Кнопка назад на главную страницу -->
    <div class="mb-3">
        <button onclick="history.back()" class="btn btn-secondary">← Назад</button>
    </div>
</div>
</body>
</html>