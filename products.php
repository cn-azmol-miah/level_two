<?php
require('config/db.php');
require('config/config.php');
session_start();
// Pagination
$rpp = 6;
// Query
require('config/all_products_query.php');

// Define products page
$all_products_page = 'products.php';

// Categories Query
$cat_query = "SELECT * FROM categories";
$cat_result = mysqli_query($conn, $cat_query);
$categories = mysqli_fetch_all($cat_result, MYSQLI_ASSOC);

// If product table drops
$product_table_query = "SELECT * FROM products";
$product_table_result = mysqli_query($conn, $product_table_query);
?>

<!-- Header and Search Includes -->
<?php include("inc/header.php"); ?>
<?php include("inc/search.php"); ?>

<!-- Flag Six -->
<?php if (empty($product_table_result)) : ?>
    <div id="flag_alert" class="alert alert-success d-flex justify-content-between animate__animated animate__fadeInUp" role="alert">
        <i class="far fa-flag fa-2x"></i>
        <div id="flagAlert"><?php echo $flag_six['flag_name']; ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" data-bs-target="#flag_alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Search Box -->
<div class="position-relative overflow-hidden p-5 bg-light my-4">
    <h1>Search Products</h1>
    <p>Search for all of the mobile phones we have in stock now.</p>
    <form action="<?php $_SERVER['PHP_SELF'];  ?>" autocomplete="off" class="form-horizontal wow animate__animated animate__fadeInLeft" method="post" accept-charset="utf-8">
        <div class="input-group">
            <input name="search" class="form-control" type="text" placeholder="Search here">

            <button class="input-group-text" name="submit" type="submit" id="addressSearch"><i class="fas fa-search"></i></button>
        </div>

    </form>
    <div class="row mt-4">
        <div class="col-md-6 col-sm-4 ">
            <div class="card mb-4 rounded-3 shadow-sm">
                <div class="card-header py-3">
                    <h4 class="my-0 fw-normal">SQL Query</h4>
                </div>
                <div class="card-body">
                    <p class="card-title pricing-card-title"><code><?php echo $sql_query == '' ? "SELECT * FROM products WHERE title LIKE '%search_query_variable%' OR description LIKE '%search_query_variable%'" : $sql_query; ?></code></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-4">
            <div class="card mb-4 rounded-3 shadow-sm">
                <div class="card-header py-3">
                    <h4 class="my-0 fw-normal">SQL Results</h4>
                </div>
                <div class="card-body">
                    <p class="card-title pricing-card-title"><code><?php $search_findings == [] ? '' : var_dump($search_findings); ?></code></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $search_results_message; ?>

<!-- All products or search -->
<div class="row">
    <?php if ($search_findings == [] && $search_results_message == '') : ?>
        <div class="d-flex justify-content-between align-items-center mt-5">
            <h3>All Products</h3>
            <form id="filter_category" method="GET" action="<?php $_SERVER['PHP_SELF']; ?>">
                <select onchange="filterCategory()" name="cat_id" class="form-select" form="filter_category">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $category) : ?>
                        <?php if ($category['cat_id'] == $_GET['cat_id']) : ?>
                            <option value="<?php echo $category['cat_id']; ?>" selected><?php echo $category['cat_name']; ?></option>
                        <?php else : ?>
                            <option value="<?php echo $category['cat_id']; ?>"><?php echo $category['cat_name']; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
        <?php if ($cat_filtered_products != []) : ?>
            <?php foreach ($cat_filtered_products as $filtered_product) : ?>
                <div class="col-md-4 col-sm-1 mb-4 mt-4 wow animate__animated animate__fadeIn">
                    <div class="card">
                        <div class="card-body position-relative">
                            <img src="<?php print_r($filtered_product['image']); ?>" class="card-img-top " style="max-height: 400px; min-height: 400px;" alt="...">
                            <span class="position-absolute top-10 start-70 translate-middle badge bg-warning">
                                -99%
                            </span>
                            <h3 class="card-title mt-2"><?php print_r($filtered_product['title']); ?></h3>
                            <p class="card-text">£<?php print_r($filtered_product['price']); ?></p>
                            <a class="btn btn-outline-primary" href="product.php?id=<?php print_r($filtered_product['id']); ?>"><i class="fas fa-eye"></i> Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <?php foreach ($products as $product) : ?>
                <div class="col-md-4 col-sm-1 mb-4 mt-4 wow animate__animated animate__fadeIn">
                    <div class="card">
                        <div class="card-body position-relative">
                            <img src="<?php print_r($product['image']); ?>" class="card-img-top " style="max-height: 400px; min-height: 400px;" alt="...">
                            <span class="position-absolute top-10 start-70 translate-middle badge bg-warning">
                                -99%
                            </span>
                            <h3 class="card-title mt-2"><?php print_r($product['title']); ?></h3>
                            <p class="card-text">£<?php print_r($product['price']); ?></p>
                            <a class="btn btn-outline-primary" href="product.php?id=<?php print_r($product['id']); ?>"><i class="fas fa-eye"></i> Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php for ($x = 1; $x < $total_pages + 1; $x++) : ?>
                        <li class="page-item"><?php echo "<a class='page-link' href='?page=$x'>$x</a>"; ?></li>
                    <?php endfor; ?>
                </ul>
            </nav>

        <?php endif; ?>
    <?php else : ?>
        <?php foreach ($search_findings as $finding) : ?>
            <div class="col-md-4 col-sm-1 mb-4">
                <div class="card">
                    <div class="card-body position-relative">
                        <img src="<?php print_r($finding['image']); ?>" class="card-img-top" style="max-height: 400px; min-height: 400px;" alt="...">
                        <span class="position-absolute top-10 start-70 translate-middle badge bg-warning">
                            -99%
                        </span>
                        <h3 class="card-title mt-2"><?php print_r($finding['title']); ?></h3>
                        <p class="card-text">£<?php print_r($finding['price']); ?></p>
                        <a class="btn btn-outline-primary" href="product.php?id=<?php print_r($finding['id']); ?>"><i class="fas fa-eye"></i> View Details</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Footer -->
<?php include("inc/footer.php"); ?>