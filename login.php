<?php
require('config/config.php');
require('config/db.php');

session_start();

$message = '';

if (isset($_POST["login_submit"])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM customers WHERE username='$username' AND password='$password' LIMIT 1";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['customer'] = $username;
        $row = mysqli_fetch_assoc($result);
        $_SESSION['customerId'] = $row['id'];

        if (isset($_GET['redirect']) && $_GET['redirect'] == 'docs.php') {
            // Login redirect to the documentation
            header('Location:' . ROOT_URL . "docs.php");
        } elseif (isset($_GET['redirect']) && $_GET['redirect'] == 'checkout.php') {
            // Login redirect to the checkout
            header('Location:' . ROOT_URL . "checkout.php");
        } else {
            header('Location:' . ROOT_URL . "myaccount.php");
        }
    } else {
        $message = 'The username or password is incorrect!';
    }
}
?>

<!-- Header -->
<?php include("inc/header.php"); ?>

<!-- Login Form -->
<div class="row">
    <div class="col-md-6 col-sm-8 mx-auto mb-5 mt-4">
        <?php if (isset($_SESSION['customer'])) : ?>
            <p class="text-center mb-3">User <span class="badge bg-success"><?php echo $_SESSION['customer']; ?> </span> currently logged in!</p>

            <a href="logout.php" class="w-100 btn btn-lg btn-outline-danger" name="logout_submit" type="submit"><i class="fas fa-sign-out-alt"></i> Logout</a>
        <?php else : ?>
            <h1>Customer Login</h1>
            <?php if ($message != '') : ?>
                <div id="my-alert" class="alert alert-danger d-flex justify-content-between" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" data-bs-target="#my-alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-floating mb-3">
                    <input type="text" name="username" class="form-control" id="floatingInput">
                    <label for="floatingInput">Username</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control" id="floatingPassword">
                    <label for="floatingPassword">Password</label>
                </div>


                <button class="w-100 btn btn-lg btn-outline-success mb-3" name="login_submit" type="submit"><i class="fas fa-sign-in-alt"></i> Login</button>
                <p>Don't have account? Register <a href="register.php">here</a>.</p>
            </form>
        <?php endif; ?>
    </div>
</div>

<!-- Footer -->
<?php include("inc/footer.php"); ?>