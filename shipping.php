<?php
require_once 'core/init.php';

$full_name=sanitize($_POST['name']);
$email=sanitize($_POST['email']);
$address1=sanitize($_POST['address1']);
$address2=sanitize($_POST['address2']);
$city=sanitize($_POST['city']);
$state=sanitize($_POST['state']);
$zip=sanitize($_POST['zip']);
$total=sanitize($_POST['total']);


// adjust products inventory
$itemsql="SELECT * FROM cart WHERE id='{$cart_id}'";
$itemquery=mysqli_query($db,$itemsql);
$itemresult=mysqli_fetch_assoc($itemquery);
$items=json_decode($itemresult['items'],true);

foreach ($items as $item) {
  $item_id=$item['id'];
  $item_kilo=$item['kilo'];

  $productsql="SELECT * FROM products WHERE id='{$item_id}'";
  $productquery=mysqli_query($db,$productsql);
  $productresult=mysqli_fetch_assoc($productquery);
  $product_kilo=$productresult['kilos'];


  if($item_kilo!=$product_kilo){
    $newkilo=$product_kilo-$item_kilo;
    $updatekilosql="UPDATE products SET kilos ='$newkilo' WHERE id={$item_id}";
    mysqli_query($db,$updatekilosql);
  }else{
    $updatekilosql="UPDATE products SET deleted = 1 WHERE id={$item_id}";
    mysqli_query($db,$updatekilosql);
  }

}

$upadte_paid_sql="UPDATE cart SET paid =1 WHERE id ='{$cart_id}'";
mysqli_query($db,$upadte_paid_sql);

$insertshippingsql="INSERT INTO transaction (`cartid`,`fullname`,`email`,`street`,`street2`,`city`,`state`,`zipcode`)
VALUES ('$cart_id','$full_name','$email','$address1','$address2','$city','$state','$zip')";
$yo=mysqli_query($db,$insertshippingsql);

 $doamin=($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false;
 setcookie(CART_COOKIE,'',1,"/",$doamin,false);
 include 'includes/head.php';
 include 'includes/navigation.php';
 ?>
 <div class="container py-5">
  <h4 class="alert-heading">Your Order has been placed !!</h4>

  <p> Total Amount &nbsp;
  <h1>  <?=money($total);?>  </h1>
 </p>
  <hr>
  <p class="mb-0">
    <h4><i class="fas fa-file-invoice-dollar"></i> Reciept</h4>
    <br>

    <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col" rowspan="2">Address</th>
      <th scope="col">City</th>
      <th scope="col">State</th>
      <th scope="col">Zip</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?=$full_name;?><br></td>
      <td><?=$email;?><br></td>
      <td><?=$address1;?><br> <?=$address2;?></td>
      <td><?=$city;?><br></td>
      <td><?=$state;?><br></td>
      <td><?=$zip;?><br></td>
    </tr>
  </tbody>
</table>
  </p>
  <p class="clearfix"><a href="index.php" class="btn btn-success float-right"> <i class="fas fa-home"></i> Back To Home</a></p>
</div>
 <?php
 include 'includes/footer.php';


 ?>
