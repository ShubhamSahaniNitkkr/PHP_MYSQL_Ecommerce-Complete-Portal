<h5 class="text-center">Latest items</h5>

 <table class="table table-bordered table-hover table-responsive-lg" style="font-size:12px;">
 <thead class="thead-light">
   <tr>
     <th scope="col">Item</th>
     <th scope="col">view</th>
   </tr>
 </thead>
 <tbody>
   <?php
     $productsql="SELECT * FROM products WHERE deleted = 0 LIMIT 2";
     $productquery=mysqli_query($db,$productsql);
   ?>
   <?php while($productresult=mysqli_fetch_assoc($productquery)){ ?>
   <tr>
     <td><?=$productresult['title'];?></td>
     <td>
       <a style="border:2px solid green;border-radius:3px;pointer:hand;padding:5px;" onclick="details_modal_function(<?= $productresult['id']; ?>);" name="buy"></i>View</a>
     </td>
   </tr>
   <?php } ?>
 </tbody>
</table>
