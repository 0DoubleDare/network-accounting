<?php
session_start();
?>

<?php include '../includes/header.php' ?>

<h1>Опаньки! Что-то пошло не так</h1>
<p><?= $_SESSION['server_error'] ?></p>

<?php include '../includes/footer.php' ?>
