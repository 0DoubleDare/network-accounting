<?php
session_start();
require '../../config/db.php';
require '../../app/includes/functions.php';

$id = $_POST['id'];
$image_name = uploadImage($_FILES['image_name'], "../../storage/network_points/");
updateNetworkPoint($pdo, $id, $_POST['label'], $_POST['type'], $_POST['location'], $_POST['status'], $_FILES['image_name']);
// var_dump($id);
header('Location: ./inventory_view.php');