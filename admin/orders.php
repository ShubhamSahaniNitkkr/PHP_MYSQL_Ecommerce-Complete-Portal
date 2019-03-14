<?php
  require_once '../core/init.php';
  if(!is_logged_in()){
    login_error_redirect();
  }
  include 'includes/head.php';
  include 'includes/navigation.php';

  if(isset($_GET['complete']) && $_GET['complete']==1){
    $cart_id=sanitize((int)$_GET['cart_id']);
    $update_shipped_sql="UPDATE cart SET shipped =1 WHERE id='{$cart_id}'";
    $update_shipped_query=mysqli_query($db,$update_shipped_sql);
    $_SESSION['success_flash']="The Order has been Completed !";
    header('location:index.php');

  }

  $txn_id=sanitize((int)$_GET['txn_id']);
  $txnsql="SELECT * FROM transaction WHERE id ='$txn_id'";
  $txnquery=mysqli_query($db,$txnsql);
  $txn=mysqli_fetch_assoc($txnquery);
  $cart_id=$txn['cartid'];

  $cartsql="SELECT * FROM cart WHERE id ='$cart_id'";
  $cartquery=mysqli_query($db,$cartsql);
  $cart=mysqli_fetch_assoc($cartquery);
  $items=json_decode($cart['items'],true);
  $idArray=array();
  $products=array();
  foreach($items as $item){
    $idArray[] = $item['id'];
  }
  $ids=implode(',',$idArray);
  $productsql="SELECT i.id as 'id', i.title as 'title', c.id as 'cid', c.category as 'child',
  p.category as 'parent' FROM products i
  LEFT JOIN categories c ON i.categories = c.id
  LEFT JOIN categories p ON c.parent = p.id
  WHERE i.id IN ({$ids})
  ";
  $productquery=mysqli_query($db,$productsql);
  while($p=mysqli_fetch_assoc($productquery)){
    foreach ($items as $item) {
      if($item['id'] == $p['id'])
      {
        $x=$item;
        continue;
      }
    }
    $products[]=array_merge($x,$p);
  }
?>

<div class="container py-4">
  <h3>Order Details <i class="fas fa-file-invoice"></i></h3>
<table class="table table-bordered table-striped">
  <thead class="bg-light">
    <tr>
      <th scope="col">Quantity</th>
      <th scope="col">Title</th>
      <th scope="col">Category</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($products as $product){?>
    <tr>
      <td><?=$product['kilo'];?></td>
      <td><?=$product['title'];?></td>
      <td><?=$product['parent'].' ~ '.$product['child'];?></td>
    </tr>
    <?php }?>
  </tbody>
</table>
</div>

<div class="container-fluid row py-3">
<div class="col-md-6">
  <table class="table table-bordered">
    <h3>Paid Amount <i class="far fa-money-bill-alt"></i></h3>
    <thead class="bg-light">
      <tr>
        <th scope="col">Sub Total</th>
        <th scope="col">Tax</th>
        <th scope="col">Total</th>
        <th scope="col">Order date</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?=$k=$txn['total'];?></td>
        <td><?=$i=50;?></td>
        <td><?=$k+$i;?></td>
        <td><?=$txn['txn_date'];?></td>
      </tr>
    </tbody>
  </table>
</div>


<div class="col-md-6">
  <table class="table table-bordered">
    <h3>Shipping address <i class="fas fa-shipping-fast"></i></h3>
    <thead class="bg-light">
      <tr>
        <th scope="col">Name</th>
        <th colspan="4">Address</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?=$k=$txn['fullname'];?></td>
        <td><?=$k=$txn['street'];?></td>
        <td><?=$k=$txn['street2'];?></td>
        <td><?=$k=$txn['fullname'];?></td>
        <td><?=$k=$txn['city'];?> <?=$k=$txn['state'];?> <?=$k=$txn['zipcode'];?></td>
      </tr>
    </tbody>
  </table>

</div>
</div>

<div class="clearfix container">
  <a href="orders.php?complete=1&cart_id=<?=$cart_id;?>" class="btn btn-info px-2 float-right">Complete</a>

  <a href="index.php" class="btn btn-danger float-right">Cancel</a>
</div>






<?php include 'includes/footer.php'; ?>
