<?php
require('config/db.php');
require('config/config.php');
session_start();

if (!isset($_SESSION['customer'])) {
    header('Location:' . ROOT_URL . 'login.php?redirect=checkout.php');
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : null;
$count = count($cart);
$message = '';
$customer_id = $_SESSION['customerId'];
$query = "SELECT * FROM customers_data WHERE customer_id = $customer_id";
$result = mysqli_query($conn, $query);
$customer_row = mysqli_fetch_assoc($result);

if ($count == 0) {
    header('Location:' . ROOT_URL . 'products.php');
}

function insert_orders($cart, $conn, $customer_id)
{
    $total = 0;

    foreach ($cart as $key => $value) {
        $cart_query = "SELECT * FROM products WHERE id=$key";
        $result = mysqli_query($conn, $cart_query);
        $row = mysqli_fetch_assoc($result);
        $total +=  $row['price'] * $value['quantity'];
    }


    $insert_order = "INSERT INTO orders (customer_id, total_price, order_status) VALUES('$customer_id','$total', 'Order Placed')";
    $insert_order_result = mysqli_query($conn, $insert_order);

    if ($insert_order_result) {
        $order_id = mysqli_insert_id($conn);
        foreach ($cart as $key => $value) {
            $cart_query = "SELECT * FROM products WHERE id=$key";
            $result = mysqli_query($conn, $cart_query);
            $row = mysqli_fetch_assoc($result);
            $quantity = $value["quantity"];
            $price = $row["price"];
            $insert_order_items = "INSERT INTO orders_items (order_id, product_id, quantity, product_price) VALUES('$order_id','$key', '$quantity', '$price')";

            if (mysqli_query($conn, $insert_order_items)) {
                unset($_SESSION['cart']);
                header('Location:' . ROOT_URL . 'myaccount.php');
            }
        }
    }
}

if (isset($_POST['submit'])) {
    if (isset($_POST['agree'])) {
        header('Location:' . ROOT_URL . 'checkout.php');

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $address1 = $_POST['address1'];
        $address2 = $_POST['address2'];
        $country = $_POST['country'];
        $city = $_POST['city'];
        $postcode = $_POST['postcode'];
        //$cc_name = $_POST['cc_name'];
        //$cc_number = $_POST['cc_number'];
        //$cc_expiration = $_POST['cc_expiration'];
        //$cc_cvv = $_POST['cc_cvv'];


        if (mysqli_num_rows($result) == 1) {
            // Update query
            $update_query = "UPDATE customers_data SET first_name='$first_name', last_name='$last_name', address1='$address1', address2='$address2', city='$city', country='$country', postcode='$postcode' WHERE customer_id = $customer_id";
            $update_result = mysqli_query($conn, $update_query);

            if ($update_result) {
                insert_orders($cart, $conn, $customer_id);
            }
        } else {
            // Insert Query
            $insert_query = "INSERT INTO customers_data (customer_id, first_name, last_name, address1, address2, city, country, postcode) VALUES('$customer_id','$first_name','$last_name','$address1','$address2','$city','$country','$postcode')";
            $insert_result = mysqli_query($conn, $insert_query);

            if ($insert_result) {
                insert_orders($cart, $conn, $customer_id);
            }
        }
    } else {
        $message = 'Please, agree to terms and conditions before purchase!';
    }
}
?>
<?php include("inc/header.php"); ?>
<main>
    <div class="mb-3">
        <h1>Checkout form</h1>
        <p class="lead">Please, check all your details are correct before placing order.</p>
    </div>
    <a href="javascript:history.go(-1)" class="btn btn-outline-secondary mt-4 mb-3"><i class="fas fa-chevron-left"></i> Back</a>
    <?php if ($message != '') : ?>
        <div id="payment_success_alert" class="alert alert-danger d-flex justify-content-between" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" data-bs-target="#payment_success_alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-5">
        <div class="col-md-5 col-lg-4 order-md-last">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary">Your cart</span>
                <span class="badge bg-primary rounded-pill"><?php echo $count; ?></span>
            </h4>
            <ul class="list-group mb-3">
                <?php foreach ($cart as $key => $value) : ?>
                    <?php
                    $cart_query = "SELECT * FROM products WHERE id=$key";
                    $result = mysqli_query($conn, $cart_query);
                    $row = mysqli_fetch_assoc($result);

                    ?>
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0"><?php print_r($row['title']); ?></h6>
                            <small class="text-muted">Quantity: <?php print_r($value['quantity']) ?></small>
                        </div>
                        <span class="text-muted">£<?php print_r($row['price']) ?></span>
                    </li>
                <?php endforeach; ?>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (GBP)</span>
                    <strong>£<?php echo $total; ?></strong>
                </li>
            </ul>
        </div>
        <div class="col-md-7 col-lg-8">
            <h4 class="mb-3">Billing address</h4>
            <form id="checkout-form" method="POST" class="needs-validation" novalidate>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="first_name" class="form-label">First name</label>
                        <input type="text" name="first_name" class="form-control" id="first_name" placeholder="" value="<?php echo $customer_row['first_name']; ?>" required>
                        <div class="invalid-feedback">
                            Valid first name is required.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="last_name" class="form-label">Last name</label>
                        <input type="text" name="last_name" class="form-control" id="last_name" placeholder="" value="<?php echo $customer_row['last_name']; ?>" required>
                        <div class="invalid-feedback">
                            Valid last name is required.
                        </div>
                    </div>

                    <!-- <div class="col-12">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text">@</span>
                            <input type="text" name="username" class="form-control" id="username" placeholder="Username" required>
                            <div class="invalid-feedback">
                                Your username is required.
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="col-12">
                        <label for="email" class="form-label">Email <span class="text-muted">(Optional)</span></label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="you@example.com">
                        <div class="invalid-feedback">
                            Please enter a valid email address for shipping updates.
                        </div>
                    </div> -->

                    <div class="col-12">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address1" class="form-control" id="address1" value="<?php echo $customer_row['address1']; ?>" placeholder="1234 Main St" required>
                        <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="address2" class="form-label">Address 2 <span class="text-muted">(Optional)</span></label>
                        <input type="text" name="address2" class="form-control" id="address2" value="<?php echo $customer_row['address2']; ?>" placeholder="Apartment or suite">
                    </div>

                    <div class="col-md-5">
                        <label for="country" class="form-label">Country</label>
                        <select class="form-select" name="country" id="country" form="checkout-form" required>
                            <option value="">Choose...</option>
                            <option selected>United Kingdom</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a valid country.
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="state" class="form-label">City</label>
                        <select class="form-select" name="city" id="state" form="checkout-form" required>
                            <option value="">Choose...</option>
                            <option selected>Manchester</option>
                        </select>
                        <div class="invalid-feedback">
                            Please provide a city.
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="zip" class="form-label">Postcode</label>
                        <input type="text" name="postcode" class="form-control" id="zip" value="<?php echo $customer_row['postcode']; ?>" placeholder="" required>
                        <div class="invalid-feedback">
                            Postcode required.
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="form-check">
                    <input type="checkbox" name="same-address" class="form-check-input" id="same-address">
                    <label class="form-check-label" for="same-address">Shipping address is the same as my billing address</label>
                </div>

                <div class="form-check">
                    <input type="checkbox" name="save-info" class="form-check-input" id="save-info">
                    <label class="form-check-label" for="save-info">Save this information for next time</label>
                </div>

                <hr class="my-4">

                <h4 class="mb-3">Payment</h4>

                <div class="my-3">
                    <div class="form-check">
                        <input id="credit" type="radio" class="form-check-input" checked required>
                        <label class="form-check-label" for="credit">Credit card</label>
                    </div>
                    <div class="form-check">
                        <input id="debit" type="radio" class="form-check-input" required>
                        <label class="form-check-label" for="debit">Debit card</label>
                    </div>
                    <div class="form-check">
                        <input id="paypal" type="radio" class="form-check-input" required>
                        <label class="form-check-label" for="paypal">PayPal</label>
                    </div>
                </div>

                <!-- <div class="row gy-3">
                    <div class="col-md-6">
                        <label for="cc-name" class="form-label">Name on card</label>
                        <input type="text" class="form-control" name="cc_name" value="" id="cc-name" placeholder="" required>
                        <small class="text-muted">Full name as displayed on card</small>
                        <div class="invalid-feedback">
                            Name on card is required
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="cc-number" class="form-label">Credit card number</label>
                        <input type="text" class="form-control" name="cc_number" id="cc-number" value="" placeholder="" required>
                        <div class="invalid-feedback">
                            Credit card number is required
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="cc-expiration" class="form-label">Expiration</label>
                        <input type="text" class="form-control" name="cc_expiration" id="cc-expiration" value="" placeholder="" required>
                        <div class="invalid-feedback">
                            Expiration date required
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="cc-cvv" class="form-label">CVV</label>
                        <input type="text" class="form-control" name="cc_cvv" id="cc-cvv" value="" placeholder="" required>
                        <div class="invalid-feedback">
                            Security code required
                        </div>
                    </div>
                </div> -->

                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" name="agree" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        I've read and accepted the <a href="#">Terms</a> and <a href="#">Conditions</a>.
                    </label>
                </div>

                <hr class="my-4">

                <button class="w-100 btn btn-outline-success" name="submit" type="submit"><i class="fas fa-thumbs-up"></i> Pay Now</button>
            </form>
        </div>
    </div>
</main>
<?php include("inc/footer.php"); ?>