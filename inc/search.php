<?php

$search_findings = [];

$search_results_message = '';

$all_products_page = '';

$sql_query = '';

if (isset($_POST["submit"])) {
    $searchq = $_POST['search'];

    $search_query = "SELECT * FROM products WHERE title LIKE '%$searchq%' OR description LIKE '%$searchq%'";

    $search_result = mysqli_query($conn, $search_query);

    $count = mysqli_num_rows($search_result);

    if ($count == 0) {
        $search_results_message = '<h3 class="mt-4">No results found for "' . $searchq . '"</h3><p>Try your search again or to go back to all products click <a href="' . $all_products_page . '">here</a>.</p>';
    } else {
        $search_results_message = '<h3 class="mt-4">Results for "' . $searchq . '"</h3><p>To go back to all products click <a href="' . $all_products_page . '">here</a>.</p>';
        $search_findings = mysqli_fetch_all($search_result, MYSQLI_ASSOC);
    }

    $sql_query = $search_query;

    // Free Result
    mysqli_free_result($search_result);
}
