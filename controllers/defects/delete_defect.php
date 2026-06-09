<?php
session_start();
require '../../config/db.php';
require '../../app/includes/functions.php';

$id = $_GET['id'] ?? '';
$point_id = $_GET['point_id'] ?? '';
deleteDefects($pdo, $id);
header('Location: ../../controllers/defects/defects_view.php?point_id=' . $point_id);
exit();
?>