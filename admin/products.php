<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Ecommerce/core/init.php';
if(!is_logged_in()){
  login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';

// delete products
if(isset($_GET['delete'])){
  $delete_id=sanitize($_GET['delete']);
  $delete_product_sql="UPDATE products SET deleted = 1 WHERE id = '$delete_id'";
  mysqli_query($db,$delete_product_sql);
  header("Refresh:0;url=products.php");
}
$dbpath='';

if(isset($_GET['add']) || isset($_GET['edit'])){
  $shopsql="SELECT * FROM shops ORDER BY name";
  $shop_query=mysqli_query($db,$shopsql);

  $main_menu_sql="SELECT * FROM categories WHERE parent = 0";
  $main_menu_query=mysqli_query($db,$main_menu_sql);

  $title=((isset($_POST['title']) && $_POST['title']!='')?sanitize($_POST['title']):'');
  $shop=((isset($_POST['shop']) && $_POST['shop']!='')?sanitize($_POST['shop']):'');
  $sub_category=((isset($_POST['sub_category']) && $_POST['sub_category']!='')?sanitize($_POST['sub_category']):'');
  $categories=((isset($_POST['category']) && $_POST['category']!='')?sanitize($_POST['category']):'');
  $price=((isset($_POST['price']) && $_POST['price']!='')?sanitize($_POST['price']):'');
  $list_price=((isset($_POST['list_price']) && $_POST['list_price']!='')?sanitize($_POST['list_price']):'');
  $Qtypreview=((isset($_POST['Qtypreview']) && $_POST['Qtypreview']!='')?sanitize($_POST['Qtypreview']):'');
  $description=((isset($_POST['description']) && $_POST['description']!='')?sanitize($_POST['description']):'');
  $saved_image='';

  if(isset($_GET['edit'])){
    $edit_id=(int)$_GET['edit'];
    $fetchproductresultsql="SELECT * FROM products WHERE id='$edit_id'";
    $fetch_product_query=mysqli_query($db,$fetchproductresultsql);
    $productforedit=mysqli_fetch_assoc($fetch_product_query);
    if(isset($_GET['delete_image'])){
      $imgi=(int)$_GET['imgi']-1;
      $images=explode(',',$productforedit['image']);
      $image_url='../'.$images[$imgi];
      unlink($image_url);
      unset($images[$imgi]);
      $newimagestring=implode(',',$images);
      $clearimagesql="UPDATE products SET image='{$newimagestring}' WHERE id = '$edit_id'";
      $clearimagequery=mysqli_query($db,$clearimagesql);
      header('Location:products.php?edit='.$edit_id);
    }
    $title=((isset($_POST['title']) && !empty($_POST['title']))?sanitize($_POST['title']):$productforedit['title']);
    $shop=((isset($_POST['shop']) && !empty($_POST['shop']))?sanitize($_POST['shop']):$productforedit['shops']);
    $sub_category=((isset($_POST['sub_category']) && !empty($_POST['sub_category']))?sanitize($_POST['sub_category']):$productforedit['categories']);
    $fetch_main_category_frm_sub_category="SELECT * FROM categories WHERE id='$sub_category'";
    $fetch_main_category_frm_sub_category_query=mysqli_query($db,$fetch_main_category_frm_sub_category);
    $fetch_main_category_frm_sub_category_result=mysqli_fetch_assoc($fetch_main_category_frm_sub_category_query);
    $categories=((isset($_POST['category']) && !empty($_POST['category']))?sanitize($_POST['category']):$fetch_main_category_frm_sub_category_result['parent']);
    $price=((isset($_POST['price']) && !empty($_POST['price']))?sanitize($_POST['price']):$productforedit['price']);
    $list_price=((isset($_POST['list_price']) && !empty($_POST['list_price']))?sanitize($_POST['list_price']):$productforedit['list_price']);
    $description=((isset($_POST['description']) && !empty($_POST['description']))?sanitize($_POST['description']):$productforedit['description']);
    $Qtypreview=((isset($_POST['Qtypreview']) && !empty($_POST['Qtypreview']))?sanitize($_POST['Qtypreview']):$productforedit['kilos']);
    $saved_image=(($productforedit['image']!='')?$productforedit['image']:'');
    $dbpath=$saved_image;
  }

  if(!empty($Qtypreview))
  {
    $kilo_string=sanitize($Qtypreview);
    $kilo_string=rtrim($kilo_string,',');
  }

  if($_POST)
  {
    $tmploc='';
    $uploadpath='';
    $required=array('title','shop','price','list_price','category','sub_category','Qtypreview');
    $allowed=array('png','jpeg','jpg','gif');
    $photoarray=array();
    $tmploc=array();
    $uploadpath=array();
    foreach ($required as $field){
      if($_POST[$field]==''){
        $errors[]='All Fields with ^ is Required !';
        break;
      }
    }


    if(!empty($_FILES)){
      $photocount=count($_FILES['photo']['name']);
      $photo = $_FILES['photo'];
      $photo_name=$photo['name'];

      if($photocount >0)
      {
        for($i=0;$i<$photocount;$i++){
          $name=$_FILES['photo']['name'][$i];
          $photoarray=explode('.',$name);
          $filename=$photoarray[0];
          $fileext=$photoarray[1];
        $mime = explode('/',$_FILES['photo']['type'][$i]);
        $mimetype=$mime[0];
        $mimeext=$mime[1];
        $tmploc[]=$_FILES['photo']['tmp_name'][$i];
        $filesize=$_FILES['photo']['size'][$i];

        $uploadname=md5(microtime().$i).'.'.$fileext;
        $uploadpath[]=BASEURL.'medias/products/'.$uploadname;
        if($i!=0){
          $dbpath .= ',';
        }
        $dbpath.='medias/products/'.$uploadname;

        if($mimetype!='image'){
          $errors[]='The File must be an image !';
        }

        if(!in_array($fileext,$allowed)){
          $errors[]='Allowed types are png , jpeg , jpg , gif !';
        }

        if($filesize>15000000){
          $errors[]='The File must be under 15 mb!';
        }

        }
      }
    }

    if(!empty($errors))
    {
      echo display_errors($errors);
    }
    else {
        if($photocount > 0){
          for($i=0 ; $i<$photocount ;$i++){
            move_uploaded_file($tmploc[$i],$uploadpath[$i]);
          }
        }
      $insertproductsql="INSERT INTO products (`title`,`price`,`list_price`,`shops`,`categories`,`image`,`description`,`kilos`)
      VALUES ('$title','$price','$list_price','$shop','$sub_category','$dbpath','$description','$kilo_string')";
      if(isset($_GET['edit']))
      {
        $insertproductsql="UPDATE products SET title = '$title', price= '$price',list_price = '$list_price', shops= '$shop', categories= '$sub_category', image= '$dbpath', description= '$description' ,kilos ='$kilo_string' WHERE id='$edit_id'";
      }
      mysqli_query($db,$insertproductsql);
      header('Location: products.php');
    }
  }

?>
<br><br>
<div class="container py-4 border border-success rounded">
  <div class="col-md-12">
  <h2 class="text-center"><?=((isset($_GET['edit']))?'Edit':'Add')?> Product</h2>
  <form action="products.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1')?>" method="post" enctype="multipart/form-data">

  <div class="form-group">

  <?php if($saved_image!=''){ ?>
  <?php
  $imgi=1;
  $images=explode(',',$saved_image);
  foreach ($images as $image){ ?>
    <img src="<?='../'.$image;?>" alt="<?=$title;?>" class="img-thumbnail" style="height:auto;width: 200px;">
    <a href="products.php?delete_image=1&edit=<?=$edit_id?>&imgi=<?=$imgi;?>" class="btn btn-danger">Delete Image</a>
    <?php $imgi++; }}else{ ?>
    <label for="photo">Product Photo :</label>
    <input type="file" name="photo[]" id="photo" class="form-control" multiple required>
    <?php } ?>

  </div>

  <div class="form-group">
  <label for="title">Title^</label>
  <input type="text" class="form-control" name="title" id="title" value="<?=$title;?>">
  </div>

  <div class="form-group">
  <label for="shops">Shops^</label>
  <select class="form-control" name="shop" id="shop">
    <option value=""<?=(($shop=='')?'selected':'')?>></option>
    <?php while($shops=mysqli_fetch_assoc($shop_query)){ ?>
    <option value="<?=$shops['id']?>" <?=(($shop==$shops['id'])?'selected':'')?> ><?=$shops['name']?></option>
    <?php }?>
  </select>
  </div>

  <div class="form-group">
  <label for="category">Main Category^</label>
  <select class="form-control" name="category" id="category">
    <option value=""<?=(($categories=='')?'selected':'')?>></option>
    <?php while($main_menus=mysqli_fetch_assoc($main_menu_query)){ ?>
    <option value="<?=$main_menus['id']?>" <?=(($categories==$main_menus['id'])?'selected':'')?> ><?=$main_menus['category']?></option>
    <?php }?>
  </select>
  </div>

  <div class="form-group">
  <label for="sub_category">Sub Category^</label>
  <select class="form-control" name="sub_category" id="sub_category">
  </select>
  </div>

  <div class="form-group">
    <label for="price">Price^ : </label>
    <input type="text" name="price" class="form-control" value="<?=$price;?>">
  </div>

  <div class="form-group">
    <label for="list_price">List Price^ : </label>
    <input type="text" name="list_price" class="form-control" value="<?=$list_price;?>">
  </div>

  <div class="form-group">
    <label for="Quantity">Change Quantity :</label>
    <input type="text" id="qty" name="Qtypreview" class="form-control" value="<?=$Qtypreview;?>">
  </div>

  <!-- <div class="form-group">
    <label for="Qtypreview">Quantity Preview^ : </label>
    <input type="text" id="qty_field" name="Qtypreview" class="form-control" value="<?=$Qtypreview;?>" readonly>
  </div> -->



  <div class="form-group">
    <label for="description">Description : </label>
    <input type="textarea" name="description" class="form-control" value="<?=$description;?>">
  </div>

  <input type="submit" name="" value="<?=((isset($_GET['edit']))?'Edit':'Add')?> Products" class="form-control btn btn-success">
<br>
<br>
  <a href="products.php" class="btn btn-danger form-control">Cancel</a>
</form>

<!-- modal -->
<div class="modal fade" id="sizemodal" tabindex="-1" role="dialog" aria-labelledby="login_sign_up_ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sizesModalLabel">Quantity & Sizes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php for($i=1;$i<3;$i++){ ?>
          <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" min="0" name="qty<?=$i;?>" id="qty<?=$i;?>" class="form-control">
          </div>

        <?php } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="update_kilo();$('#sizemodal').modal('toggle');return false;">Save changes</button>
      </div>
    </div>
  </div>
</div>

</div>
</div>
<?php
}else {
$productsql="SELECT * FROM products WHERE deleted = 0";
$product_query=mysqli_query($db,$productsql);

if(isset($_GET['featured'])){
  $id=(int)$_GET['id'];
  $featurd =(int)$_GET['featured'];

  $updatesql ="UPDATE products SET featured ='$featurd' WHERE id='$id'";
  $result=mysqli_query($db,$updatesql);
  header('Location: products.php');
}
 ?>

 <div class="container py-5">
   <table class="table table-responsive-lg table-hover table-bordered ">
     <p class="clearfix py-2">
   <h3 class="text-center float-left"> <?=((isset($_GET['edit']))?'Edit':'Add')?> Products</h3>
   <a href="products.php?add=1" class="btn btn-success float-right" id="add-product-btn"> <?=((isset($_GET['edit']))?'Edit':'Add')?> Product</a>
   </p>
   <thead class="thead-light py-2">
     <tr>
       <th>Update</th>
       <th scope="col">Product</th>
       <th scope="col">Price</th>
       <th scope="col">Category</th>
       <th scope="col">Featured</th>
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

     <tr class="clearfix">
       <td> <a href="products.php?edit=<?= $products['id'];?>" class="btn btn-xs btn-warning float-left"><i class="fas fa-edit"></i> Edit</a>
        <a href="products.php?delete=<?= $products['id'];?>" class="btn btn-xs btn-danger float-right"> <i class="fas fa-trash"></i> Delete</a></td>
       <td><?=$products['title']?></td>
       <td><?=money($products['price']);?></td>
       <td><?=$category;?></td>
       <td>
         <a href="products.php?featured=<?=(($products['featured']==0)?'1':'0')?>&id=<?=$products['id']?>" class="btn btn-xs btn-info"> <i class="fas fa-<?=(($products['featured']==0)?'plus':'minus')?>"></i></a>
         &nbsp;<?=(($products['featured']==1)?'Featured Product':'')?>
       </td>
       </td>
       <td>0</td>
     </tr>
     <?php }?>
   </tbody>
 </table>
 </div>

 <?php }
 include 'includes/footer.php'; ?>
 <script>
 $('document').ready(function(){
   get_sub_category('<?=$sub_category;?>');
 });
 </script>
