<?php
require('config/db.php');
require('config/config.php');

session_start();
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : null;
$count = count($cart);
$total = 0;
?>
<?php include("inc/header.php"); ?>
<h1>Cart</h1>
<a href="javascript:history.go(-1)" class="btn btn-outline-secondary mt-4 mb-3">Back</a>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#id</th>
            <th scope="col">Image</th>
            <th scope="col">Product</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
            <th scope="col">Total</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($count != 0) :  ?>
            <?php foreach ($cart as $key => $value) : ?>
                <?php
                $cart_query = "SELECT * FROM products WHERE id=$key";
                $result = mysqli_query($conn, $cart_query);
                $row = mysqli_fetch_assoc($result);
                ?>
                <tr>
                    <th scope="row"><?php echo $key ?></th>
                    <td><img src="<?php print_r($row['image']) ?>" alt="" style="width:50px;height:55px;"></td>
                    <td><a href="product.php?id=<?php print_r($row['id']); ?>"><?php print_r($row['title']) ?></a></td>
                    <td>£<?php print_r($row['price']); ?></td>
                    <td><?php echo $value['quantity']; ?></td>
                    <td>£<?php print_r($row['price'] * $value['quantity']); ?></td>
                    <td><a href="<?php echo ROOT_URL ?>deletefromcart.php?id=<?php echo $key; ?>" class="btn btn-outline-danger">Remove</a></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<div class="card">
    <div class="card-header">
        <strong>Total Amount</strong>
    </div>
    <div class="card-body">
        <h3 class="card-title">£<?php echo $total; ?></h3>
        <p class="card-text">Please double check your cart and the total amount before checking out.</p>
        <?php if ($count != 0) :  ?>
            <a href="checkout.php" class="btn btn-outline-primary">Checkout</a>
        <?php else : ?>
            <h5>Your cart is empty!</h5>
        <?php endif; ?>
    </div>
</div>
<?php include("inc/footer.php"); ?>