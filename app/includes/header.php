<?php
// Берем корень нашего проекта. Нужно чтобы...
$web_root = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'))[0];
$web_root = '/' . $web_root . '/';
// $web_root = "/network-accounting/"

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
/**
 * Шапка сайта. Открывает HTML, показывает меню, подключает стили. Используем на всех страницах в самом конце.
 */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Учёт сетевой инфраструктуры</title>
    <link rel="stylesheet" href="<?= $web_root ?>public/assets/css/style.css">
    <script src="<?= $web_root ?>public/assets/js/script.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- <header style="background: white; padding: 20px 40px; border-bottom: 1px solid #c0c0c0;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <a href="<?= $web_root ?>public/index.php"><h1 style="color: #333; font-size: 24px; font-weight: 600;">🍵 Network accounting</h1></a>
        <nav style="display: flex; gap: 12px;">
            <a href="<?= $web_root ?>app/view/registration.php"><button type="button" class="btn btn-primary">Регистрация</button></a>
            <a href="<?= $web_root ?>app/view/login.php"><button type="button" class="btn btn-success">Войти</button></a></a>
            <a href="<?= $web_root ?>controllers/inventorycontroller.php?action=index"><button type="button" class="btn btn-info">Инвентарь</button></a> -->
<header class="site-header">
    <div class="header-container">
        <a href="<?= $web_root ?>public/index.php" class="site-logo">
            <h1 class="logo-title">Network accounting</h1>
        </a>
<nav style="display: flex; gap: 12px; align-items: center">
    <?php if (isset($_SESSION['user_info']) && !empty($_SESSION['user_info'])): ?>
        <span class=""><?php echo htmlspecialchars($_SESSION['user_info']['login'] ?? ''); ?></span>
        <a href="<?= $web_root ?>controllers/logout.php"><button type="button" class="btn btn-danger">Выйти</button></a>
    <?php else: ?>
        <a href="<?= $web_root ?>app/view/registration.php"><button type="button" class="btn btn-primary">Регистрация</button></a>
        <a href="<?= $web_root ?>app/view/login.php"><button type="button" class="btn btn-success">Войти</button></a>
        <a href="<?= $web_root ?>controllers/inventorycontroller.php?action=index"><button type="button" class="btn btn-info">Инвентарь</button></a>
    <?php endif; ?>
</nav>
    </div>
</header>
<main class="content">