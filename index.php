<?php
session_start();

// Если перешли на страницу инвентаря

/**
 * Главная страница
 */
//session_start();
//print_r($_SESSION);
require './config/db.php';
require './app/includes/functions.php';
require './app/includes/functions/dashbord_stats.php';

$count = getPointsCount($pdo);
$materials = getMaterialsStats($pdo);
$defectCount = getDefectsCount($pdo);

$defectCountWithCategories = getDefectCountWithCategories($pdo);
$materialsCountWithCategories = getMaterialsCountWithCategories($pdo);
//echo '<pre>';
//print_r($defectCountWithCategories);
//print_r($materialsCountWithCategories);
//echo '</pre>';

include './app/view/dashboard.php';
?>