<?php
  require_once '../core/init.php';
  if(!is_logged_in()){
    login_error_redirect();
  }
  include 'includes/head.php';
  include 'includes/navigation.php';
?>
<?php
  $ordersql="SELECT t.id,t.cartid,t.fullname,t.description,t.txn_date,t.total,c.items,c.paid,c.shipped
    FROM transaction t LEFT JOIN cart c ON t.cartid = c.id
    WHERE c.paid=1 AND c.shipped =0
    ORDER BY t.id";
  $order_query=mysqli_query($db,$ordersql);
 ?>

<div class="container py-5">
  <h4>Orders to Complete </h4>
 <table class="table table-bordered table-hover">
  <thead class="bg-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">No. of Items</th>
      <th scope="col">Total</th>
      <th scope="col">Order Date</th>
    </tr>
  </thead>
  <tbody>
    <?php while($order=mysqli_fetch_assoc($order_query)){ ?>
    <tr>
      <th> <a href="orders.php?txn_id=<?=$order['id'];?>" class="btn btn-sm btn-info">Details</a> </th>
      <td><?=$order['fullname'];?></td>
      <td><?=$order['description'];?></td>
      <td><?=money($order['total']);?></td>
      <td><?=pretty_date($order['txn_date']);?></td>
    </tr>
    <?php }?>
  </tbody>
</table>

<div class="row py-5" >


  <div class="col-md-6">
    <?php
    $thisyr=date("Y");
    $lastyr=$thisyr-1;

    $thisyrsql="SELECT total ,txn_date FROM transaction WHERE YEAR(txn_date)='{$thisyr}'";
    $thisyrquery=mysqli_query($db,$thisyrsql);

    $lastyrsql="SELECT total ,txn_date FROM transaction WHERE YEAR(txn_date)='{$lastyr}'";
    $lastyrquery=mysqli_query($db,$lastyrsql);

    $current=array();
    $last=array();
    $current_total=0;
    $last_total=0;

    while($x=mysqli_fetch_assoc($thisyrquery)){
      $month = date("m",strtotime($x['txn_date']));
      if(!array_key_exists($month,$current)){
        $current[(int)$month]=$x['total'];
      }else{
        $current[(int)$month] += $x['total'];
      }
      $current_total += $x['total'];
    }


    while($y=mysqli_fetch_assoc($lastyrquery)){
      $month = date("m",strtotime($x['txn_date']));
      if(!array_key_exists($month,$last)){
        $last[(int)$month]=$y['total'];
      }else{
        $last[(int)$month]+=$y['total'];
      }
      $last_total+=$y['total'];
    }
     ?>
    <table class="table table-bordered table-striped table-hover">
      <h3>Sales By Month</h3>
  <thead>
    <tr>
      <th scope="col">Months</th>
      <th scope="col"><?=$lastyr;?></th>
      <th scope="col"><?=$thisyr;?></th>


    </tr>
  </thead>
  <tbody>
    <?php for($i=1 ;$i<=12;$i++){ ?>
      <?php $dt=DateTime::createFromFormat('!m',$i); ?>
    <tr <?=(date("m") == $i)?' class="bg-info"':''?>>
      <td><?=$dt->format("F");?></td>
      <td scope="col"><?=(array_key_exists($i,$last))?money($last[$i]):money(0);?></td>
      <td scope="col"><?=(array_key_exists($i,$current))?money($current[$i]):money(0);?></td>
     </tr>
    <?php } ?>
    <tr>
      <td>Total</td>
      <td><?=money($last_total);?></td>
      <td class="text-success"> <h3> <?=money($current_total);?></h3> </td>
    </tr>
  </tbody>
</table>
  </div>

  <div class="col-md-6">
    <table class="table table-bordered table-hover table-striped">
      <h3>Low Inventory</h3>
    <thead>
      <tr>
        <th scope="col">Product</th>
        <th scope="col">Category</th>
        <th scope="col">Quantity</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $productsql="SELECT * FROM products WHERE deleted =0 ORDER BY kilos";
      $productquery=mysqli_query($db,$productsql);
       ?>
       <?php while($product = mysqli_fetch_assoc($productquery)){ ?>
         <?php $category_id=$product['categories'];
          $categorysql="SELECT * FROM categories WHERE id='$category_id'";
          $categoryquery=mysqli_query($db,$categorysql);
          $category = mysqli_fetch_assoc($categoryquery);
         ?>
      <tr
      <?
      if($product['kilos']==1)
      {
        echo 'class=bg-danger';
      }
      else if($product['kilos']<=5){
        echo 'class=bg-warning';
      }
      else if($product['kilos']<=10 && $product['kilos']>5){
        echo 'class=bg-primary';
      }
      ?>
      >
        <td><?=$product['title']?></td>
        <td><?=$category['category']?></td>
        <td><?=$product['kilos']?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>

  </div>

</div>



</div>
<?php include 'includes/footer.php';
?>
