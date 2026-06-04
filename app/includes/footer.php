<?php
/**
 * Подвал сайта. Закрывает теги, подключает скрипты, используем на всех страницах в самом конце
 */
?>
<!-- Подключаем Bootstrap 5 CSS и иконки -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="assets/css/style.css">

</main>
<footer class="site-footer bg-white pt-5 pb-4 mt-auto border-top">
    <div class="container">
        <div class="row text-center text-md-start">
            <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mt-3">
                <h3 class="mb-3">Сетевая бухгалтерия</h3>
                <p class="text-muted">Учёт сетевой инфраструктуры</p>
            </div>
                <div class="col-md-5 col-lg-10 col-xl-5 mt-3" style="margin-left: auto;">
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
                                    <p class="copyright text-muted">
                    &copy; <?php echo date('Y'); ?> Сетевая бухгалтерия
                </p>
            </div>


            </div>
        </div>
    </div>
</footer>

</body>
</html>