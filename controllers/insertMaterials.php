<?php
session_start();
require '../config/db.php';
require '../app/includes/functions.php';

insertMaterials($pdo, $_POST['name'], $_POST['type'], $_POST['unit']);

header('Location: ../app/view/materials.php');