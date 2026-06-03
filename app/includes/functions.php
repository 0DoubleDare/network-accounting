<?php
/**
 * Функции для всего проекта
 */
require_once __DIR__ . '/../../config/db.php';

// функциия Влады
function checkAuthorizedUser($pdo, $login, $password) {
    try {
        $sql = "SELECT id,  login, password_hash, role FROM users WHERE login = :login";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
           
            if (md5($password, $user['password_hash'])) {
                $response = [
                    'user_id' => $user['id'],
                    'role' => $user['role']
                ];
                return $response;
                
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// функциия тимура
function checkUserExists($pdo, $login) {
    try {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE login = :login");
        $stmt->execute([':login' => $login]);
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        return false;
    }
}

// функциия тимура
function registerUser($pdo, $login, $password_hash) {
    try {
        $stmt = $pdo->prepare("INSERT INTO users (login, password_hash, role) VALUES (:login, :password_hash, 'operator')");
        $result = $stmt->execute([
            ':login' => $login,
            ':password_hash' => $password_hash
        ]);
        
        if ($result) {
            return true;
        }
        return false;
    } catch (PDOException $e) {
        error_log("Register error: " . $e->getMessage());
        return false;
    }
}
?>