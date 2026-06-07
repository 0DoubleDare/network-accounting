<?php
session_start();
require '../../config/db.php';
require '../../app/includes/functions.php';

$image_name = uploadImage($_FILES['image_name'], "../../storage/network_points/");
insertNetworkPoint($pdo, $_POST['label'], $_POST['type'], $_POST['location'], $_POST['status'], $image_name);

header('Location: ./inventory_view.php');