<?php
/**
 * Страница входа. Форма с логином и паролем.
 */
?>
<?php include '../includes/header.php'; ?>

    <form action="../../controllers/authcontroller.php" method="post">
        <label>Логин</label>
        <input type="text" name="login"><br><br>

        <label>Пароль</label>
        <input type="password" name="password_hash"><br><br>
    
<!--        <select name="role">-->
<!--            -->
<!--            <option>Укажите свою роль</option>-->
<!--            -->
<!--            <option value="operator">operator</option>-->
<!--            <option value="admin">admin</option>-->
<!--        </select><br><br>-->

        <button type="submit">Войти</button>
    </form>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger">
                <strong>Ошибка:</strong> <?php echo htmlspecialchars($_SESSION['error']) ?>;
        </div>
    <?php endif; ?>

<?php include '../includes/footer.php'; ?>
