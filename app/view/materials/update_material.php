<?php
require '../../../config/db.php';
require '../../includes/functions.php';
$id = $_GET['id'];
$idMaterials = materialsId($pdo, $id);
$typesId = materialTypeId($pdo, $id);
$types = materialType($pdo);
?>

<?php include '../../includes/header.php'; ?>
    <div class="container mt-4">
        <button onclick="history.back()" class="btn btn-sm btn-outline-secondary">
            &larr; Назад
        </button>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Редактирование материала</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="../../../controllers/materials/update_material.php">
                            <input type="hidden" name="id" value="<?php echo $idMaterials['id']; ?>">

                            <div class="mb-3">
                                <label class="form-label">Название</label>
                                <input type="text" name="name"
                                       value="<?php echo htmlspecialchars($idMaterials['name']); ?>"
                                       class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Тип</label>
                                <select name="type" class="form-select">
                                    <?php foreach ($typesId as $typeId): ?>
                                        <option value="<?= $typeId['id'] ?>" <?= $typeId['id'] == $idMaterials['type'] ? 'selected' : '' ?> >
                                            <?= $typeId['display_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                    <?php foreach ($types as $type): ?>
                                        <option value="<?= $type['id'] ?>"><?php echo htmlspecialchars($type['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Единица измерения</label>
                                <select name="unit" class="form-select">
                                    <option value="m">m</option>
                                    <option value="pcs">pcs</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Редактировать</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include '../../includes/footer.php'; ?>