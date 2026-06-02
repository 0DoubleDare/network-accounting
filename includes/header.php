<?php
/**
 * Шапка сайта. Открывает HTML, показывает меню, подключает стили. Используем на всех страницах в самом конце.
 */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Учёт сетевой инфраструктуры</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header style="background: white; padding: 20px 40px; border-bottom: 1px solid #c0c0c0;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1 style="color: #333; font-size: 24px; font-weight: 600;">🍵 Network accounting</h1>
        <nav style="display: flex; gap: 12px;">
            <a href="view/registration.php"><button type="button" class="btn btn-primary">Регистрация</button></a>
            <a href="view/login.php"><button type="button" class="btn btn-success">Войти</button></a>
        </nav>
    </div>
</header>
</body>
</html>