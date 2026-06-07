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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<header class="site-header">
    <div class="header-container">
        <a href="<?= $web_root ?>" class="site-logo">
            <h1 class="logo-title">Network accounting</h1>
        </a>

        <a href="<?= $web_root ?>controllers/inventory/inventory_view.php?action=index">
            <button type="button" class="btn btn-info">Инвентарь</button>
        </a>
        <a href="<?= $web_root ?>controllers/materials/materials_view.php?action=index">
            <button type="button" class="btn btn-info">Материалы</button>
        </a>
        <a href="<?= $web_root ?>controllers/materials_usage/materials_usage_view.php?action=index">
            <button type="button" class="btn btn-info">Расход материалов</button>
        </a>
        <nav style="display: flex; gap: 12px; align-items: center">
            <?php if (isset($_SESSION['user_info']) && !empty($_SESSION['user_info'])): ?>
                <span class=""><?php echo htmlspecialchars($_SESSION['user_info']['login'] ?? ''); ?></span>

                <?php if (isset($_SESSION['user_info']['role']) && $_SESSION['user_info']['role'] === 'admin'): ?>
                    <a href="<?= $web_root ?>controllers/logs.php?action=index">
                        <button type="button" class="btn btn-secondary">Журнал действий</button>
                    </a>
                <?php endif; ?>

                <a href="<?= $web_root ?>controllers/user/logout.php">
                    <button type="button" class="btn btn-danger">Выйти</button>
                </a>
            <?php else: ?>
                <a href="<?= $web_root ?>app/view/user/registration.php">
                    <button type="button" class="btn btn-primary">Регистрация</button>
                </a>
                <a href="<?= $web_root ?>app/view/user/login.php">
                    <button type="button" class="btn btn-success">Войти</button>
                </a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="content">