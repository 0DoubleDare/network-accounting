<?php
/**
 * Функции для всего проекта
 */
require '../config/db.php';

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
                    'role' => $user['role'],
                    'login' => $login,
                ];
                return $response;
                
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>