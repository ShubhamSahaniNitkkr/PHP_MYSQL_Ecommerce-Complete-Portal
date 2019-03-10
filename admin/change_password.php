<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Ecommerce/core/init.php';
if(!is_logged_in()){
  login_error_redirect();
}
include 'includes/head.php';

$hashed=$user_data['password'];
$old_password=((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
$old_password=trim($old_password);

$password=((isset($_POST['password']))?sanitize($_POST['password']):'');
$password=trim($password);

$confirm=((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
$confirm=trim($confirm);

$new_hashed=password_hash($password,PASSWORD_DEFAULT);
$user_id=$user_data['id'];

$errors=array();
?>

<style media="screen">
  body{
    background-image: url('../medias/login_background.jpg');
    background-size: cover;
    background-repeat: no-repeat;
  }


  #login-form{
    margin: 8% auto;
    width: 50%;
    height: 60%;
    padding: 25px;
    background: #80808070;
  }

</style>

<div id="login-form" class="container">
  <?php
  if($_POST)
  {
    if(strlen($password)<6){
      $errors[].='The Password must be of 6 digits';
    }

    // if new password and confirmm password are not same
    if($password!=$confirm)
    {
      $errors[].='The Password and confirm Password does not match !';
    }

    if(!password_verify($old_password,$hashed)){
      $errors[].='The Old Password you entered is wrong !';
    }

    if(!empty($errors)){
      echo display_errors($errors);
    }else{
      $update_password_sql="UPDATE users SET password ='$new_hashed' where id='$user_id'";
      mysqli_query($db,$update_password_sql);
      $_SESSION['success_flash']='Your password has been updated !';
      header('location:index.php');
    }
  }
   ?>
  <div>
    <h2 class="text-center">Change Password</h2>
  </div>

  <form action="change_password.php" method="post">
  <div class="form-group">
    <label for="old_password">Old Password</label>
    <input type="text"  name="old_password" class="form-control" id="old_Password" value="<?=$old_password;?>" placeholder="Old_Password" required>
  </div>

  <div class="form-group">
    <label for="Password">New Password</label>
    <input type="password"  name="password" class="form-control" id="Password" value="<?=$password;?>" placeholder="Password" required>
  </div>

  <div class="form-group">
    <label for="Confirm">Confirm New Password</label>
    <input type="password"  name="confirm" class="form-control" id="confirm" value="<?=$confirm;?>" placeholder="Password" required>
  </div>

  <button type="submit" class="btn btn-dark">Change Password</button>
  <a class="btn btn-danger float-right" href="index.php" alt="Home"> <i class="fas fa-times"></i> Cancel</a>
</form>


</div>

<?php include 'includes/footer.php'; ?>
