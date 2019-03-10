<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Ecommerce/core/init.php';
if(!is_logged_in()){
  login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';
 ?>

 <?php
  $menusql="SELECT * FROM categories WHERE parent = 0";
  $menu_query=mysqli_query($db,$menusql);
  $errors=array();
  $category='';
  $post_parent='';
  ?>

  <!-- edit categories -->
  <?php
  if(isset($_GET['edit']) && !empty($_GET['edit']))
  {
    $edit_id=(int)$_GET['edit'];
    $edit_id=sanitize($edit_id);

    $editsql="SELECT * FROM categories WHERE id ='$edit_id' ";
    $edit_result=mysqli_query($db,$editsql);
    $editmenu=mysqli_fetch_assoc($edit_result);

  }

   ?>

  <!-- delete category -->
  <?php
  if(isset($_GET['delete']) && !empty($_GET['delete']))
  {
    $delete_id=(int)$_GET['delete'];
    $delete_id=sanitize($delete_id);
    $checksql="SELECT * FROM categories WHERE id ='$delete_id' ";
    $result=mysqli_query($db,$checksql);
    $check=mysqli_fetch_assoc($result);
    if($check['parent']==0)
    {
      $delete_sub_menu_sql="DELETE FROM categories WHERE parent ='$delete_id' ";
      mysqli_query($db,$delete_sub_menu_sql);
    }
    $deletesql="DELETE FROM categories WHERE id ='$delete_id' ";
    mysqli_query($db,$deletesql);
    header('Location: categories.php');
  }
   ?>

  <!-- process form -->
  <?php

  if(isset($_POST) && !empty($_POST))
  {
    $post_parent=sanitize($_POST['parent']);
    $category=sanitize($_POST['category']);

    $sqlform="SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent' ";
    if(isset($_GET['edit']))
    {
      $check_edit_id=$editmenu['id'];
      $sqlform="SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent' AND id = '$check_edit_id' ";
    }
    $form_query=mysqli_query($db,$sqlform);
    $count=mysqli_num_rows($form_query);

    if($category == ''){
      $errors[].='The category cannot be left blank';
    }

    if($count>0)
    {
      $errors[].=$category.' Already exist !';
    }

    if(!empty($errors))
    {
      $display=display_errors($errors);
    ?>
    <script>
    jQuery('document').ready(function(){
      jQuery('#errors').html('<?=$display?>');
    });
    </script>
    <?php
    }else{
      $insertsql ="INSERT INTO categories (category,parent) VALUES ('$category','$post_parent')";
      if(isset($_GET['edit']))
      {
        $insertsql ="UPDATE categories SET category = '$category', parent ='$post_parent' WHERE id= '$edit_id'";
      }
      mysqli_query($db,$insertsql);
      header('Location: categories.php');
    }
  }

   ?>
   <?php
   $menu_value='';
   $menu_parent_value=0;
   if(isset($_GET['edit'])){
     $menu_value=$editmenu['category'];
     $menu_parent_value= $editmenu['parent'];
    }else {
     if(isset($_POST['category']))
     {
       $menu_value=sanitize($_POST['category']);
       $menu_parent_value=$post_parent;
     }
   }
    ?>

 <div class="container py-5">
   <p id="errors" class="text-danger"> </p>

   <form class="was-validated" action="categories.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'')?>" method="post">
     <div class="form-group">
       <select class="custom-select form-control" name="parent" id="parent" required>
         <option value="0"<?=(($menu_parent_value == 0)?' selected="selected"':'');?> >Main Category</option>
         <?php while($menu = mysqli_fetch_assoc($menu_query)){ ?>
           <option value="<?=$menu['id'];?>"<?=(($menu_parent_value == $menu['id'])?'selected="selected"':'')?>> <?=$menu['category'];?> </option>
         <?php } ?>
       </select>
       <div class="invalid-feedback">Choosing any category is must!</div>
     </div>

     <div class="form-group">
       <input type="text" name="category" id="category" class="form-control" value="<?=$menu_value;?>">
     </div>
     <div class="form-group">
       <input type="submit" value="<?=((isset($_GET['edit']))?'Edit Category':'Add Category')?>" class="btn btn-success">

     <?php if(isset($_GET['edit'])){ ?>
         <a href="categories.php" class="text-danger px-3"> cancel</a>
     <?php } ?>
    </div>

   </form>



   <table class="table table-responsive-lg table-hover table-bordered ">
   <h3 class="text-center">Category</h3>
   <thead class="thead-light">
     <tr>
       <th scope="col">Category</th>
       <th scope="col">Sub - Category</th>
       <th scope="col">Edit</th>
       <th scope="col">Delete</th>
     </tr>
   </thead>
   <tbody>
     <?php
       $menusql="SELECT * FROM categories WHERE parent = 0";
       $menu_query=mysqli_query($db,$menusql);
     ?>
     <?php while($menus = mysqli_fetch_assoc($menu_query)){
       $parent_id= $menus['id'];
       $submenusql="SELECT * FROM categories WHERE parent = '$parent_id'";
       $submenu_query=mysqli_query($db,$submenusql);
      ?>
      <tr class="text-info">
        <td><?= $menus['category'];?></td>
        <td></td>
        <td> <a href="categories.php?edit=<?= $menus['id'];?>" class="btn btn-xs btn-warning "><i class="fas fa-edit"></i> Edit</a></td>
        <td> <a href="categories.php?delete=<?= $menus['id'];?>" class="btn btn-xs btn-danger "> <i class="fas fa-trash"></i> Delete</a></td>
      </tr>

       <tr>
         <?php while($submenus = mysqli_fetch_assoc($submenu_query)){ ?>
         <td></td>
         <td><?= $submenus['category'];?></td>
         <td> <a href="categories.php?edit=<?= $submenus['id'];?>" class="btn btn-xs btn-warning "><i class="fas fa-edit"></i> Edit</a></td>
         <td> <a href="categories.php?delete=<?= $submenus['id'];?>" class="btn btn-xs btn-danger "> <i class="fas fa-trash"></i> Delete</a></td>
       </tr>
     <?php } ?>
     <?php  }?>

   </tbody>
 </table>
 </div>



 <?php include 'includes/footer.php'; ?>
