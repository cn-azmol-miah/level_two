<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Codenation Vulnerable Shop | Level Two</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="images/favicon.ico" type="image/ico">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://unpkg.com/tooltip-sequence@latest/dist/index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body style="padding-bottom: 3rem;">
  <div class="tour"></div>
  <div class="container">
    <nav class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="<?php echo ROOT_URL; ?>" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">

        <?php echo '<img src="images/long_logo.png" alt="" style="height: 35px;"> '; ?>
        <h3 class="d-inline mt-2"> Level Two </h3>
      </a>

      <ul class="nav nav-pills">
        <li class="nav-item"><a href="<?php echo ROOT_URL; ?>" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="products.php" class="nav-link">Products</a></li>
        <?php if (isset($_SESSION['customer'])) : ?>

          <li class="nav-item"><a href="myaccount.php" class="nav-link">myaccount</a></li>
          <li class="nav-item"><a href="login.php" class="nav-link">Logout</a></li>
          <!-- <li class="nav-item"><a href="docs.php" class="btn btn-outline-primary"><i class="fas fa-file-alt"></i> Docs</a></li> -->

        <?php else : ?>

          <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
          <!-- <li class="nav-item"><a href="docs.php" class="btn btn-outline-primary"><i class="fas fa-file-alt"></i> Docs</a></li> -->
        <?php endif; ?>
        <li class="nav-item dropdown">
          <button class="btn btn-outline-primary" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php
            $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : null;
            $count = count($cart);
            $total = 0;
            ?>
            <i class="fas fa-shopping-cart"></i> <span class="badge rounded-pill bg-danger"><?php echo $count; ?></span>
          </button>
          <div class="dropdown-menu p-3" aria-labelledby="navbarDropdown" style="min-width: 20rem;">
            <?php if ($count != 0) : ?>
              <?php foreach ($cart as $key => $value) : ?>
                <?php
                $cart_query = "SELECT * FROM products WHERE id=$key";
                $result = mysqli_query($conn, $cart_query);
                $row = mysqli_fetch_assoc($result);
                $total +=  $row['price'] * $value['quantity'];
                ?>
                <div class="row">
                  <div class="col-3">
                    <img class="mx-auto" src="<?php print_r($row['image']) ?>" alt="" style="width:50px;height:55px;">
                  </div>
                  <div class="col-9">
                    <span><a href="product.php?id=<?php print_r($row['id']); ?>"><?php print_r($row['title']) ?></a></span><br>
                    <small class="text-info">£<?php print_r($row['price']); ?> </small><span> <small>Quantity:<?php echo $value['quantity']; ?></small></span>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else : ?>
              <h5>The cart is empty!</h5>
            <?php endif; ?>
            <hr>
            <div class="d-flex justify-content-between align-items-center">
              <div><i class="fas fa-shopping-cart"></i> <span class="badge rounded-pill bg-danger"><?php echo $count; ?></span></div>
              <strong>Total: £<?php echo $total; ?></strong>
            </div>
            <hr>
            <a href="cart.php" class="btn btn-outline-primary w-100">Cart</a>
          </div>
        </li>
      </ul>
    </nav>