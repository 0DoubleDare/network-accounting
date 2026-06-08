<?php
session_start();
require '../config/db.php';
require '../app/includes/functions.php';

$id = $_POST['id'];
updateNetworkPoint($pdo, $id, $_POST['label'], $_POST['type'], $_POST['location'], $_POST['status'], $_FILES['image_name']);
// var_dump($id);
header('Location: ./inventorycontroller.php');