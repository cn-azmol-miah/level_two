<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Codenation Vulnerable Shop | Level Two</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../images/favicon.ico" type="image/ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/shepherd.js@5.0.1/dist/js/shepherd.js"></script>
</head>

<body style="padding-bottom: 3rem;">
    <div class="tour"></div>
    <div class="container">
        <nav class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <a href="<?php echo ROOT_URL; ?>" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">

                <?php echo '<img src="../images/long_logo.png" alt="" style="height: 35px;"> '; ?>
                <h3 class="d-inline mt-2"> Level Two </h3>
            </a>

            <ul class="nav nav-pills">
                <?php if (isset($_SESSION['admin-logedIn']) && $_SESSION['admin-logedIn'] === true) : ?>
                    <li class="nav-item"><a href="<?php echo ROOT_URL; ?>admin/" class="nav-link">dashboard</a></li>
                    <li class="nav-item"><a href="<?php echo ROOT_URL; ?>admin/login.php" class="nav-link">Logout</a></li>
                <?php else : ?>
                    <li class="nav-item"><a href="index.php" class="nav-link">Login</a></li>
                <?php endif; ?>
                <li class="nav-item"><a href="../docs.php" class="btn btn-outline-primary"><i class="fas fa-file-alt"></i> Docs</a></li>
            </ul>
        </nav>