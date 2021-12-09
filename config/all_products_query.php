<?php

// Check for set page
isset($_GET['page']) ? $page = $_GET['page'] : $page = 0;
// Check for page one 
$page > 1 ? $start = ($page * $rpp) - $rpp : $start = 0;
// Query db for Total records
$result_set = mysqli_query($conn, 'SELECT id FROM products');
// Get total records
$num_rows = mysqli_num_rows($result_set);
// Get total number of pages
$total_pages = $num_rows / $rpp;

// Create query
$query = "SELECT * FROM products ORDER BY created_at DESC LIMIT $start, $rpp";
// Get result
$result = mysqli_query($conn, $query);
// Fetch data
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

$cat_filtered_products = [];
// Get products based on filter
if (isset($_GET['cat_id'])) {
    $cat_id = intval($_GET['cat_id']);
    $cat_filter_query = "SELECT * FROM products WHERE cat_id=$cat_id";
    $cat_filter_result = mysqli_query($conn, $cat_filter_query);

    $cat_filtered_products = mysqli_fetch_all($cat_filter_result, MYSQLI_ASSOC);
}

// Free Result
mysqli_free_result($result);
