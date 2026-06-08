<?php
session_start();
require '../../config/db.php';
require '../../app/includes/functions.php';

$id = $_POST['id'];
deleteMaterials($pdo, $id);

header('Location: ../app/view/materials.php');