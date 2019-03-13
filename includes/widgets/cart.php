<h5 class="text-center">Shopping Cart</h5>
<div>
<?php if(empty($cart_id)){ ?>
  <p>Your Shopping cart is empty!</p>

<?php }else{
  $cart_item_sql="SELECT * FROM cart WHERE id ='{$cart_id}'";
  $cart_item_query=mysqli_query($db,$cart_item_sql);
  $cart_item_result=mysqli_fetch_assoc($cart_item_query);
  $cart_items=json_decode($cart_item_result['items'],true);
  $i=1;
  $m=0;
  $sub_total=0;
  $total=0;
  $item_count=0;
  ?>

  <table class="table table-bordered table-hover table-responsive-lg" style="font-size:12px;">
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Item</th>
      <th scope="col">Price</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($cart_items as $item) {
      $item_product_id=$item['id'];
      $productsql="SELECT * FROM products WHERE id ='{$item_product_id}'";
      $productquery=mysqli_query($db,$productsql);
      $productresult=mysqli_fetch_assoc($productquery);

      $available=$productresult['kilos'];
      $cArray=$item['kilo'];
    ?>
    <tr>
      <td><?=$i;?></td>
      <td><?=$productresult['title'];?></td>
      <td><?=money(trim($productresult['price']));?></td>
      <?php $m=money($cArray * $productresult['price']); ?>
    </tr>
    <?php
    $i++;
    $sub_total+=$cArray;
    $m = trim($m,"₹");
    $total+=$m;
} ?>
<tr>
  <td></td>
  <td><strong> Quantity :</strong> <h6 class="text-info"><?=$sub_total;?></h6>  </td>
  <td class="clearfix"> <strong>Total :</strong>  <h6 class="text-success"><?=money($total); ?></h6></td>
</tr>
<tr>
  <td></td>
  <td colspan="2">
  <a class="nav-link btn btn-outline-warning" href="cart.php" ><i class="fas fa-shopping-bag"></i> View cart </a>
  </td>
</tr>
  </tbody>
</table>

<?php } ?>
</div>
