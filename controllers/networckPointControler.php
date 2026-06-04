<?php
session_start();
require '../config/db.php';
require '../app/includes/functions.php';

insertNetvorkPoint($pdo, $_POST['label'], $_POST['type'], $_POST['location'], $_POST['status'], $_FILES['image_path']);

header('Location: ..\app\view\inventory.php');