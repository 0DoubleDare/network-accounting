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
//require '../app/includes/functions/dashbord_stats.php';
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
    <form>
        <h4>Количество сетевых точек</h4>
        <h5> <?php echo $count ?></h5><br>

        <h4>Количество различных типов материалов</h4>
        <h5><?php echo $materials['unique_types']; ?></h5>

        <h4>Общее количество записей о списанных материалах</h4>
        <h5><?php echo $materials['total_quantity']; ?></h5>

        <h4>Общее количество Дефектов</h4>
        <h5><?php echo $defectCount; ?></h5>

    </form>


    <!--   ПРИМЕР СОЗДАНИЕ ДИАГРАММЫ С ИСПОЛЬЗОВАНИЕМ bootstrap 5 И charts.js -->

    <!-- Сам контейнер -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card p-3">
                    <h5 class="card-title text-center">Дефекты оборудования</h5>
                    <!-- Холст (canvas) для отрисовки графика -->
                    <canvas id="defectsStats"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card p-3">
                    <h5 class="card-title text-center">Использование материалов</h5>
                    <!-- Холст (canvas) для отрисовки графика -->
                    <canvas id="materialStats"></canvas>
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
                        'rgb(13 110 253 / 0.56)',
                        'rgb(44 13 200 / 0.58)',
                        'rgb(21 244 205 / 0.55)',
                        'rgb(103 244 21 / 0.51)',
                        'rgb(244 66 21 / 0.53)',
                        'rgb(255 120 2 / 0.53)'
                    ],
                    borderColor: 'rgb(13 110 253 / 0.58)',
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
                        'rgb(13 110 253 / 0.56)',
                        'rgb(44 13 200 / 0.58)',
                        'rgb(21 244 205 / 0.55)',
                        'rgb(103 244 21 / 0.51)',
                        'rgb(244 66 21 / 0.53)',
                        'rgb(255 120 2 / 0.53)'
                    ],
                    borderColor: 'rgb(13 110 253 / 0.58)',
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

    </script>

<?php include './app/includes/footer.php'; ?>