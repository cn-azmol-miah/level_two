<?php
require('config/db.php');
require('config/config.php');
session_start();

$customer_id = $_SESSION['customerId'];
$query = "SELECT * FROM orders WHERE customer_id = $customer_id";
$result = mysqli_query($conn, $query);
$order_row = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<!-- Header and Search Includes -->
<?php include("inc/header.php"); ?>

<?php if (isset($_SESSION['customer'])) : ?>
    <h4 class="text-reset mb-5">Welcome <span id="username" class="badge bg-success"><?php echo $_SESSION['customer']; ?></span></h4>
    <h1 class="text-center">Your Orders</h1>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#Id</th>
                <th scope="col">Date</th>
                <th scope="col">Status</th>
                <th scope="col">Total Cost</th>
                <th scope="col"></th>
            </tr>

        </thead>
        <tbody>
            <?php foreach ($order_row as $order) : ?>
                <tr>
                    <th scope="row"><?php echo $order['id']; ?></th>
                    <td><?php echo $order['created_at']; ?></td>
                    <td><?php echo $order['order_status']; ?></td>
                    <td>£<?php echo $order['total_price']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <div class="alert alert-danger my-5" role="alert">You are not logged in. Visit the <a href="login.php">login</a> page to sign in.</div>
<?php endif; ?>

<?php include("inc/footer.php"); ?>