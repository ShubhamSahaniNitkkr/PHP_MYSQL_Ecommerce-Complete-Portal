<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Ecommerce/core/init.php';

$mode=$_POST['mode'];
$edit_id=$_POST['edit_id'];
$edit_kilo=$_POST['edit_kilo'];
var_dump($edit_id);
var_dump($edit_kilo);
var_dump($mode);



$cartq="SELECT * FROM cart WHERE id='{$cart_id}'";
$cartq_query=mysqli_query($db,$cartq);
$result=mysqli_fetch_assoc($cartq_query);
$items=json_decode($result['items'],true);
$upadted_items=array();
$doamin=($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false;

if($mode=='removeone'){
  foreach ($items as $item) {
    if($item['id'] ==$edit_id && $item['kilo']==$edit_kilo){
      $item['kilo']=$item['kilo']-1;
    }

    if($item['kilo'] > 0){
      $updated_items[]=$item;
    }
  }
}


if($mode=='addone'){
  foreach ($items as $item) {
    if($item['id'] ==$edit_id && $item['kilo']==$edit_kilo){
      $item['kilo']=$item['kilo']+1;
    }
      $updated_items[]=$item;
  }
}

if(!empty($updated_items)){
  $json_updated=json_encode($updated_items);
  $updatesql="UPDATE cart SET items ='{$json_updated}' WHERE id ='{$cart_id}'";
  mysqli_query($db,$updatesql);
  $_SESSION['success_flash']="Your shopping cart has been updated !";
}

if(empty($updated_items)){
  $updatesql="DELETE FROM cart SET WHERE id ='{$cart_id}'";
  mysqli_query($db,$updatesql);
  setcookie(CART_COOKIE,'',1,"/",$doamin,false);
}


 ?>
