<?php
require '../../config/db.php';
require '../includes/functions.php';

$types = materialType($pdo);

?>


<?php include '../includes/header.php'; ?>
    </head>
    <body>
    <form method="post" action="../../controllers/insertMaterials.php">
        <label>Название</label><br>
        <input type="text" name="name"><br><br>

        <label>тип</label><br>
        <select name="type">
            <?php foreach ($types as $type): ?>
                <option value="<?= $type['id'] ?>"><?php echo htmlspecialchars($type['display_name']); ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Единица измерения</label><br>
        <select name="unit">
            <option value="m">m</option>
            <option value="pcs">pcs</option>
        </select><br><br>

        <button type="submit">Добавить</button>

    </form>
    </body>

<?php include '../includes/footer.php'; ?>