<?php
//Подключение к БД (MySql). Используется во всех файлах, где нужен доступ к БД.
$db_host = getenv('DB_HOST_PURE') ?: 'localhost';
$db_name = 'network_accounting_db';

$user = 'root';
$password = '';

$dsn = 'mysql:host=' . $db_host . ';dbname=' . $db_name;
try {
    $pdo = new PDO($dsn, $user, $password);
} catch (PDOException $error) {
    die('Error: ' . $error->getMessage());
}
?>