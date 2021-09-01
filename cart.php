<?php

include('app/init.php');
$Template->set_data("page_class", "shoppingcart"); //body css class

/*
  SHOW PRODUCTS IN THE CART
*/

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {

  // check if id is not valid
  if(! $Products->product_exist($_GET["id"])) {
    $Template->set_alert("Invalid item product!!");
    $Template->redirect(SITE_PATH . "cart.php");
  }

  // add products to cart
  if (isset($_GET["num"]) && is_numeric($_GET["num"])) {
    $Cart->add($_GET["id"], $_GET["num"]);
    $Template->set_alert("You have products in the cart!!!");
  } else {
    $Cart->add($_GET["id"]);
    $Template->set_alert("You have a product in the cart!!!");
  }

   $Template->redirect(SITE_PATH . "cart.php");
}

// empty the car
if (isset($_GET["empty"])) {
  $Cart->empty_car();
  
  // Show the total products and cost in Cart on top of the page
  $Template->set_data("total_products", $Cart->get_total_items());
  $Template->set_data("total_cost", $Cart->get_total_cost());

  $Template->set_alert("Cart is empty");
  $Template->redirect(SITE_PATH . "cart.php");
}

/*
  Form submitted when button Update Cart is clicked
  update -> name attr of submit input
*/
if (isset($_POST["update"])) {
  // get all products ids in cart
  $ids = $Cart->get_ids();

  if ($ids != NULL) {

    foreach ($ids as $id){
      // check input quantity and pass product id and quantity 
      if (is_numeric($_POST["product" . $id])) {
        $Cart->update($id, $_POST["product" . $id]);
      }
    }

    // Show the total products and cost in Cart on top of the page
    $Template->set_data("total_products", $Cart->get_total_items());
    $Template->set_data("total_cost", $Cart->get_total_cost());

    // add alert 
    $Template->set_alert("Quantity of products updated!!!");
  
  } else {
    // add alert 
    $Template->set_alert("No products for update!!!");
  }  
}

// show products in cart
$cart_items = $Cart->create_cart_items();
$Template->set_data('cart_items', $cart_items);

// create categories nav menu
$category_nav = $Categories->create_category_nav("");
$Template->set_data("page_nav", $category_nav);

// SHOW CART VIEW ***
$Template->load("app/views/v_public_cart.php", "Shopping Cart"); 


/*     
echo "<pre>";
var_dump($cart_items);
echo "</pre>";  
*/