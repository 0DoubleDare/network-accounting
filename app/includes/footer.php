<?php
/**
 * Подвал сайта. Закрывает теги, подключает скрипты, используем на всех страницах в самом конце
 */
?>

</main>

<footer class="site-footer bg-white pt-2 pb-4 mt-auto border-top">
    <div class="container">
        <!-- text-md-start выравнивает левую часть по левому краю, а на мобилках центрует -->
        <div class="row text-center text-md-start align-items-start">

            <!-- Левая колонка с названием проекта (поставили mt-5, чтобы опустить текст ниже) -->
            <div class="col-md-6 col-lg-4 mt-5">
                <h3 class="mb-3">Network accounting</h3>
                <p class="text-muted">Учёт сетевой инфраструктуры</p>
            </div>

            <!-- Правая колонка: ms-auto толкает её вправо, text-md-end выравнивает контент по правому краю -->
            <div class="col-md-6 col-lg-4 mt-5 ms-auto text-md-end">
                <h4 class="mb-3">Соцсети</h4>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="https://github.com/0DoubleDare/network-accounting/tree/main"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="text-decoration-none text-dark">
                            <i class="fab fa-github me-2"></i>GitHub
                        </a>
                    </li>
                </ul>
                <p class="copyright text-muted mt-4">
                    &copy; 2026 Network accounting
                </p>
            </div>

        </div>
    </div>
</footer>

</body>
</html>