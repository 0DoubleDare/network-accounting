<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

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

header('Location: ../../public/index.php');
exit();
        }
    }
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <body>
    <div class="d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 150px); padding: 20px;">
    
    
    <form action="" method="post" style="max-width: 650px; width:100%;">
        <h1>Регистрация</h1>
        <div class="mb-3 w-50">

         <label for="exampleFormControlInput1" class="form-label">Логин</label>
        <input type="text" name="login" placeholder="Придумайте логин" value="<?php echo htmlspecialchars($_POST['login'] ?? ''); ?>" required maxlength="50" class="form-control" id="exampleFormControlInput1"><br><br>
        
        <label for="inputPassword5" class="form-label">Пароль</label>
        <input type="password" name="password" placeholder="Придумайте пароль" required maxlength="50" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock"><br><br>
        
        <label for="exampleFormControlInput1" class="form-label">Подтвердить пароль</label>
        <input type="password" name="password_confirm" placeholder="Подтвердите пароль" required maxlength="50" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock"><br><br>
        
<button type="submit" class="btn btn-outline-info">Зарегистрироваться</button>
        <p>
            Уже есть аккаунт? - <a href="../view/login.php" class="link-success">Войти</a>
        </p>
                </div>
    </form>
    </div>
    </body>
    <div class="alert alert-danger">
        <?php if (!empty($error)): ?>
            <strong>Ошибка:</strong> <?php echo htmlspecialchars($error); ?>
        <?php endif; ?>
    </div>

<?php include __DIR__ . '/../includes/footer.php'; ?>