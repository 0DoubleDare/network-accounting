<?php
session_start();
require '../config/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if (strlen($login) < 3) {
    $error = 'Логин должен содержать минимум 3 символа';
    }
    elseif (strlen($password) < 4) {
    $error = 'Пароль должен содержать минимум 4 символа';
    }
    elseif ($password !== $password_confirm) {
    $error = 'Пароли не совпадают';
    }
    else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE login = ?");
        $stmt->execute([$login]);
        if ($stmt->fetch()) {
            $error = 'Пользователь с таким логином уже существует';
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (login, password_hash, role) VALUES (?, ?, 'operator')");
            $stmt->execute([$login, $password_hash]);
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['login'] = $login;
            $_SESSION['role'] = 'operator';

header('Location: ../index.php');
exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet"  > <!-- href="путь для стилей" (ЭТУ Команду в тэг link после rel="stylesheet") -->
</head>
<body>
<!-- Пропуски для div ( для стилей ) -->
    <h1>Регистрация</h1>
<!-- Пропуски для div ( для стилей ) -->
    <form action="" method="post">
<!-- Пропуски для div ( для стилей ) -->
        <label>Логин</label>
        <input type="text" name="login" placeholder="Придумайте логин" value="<?php echo htmlspecialchars($_POST['login'] ?? ''); ?>" required><br><br>
<!-- Пропуски для div ( для стилей ) -->
        <label>Пароль</label>
        <input type="password" name="password" placeholder="Придумайте пароль" required><br><br>
<!-- Пропуски для div ( для стилей ) -->      
        <label>Подтвердить пароль</label>
        <input type="password" name="password_confirm" placeholder="Подтвердите пароль" required><br><br>
<!-- Пропуски для div ( для стилей ) -->
        <button type="submit">Зарегистрироваться</button><br><br>
<!-- Пропуски для div ( для стилей ) -->
        <p>
            Уже есть аккаунт? - <a href="login.php">Войти</a>
        </p>
<!-- Пропуски для div ( для стилей ) -->
    <?php if (!empty($error)): ?>
        <!-- Пропуски для div ( для стилей ) -->
        <strong>Ошибка:</strong> <?php echo htmlspecialchars($error); ?>
        <!-- Пропуски для div ( для стилей ) -->
    <?php endif; ?>
    </form>
</body>
</html>