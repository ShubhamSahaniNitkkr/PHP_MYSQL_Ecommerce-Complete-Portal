<!-- post means form data -->
<!-- get means address data -->

<?php
  require_once '../core/init.php';
  if(!is_logged_in()){
    login_error_redirect();
  }
  include 'includes/head.php';
  include 'includes/navigation.php';
?>
<?php $errors=array();

// <!-- get shop name from database -->
$shopsql="SELECT * FROM shops ORDER BY name";
$shop_query=mysqli_query($db,$shopsql);

// <!-- delete shops -->

 if(isset($_GET['delete']) && !empty($_GET['delete']))
 {
   $delete_id=(int)$_GET['delete'];
   $delete_id=sanitize($delete_id);
   $deletesql="DELETE FROM shops WHERE id ='$delete_id' ";
   mysqli_query($db,$deletesql);
   header('Location: shops.php');
 }

 // <!-- edit shops -->
 if(isset($_GET['edit']) && !empty($_GET['edit']))
 {
   $edit_id=(int)$_GET['edit'];
   $edit_id=sanitize($edit_id);

   $editsql="SELECT * FROM shops WHERE id ='$edit_id' ";
   $edit_result=mysqli_query($db,$editsql);
   $editshop=mysqli_fetch_assoc($edit_result);

 }

// <!-- Add shops  -->

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
if(isset($_GET['edit']))
{
  $checksql ="SELECT * FROM shops WHERE name = '$shop_name' AND id!='$edit_id'";
}

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
  // update shop name

  if(isset($_GET['edit'])){
    $insertsql ="UPDATE shops SET name ='$shop_name' WHERE id='$edit_id'";
  }
  $result=mysqli_query($db,$insertsql);
  header('Location: shops.php');
}
 }
  ?>

<div class="container py-5">
  <table class="table table-responsive-lg table-hover table-bordered ">
    <tr>
        <?php
        $shop_value='';
        if(isset($_GET['edit'])){
          $shop_value=$editshop['name'];
         }else {
          if(isset($_POST['shop_name']))
          {
            $shop_value=sanitize($_POST['shop_name']);
          }
        }
         ?>
      <td>
        <form class="form-inline" action="shops.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'')?>" method="post">
        <div class="form-group mb-2">
        <label for="shop" class="h3 btn btn-outline-info"><?=((isset($_GET['edit']))?'Edit':'Add')?> Shop Name :</label>
        </div>
      </td>
      <td>
        <div class="form-group mx-sm-3 mb-2">
        <input type="text" class="form-control" name="shop_name" autocomplete="off" id="Update_Shop" value="<?= $shop_value;?>">
        </div>
      </td>
      <td>
        <input type="submit" name="add_submit" class="btn btn-success mb-2" value="<?=((isset($_GET['edit']))?'Edit Shop Name':'Add Shop Name')?>">
        <?php if(isset($_GET['edit'])){ ?>
          <a href="shops.php" class="text-danger px-3"> cancel</a>
        <?php } ?>
        </form>
      </td>
    </tr>

  <h3 class="text-center">Shops</h3>
  <thead class="thead-light">
    <tr>
      <th scope="col">Edit</th>
      <th scope="col">Shops</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php while($shops = mysqli_fetch_assoc($shop_query)){ ?>
    <tr>
      <td> <a href="shops.php?edit=<?= $shops['id'];?>" class="btn btn-xs btn-warning "><i class="fas fa-edit"></i> Edit</a></td>
      <td><?= $shops['name'];?></td>
      <td> <a href="shops.php?delete=<?= $shops['id'];?>" class="btn btn-xs btn-danger "> <i class="fas fa-trash"></i> Delete</a></td>
    </tr>
    <?php  }?>

  </tbody>
</table>
</div>
<?php include 'includes/footer.php'; ?>
