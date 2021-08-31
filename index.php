<?php

include('app/init.php');

// create categories nav menu
$category_nav = $Categories->create_category_nav("Home");
$Template->set_data("page_nav", $category_nav);

// Create product items grid 
$products_items = $Products->create_product_items();
$Template->set_data("product_items", $products_items);

// show home view
$Template->load("app/views/v_public_home.php", "Shopping Cart");  

/* echo "<pre>" ;
var_dump($Products->get());
echo "</pre>" ;  */