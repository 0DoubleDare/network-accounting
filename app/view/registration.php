<?php
session_start();
require '../includes/functions.php';

$error = getError();
$message = getMessage();
?>
<?php include '../includes/header.php'; ?>

<body>
<div class="d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 150px); padding: 20px;">

<form action="../../controllers/authcontroller.php" method="post" style="max-width: 650px; width:100%;">
    <h1>Регистрация</h1>

    <div class="mb-3 w-50">

    <label for="exampleFormControlInput1" class="form-label">Логин</label>
    <input type="text" name="login" placeholder="Придумайте логин" value="<?php echo htmlspecialchars($_POST['login'] ?? ''); ?>" required maxlength="50" class="form-control" id="exampleFormControlInput1"><br><br>
    
    <label for="inputPassword5" class="form-label">Пароль</label>
    <input type="password" name="password" placeholder="Придумайте пароль" required maxlength="50" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock"><br><br>
    
    <label for="inputPassword5" class="form-label">Подтвердить пароль</label>
    <input type="password" name="password_confirm" placeholder="Подтвердите пароль" required maxlength="50" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock"><br><br>
    
    <button type="submit" class="btn btn-outline-info">Зарегистрироваться</button><br><br>
    
    <p>
        Уже есть аккаунт? - <a href="login.php" class="link-success">Войти</a>
   
    </p>
    </div>
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
