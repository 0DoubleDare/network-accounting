<?php
session_start();

// Если перешли на страницу инвентаря

/**
 * Главная страница
 */
//session_start();
//print_r($_SESSION);
require '../config/db.php';
require '../app/includes/functions.php';

$count = getPointsCount($pdo);
$materials = getMaterialsStats($pdo);
$defectCount = getDefectsCount($pdo);

?>
<?php include '../app/includes/header.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form>
        <h4>Количество сетевых точек</h4>
        <h5> <?php echo $count  ?></h5><br>

        <h4>Общее количество материалов</h4>
        <h5><?php echo $materials['unique_types'];  ?></h5>

        <h4>Общее количество записей о списанных материалах</h4>
        <h5><?php echo $materials['total_records'];  ?></h5>

        <h4>Общее количество Дефектов</h4>
        <h5><?php echo $defectCount;  ?></h5>

    </form>
</body>
</html>

<?php include '../app/includes/footer.php'; ?>