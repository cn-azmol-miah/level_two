<?php

require('../config/config.php');
require('../config/db.php');


$delete_id = $_POST['delete_id'];

if (isset($_POST["delete"])) {


    $query = "DELETE FROM products WHERE id = {$delete_id}";

    // Dump query just incase SQL query injection is incorrect
    var_dump($query);

    if (mysqli_multi_query($conn, $query)) {
        header('Location:' . ROOT_URL . 'admin/');
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}
