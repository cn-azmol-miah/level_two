<?php
$conn = mysqli_connect('localhost', 'root', '', 'cvsa');

// Check connection
if (mysqli_connect_errno()) {
    // connection failed
    echo 'Failed to connect to MySQL' . mysqli_connect_errno();
}
