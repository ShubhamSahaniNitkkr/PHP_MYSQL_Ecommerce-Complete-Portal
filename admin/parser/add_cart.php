<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Ecommerce/core/init.php';
$product_id=sanitize($_POST['product_id']);
$kilo=sanitize($_POST['kilo']);
$item=array();
$item[]=array(
  'id' =>$product_id,
  'kilo' =>$kilo,
);

$doamin=($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false;
$cart_sql="SELECT * FROM products WHERE id ='{$product_id}'";
$cart_query=mysqli_query($db,$cart_sql);

$cart_item=mysqli_fetch_assoc($cart_query);
$_SESSION['success_flash']=$cart_item['title'].' was added to your cart .';


// check to see if cart cookie exist
if($cart_id !=''){
  $cart_qsql="SELECT * FROM cart WHERE id ='{$cart_id}' ";
  $cart_q_query=mysqli_query($db,$cart_qsql);
  $cartq=mysqli_fetch_assoc($cart_q_query);
   $previous_cart_items=json_decode($cartq['items'],true);
   $item_match=0;
   $new_item=array();

   foreach ($previous_cart_items as $pitem) {
     if($item[0]['id'] == $pitem['id'] && $item[0]['kilo'] == $pitem['kilo']){
       $pitem['kilo']=$pitem['kilo']+$item[0]['kilo'];
       $item_match=1;
     }
     $new_item[]=$pitem;

   if($item_match==0){
     $new_item = array_merge($item,$previous_cart_items);
   }

   $new_item_json = json_encode($new_item);
   $cart_expire = date("Y-m-d H:i:s",strtotime("+30 days"));
   $update_cart_new_item_sql="UPDATE cart SET items ='{$new_item_json}', expire_date='{$cart_expire}' WHERE id ='{$cart_id}'";
   $update_cart_new_item_query=mysqli_query($db,$update_cart_new_item_sql);
   setcookie(CART_COOKIE,'',1,"/",$doamin,false);
   setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$doamin,false);
 }}else{
  $items_json=json_encode($item);
  $cart_expire=date("Y-m-d H:i:s", strtotime("+30 days"));

  $insert_cart_sql="INSERT INTO cart (items,expire_date) VALUES ('{$items_json}','{$cart_expire}')";
  mysqli_query($db,$insert_cart_sql);
  $cart_id=mysqli_insert_id($db);
  setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$doamin,false);

}
?>
