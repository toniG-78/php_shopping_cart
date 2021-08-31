<?php

include('app/init.php');
$Template->set_data("page_class", "home"); //body css class

/*
  SHOW PRODUCTS FROM SPECIFIC CATEGORY
*/

if(isset($_GET["id"]) && is_numeric($_GET["id"])){

  // confirm category id is valid
  $category = $Categories->get_categories($_GET["id"]);

  if(!empty($category)) {
    // create categories nav menu
    $category_nav = $Categories->create_category_nav($category["name"]);
    $Template->set_data("page_nav", $category_nav);

    // create products from that category id
    $cat_products_items = $Products->create_product_items(4, $_GET["id"]);
    
    if(!empty($cat_products_items)){
      // pass data to the view
      $Template->set_data("product_items", $cat_products_items);
    
    } else {
      $Template->set_data("product_items", "<li><strong>No products founded!!!</strong></li>");
    } 
     
    // SHOW HOME VIEW ***
    $Template->load("app/views/v_public_home.php", $category["name"]);  

  } else {
    $Template->redirect(SITE_PATH);
  }

/*
  SHOW ALL PRODUCTS
*/

} else {

  // create categories nav menu
  $category_nav = $Categories->create_category_nav("Home");
  $Template->set_data("page_nav", $category_nav);

  // create all products
  $products_items = $Products->create_product_items();
  
  // pass data to the view
  $Template->set_data("product_items", $products_items);

  // SHOW HOME VIEW ***
  $Template->load("app/views/v_public_home.php", "Welcome to Shopping Cart");  
}



/* echo "<pre>" ;
var_dump($products_items);
echo "</pre>" ;  
*/