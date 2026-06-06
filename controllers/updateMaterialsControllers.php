<?php
session_start();
require '../config/db.php';
require '../app/includes/functions.php';
$id = $_POST['id'];
updateMaterials($pdo, $id, $_POST['name'], $_POST['type'], $_POST['unit']);


//header('Location: ../app/view/materials.php');
header('Location: ./materialscontroller.php');
