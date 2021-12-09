<?php
require('../config/config.php');
require('../config/db.php');

session_start();

$message = '';

if (isset($_POST["login_submit"])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password' LIMIT 1";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin'] = $username;
        $_SESSION['admin-logedIn'] = true;
        header('Location:' . ROOT_URL . 'admin/');
    } else {
        $message = 'The username or password is incorrect!';
    }
}
?>

<!-- Header -->
<?php include("../inc/admin-header.php"); ?>


<div class="row">
    <div class="col-md-6 col-sm-8 mx-auto mb-5 mt-4">
        <?php if (isset($_SESSION['admin-logedIn']) && $_SESSION['admin-logedIn'] === true) : ?>
            <h1 class="text-center mb-3">Currently logged in as <?php echo $_SESSION['admin']; ?>!</h1>

            <a href="logout.php" class="w-100 btn btn-lg btn-outline-danger" name="logout_submit" type="submit"><i class="fas fa-sign-out-alt"></i> Logout</a>

        <?php else : ?>
            <h1>Admin Login</h1>
            <?php if ($message != '') : ?>
                <div id="my-alert" class="alert alert-danger d-flex justify-content-between" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" data-bs-target="#my-alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <form id="admin_login_form" method="POST">
                <div class="form-floating my-3">
                    <input type="text" name="username" class="form-control" id="username" required>
                    <label for="username">Username</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control" id="password" required>
                    <label for="password">Password</label>
                </div>


                <button id="login_submit" class="w-100 btn btn-lg btn-outline-success mb-3" name="login_submit" type="submit"><i class="fas fa-sign-in-alt"></i> Login</button>
                <small>This is for admin access only! Go back to the <a href="index.php">Homepage</a> if you are not admin.</small>
            </form>
        <?php endif; ?>
    </div>
</div>

<!-- Footer -->
<?php include("../inc/footer.php"); ?>