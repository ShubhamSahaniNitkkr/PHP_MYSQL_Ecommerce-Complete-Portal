<?php
  require_once '../core/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';
?>

<?php
// get brands from database
$shopsql="SELECT * FROM shops ORDER BY id";
$shop_query=mysqli_query($db,$shopsql);
 ?>
<div class="container py-5">
  <table class="table table-hover table-bordered ">
    <thead class="text-center">
      <h3>Shops</h3>
    </thead>
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Edit</th>
      <th scope="col">Shops</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php while($shops = mysqli_fetch_assoc($shop_query)){ ?>
    <tr>
      <th scope="row"><?= $shops['id'];?> </th>
      <td> <a href="brands.php?edit=<?= $shops['id'];?>"><i class="fas fa-edit"></i> Edit</a></td>
      <td><?= $shops['name'];?></td>
      <td> <a href="brands.php?delete=<?= $shops['id'];?>"> <i class="fas fa-trash"></i> Delete</a></td>
    </tr>
    <?php  }?>

  </tbody>
</table>
</div>
<?php include 'includes/footer.php'; ?>
