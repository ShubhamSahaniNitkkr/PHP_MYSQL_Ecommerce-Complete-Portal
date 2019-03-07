<?php
  $isql="SELECT * FROM products WHERE featured = 1";
  $iquery=mysqli_query($db,$isql);
?>

    <div class="col-md-8">
      <h2 class="text-center py-2"> अभी मसौढ़ी बाजार में कम कीमत वाले सामान</h2>

      <div class="row">
        <?php while($items= mysqli_fetch_assoc($iquery)){ ?>

        <div class="col-md-4 py-3">
          <div class="card" style="width:100%;">
          <img class="card-img-top" src="<?= $items['image']; ?>" alt="<?= $items['title']; ?>">
          <div class="card-body">
          <h5 class="card-title"><?= $items['title']; ?></h5>
          <p class="card-text">Shop name: <?= $items['description']; ?></p>
          <p class="clearfix"><span class="list-price text-danger float-left"> <s>Rs: <?= $items['list_price']; ?> kg</s> </span> <span class="price text-success float-right">Rs: <?= $items['price']; ?> kg</span></p>
          <button type="button" class="btn btn-md btn-success" onclick="details_modal_function(<?= $items['id']; ?>);" name="buy"><i class="fas fa-money-bill-alt"></i> Buy</button>
          <button type="button" class="btn btn-md btn-warning" onclick="details_modal_function(<?= $items['id']; ?>);" name="add_to_cart"><i class="fas fa-shopping-cart"></i> झोले में डाले</button>
          </div>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
