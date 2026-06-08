<?php

require '../../config/db.php';
require '../../app/includes/functions.php';

insert_defects($pdo, $_POST['point_id'], $_POST['category'], $_POST['severity'], $_POST['description'], $_POST['status'],
 $_POST['created_by'], $_FILES['image_name']);


header('Location: ../../app/view/defects/defects.php');