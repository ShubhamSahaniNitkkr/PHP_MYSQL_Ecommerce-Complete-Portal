<?php include 'core/init.php'; ?>
<?php include 'includes/head.php'; ?>
<?php include 'includes/navigation.php'; ?>
<?php include 'includes/left_bar.php'; ?>
<?php

  $cat_id=(($_POST['cat']!='')?sanitize($_POST['cat']):'');

  $categorysql="SELECT * FROM products";
  if($cart_id == ''){
    $categorysql.=" WHERE deleted = 0";
  }
  else{
    $categorysql.=" WHERE categories ='{$cart_id}' AND deleted != 1";
  }
  $price_sort=(($_POST['price_sort'] !='')?sanitize($_POST['price_sort']):'');
  $min_price=(($_POST['min_price'] !='')?sanitize($_POST['min_price']):'');
  $max_price=(($_POST['max_price'] !='')?sanitize($_POST['max_price']):'');
  $shop=(($_POST['shop'] !='')?sanitize($_POST['shop']):'');

  if($min_price !=''){
    $categorysql.=" AND price >= '{$min_price}'";
  }

  if($max_price !=''){
    $categorysql.=" AND price <= '{$max_price}'";
  }

  if($shop !=''){
    $categorysql.=" AND shops = '{$shop}'";
  }

  if($price_sort =='low'){
    $categorysql.=" ORDER BY price";
  }

  if($price_sort =='high'){
    $categorysql.=" ORDER BY price DESC";
  }

  $categoryquery=mysqli_query($db,$categorysql);
  $category=get_main_category($cat_id);
?>

    <div class="col-md-8">
      <?php if($cart_id!=''){ ?>
      <h2 class="text-center py-2"> <?=$category['parent'].' - '.$category['child']?></h2>
      <?php }else{ ?>
      <h2 class="text-center py-2">मेरी local दुकान</h2>
      <?php } ?>
      <div class="row">
        <?php while($items= mysqli_fetch_assoc($categoryquery)){ ?>

        <div class="col-md-4 py-3">
          <div class="card" style="width:100%;">
          <img class="card-img-top img-responsive" src="<?= $items['image']; ?>" alt="<?= $items['title']; ?>" >
          <div class="card-body">
          <h5 class="card-title"><?= $items['title']; ?></h5>
          <hr>
          <p class="card-text text-truncate" >Shop name: <?= $items['description']; ?></p>
          <hr>
          <p class="clearfix"><span class="list-price text-danger float-left"> <s>Rs: <?= $items['list_price']; ?> kg</s> </span> <span class="price text-success float-right">Rs: <?= $items['price']; ?> kg</span></p>
          <button type="button" class="btn btn-md btn-success" onclick="details_modal_function(<?= $items['id']; ?>);" name="buy"><i class="fas fa-money-bill-alt"></i> Buy</button>
          <button type="button" class="btn btn-md btn-warning" onclick="details_modal_function(<?= $items['id']; ?>);" name="add_to_cart"><i class="fas fa-shopping-cart"></i> झोले में डाले</button>
          </div>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>

<?php include 'includes/right_bar.php'; ?>
<?php include 'includes/login_sign_up_modal.php'; ?>
<?php include 'includes/footer.php'; ?>
