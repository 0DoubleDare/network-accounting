<?php
/**
 * Страница входа. Форма с логином и паролем.
 */
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="../includes/auth.php" method="post">
        <label>Логин</label>
        <input type="text" name="login"><br><br>

        <label>Пароль</label>
        <input type="password" name="password_hash"><br><br>
    
        <select name="role">
            
            <option>Укажите свою роль</option>
            
            <option value="operator">operator</option>
            <option value="admin">admin</option>
        </select><br><br>

        <button type="submit">Войти</button>
        
    </form>
</body>
</html>