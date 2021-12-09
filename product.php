<?php
require('config/db.php');
require('config/config.php');
session_start();

// Get id secure it with mysqli_real_escape_string($conn, $_GET['id']);
$id = $_GET['id'];

// Create query
$query = "SELECT * FROM products WHERE id = $id";

// Get result
$result = mysqli_query($conn, $query);

// Fetch data
$product = mysqli_fetch_array($result);

// // Free Result
mysqli_free_result($result);

?>

<!-- Header -->
<?php include("inc/header.php"); ?>

<!-- Back Button -->
<a href="javascript:history.go(-1)" class="btn btn-outline-secondary mb-3"><i class="fas fa-chevron-left"></i> Back</a>

<!-- Product Image and Information -->
<div class="row">
    <div class="col-6 px-auto">
        <img src="<?php print_r($product['image']); ?>" alt="" style="max-height: 500px;" class="mx-auto d-block">
    </div>
    <div class="col-6 py-5">
        <h1 id="title"><?php print_r($product['title']); ?></h1>
        <p class="my-2"><?php print($product['description']); ?></p>
        <div>
            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
        </div>
        <h3 class="mt-2 mb-5">£<?php print_r($product['price']); ?></h3>
        <form action="addtocart.php" method="GET">
            <div class="form-floating mb-3">
                <input type="hidden" name="id" value="<?php print_r($product['id']); ?>">
                <input type="number" name="quantity" class="form-control w-25" value="1" id="quantity">
                <label for="quantity">Quantity</label>
            </div>
            <button type="submit" class="btn btn-outline-primary btn-lg"><i class="fas fa-cart-plus"></i> Add To Cart</button>
        </form>
    </div>
</div>

<!-- Footer -->
<?php include("inc/footer.php"); ?>