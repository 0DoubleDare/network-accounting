<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet"  > <!-- href="путь для стилей" (ЭТУ Команду в тэг link после rel="stylesheet") -->
</head>
<body>
    <label><h1>Регистрация</h1></label>
    <form action="/view/login.php" method="post">

        <label>Логин</label>
        <input type="text" name="login" placeholder="Придумайте Логин" required>
        
        <label>Пароль</label>
        <input type="password" name="password" placeholder="Придумайте пароль" required>
        
        <label>Потвердить пароль</label>
        <input type="password" name="password_confirm" placeholder="Потвердите пароль" required>

        <button>Зарегистрираваца</button>
    </form>
</body>
</html>
