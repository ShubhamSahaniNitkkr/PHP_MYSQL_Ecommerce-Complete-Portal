<?php include 'core/init.php'; ?>
<?php include 'includes/head.php'; ?>
<?php include 'includes/navigation.php'; ?>
<?php include 'includes/jumbotron.php';

if($cart_id!='')
{
  $cart_item_sql="SELECT * FROM cart WHERE id ='{$cart_id}'";
  $cart_item_query=mysqli_query($db,$cart_item_sql);
  $cart_item_result=mysqli_fetch_assoc($cart_item_query);
  $cart_items=json_decode($cart_item_result['items'],true);
  $i=1;
  $m=0;
  $sub_total=0;
  $total=0;
  $item_count=0;
}
?>

<div class="container">
    <h2 class="text-center">My Shopping Cart</h2>
    <hr>
    <?php if($cart_id==''){ ?>
    <div class="text-danger text-center h3">
      Your shopping cart is empty ! <i class="fas fa-cat"></i>
    </div>
    <?php }else{ ?>
      <table class="table table-bordered table-hover">
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Item</th>
      <th scope="col">Price</th>
      <th scope="col">Quantity</th>
      <th scope="col">Sub total</th>
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
      <td><?=money($productresult['price']);?></td>
      <td class="clearfix text-center">
        <button type="button" class="btn btn-sm btn-outline-danger float-left"  name="button" onclick="update_cart('removeone','<?=$productresult['id']?>','<?=$cArray;?>');return false;"><i class="fas fa-minus"></i></button>
         <?=$cArray;?>
         <?php if($cArray < $available){  ?>
        <button type="button" class="btn btn-sm btn-outline-success float-right"  name="button" onclick="update_cart('addone','<?=$productresult['id']?>','<?=$cArray;?>');return false;"><i class="fas fa-plus"></i></button>
        <?php }else{ ?>
          <span class="text-danger"> MAX </span>
        <?php } ?>
      </td>
      <?php $m=money($cArray * $productresult['price']); ?>
      <td><?=$m;?></td>
    </tr>
    <?php
    $i++;
    $sub_total+=$cArray;
    $m = trim($m,"₹");
    $total+=$m;
} ?>
<tr>
  <td></td>
  <td></td>
  <td></td>
  <td><strong>Total Quantity :</strong> <h4 class="text-info"><?=$sub_total;?></h4>  </td>
  <td class="clearfix"> <strong>Total Money :</strong>  <h4 class="text-success"><?=money($total); ?></h4>
    <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#checkoutmodal">
    <i class="fas fa-money-check "></i>  Check Out
  </button> </td>
</tr>
  </tbody>
</table>
<br>
<br><br>

    <?php } ?>
</div>

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="checkoutmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>



<?php include 'includes/footer.php'; ?>
