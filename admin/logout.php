<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Ecommerce/core/init.php';
unset($_SESSION['SBUser']);
header('location:login.php');
 ?>
