<?php
//Подключение к БД (MySql). Используется во всех файлах, где нужен доступ к БД.
try {
    $pdo = new PDO('mysql:host=localhost;dbname=network', 'root', '');
} catch(PDOException $error) {
    die('Error: ' . $error->getMessage());
}
?>