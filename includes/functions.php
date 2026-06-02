<?php
/**
 * Функции для всего проекта
 */
// КАКИЕ ТО МЕГА КРУТЫЕ ФУКНЦИИ КАКИЕ ТО МЕГА КРУТЫЕ ФУКНЦИИ КАКИЕ ТО МЕГА КРУТЫЕ ФУКНЦИИ КАКИЕ ТО МЕГА КРУТЫЕ ФУКНЦИИ КАКИЕ ТО МЕГА КРУТЫЕ ФУКНЦИИ КАКИЕ ТО МЕГА КРУТЫЕ ФУКНЦИИ
// КАКИЕ ТО МЕГА КРУТЫЕ ФУКНЦИИ КАКИЕ ТО МЕГА КРУТЫЕ ФУКНЦИИ КАКИЕ ТО МЕГА КРУТЫЕ ФУКНЦИИ
// PULL REQUEST ЭТО КРУТО КРУТО КРУТО КРУТО КРУТО КРУТО КРУТО КРУТО КРУТО КРУТО КРУТО КРУТО

require '../config/db.php';

function checkAuthorizedUser($pdo, $login, $password, $role) {
    try {
        $sql = "SELECT id,  login, password_hash, role FROM users WHERE login = :login";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
           
            if (md5($password, $user['password_hash']) && $user['role'] === $role) {
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

?>