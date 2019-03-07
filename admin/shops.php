<?php
  require_once '../core/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';
?>
<?php $errors=array(); ?>

<!-- get brands from database -->
<?php
$shopsql="SELECT * FROM shops ORDER BY id";
$shop_query=mysqli_query($db,$shopsql);
 ?>

<!-- Add shops  -->
 <?php
 // <!-- if add shop button is clicked -->
 if(isset($_POST['add_submit'])){
$shop_name=sanitize($_POST['shop_name']);

// if shop name field is blank
if($_POST['shop_name']=='')
{
  $errors[].='You must enter a shop name !';
}

// if shop name is already in database
$checksql ="SELECT * FROM shops WHERE name = '$shop_name'";
$result=mysqli_query($db,$checksql);
$count = mysqli_num_rows($result);
if($count>0)
{
  $errors[].=$shop_name.' is already exist !';
}

// display error if exist
if(!empty($errors)){
  echo display_errors($errors);
}
else {
  // insert in to shop table
  $insertsql ="INSERT INTO shops (name) VALUES ('$shop_name')";
  $result=mysqli_query($db,$insertsql);
  header('Location: shops.php');
}
 }
  ?>

<div class="container py-5">
  <table class="table table-hover table-bordered ">
    <tr>
      <td colspan="2">
        <form class="form-inline" action="shops.php" method="post">
        <div class="form-group mb-2">
        <label for="shop"> <strong> Shop Name : </strong></label>
        </div>
      </td>
      <td>
        <div class="form-group mx-sm-3 mb-2">
        <input type="text" class="form-control" name="shop_name" autocomplete="off" id="Update_Shop" value="<?=((isset($_POST['name']))?$_POST['name']:'')?>">
        </div>
      </td>
      <td>
        <button type="submit" name="add_submit" class="btn btn-primary mb-2">Add Shop </button>
        </form>
      </td>
    </tr>

  <h3 class="text-center">Shops</h3>
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
