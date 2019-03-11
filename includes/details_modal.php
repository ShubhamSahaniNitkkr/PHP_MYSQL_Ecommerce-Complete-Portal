<?php
require_once '../core/init.php';
$id=$_POST['id'];
$id=(int)$id;

$dsql="SELECT * FROM products WHERE id = '$id'";
$dquery=mysqli_query($db,$dsql);

$product=mysqli_fetch_assoc($dquery);
$kilo=$product['kilos'];
$kilo_array=explode(',',$kilo);
 ?>

<?php ob_start(); ?>
<div class="modal fade" id="details_modal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailsModalLabel-1"> <?= $product['title'];?> </h5>
        <button type="button" class="close" onclick="close_modal()" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <span id="modal_errors" class="text-danger"></span>
      <div class="modal-body">
        <div class="col-md-12">
          <div class="card" style="width:100%;">
          <img class="card-img-top" src="<?= $product['image'];?>" alt="<?= $product['title'];?>">
          <div class="card-body">
          <h5 class="card-title">दुकानें जहां <?= $product['title'];?> की कीमत <?= $product['price'];?>/kg है</h5>
          <p class="clearfix"><span class="list-price text-danger float-left"> <s>Rs: <?= $product['list_price']; ?> kg</s> </span> <span class="price text-success float-right">Rs: <?= $product['price']; ?> kg</span></p>
        <table class="table table-hover "border="1px">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">दुकानों का नाम</th>
              <th scope="col">दुकानों का पता</th>
              <th scope="col">दूरी</th>

            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>Mukesh Kirana</td>
              <td>हनुमान मंदिर के पास</td>
              <td>5 km</td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>Mukesh Kirana</td>
              <td>हनुमान मंदिर के पास</td>
              <td>5 km</td>
            </tr>
          </tbody>
          </table>

        <form class="was-validated" action="add_cart.php" method="post" id="add_product_form">
          <input type="hidden" name="product_id" value="<?=$id;?>">
          <input type="hidden" name="kilo" value="" id="hkilo">

        <div class="form-group">
        <select id="kilo" class="custom-select" required>
        <option value="">कितने किलोग्राम </option>
        <?php
        foreach($kilo_array as $kg){
          echo '<option value="'.$kg.'" data-kg="'.$kg.'">'.$kg.'</option>';
        } ?>

        </select>
        <div class="invalid-feedback">कृपया चुनें कि आप कितने किलोग्राम खरीदना चाहते हैं|</div>
        </div>

        </form>
          </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#details-1" name="buy"><i class="fas fa-money-bill-alt"></i> Buy</button> -->
        <button type="button" onclick="add_to_cart();return false;" class="btn btn-md btn-warning" name="add_to_cart"> <i class="fas fa-shopping-bag"></i> झोले में डाले </button>
        <button type="button" class="btn btn-secondary btn-danger" onclick="close_modal()"> <i class="fas fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>

<script>

$('#kilo').change(function(){
  var kilo=$('#kilo option:selected').data("kg");
  $('#hkilo').val(kilo);
});




function close_modal()
{
  $('#details_modal').modal('hide');
  setTimeout(function(){
    $('#details_modal').remove();
  },500);
}
</script>

<?php echo ob_get_clean(); ?>
