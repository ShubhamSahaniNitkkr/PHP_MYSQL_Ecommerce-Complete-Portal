<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Ecommerce/core/init.php';
$parent_id=(int)$_POST['parent_id'];
$selected=sanitize($_POST['selected']);
$sub_menusql="SELECT * FROM categories WHERE parent = '$parent_id' ORDER BY category";
$sub_menu_query=mysqli_query($db,$sub_menusql);
ob_start();
 ?>
 <option value=""></option>
 <?php while($sub_menu=mysqli_fetch_assoc($sub_menu_query)){ ?>
 <option value="<?=$sub_menu['id'];?>" <?=(($selected==$sub_menu['id'])?' selected':'')?> ><?=$sub_menu['category'];?></option>
 <?php } ?>
 <?php echo ob_get_clean(); ?>
