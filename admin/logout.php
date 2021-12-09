<?php
require('../config/config.php');
session_start();
unset($_SESSION["admin"]);
unset($_SESSION["admin-logedIn"]);
header('Location:' . ROOT_URL . 'admin/login.php');
