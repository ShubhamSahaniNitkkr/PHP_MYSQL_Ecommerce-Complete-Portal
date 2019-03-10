<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php"> मेरी local दुकान <i class="fas fa-cogs"></i> </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      &nbsp;
      &nbsp;

      <a class="nav-item nav-link active" href="../index.php"><i class="fas fa-home"></i> HomePage <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="shops.php"><i class="fas fa-archway"></i> Shops</a>
      <a class="nav-item nav-link" href="categories.php"><i class="fas fa-align-justify"></i> Category</a>
      <a class="nav-item nav-link" href="products.php"><i class="fas fa-cubes"></i> Products</a>
      <a class="nav-item nav-link" href="archive.php"><i class="fas fa-trash-alt"></i> Archive</a>
      <?php if(has_permission('admin')){ ?>
        <a class="nav-item nav-link" href="users.php"><i class="fas fa-users"></i>  Users</a>
      <?php } ?>
    </div>

    <div class="nav-item dropdown btn-info ml-auto">
      <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-user"></i> <?= $user_data['first']; ?> <span class="caret"></span>
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item text-break" href="change_password.php"> <i class="fas fa-key"></i> Change Password</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Log out</a>
      </div>
    </div>
  </div>
</nav>
