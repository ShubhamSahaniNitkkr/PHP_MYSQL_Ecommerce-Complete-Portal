<?php
$db=mysqli_connect('localhost','root','','Ecommerce');
if(mysqli_connect_errno()){
  echo 'Database connection failed with these errors'.mysqli_connect_errno();
  die();
}
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/Ecommerce/config.php';
require_once BASEURL.'helpers/helpers.php';

if(isset($_SESSION['SBUser']))
{
  $user_id=$_SESSION['SBUser'];
  $fetch_user_data="SELECT * FROM users WHERE id='$user_id'";
  $fetch_user_query=mysqli_query($db,$fetch_user_data);
  $user_data=mysqli_fetch_assoc($fetch_user_query);
  $fn=explode(' ',$user_data['full_name']);
  $user_data['first']=$fn[0];
  $user_data['last']=$fn[1];
}

if(isset($_SESSION['success_flash'])){
  echo '<div class="bg-success" id="successMessage"><p class="text-light text-center">'.$_SESSION['success_flash'].'</p></div>';
  unset($_SESSION['success_flash']);
}


if(isset($_SESSION['error_flash'])){
  echo '<div class="bg-danger"><p class="text-light text-center">'.$_SESSION['error_flash'].'</p></div>';
  unset($_SESSION['error_flash']);
}

 ?>
