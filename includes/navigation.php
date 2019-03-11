<?php

$psql="SELECT * FROM categories WHERE parent = 0";
$pquery=mysqli_query($db,$psql);

 ?>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="index.php">मेरी local दुकान</a>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <?php while($parent= mysqli_fetch_assoc($pquery)){ ?>
        <?php
        $parent_id = $parent['id'];

        $csql="SELECT * FROM categories WHERE parent = '$parent_id'";
        $cquery=mysqli_query($db,$csql);

        ?>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?= $parent['category']; ?>  </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php while($child= mysqli_fetch_assoc($cquery)){ ?>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="category.php?cat=<?=$child['id'];?>"><?= $child['category']; ?></a>
          <?php } ?>
        </div>
      </li>
      <?php } ?>
      <li class="nav-item">
        <a class="nav-link" href="admin/index.php"><i class="fas fa-cogs"></i> Admin</a>
      </li>
    </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Find Products ..." aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
      <button class="btn btn-outline-info mx-2 my-sm-0" data-toggle="modal" data-target="#login_sign_up"> <i class="fas fa-user"></i> </button>
      <div class="nav-item">
        <a class="nav-link btn btn-warning" href="cart.php"><i class="fas fa-shopping-bag"></i> Bag </a>
      </div>
  </div>
</nav>
