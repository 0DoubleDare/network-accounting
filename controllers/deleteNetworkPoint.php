<?php

session_start();
require '../config/db.php';
require '../app/includes/functions.php';

$id = $_GET['id'];

deleteNetworkPoint($pdo, $id);

header('Location: ./inventorycontroller.php');
