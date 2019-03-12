<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Ecommerce/core/init.php';

$name=sanitize($_POST['name']);
$email=sanitize($_POST['email']);
$address1=sanitize($_POST['address1']);
$address2=sanitize($_POST['address2']);
$city=sanitize($_POST['city']);
$state=sanitize($_POST['state']);
$zip=sanitize($_POST['zip']);
$errors=array();
$required=array(
'name' =>'name',
'email' =>'email',
'address1' =>'address1',
'address2' =>'address2',
'city' =>'city',
'state' =>'state',
'zip' =>'zip',
);

foreach ($required as $value => $d) {
  if(empty($_POST[$value]) || $_POST[$value]=''){
    // $errors[] = $d.' is required !';
    $errors[] ='All Fields are required !';
    break;
  }
}

if($email !='' && !filter_var($email,FILTER_VALIDATE_EMAIL)){
  $errors[] ='Enter a Valid Email !';
}

if(!empty($errors)){
  echo display_errors($errors);
}else{
  echo 'passed';
}

 ?>
