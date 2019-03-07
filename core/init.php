<?php
$db=mysqli_connect('localhost','root','','Ecommerce');
if(mysqli_connect_errno()){
  echo 'Database connection failed with these errors'.mysqli_connect_errno();
  die();
}

define('BASEURL' ,'/Ecommerce/');

 ?>
