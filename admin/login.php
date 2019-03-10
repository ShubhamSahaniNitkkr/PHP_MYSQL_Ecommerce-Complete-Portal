<!-- cookie- little information stored on client computer usually like remember me-->
<!-- session is same as cookie but stored on server side and does'nt need expire time it expire when browser is closed -->

<!-- session is better for security purpose as it is not visible -->
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Ecommerce/core/init.php';
include 'includes/head.php';

$email=((isset($_POST['email']))?sanitize($_POST['email']):'');
$email=trim($email);
$password=((isset($_POST['password']))?sanitize($_POST['password']):'');
$password=trim($password);
$hashed=password_hash($password,PASSWORD_DEFAULT);
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

    $check_email_existence="SELECT * FROM users WHERE email='$email'";
    $check_email_query=mysqli_query($db,$check_email_existence);
    $fetch_users=mysqli_fetch_assoc($check_email_query);
    $count_users=mysqli_num_rows($check_email_query);
    if($count_users<1)
    {
      $errors[].='The Email doesnt exist';
    }

    if(!password_verify($password,$fetch_users['password']) && strlen($password)>=6){
      $errors[].='The Password you entered is wrong';
    }

    if(!empty($errors)){
      echo display_errors($errors);
    }else{
      $fetched_user_id=$fetch_users['id'];
      login($fetched_user_id);
      // echo '<p class="bg-success">Welcome '.$fetch_users['full_name'].' !</p>';
    }
  }



   ?>
  <div>
    <h2 class="text-center">Login</h2>
  </div>

  <form action="login.php" method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email"  name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" value="<?=$email;?>" required>
    <small id="emailHelp" class="form-text text-light ">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password"  name="password" class="form-control" id="Password" value="<?=$password;?>" placeholder="Password" required>
  </div>
  <button type="submit" class="btn btn-primary"> <i class="fas fa-sign-in-alt"></i> Login</button>
  <a class="btn btn-info float-right" href="../index.php" alt="Home"> <i class="fas fa-home"></i></a>
</form>


</div>

<?php include 'includes/footer.php'; ?>
