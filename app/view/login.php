<?php
/**
 * Страница входа. Форма с логином и паролем.
 */
?>
<?php include '../includes/header.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<body>

    <div class="d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 150px); padding: 20px;">
        
    <form action="../../controllers/authcontroller.php" method="post" style="max-width: 650px; width:100%;">
        <h1>Вход в аккаунт</h1>

        <div class="mb-3 w-50">

        <label for="exampleFormControlInput1" class="form-label">Логин</label>
        <input type="text" name="login" class="form-control" id="exampleFormControlInput1"><br><br>

        <label for="inputPassword5" class="form-label">Пароль</label>
        <input type="password" name="password_hash" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock"><br><br>

<button type="submit" class="btn btn-outline-success">Войти</button>

        </div>
    </form>
    </div>
</body>
    </body>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger">
                <strong>Ошибка:</strong> <?php echo htmlspecialchars($_SESSION['error']) ?>;
        </div>
    <?php endif; ?>

<?php include '../includes/footer.php'; ?>
