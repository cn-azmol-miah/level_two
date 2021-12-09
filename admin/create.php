<?php
require('../config/config.php');
require('../config/db.php');
session_start();

// Check for submit

if (isset($_POST["submit"])) {

    $image = $_FILES['image'];
    if ($image) {
        $imagePath = "images/" . $image['name'];
        //mkdir(dirname($imagePath));
        move_uploaded_file($image['tmp_name'], $imagePath);
    }

    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $cat_id = intval($_POST['cat_id']);


    $query = "INSERT INTO products(title, image, price, cat_id, description) VALUES('$title', '$imagePath', '$price', '$cat_id', '$description')";

    if (mysqli_multi_query($conn, $query)) {
        $sql_query = $query;
        header('Location:' . ROOT_URL . 'admin/create.php');
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}

// Create Products Query for the SQL Results Boxes
$query = "SELECT * FROM products ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $query);
$products = mysqli_fetch_assoc($result);

// Categories Query
$cat_query = "SELECT * FROM categories";
$cat_result = mysqli_query($conn, $cat_query);
$categories = mysqli_fetch_all($cat_result, MYSQLI_ASSOC);
?>

<!-- Admin Header -->
<?php include("../inc/admin-header.php"); ?>

<!-- page title -->
<h1>Create New Product</h1>
<p>Use this form to add new products.</p>

<!-- Back button -->
<a href="<?php echo ROOT_URL; ?>admin/" class="btn btn-outline-secondary my-4"><i class="fas fa-chevron-left"></i> Back</a>

<div class="row mt-4">
    <div class="col-6">
        <div class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h4 class="my-0 fw-normal">SQL Query</h4>
            </div>
            <div class="card-body">

                <p class="card-title pricing-card-title"><code id="code"><?php echo isset($products) ? 'INSERT INTO products(title, image, price, cat_id, description) VALUES("' . $products["title"] . '", "' . $products["image"] . '", "' . $products["price"] . '", "' . $products["cat_id"] . '", "' . $products["description"] . '")"' : "INSERT INTO products(title, image, price, cat_id, description) VALUES('title_variable', 'image_path_variable', 'price_variable', 'cat_id_variable','description_variable')"; ?></code></p>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h4 class="my-0 fw-normal">SQL Results</h4>
            </div>
            <div class="card-body">
                <p class="card-title pricing-card-title"><code><?php echo isset($products) ? var_dump($products) : mysqli_error($conn); ?></code></p>
            </div>
        </div>
    </div>
</div>

<!-- Create Product Form -->
<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>?title=title" enctype="multipart/form-data">
    <div class="form-group mb-2">
        <label>Product Image</label>
        <input id="image" type="file" name="image" class="form-control">
    </div>
    <div class="form-group mb-2">
        <label>Product Title</label>
        <input id="title" type="text" name="title" class="form-control">
    </div>
    <div class="form-group mb-2">
        <label>Product Description</label>
        <textarea id="description" type="text" name="description" class="form-control"></textarea>
    </div>
    <div class="form-group mb-2">
        <label>Product Price</label>
        <input id="price" type="number" name="price" step=".01" class="form-control">
    </div>
    <div class="form-group mb-2">
        <label>Product Category</label>
        <select id="cat_id" name="cat_id" class="form-select" aria-label="Default select example" form="product_form">
            <option selected>Choose Category</option>
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['cat_id']; ?>"><?php echo $category['cat_name']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button id="product_form_submit" type="submit" name="submit" class="btn btn-outline-success mt-4"><i class="fas fa-thumbs-up"></i> Submit</button>
</form>


<!-- Footer -->
<?php include("../inc/footer.php"); ?>