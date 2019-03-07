<?php
$db=mysqli_connect('localhost','root','','Ecommerce');
if(mysqli_connect_errno()){
  echo 'Database connection failed with these errors'.mysqli_connect_errno();
  die();
}
require_once $_SERVER['DOCUMENT_ROOT'].'/Ecommerce/config.php';
require_once BASEURL.'helpers/helpers.php';
 ?>
