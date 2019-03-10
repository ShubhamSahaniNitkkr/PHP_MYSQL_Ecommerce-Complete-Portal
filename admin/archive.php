<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Ecommerce/core/init.php';
if(!is_logged_in()){
  login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';

// delete products
if(isset($_GET['restore'])){
  $restore_id=sanitize($_GET['restore']);
  $restore_product_sql="UPDATE products SET deleted = 0 WHERE id = '$restore_id'";
  mysqli_query($db,$restore_product_sql);
  header("Refresh:0;url=archive.php");
}
$productsql="SELECT * FROM products WHERE deleted = 1";
$product_query=mysqli_query($db,$productsql);

 ?>

 <div class="container py-5">
   <table class="table table-responsive-lg table-hover table-bordered ">
    <p class="h4 text-left">Deleted Products</p>
   <thead class="thead-light py-2">
     <tr>
       <th>Update</th>
       <th scope="col">Product</th>
       <th scope="col">Price</th>
       <th scope="col">Category</th>
       <th scope="col">Sold</th>
     </tr>
   </thead>
   <tbody>
     <?php while($products = mysqli_fetch_assoc($product_query)){ ?>
     <?php
      $product_category_id=$products['categories'];
      $find_child_sql="SELECT * FROM categories WHERE id='$product_category_id' ";
      $find_child_query=mysqli_query($db,$find_child_sql);
      $child=mysqli_fetch_assoc($find_child_query);

      $parent_id=$child['parent'];

      $find_parent_sql="SELECT * FROM categories WHERE id='$parent_id' ";
      $find_parent_query=mysqli_query($db,$find_parent_sql);
      $parent=mysqli_fetch_assoc($find_parent_query);
      $category=$parent['category'].' - '.$child['category'];

      ?>

     <tr>
       <td> <a href="archive.php?restore=<?= $products['id'];?>" class="btn btn-xs btn-info "><i class="fas fa-circle-notch"></i> Restore</a>
       <td><?=$products['title']?></td>
       <td><?=money($products['price']);?></td>
       <td><?=$category;?></td>
       <td>0</td>
     </tr>
     <?php }?>
   </tbody>
 </table>
 </div>

 <?php include 'includes/footer.php'; ?>
 <script>
 $('document').ready(function(){
   get_sub_category('<?=$sub_category;?>');
 });
 </script>
