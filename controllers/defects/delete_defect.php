<?php
session_start();
require '../../config/db.php';
require '../../app/includes/functions.php';

if (empty($_SESSION['user_info']['user_id']) && empty($_SESSION['user_id'])) {
    header('Location: ../../../app/view/user/registration.php');
} else {
    $id = $_GET['id'] ?? '';
    $point_id = $_GET['point_id'] ?? '';
    deleteDefects($pdo, $id);
    header('Location: ../../../app/view/defects/defects.php?point_id=' . $point_id);
}