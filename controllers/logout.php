<?php
session_start();
unset($_SESSION['user_info']);
header('Location: ../public/index.php');
exit();