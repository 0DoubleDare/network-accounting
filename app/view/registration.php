<?php
session_start();
require '../includes/functions.php';

$error = getError();
$message = getMessage();
?>
<?php include '../includes/header.php'; ?>

<h1>Регистрация</h1>
<form action="../../controllers/authcontroller.php" method="post">
    <label>Логин</label>
    <input type="text" name="login" placeholder="Придумайте логин" value="<?php echo htmlspecialchars($_POST['login'] ?? ''); ?>" required maxlength="50"><br><br>
    <label>Пароль</label>
    <input type="password" name="password" placeholder="Придумайте пароль" required maxlength="50"><br><br>
    <label>Подтвердить пароль</label>
    <input type="password" name="password_confirm" placeholder="Подтвердите пароль" required maxlength="50"><br><br>
    <button type="submit">Зарегистрироваться</button><br><br>
    <p>
        Уже есть аккаунт? - <a href="login.php">Войти</a>
    </p>
</form>
<?php if ($error !== null): ?>
    <div class="alert alert-danger">
        <strong>Ошибка:</strong> <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<?php if ($message !== null): ?>
    <div class="alert alert-success">
        <strong>Успех:</strong> <?php echo htmlspecialchars($message); ?>
    </div>
<?php endif; ?>
<?php include '../includes/footer.php'; ?>