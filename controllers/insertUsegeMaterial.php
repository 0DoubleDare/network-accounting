<?php
session_start();
require '../config/db.php'; 
require '../app/includes/functions.php'; 

insertUsegeMaterials($pdo, $_POST['material_id'], $_POST['quantity'], $_POST['point_id'], $_POST['used_by'], $_POST['comment']);

header('Location: ../app/view/defects.php');
