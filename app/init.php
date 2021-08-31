<?php

/*
	Configuration settings
*/

// connect to db
$server = 'localhost';
$user = 'root';
$password = 'root';
$db = 'php_shoppingcart';
$Database = new mysqli($server, $user, $password, $db);

// error reporting
mysqli_report(MYSQLI_REPORT_ERROR);
ini_set('display_errors', 1);

// constants
define('SITE_NAME', 'Shopping Cart');
define('SITE_PATH', 'http://localhost/shoppingcart/');
define('IMAGES_PATH', 'http://localhost/shoppingcart/resources/images/');

// include objects
include('app/models/m_template.php');
include('app/models/m_categories.php');
include('app/models/m_products.php');
include('app/models/m_cart.php');

// create objects
$Template = new Template();
$Categories = new Categories();
$Products = new Products();
$Cart = new Cart();


session_start();