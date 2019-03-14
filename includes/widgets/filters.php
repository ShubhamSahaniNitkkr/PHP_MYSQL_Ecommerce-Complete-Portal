<?php
  $cat_id=((isset($_REQUEST['cat']))?sanitize($_REQUEST['cat']):'');
  $price_sort=((isset($_REQUEST['price_sort']))?sanitize($_REQUEST['price_sort']):'');
  $min_price=((isset($_REQUEST['min_price']))?sanitize($_REQUEST['min_price']):'');
  $max_price=((isset($_REQUEST['max_price']))?sanitize($_REQUEST['max_price']):'');

  $b=((isset($_REQUEST['shop']))?sanitize($_REQUEST['shop']):'');
  $brandsql="SELECT * FROM shops ORDER BY name";
  $brandquery=mysqli_query($db,$brandsql);

 ?>

<div class="text-center h5 my-1"> Search By : </div>

<div> Price </div>
<form action="search.php" method="post">
  <input type="hidden" name="cat" value="<?=$cat_id;?>">
  <input type="hidden" name="price_sort" value="0">

  <input type="radio" name="price_sort" value="low" <?=(($price_sort == 'low')?' checked':'');?>>
  Low to High <br>

  <input type="radio" name="price_sort" value="high" <?=(($price_sort == 'high')?' checked':'');?>>
  High to Low <br>
  <br>
  <input type="text" name="min_price" value="<?=$min_price?>" class="price_range " placeholder="Min Rs:">
  <input type="text" name="max_price" value="<?=$max_price?>" class="price_range " placeholder="Max Rs:">
  <hr>

  <div> Shops </div>
  <input type="radio" name="shop" value="" <?=(($b == '')?' checked':'');?>> All <br>
  <?php while($shops = mysqli_fetch_assoc($brandquery)){ ?>
    <input type="radio" name="shop" value="<?=$shops['id']?>" <?=(($b == $shops['id'])?' checked':'');?>> <?=$shops['name']?><br>
   <?php } ?>
   <br>
   <input type="submit" class="btn btn-info btn-sm" value="Search">
</form>
<?php

 ?>
