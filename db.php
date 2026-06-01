<?php
//Подключение к БД
try{
    $pdo = new PDO('mysql:host=localhost;dbname=network_accounting_db', 'root', '');
}catch(PDOException $error){
    die('Error: ' .  $error->getMessage());
}
?>