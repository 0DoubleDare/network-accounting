<?php
session_start();
unset($_SESSION['user_info']);
header('Location: ../public/dashboard.php');
exit();