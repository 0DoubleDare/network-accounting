<?php
require '../../../config/db.php';
require '../../includes/functions.php';

$types = materialType($pdo);
?>

<?php include '../../includes/header.php'; ?>

<div class="container my-5">
    <div class="mb-4">
        <button onclick="history.back()" class="btn btn-sm btn-outline-secondary">
            &larr; Назад
        </button>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-secondary-subtle bg-white shadow-sm">
                <div class="card-body p-4">

                    <h2 class="h4 mb-4 fw-bold text-dark">Добавление материала</h2>

                    <form method="post" action="../../../controllers/materials/insert_material.php" class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-medium text-muted">Название</label>
                            <input type="text" name="name" class="form-control" required
                                   placeholder="Введите название материала">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-medium text-muted">Тип</label>
                            <select name="type" class="form-select">
                                <?php foreach ($types as $type): ?>
                                    <option value="<?= $type['id'] ?>"><?php echo htmlspecialchars($type['display_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12 mb-2">
                            <label class="form-label small fw-medium text-muted">Единица измерения</label>
                            <select name="unit" class="form-select">
                                <option value="m">m (метры)</option>
                                <option value="pcs">pcs (штуки)</option>
                            </select>
                        </div>
                        <div class="col-12 pt-2">
                            <button type="submit" class="btn btn-primary w-100">Добавить материал</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
