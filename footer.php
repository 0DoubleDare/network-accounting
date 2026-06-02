<?php
/**
 * Подвал сайта. Закрывает теги, подключает скрипты, используем на всех страницах в самом конце
 */
?>
<!-- Подключаем стили прямо из футера -->
<link rel="stylesheet" href="/assets/css/style.css">
<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-section">
            <h3>Сетевая бухгалтерия</h3>
            <p>Учёт сетевой инфраструктуры</p>
        </div>
        
        <div class="footer-section">
            <h4>Соцсети</h4>
            <ul class="social-links">
                <li>
                    <a href="https://github.com/0DoubleDare/network-accounting/tree/main"
                        target="_blank" rel="noopener noreferrer">
                        GitHub
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="footer-section">
            <p class="copyright">
                &copy; <?php echo date('Y'); ?> Сетевая бухгалтерия
            </p>
        </div>
    </div>
</footer>
<!-- бутстрап -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- скрипты -->
<script src="assets/js/script.js"></script>
</body>
</html>
