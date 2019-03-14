<?php
  $isql="SELECT * FROM products WHERE featured = 1 AND deleted!= 1";
  $iquery=mysqli_query($db,$isql);
?>

    <div class="col-md-8">
      <h2 class="text-center py-2"> अभी मसौढ़ी बाजार में कम कीमत वाले सामान</h2>

      <div class="row">
        <?php while($items= mysqli_fetch_assoc($iquery)){ ?>

        <div class="col-md-4 py-3">
          <div class="card" style="width:100%;">
            <?php $photos=explode(',',$items['image']);?>

          <img class="card-img-top img-responsive" src="<?= $photos[0]; ?>" alt="<?= $items['title']; ?>" >

          <div class="card-body">
          <h5 class="card-title"><?= $items['title']; ?></h5>
          <hr>
          <div class="card-text text-truncate " >Shop name: <?= $items['description']; ?></div>
          <hr>
          <p class="clearfix"><span class="list-price text-danger float-left"> <s>Rs: <?= $items['list_price']; ?> kg</s> </span> <span class="price text-success float-right">Rs: <?= $items['price']; ?> kg</span></p>
          <button type="button" class="btn btn-md btn-success" onclick="details_modal_function(<?= $items['id']; ?>);" name="buy" id="details_modal_btn"><i class="fas fa-money-bill-alt"></i> Buy</button>
          <!-- <button type="button" class="btn btn-md btn-warning" onclick="details_modal_function(<?= $items['id']; ?>);" name="add_to_cart"><i class="fas fa-shopping-bag"></i> झोले में डाले</button> -->
          </div>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
