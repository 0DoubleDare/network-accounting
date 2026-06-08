<?php
session_start();
require '../../config/db.php';
require '../../app/includes/functions.php';
require '../../app/includes/functions/material_usage.php';

$id = $_POST['id'];

if (!checkMaterialIsUse($pdo, $id)) {
    deleteMaterials($pdo, $id);
}

header('Location: ./materials_view.php');