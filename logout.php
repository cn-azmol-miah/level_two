<?php
require('config/config.php');
session_start();
unset($_SESSION['customer']);
unset($_SESSION['cart']);
header('Location:' . ROOT_URL . 'login.php');
