<?php
session_start();
require '../../config/db.php';
require '../../app/includes/functions.php';

$image = uploadImage($_FILES['image_name'], "../../storage/defects/");
insert_defects($pdo, $_POST['point_id'], $_POST['category'], $_POST['severity'], $_POST['description'], $_POST['status'], $_POST['created_by'], $image);

//header('Location: ../../controllers/defects/defects_view.php?point_id=' . $_POST['point_id']);
header('Location: ./defects_view.php?point_id=' . $_POST['point_id']);
exit();
?>