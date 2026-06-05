<?php
require '../../config/db.php';
require '../includes/functions.php';
$id = $_GET['id'];
$idMaterials = materialsId($pdo, $id);
$typesId = materialTypeId($pdo, $id);
$types = materialType($pdo);
?>

<?php include '../app/includes/header.php'; ?>
</head>
<body>
    <form method="post" action="../../controllers/updateMaterialsControllers.php">
    <input type="hidden" name="id" value="<?php echo $idMaterials['id']; ?>">
    
    <label>Название</label><br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($idMaterials['name']); ?>"><br><br>

        <label>тип</label><br>
        <select name="type">

        <?php foreach($typesId as $typeId): ?>
            <option value="<?= $typeId['id']?>" <?= $typeId['id'] == $idMaterials['type'] ? 'selected' : ''?> >
                <?= $typeId['display_name']; ?>
            </option>
            <?php endforeach; ?>

            <?php foreach($types as $type): ?>
            <option value="<?= $type['id']?>"><?php echo htmlspecialchars($type['name']); ?></option>
            <?php endforeach; ?>
        </select><br><br>
        
        <label>Единица измерения</label><br>
        <select name="unit">
            <option value="<?= $idMaterials['id']?>"><?php echo htmlspecialchars($idMaterials['unit']);?></option>

            <option value="m">m</option>
            <option value="pcs">pcs</option>
        </select><br><br>

        <button type="submit">Редактировать</button>


    </form>
</body>
<?php include '../app/includes/footer.php'; ?>