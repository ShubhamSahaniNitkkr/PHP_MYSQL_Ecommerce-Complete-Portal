<?php include 'core/init.php'; ?>
<?php include 'includes/head.php'; ?>
<?php include 'includes/navigation.php'; ?>
<?php
$i=0;
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

<div class="container py-4">
    <h2 class="text-center">My Shopping Cart</h2>
    <hr>
    <?php if($cart_id==''){ ?>
    <div class="text-danger text-center h3">
      Your shopping cart is empty ! <i class="fas fa-cat"></i>
    </div>
    <?php }else{ ?>
  <table class="table table-bordered table-hover table-responsive-lg">
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Item</th>
      <th scope="col">Price</th>
      <th scope="col">Paid</th>
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
      <td><?=money(trim($productresult['price']));?></td>
      <?if($cart_item_result['paid']>0){?>
        <td> Yes </td>
      <?php }else{ ?>
        <td> No </td>
        <?php } ?>
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
<!--
<script>
$('#cart_number').html("<?=$i-1;?>");
</script> -->

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="checkoutmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="shipping_title">Shipping Address <i class="fas fa-truck"></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="shipping.php" method="post" id="payment_form">
          <span class="bg-danger" id="payment-errors"></span>
          <div id="step1" style="display:block;">

            <input type="text" class="form-control d-none" id="total"  name="total" value="<?=$total?>">

            <div class="form-row">
            <div class="form-group col-md-6">
            <label for="inputPassword4">Name</label>
            <input type="text" class="form-control" id="name"  name="name" placeholder="Full Name">
            </div>

            <div class="form-group col-md-6">
            <label for="Email">Email</label>
            <input type="email" class="form-control" id="email"  name="email" placeholder="Email">
            </div>

            </div>

            <div class="form-group">
            <label for="inputAddress">Address</label>
            <input type="text" class="form-control" id="address1"  name="address1" placeholder="1234 Main St">
            </div>
            <div class="form-group">
            <label for="inputAddress2">Address 2</label>
            <input type="text" class="form-control" id="address2"  name="address2" placeholder="Apartment, studio, or floor">
            </div>
            <div class="form-row">
            <div class="form-group col-md-6">
            <label for="inputCity">City</label>
            <input type="text" class="form-control"  name="city" id="city">
            </div>
            <div class="form-group col-md-4">
            <label for="inputState">State</label>
            <select id="state"  name="state" class="form-control">
            <option selected>Choose...</option>
            <option>...</option>
            </select>
            </div>
            <div class="form-group col-md-2">
            <label for="inputZip">Zip</label>
            <input type="text" class="form-control" id="zip" name="zip" >
            </div>
            </div>

          </div>

          <div id="step2" style="display:none;">
            <div class="form-row">
            <div class="form-group col-md-3">
            <label for="name">Name on card :</label>
            <input type="text" class="form-control" id="name">
            </div>

            <div class="form-group col-md-3">
            <label for="number">Card Number:</label>
            <input type="text" class="form-control" id="number">
            </div>

            <div class="form-group col-md-2">
            <label for="number">CVC:</label>
            <input type="text" class="form-control" id="cvc">
            </div>

            <div class="form-group col-md-2">
            <label for="expire-month">Expire Month</label>
            <select id="exp-month" class="form-control">
              <option></option>
              <?php for($i=1; $i<13; $i++) {?>
            <option value="<?=$i?>"><?=$i?></option>
              <?php } ?>
            </select>
            </div>

            <div class="form-group col-md-2">
            <label for="expire-year">Expire Year</label>
            <select id="exp-year" class="form-control">
              <option></option>
              <?php $yr=date("Y"); ?>
              <?php for($i=1; $i<13; $i++) {?>
            <option value="<?=$yr+$i?>"><?=$yr+$i?></option>
              <?php } ?>
            </select>
            </div>

          </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="check_address();"  id="next_button">Next <i class="fas fa-arrow-alt-circle-right"></i> </button>
        <button type="button" class="btn btn-info" onclick="back_address();"  id="back_button" style="display:none;"> <i class="fas fa-arrow-alt-circle-left"></i> Back </button>
        <button type="submit" class="btn btn-success " id="check_out_button" style="display:none;"> <i class="fas fa-hand-holding-usd"></i> Checkout </button>
      </div>
    </form>

    </div>
  </div>
</div>


<script>



</script>


<?php include 'includes/footer.php'; ?>
