<?php
  require_once '../core/init.php';
  if(!is_logged_in()){
    login_error_redirect();
  }
  include 'includes/head.php';
  include 'includes/navigation.php';
?>
<div class="container">
  <h1>Admin Panel</h1>
</div>
<?php include 'includes/footer.php';
?>