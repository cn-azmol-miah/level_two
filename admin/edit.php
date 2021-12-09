<?php
require('../config/config.php');
require('../config/db.php');
session_start();

// Check for submit

if (isset($_POST["submit"])) {

    $image = $_FILES['image'];
    $imagePath = '';
    if ($image) {
        $imagePath = 'images/' . $image['name'];
        //mkdir(dirname($imagePath));
        move_uploaded_file($image['tmp_name'], $imagePath);
    }

    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $cat_id = intval($_POST['cat_id']);
    $update_id = $_POST['update_id'];

    $query = "UPDATE products SET image='$imagePath', title='$title', description='$description', price='$price', cat_id='$cat_id' WHERE id = {$update_id}";

    // Dump query just incase SQL query injection is incorrect
    //var_dump($query);

    if (mysqli_query($conn, $query)) {
        header('Location:' . ROOT_URL . 'admin/index.php');
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}

// Products Query
$id = $_GET['id'];
$query = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);
mysqli_free_result($result);

// Categories Query
$cat_query = "SELECT * FROM categories";
$cat_result = mysqli_query($conn, $cat_query);
$categories = mysqli_fetch_all($cat_result, MYSQLI_ASSOC);

// Close connection
mysqli_close($conn);

?>

<?php include("../inc/admin-header.php"); ?>

<h1>Edit Product <?php echo $product['id']; ?></h1>
<p>Use this form to carry out your penetration tests.</p>
<a href="<?php echo ROOT_URL; ?>/admin/" class="btn btn-outline-secondary mt-5 mb-3"><i class="fas fa-chevron-left"></i> Back</a>
<div class="row mt-4">
    <div class="col-6">
        <div class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h4 class="my-0 fw-normal">SQL Query</h4>
            </div>
            <div class="card-body">
                <p class="card-title pricing-card-title"><code id="code"><?php echo isset($product) ? 'UPDATE products SET image="' . $product['id'] . '", title="' . $product['title'] . '", description="' . $product['description'] . '", price="' . $product['price'] . '" WHERE id = {' . $product['id'] . '}' : "UPDATE products SET image='$imagePath', title='$title', description='$description', price='$price' WHERE id = {$update_id}" ?></code></p>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h4 class="my-0 fw-normal">SQL Results</h4>
            </div>
            <div class="card-body">
                <p class="card-title pricing-card-title"><code><?php print_r($product); ?></code></p>
            </div>
        </div>
    </div>
</div>
<form id="product_form" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
    <div class="form-group mb-2">
        <label>Product Image</label>
        <input type="file" name="image" class="form-control" value="<?php echo $product['image']; ?>">
    </div>
    <div class="form-group mb-2">
        <label>Product Title</label>
        <input type="text" name="title" class="form-control" value="<?php echo $product['title']; ?>">
    </div>
    <div class="form-group mb-2">
        <label>Product Description</label>
        <textarea type="text" name="description" class="form-control"><?php echo $product['description']; ?></textarea>
    </div>
    <div class="form-group mb-2">
        <label>Product Price</label>
        <input type="number" name="price" step=".01" class="form-control" value="<?php echo $product['price']; ?>">
    </div>
    <div class="form-group mb-2">
        <label>Product Category</label>
        <select name="cat_id" class="form-select" aria-label="Default select example" form="product_form">
            <?php foreach ($categories as $category) : ?>
                <?php if ($category['cat_id'] == $product['cat_id']) : ?>
                    <option value="<?php echo $category['cat_id']; ?>" selected><?php echo $category['cat_name']; ?></option>
                <?php else : ?>
                    <option value="<?php echo $category['cat_id']; ?>"><?php echo $category['cat_name']; ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
    <input type="hidden" name="update_id" value="<?php echo $product['id']; ?>">
    <button type="submit" name="submit" class="btn btn-outline-success mt-2"><i class="fas fa-thumbs-up"></i> Submit</button>
</form>

<?php include("../inc/footer.php"); ?>