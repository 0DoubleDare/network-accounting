<?php
/**
 * Страница входа. Форма с логином и паролем.
 */
?>
<?php include '../includes/header.php'; ?>


<!-- Основной контент который уникален именно для этой страницы -->


<div class="d-flex justify-content-center align-items-center flex-column" style="min-height: 70vh; padding: 20px;">
    <form action="../../controllers/authcontroller.php" method="post" class="d-flex flex-column align-items-center" style="max-width: 450px; width: 100%;">

        <h1>Вход в аккаунт</h1>

        <div class="mb-3 w-100">

        <label for="exampleFormControlInput1" class="form-label">Логин</label>
        <input type="text" name="login" class="form-control" id="exampleFormControlInput1" placeholder="Введите логин"><br><br>
        </div>
        <div class="mb-4 w-100">
        <label for="inputPassword5" class="form-label">Пароль</label>
        <input type="password" name="password_hash" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock" placeholder="Введите пароль"><br><br>
        <button type="submit" class="btn btn-outline-success w-100">Войти</button>
        </div>
    </form>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <strong>Ошибка:</strong> <?php echo htmlspecialchars($_SESSION['error']) ?>;
        </div>
    <?php endif; ?>
</div>


<!-- Конец уникального контента -->


<?php include '../includes/footer.php'; ?>
