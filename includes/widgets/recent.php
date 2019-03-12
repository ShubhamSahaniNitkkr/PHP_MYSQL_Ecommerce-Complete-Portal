<h3 class="text-center">Popular items</h3>
<?php
$cart_item_sql="SELECT * FROM cart WHERE paid =1 ORDER BY id DESC LIMIT 5";
$cart_item_query=mysqli_query($db,$cart_item_sql);
$cart_item_result=mysqli_fetch_assoc($cart_item_query);
$cart_items=json_decode($cart_item_result['items'],true);
?>

 <table class="table table-bordered table-hover table-responsive-lg" style="font-size:12px;">
 <thead class="thead-light">
   <tr>
     <th scope="col">Item</th>
     <th scope="col">view</th>
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
     <td><?=$productresult['title'];?></td>
     <td>
       <a style="border:2px solid green;border-radius:3px;pointer:hand;padding:5px;" onclick="details_modal_function(<?= $productresult['id']; ?>);" name="buy"></i>View</a>
     </td>
   </tr>
   <?php
   $i++;
} ?>
 </tbody>
</table>
