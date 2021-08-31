<?php

/*
	Cart Class
	Handle all tasks related to showing or modifying the number of items in cart
	
	The cart keeps track of user selected items using a session variable, $_SESSION['cart']. 
	The session variable holds an array that contains the ids and the number selected of 
	the products in the cart.
	
	$_SESSION['cart']['product_id'] = num of specific item in cart
*/

class Cart {

  function __construct(){}

  /*
      Setting / Getting products 
  */

  /**
   * Add products to the Cart (use $_SESSION[])
   *
   * @param integer $id
   * @param integer $num
   * @return void
   */
  public function add($id, $num = 1) {

    $cart = array();

    // retrieve cart products from the SESSION
    if(isset($_SESSION["cart"])) $cart = $_SESSION["cart"];
    
    // if the product is in $cart
    if(isset($cart[$id])) $cart[$id] = $cart[$id] + $num; // ++add same product
    else $cart[$id] = $num;

    $_SESSION["cart"] = $cart;
  }

  /**
   * Empty products in Cart
   *
   * @access public
   * @return void
   */
  public function empty_car() {
    unset($_SESSION["cart"]);
  }

  /**
   * Update the quantity for each product in Cart
   *
   * @access public
   * @param integer $id
   * @param integer $num
   * @return void
   */
  public function update($id, $num) {
    if($num === 0) unset($_SESSION["cart"][$id]);
    else $_SESSION["cart"][$id] = $num;
  }


  /**
   * Return products info according to the information saved in cart
   *
   * @access public
   * @return array, NULL
   */
  public function get(){

    // get the products ids in Cart
    if(isset($_SESSION["cart"])){
      $ids = $this->get_ids();
      // get the info of each product according with the ids 
      global $Products;
      return $Products->get($ids);
    }
    return NULL;
  }

  /**
   * return an array of all products ids in Cart
   * 
   * @access public 
   * @return array, NULL
   */
  public function get_ids() {
    if(isset($_SESSION["cart"])){
      return array_keys($_SESSION["cart"]);
    }
    return NULL;
  }


  /*
    CREATE CART PAGE PRODUCT ITEMS
  */

  /**
   * Return a string containing a list of products saved in the Cart to pass to the view
   *
   * @access public
   * @return string
   */
  public function create_cart_items() {

    // get products in cart and get the info from the db)
    $products = $this->get();

    $data = "";
    $total = 0;

    // This is inside a form ***
    $data .= '<li class="header_row"><div class="col1">Product Name:</div><div class="col2">Quantity:</div><div class="col3" style="text-align:end">Product Price:</div><div class="col4" style="text-align:end">Total Price:</div></li>';

    if($products != "") {
      $row = 1;
      foreach($products as $product){
        // create each product row 
        $data .= "<li";

        // class for even rows
        if($row % 2 === 0) $data .= " class='alt'";
        
        $data .= "><div class='col1'>" . $product["name"] . "</div>";

        // here is the input for quantity for each product ***
        $data .= "<div class='col2'><input name='product" . $product["id"] . "' value='" . $_SESSION["cart"][$product["id"]] . "'></div>"; 

        $data .= "<div class='col3' style='text-align:end'>" . $product["price"] . " €</div>" ;

        $data .= "<div class='col4' style='text-align:end'>" . $product["price"] *  $_SESSION["cart"][$product["id"]] . " €</div></li>";

        // total for each products ***
        $total += $product["price"] * $_SESSION["cart"][$product["id"]];
        $row++;
      }

      // add subtotal ***
			$data .= '<li class="subtotal_row"><div class="col1" style="text-align:end">Subtotal:</div><div class="col2" style="text-align:end">' . $total . ' €</div></li>';

      // add total ***
			$data .= '<li class="total_row"><div class="col1" style="text-align:end">Total:</div><div class="col2" style="text-align:end">' . $total . ' €</div></li>';


    } else {
      // No products to show 
      $data .= '<li><strong>No items in the cart!</strong></li><br>';

      // add subtotal
			$data .= '<li class="subtotal_row"><div class="col1">Subtotal:</div><div class="col2" style="text-align:end">0,00 €</div></li>';

      // add total
			$data .= '<li class="total_row"><div class="col1">Total:</div><div class="col2" style="text-align:end">0,00 €</div></li>';
    }

   return $data;
  }
}