<?php include 'core/init.php'; ?>
<?php include 'includes/head.php'; ?>
<?php include 'includes/navigation.php'; ?>
<?php include 'includes/left_bar.php'; ?>
<?php

  if(isset($_GET['cat'])){
    $cat_id=sanitize($_GET['cat']);
  }else{
    $cat_id='';
  }
  $categorysql="SELECT * FROM products WHERE categories = '$cat_id' AND deleted!= 1";
  $categoryquery=mysqli_query($db,$categorysql);
  $category=get_main_category($cat_id);
?>

    <div class="col-md-8">
      <h2 class="text-center py-2"> <?=$category['parent'].' - '.$category['child']?></h2>

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
