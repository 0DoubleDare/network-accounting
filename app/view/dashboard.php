<?php
//session_start();
//
//// Если перешли на страницу инвентаря
//
///**
// * Главная страница
// */
////session_start();
////print_r($_SESSION);
//require '../config/db.php';
//require '../app/includes/functions.php';
//require '../app/includes/functions/get_dashbord_stats.php';
//
//$count = getPointsCount($pdo);
//$materials = getMaterialsStats($pdo);
//$defectCount = getDefectsCount($pdo);
//
//$defectCountWithCategories = getDefectCountWithCategories($pdo);
//$materialsCountWithCategories = getMaterialsCountWithCategories($pdo);
////echo '<pre>';
////print_r($defectCountWithCategories);
////print_r($materialsCountWithCategories);
////echo '</pre>';
//?>
<?php include './app/includes/header.php'; ?>

<!-- Зачем здесб форма?????????????????????????????? -->
<div class="container py-4">
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center bg-white">
                <div class="card-body py-4">
                    <h4 class="text-dark">Количество сетевых точек</h4>
                    <h2 class="display-4 fw-bold mb-0 text-dark"> <?php echo $count ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center bg-white">
                <div class="card-body py-4">
                    <h4 class="text-dark">Количество различных типов материалов</h4>
                    <h2 class="display-4 fw-bold mb-0 text-dark"><?php echo $materials['unique_types']; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center bg-white">
                <div class="card-body py-4">
                    <h4 class="text-dark">Общее количество записей о списанных материалах</h4>
                    <h2 class="display-4 fw-bold mb-0 text-dark"><?php echo $materials['total_quantity']; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center bg-white">
                <div class="card-body py-4">
                    <h4 class="text-dark">Общее количество Дефектов</h4>
                    <h2 class="display-4 fw-bold mb-0 text-dark"><?php echo $defectCount; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!--   ПРИМЕР СОЗДАНИЕ ДИАГРАММЫ С ИСПОЛЬЗОВАНИЕМ bootstrap 5 И charts.js -->

    <!-- Сам контейнер -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h5 class="card-title text-center text-dark mb-0">Дефекты оборудования</h5>
                </div>
                <div class="card-body p-4">
                    <canvas id="defectsStats"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h5 class="card-title text-center text-dark mb-0">Использование материалов</h5>
                </div>
                <div class="card-body p-4">
                    <canvas id="materialStats"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS Код для вывода самой диаграммы -->
<script>
    const ctx_defects = document.getElementById('defectsStats').getContext('2d');
    const defects_stats = new Chart(ctx_defects, {
        type: 'pie', // Тип диаграммы: bar (столбцы), line (линия), pie (круговая)
        data: {
            // labels: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн'],
            labels: <?php echo json_encode($defectCountWithCategories['categories']); ?>,
            datasets: [{
                label: 'Количество',
                // data: [12, 19, 3, 5, 2, 3],
                data: <?= json_encode($defectCountWithCategories['count']); ?>,
                backgroundColor: [
                    '#0d6efd',
                    '#0dcaf0',
                    '#198754',
                    '#ffc107',
                    '#6c757d',
                    '#dc3545'
                ],
                borderColor: '#ffffff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true, // Обеспечивает адаптивность под размер сетки Bootstrap
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const ctx_material = document.getElementById('materialStats').getContext('2d');
    const materials_stats = new Chart(ctx_material, {
        type: 'pie', // Тип диаграммы: bar (столбцы), line (линия), pie (круговая)
        data: {
            // labels: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн'],
            labels: <?php echo json_encode($materialsCountWithCategories['categories']); ?>,
            datasets: [{
                label: 'Количество',
                // data: [12, 19, 3, 5, 2, 3],
                data: <?= json_encode($materialsCountWithCategories['count']); ?>,
                backgroundColor: [
                    '#0d6efd',
                    '#0dcaf0',
                    '#198754',
                    '#ffc107',
                    '#6c757d',
                    '#dc3545'
                ],
                borderColor: '#ffffff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true, // Обеспечивает адаптивность под размер сетки Bootstrap
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php include './app/includes/footer.php'; ?>