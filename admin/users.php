<?php
  require_once '../core/init.php';
  if(!is_logged_in()){
    login_error_redirect();
  }
  if(!has_permission('admin')){
    permission_error_redirect('index.php');
  }
  include 'includes/head.php';
  include 'includes/navigation.php';

  $fetch_users_sql="SELECT * FROM users ORDER BY full_name";
  $fetch_users_query=mysqli_query($db,$fetch_users_sql);


  // delete user
  if(isset($_GET['delete']))
  {
    $delete_id=sanitize($_GET['delete']);
    $delete_user_sql="DELETE FROM users WHERE id='$delete_id'";
    mysqli_query($db,$delete_user_sql);
    $_SESSION['success_flash']='User has been deleted !';
    header('location:users.php');
  }

  if(isset($_GET['add'])){
    $name=((isset($_POST['name']))?sanitize($_POST['name']):'');
    $email=((isset($_POST['email']))?sanitize($_POST['email']):'');
    $password=((isset($_POST['password']))?sanitize($_POST['password']):'');
    $confirm=((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
    $permissions=((isset($_POST['permissions']))?sanitize($_POST['permissions']):'');
    $errors=array();

    if($_POST)
    {
      $email=trim($email);
      $check_email_existence="SELECT * FROM users WHERE email = '$email'";
      $check_email_query=mysqli_query($db,$check_email_existence);
      $check=mysqli_fetch_assoc($check_email_query);
      $count_users=mysqli_num_rows($check_email_query);

      if($count_users){
        $errors[].='The Email Already exist';
      }

      if(strlen($password)<6){
        $errors[].='Password must be of 6 digits';
      }

      if($password!=$confirm){
        $errors[].='Password does not match with confirm password !';
      }


      if(!empty($errors)){
        echo display_errors($errors);
      }else {
        $hashed=password_hash($password,PASSWORD_DEFAULT);
        $insert_user_sql="INSERT INTO users (full_name,email,password,permissions) VALUES ('$name','$email','$hashed','$permissions')";
        $inser_user_query=mysqli_query($db,$insert_user_sql);
        $_SESSION['success_flash']='New User Inserted !';
        header('location:users.php');
      }
    }

    ?>
    <div class="container py-5">
      <h2 class="text-center py-4">Add New User</h2>

        <form action="users.php?add=1" method="post">
        <div class="form-row">
        <div class="col-md-4 mb-3">
        <label for="name">Full name</label>
        <input type="text" class="form-control is-valid"  name="name" id="name" placeholder="First name" value="<?=$name;?>" required>
        <div class="valid-feedback">
          Full name.
        </div>
        </div>

        <div class="col-md-4 mb-3">
        <label for="name">Email</label>
        <input type="email" class="form-control is-valid"  name="email" id="email" placeholder="Email" value="<?=$email;?>" required>
        <div class="valid-feedback">
          Enter your vaild email.
        </div>
        </div>

        <div class="col-md-4 mb-3">
        <label for="name">Password</label>
        <input type="password" class="form-control is-valid"  name="password" id="password" placeholder="Password" value="<?=$password;?>" required>
        <div class="valid-feedback">
          Password must be of more than 6 digits.
        </div>
        </div>
        </div>

        <div class="form-row">
        <div class="col-md-4 mb-3">
        <label for="confirm">Confirm Password</label>
        <input type="password" class="form-control is-valid"  name="confirm" id="confirm" placeholder="confirm Password" value="<?=$confirm;?>" required>
        <div class="valid-feedback">
          Confirm Password must be equal to Your above password.
        </div>
        </div>

        <div class="col-md-3 mb-3">
        <label for="Permissions">Permissions</label>
          <div class="form-group">
          <select name="permissions" class="custom-select" required>
          <option value=""<?=(($permissions == '')?' selected':'')?>></option>
          <option value="editor"<?=(($permissions == 'editor')?' selected':'')?>>Editor</option>
          <option value="admin,editor"<?=(($permissions == 'admin,editor')?' selected':'')?>>Admin,Editor</option>
          </select>
          <div class="invalid-feedback">Choose from dropdown</div>
          </div>
        </div>
        </div>

        <input class="btn btn-primary" type="submit" value="Add User">
        <a href="users.php" class="btn btn-danger">Cancel</a>
        </form>

    </div>
  <?php }else{ ?>
<div class="container py-4">
  <h4>Users</h4>
  <table class="table table-bordered table-hover">
  <thead class="thead-light">
    <tr>
      <th scope="col">Update</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Join date</th>
      <th scope="col">Last login</th>
      <th scope="col">Permissions</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th colspan="6" class="text-right"> <a href="users.php?add=1" class="btn btn-success">Add User <i class="fas fa-user-plus"></i></a></th>
    </tr>
    <?php while($users=mysqli_fetch_assoc($fetch_users_query)){ ?>
    <tr>
      <?php if($users['id']!=$user_data['id']){  ?>
      <th> <a href="users.php?delete=<?=$users['id'];?>" class="btn btn-danger">Remove User <i class="fas fa-user-times"></i></a></th>
      <?php }else{?>
        <td></td>
        <?php } ?>
      <td><?=$users['full_name'];?></td>
      <td><?=$users['email'];?></td>
      <td><?=pretty_date($users['join_date']);?></td>
      <td> <?=(($users['last_login'] =='0000-00-00 00:00:00')?'Never':pretty_date($users['last_login']))?></td>
      <td><?=$users['permissions'];?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
</div>
<?php }include 'includes/footer.php'; ?>
