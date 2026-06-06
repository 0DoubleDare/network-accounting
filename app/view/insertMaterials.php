<?php
require '../../config/db.php';
require '../includes/functions.php';

$types = materialType($pdo);

?>

<?php include '../includes/header.php'; ?>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Добавление материала</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="../../controllers/insertMaterials.php">
                            <div class="mb-3">
                                <label class="form-label">Название</label>
                                <input type="text" name="name" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Тип</label>
                                <select name="type" class="form-select">
                                    <?php foreach ($types as $type): ?>
                                        <option value="<?= $type['id'] ?>"><?php echo htmlspecialchars($type['display_name']); ?></option>
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

                            <button type="submit" class="btn btn-primary">Добавить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include '../includes/footer.php'; ?>