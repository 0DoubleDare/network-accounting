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

    <div class="container py-4">
        <div class="row g-4 mb-5 mx-auto d-flex align-items-center justify-content-center">
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
                        <h2 class="display-4 fw-bold mb-0 text-dark"><?= $materials['unique_types']; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center bg-white">
                    <div class="card-body py-4">
                        <h4 class="text-dark">Общее количество записей о списанных материалах</h4>
                        <h2 class="display-4 fw-bold mb-0 text-dark"><?= $materials['total_quantity']; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center bg-white">
                    <div class="card-body py-4">
                        <h4 class="text-dark">Общее количество Дефектов</h4>
                        <h2 class="display-4 fw-bold mb-0 text-dark"><?= $defectCount; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center bg-white">
                    <div class="card-body py-4">
                        <h4 class="text-dark">Использовано метров материала</h4>
                        <h2 class="display-4 fw-bold mb-0 text-dark"><?= $totalMeterUse; ?></h2>
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
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <h5 class="card-title text-center text-dark mb-0">Статусы сетевых точек</h5>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="networkPointStatus"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <h5 class="card-title text-center text-dark mb-0">Типы сетевых точек</h5>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="networkPointCategories"></canvas>
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
                        'rgb(13 110 253 / 0.7)',
                        'rgb(13 202 240 / 0.7)',
                        'rgb(25 135 84 / 0.7)',
                        'rgb(255 193 7 / 0.7)',
                        'rgb(108 117 125 / 0.7)',
                        'rgb(220 53 69 / 0.7)'
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
                        'rgb(13 110 253 / 0.7)',
                        'rgb(13 202 240 / 0.7)',
                        'rgb(25 135 84 / 0.7)',
                        'rgb(255 193 7 / 0.7)',
                        'rgb(108 117 125 / 0.7)',
                        'rgb(220 53 69 / 0.7)',
                        'rgb(93 13 253 / 0.7)',
                        'rgb(253 81 13 / 0.7)',
                        'rgb(61 253 13 / 0.7)',
                        'rgb(13 233 253 / 0.7)',
                        "rgb(253 153 13 / 0.7)"
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
        const ctx_network_points_status = document.getElementById('networkPointStatus').getContext('2d');
        const network_points_status = new Chart(ctx_network_points_status, {
            type: 'pie', // Тип диаграммы: bar (столбцы), line (линия), pie (круговая)
            data: {
                // labels: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн'],
                labels: <?php echo json_encode($networkPointsWithStatus['categories']); ?>,
                datasets: [{
                    label: 'Количество',
                    // data: [12, 19, 3, 5, 2, 3],
                    data: <?= json_encode($networkPointsWithStatus['count']); ?>,
                    backgroundColor: [
                        'rgb(13 110 253 / 0.7)',
                        'rgb(44 13 200 / 0.7)',
                        'rgb(21 244 205 / 0.7)',
                        'rgb(103 244 21 / 0.7)',
                        'rgb(244 66 21 / 0.7)',
                        'rgb(255 120 2 / 0.7)'
                    ],
                    borderColor: 'rgb(13 110 253 / 0.7)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true, // Обеспечивает адаптивность под размер сетки Bootstrap
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctx_network_point_categories = document.getElementById('networkPointCategories').getContext('2d');
        const network_point_categories = new Chart(ctx_network_point_categories, {
            type: 'pie', // Тип диаграммы: bar (столбцы), line (линия), pie (круговая)
            data: {
                // labels: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн'],
                labels: <?= json_encode($networkPointsWithCategories['categories']); ?>,
                datasets: [{
                    label: 'Количество',
                    // data: [12, 19, 3, 5, 2, 3],
                    data: <?= json_encode($networkPointsWithCategories['count']); ?>,
                    backgroundColor: [
                        'rgb(13 110 253 / 0.7)',
                        'rgb(13 202 240 / 0.7)',
                        'rgb(25 135 84 / 0.7)',
                        'rgb(255 193 7 / 0.7)',
                        'rgb(108 117 125 / 0.7)',
                        'rgb(220 53 69 / 0.7)'
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