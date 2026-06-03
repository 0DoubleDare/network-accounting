<?php
/**
 * Функции для всего проекта
 */


$root_path = dirname(__DIR__, 2);
define('ROOT_PATH', $root_path);
require ROOT_PATH . '/config/db.php';


if (!function_exists('checkAuthorizedUser')) {
    function checkAuthorizedUser($pdo, $login, $password) {
        try {
            $sql = "SELECT id, login, password_hash, role FROM users WHERE login = :login";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':login', $login);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
               
                if (md5($password) == $user['password_hash']) {
                    return [
                        'user_id' => $user['id'],
                        'role' => $user['role'],
                        'login' => $login,
                    ];
                }
            }
            return null;
        } catch (PDOException $e) {
            error_log("checkAuthorizedUser error: " . $e->getMessage());
            return null;
        }
    }
}

// функция тимура - для сессии
if (!function_exists('getError')) {
    function getError() {
        if (isset($_SESSION['error'])) {
            $error = $_SESSION['error'];
            unset($_SESSION['error']);
            return $error;
        }
        return null;
    }
}

// функция тимура - для сессии
if (!function_exists('getMessage')) {
    function getMessage() {
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
            return $message;
        }
        return null;
    }
}

// функция тимура - регистрация
if (!function_exists('checkUserExists')) {
    function checkUserExists($pdo, $login) {
        try {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE login = :login");
            $stmt->execute([':login' => $login]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("checkUserExists error: " . $e->getMessage());
            return false;
        }
    }
}

// функция тимура - регистрация
if (!function_exists('registerUser')) {
    function registerUser($pdo, $login, $password_hash) {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (login, password_hash, role) VALUES (:login, :password_hash, 'operator')");
            $stmt->execute([
                ':login' => $login,
                ':password_hash' => $password_hash
            ]);
            return $response = [
                'id' => $pdo->lastInsertId(),
                'login' => $login,
                'role' => 'operator'
            ];
        } catch (PDOException $e) {
            error_log("Register error: " . $e->getMessage());
            return false;
        }
    }
}

//Таблица инвентарь 
function getAllInventory($pdo){
    try{
        $sql = "SELECT * FROM network_points";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $points = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $points;
    }catch(PDOException $error){
        error_log("Error: " . $error->getMessage());
    }
}
?>