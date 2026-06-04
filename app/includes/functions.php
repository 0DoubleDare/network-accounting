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

//Получение данные одной конкретной точки по её ID
function getIDDefects($pdo, $point_id){
    try{
        $sql = "SELECT * FROM `network_points` WHERE id = :point_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':point_id' => $point_id]);
        $point = $stmt->fetch(PDO::FETCH_ASSOC);
        return $point;
    }catch(PDOException $error){
        error_log("Error: " . $error->getMessage());
        return null;
    }
}

//Для получения всех дефектов конкретной точки
function getAllDefects($pdo, $point_id){
    try{
        $sql = "SELECT
            defects.id,
            defects.category,
            defects.severity,
            defects.description,
            defects.status,
            defects.created_by,
            defects.created_at,
            defects.image_path,
            users.login AS author,
            network_points.label AS point_label
        FROM defects
        LEFT JOIN users ON defects.created_by = users.id
        LEFT JOIN network_points ON defects.point_id = network_points.id
        WHERE defects.point_id = :point_id
        ORDER BY defects.created_at DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':point_id' => $point_id]);
        $defects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $defects;
    }catch(PDOException $error){
        error_log("Error: " . $error->getMessage());
        return [];
    }
}
// функция для таблицы логов
function getAllLogs($pdo) {
    try {
        $sql = "SELECT logs.*, users.login, users.role 
                FROM logs 
                LEFT JOIN users ON logs.user_id = users.id 
                ORDER BY logs.created_at DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("getAllLogs error: " . $e->getMessage());
        return [];
    }
}

// Запись лога в журнал действий
function addLog($pdo, $user_id, $action, $target_table, $target_id = null) {
    try {
        $stmt = $pdo->prepare("INSERT INTO logs (user_id, action, target_table, target_id) VALUES (:user_id, :action, :target_table, :target_id)");
        $stmt->execute([
            ':user_id' => $user_id,
            ':action' => $action,
            ':target_table' => $target_table,
            ':target_id' => $target_id
        ]);
        return true;
    } catch (PDOException $e) {
        error_log("Log insert error: " . $e->getMessage());
        return false;
    }
}
// Запись лога о входе в систему
function addLoginLog($pdo, $user_id, $role) {
    return addLog($pdo, $user_id, 'Вход в систему (роль: ' . $role . ')', 'users', $user_id);
}
// Запись лога о регистрации
function addRegistrationLog($pdo, $user_id) {
    return addLog($pdo, $user_id, 'Регистрация нового пользователя (роль: operator)', 'users', $user_id);
}
function uploudImage($image, $uploadDir = '..\public\storage\network_points'){
        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $filename = uniqid('', true) . '.' . $extension;
    $fullPath = $uploadDir . $filename;
    
    move_uploaded_file($image['tmp_name'], $fullPath);
    
    return $filename; 
    }


function insertNetvorkPoint($pdo, $label, $type, $location, $status, $file){
    $image_path = uploudImage($file);
    $sql = "INSERT INTO network_points (`label`, `type`, `location`, `status`, `image_path`) VALUES (:label, :type, :location, :status, :image_path)";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute([
        'label' => $label,
        'type' => $type,
        'location' => $location,
        'status' => $status,
        'image_path' => $image_path
    ]);
    $response = [
        'id' => $pdo -> lastInsertId(),
        'image_path' => $image_path
    ];
    return $response;
    }

    function deleteNetworkPoint($pdo, $id){
        $sql = "DELETE FROM `network_points` WHERE id=:id";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute(['id' => $id]);
    }

    function updateNetworkPoint($pdo, $id, $label, $type, $location, $status, $file){
        $image_path = uploudImage($file);
        $sql = "UPDATE `network_points` SET label=:label, type=:type, location=:location, status=:status, image_path=:image_path WHERE id = :id";
    $stmt = $pdo -> prepare($sql);
    return $stmt -> execute([
        'id' => $id,
        'label' => $label,
        'type' => $type,
        'location' => $location,
        'status' => $status,
        'image_path' => $image_path]);
        }

        function networkPointId($pdo, $id){
            $sql = "SELECT * FROM `network_points` WHERE id = :id";
            $stmt = $pdo -> prepare($sql);
            $stmt -> execute(['id' => $id]);
            return $stmt -> fetch(PDO::FETCH_ASSOC);
        }
?>