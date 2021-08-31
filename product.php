<?php

/*
  PRODUCT DETAIL PAGE
*/

include('app/init.php');
$Template->set_data("page_class", "product"); //body css class

if(isset($_GET["id"]) && is_numeric($_GET["id"])) {
  
  // Confirm product id is valid
  $product = $Products->get($_GET["id"]);

  if(!empty($product)) {

    // create categories nav menu
    $category_nav = $Categories->create_category_nav($product["category"]);
    $Template->set_data("page_nav", $category_nav);

    // pass product data to the view
    $Template->set_data("product_id", $product["id"]);
    $Template->set_data("product_name", $product["name"]);
    $Template->set_data("product_desc", $product["description"]);
    $Template->set_data("product_price", $product["price"] . " €");
    $Template->set_data("product_image", IMAGES_PATH . $product["image"]);
    $Template->set_data("product_cat", $product["category"]);

    // SHOW PRODUCT VIEW ***
    $Template->load("app/views/v_public_product.php", $product["name"] . " - " . $product["category"]); 

  } else {
    // TODO: show some message or create a modal...
    $Template->redirect(SITE_PATH);
  }

} else {
  // id is not valid or error 
  // TODO: show some message or create a modal...
  $Template->redirect(SITE_PATH);
}


/*       
echo "<pre>" ;
var_dump($product);
echo "</pre>" ;  
*/