<?php
session_start();
require '../includes/functions.php';

$error = getError();
$message = getMessage();
?>
<?php include '../includes/header.php'; ?>

<div class="d-flex justify-content-center align-items-center flex-column" style="min-height: 70vh; padding: 20px;">

    <form action="../../controllers/registration_controller.php" method="post" class="d-flex flex-column align-items-center" style="max-width: 450px; width: 100%;">
        <h1>Регистрация</h1>

        <div class="mb-3 w-100 ">

        <label for="exampleFormControlInput1" class="form-label">Логин</label>
        <input type="text" name="login" placeholder="Придумайте логин" value="<?php echo htmlspecialchars($_POST['login'] ?? ''); ?>" required maxlength="50" class="form-control" id="exampleFormControlInput1"><br><br>

        <label for="inputPassword5" class="form-label">Пароль</label>
        <input type="password" name="password" placeholder="Придумайте пароль" required maxlength="50" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock"><br><br>

        <label for="inputPassword5" class="form-label">Подтвердить пароль</label>
        <input type="password" name="password_confirm" placeholder="Подтвердите пароль" required maxlength="50" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock"><br><br>

        <button type="submit" class="btn btn-outline-info w-100">Зарегистрироваться</button><br><br>

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

<?php //if ($message !== null) flex-column: ?>
<!--    <div class="alert alert-success">-->
<!--        <strong>Успех:</strong> --><?php //echo htmlspecialchars($message); ?>
<!--    </div>-->
<?php //endif; ?>
</div>
<?php include '../includes/footer.php'; ?>
