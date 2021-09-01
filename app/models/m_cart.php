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
    if($num === 0) {
      unset($_SESSION["cart"][$id]);
      if (empty($_SESSION["cart"])) unset($_SESSION["cart"]);
    }
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

  /**
   * Get total of products items in Cart
   *
   * @access public
   * @return integer
   */
  public function get_total_items(){
    $num = 0;
    if(isset($_SESSION["cart"])) {
      foreach ($_SESSION["cart"] as $item) {
        $num += $item;
      }
    }
    return $num;
  }

  /**
   * Get total cost of all products in Cart
   *
   * @access public
   * @return string
   */
  public function get_total_cost(){

    $total_cost = "0.00";

    if(isset($_SESSION["cart"])) {
      // 

      // get product ids in Cart
      $ids = $this->get_ids();

      // this will return the specific price and id for each product in Cart
      global $Products;
      $prices = $Products->get_product_prices($ids); 

      // loop through $prices and add the cost of each product X the number of products
      if ($prices != NULL) {
        foreach ($prices as $price) {
          $total_cost += doubleval($price["price"] * $_SESSION["cart"][$price["id"]]);
        }
      }
    }
    return $total_cost;
  }

  /**
   * Return the shipping cost based on cost for total cost of each product
   * 
   * @access public
   * @param double $total
   * @return double
   */
  public function get_shipping_cost($total) {
    if ($total > 1000) return 100.0;
    elseif ($total > 200) return 40.0;
    elseif ($total > 50) return 15.0;
    elseif ($total > 10) return 4.0;
    elseif ($total > 1) return 1.0;
    else  return 0;
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
    // TODO: CREATE HTML COMPONENTS
    $data .= '<li class="header_row"><div class="col1">Product Name:</div><div class="col2">Quantity:</div><div class="col3" style="text-align:end">Product Price:</div><div class="col4" style="text-align:end">Total Price:</div></li>';

    if($products != "") {

      $row = 1;
      $shipping = 0;

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

        // calculate shipping ***
        $shipping += ($this->get_shipping_cost($product["price"] * $_SESSION["cart"][$product["id"]]));

        // total for each products ***
        $total += $product["price"] * $_SESSION["cart"][$product["id"]];
        $row++;
      }

      // add subtotal ***
			$data .= '<li class="subtotal_row"><div class="col1" style="text-align:end">Subtotal:</div><div class="col2" style="text-align:end">' . $total . ' €</div></li>';

      // add shipping ***
      $data .= "<li class='shipping_row'><div class='col1'>Shipping Cost:</div> <div class ='col2' style='text-align:end'>" . number_format($shipping, 2) . " €</div></li>";

      // add taxes ***
      if (PRODUCT_TAX > 0) {
        $data .= "<li class='taxes_row'><div class='col1'>Tax (" . (PRODUCT_TAX * 100) . "%):</div><div class='col2' style='text-align:end'>" . number_format(PRODUCT_TAX * $total, 2) . " €</div></li>";
      }

      // add total ***
			$data .= '<li class="total_row"><div class="col1" style="text-align:end">Total:</div><div class="col2" style="text-align:end">' . number_format($total + (PRODUCT_TAX * $total) + $shipping, 2) . ' €</div></li>';


    } else {
      // No products to show 
      $data .= '<li><strong>No items in the cart!</strong></li><br>';

      // add subtotal
			$data .= '<li class="subtotal_row"><div class="col1">Subtotal:</div><div class="col2" style="text-align:end">0.00 €</div></li>';

      // add shipping ***
      $data .= "<li class='shipping_row'><div class='col1'>Shipping Cost:</div><div class ='col2' style='text-align:end'>0.00 €</div></li>";

      // add taxes 
      if (PRODUCT_TAX > 0) {
        $data .= "<li class='taxes_row'><div class='col1'>Tax (" . (PRODUCT_TAX * 100) . "%):</div><div class='col2' style='text-align:end'>0.00 €</div></li>";
      }

      // add total
			$data .= '<li class="total_row"><div class="col1">Total:</div><div class="col2" style="text-align:end">0.00 €</div></li>';
    }

   return $data;
  }
}