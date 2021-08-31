<?php

/*
	Products Class
	Handle all tasks related to retrieving and displaying products
*/

class Products {

  private $Database;
  private $db_table = "products";

  function __construct(){
    global $Database;
    $this->Database = $Database;
  }  

  /*
      Setting / Getting products from Database
  */

  /**
   * Retrive product(s) info from database
   *
   * @access public
   * @param integer, array $id (optional)
   * @return array
   */
  public function get($id = NULL) {

    $data = array();

    if (is_array($id)){
      // get a list of products based on array of ids
      // also used in Cart model 
      $items = "";
      foreach ($id as $item_id) {
        if($items != "") $items .=  ",";
        $items .= $item_id;
      } // 1,2,3,4,5....

      $query = "SELECT id, name, description, price, image FROM $this->db_table WHERE id IN ($items) ORDER BY name";

      if ($result = $this->Database->query($query)){
        if($result->num_rows > 0){
          while($row = $result->fetch_array()) {
            $data[] = array(
              "id"        => $row["id"],
              "name"      => $row["name"],
              "description" => $row["description"],
              "price"       => $row["price"],
              "image"       => $row["image"]
            );
          }
        }
      }

    } else if ($id != NULL) {

      // get one specific product
      $query = "SELECT 
        $this->db_table.id,
        $this->db_table.name,
        $this->db_table.description,
        $this->db_table.price,
        $this->db_table.image,
        categories.name AS category_name
        FROM $this->db_table, categories
        WHERE $this->db_table.id = ? AND $this->db_table.category_id = categories.id";

      if($stmt = $this->Database->prepare($query)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($prod_id, $prod_name, $prod_descr, $prod_price, $prod_img, $cat_name);
        $stmt->fetch();

        if($stmt->num_rows > 0){
          $data = array(
            "id"          => $prod_id,
            "name"        => $prod_name,
            "description" => $prod_descr,
            "price"       => $prod_price,
            "image"       => $prod_img,
            "category"    => $cat_name
          );
        }
        $stmt->close();
      }

    } else {
      
      // get All products
      $query = "SELECT * FROM " . $this->db_table . " ORDER BY name";

      if($result = $this->Database->query($query)){
        if($result->num_rows > 0){
          while($row = $result->fetch_array()){
            $data[] = array(
              "id"        => $row["id"],
              "name"      => $row["name"],
              "description" => $row["description"],
              "price"       => $row["price"],
              "image"       => $row["image"],
              "category"    => $row["category_id"]
            );
          }
        }
      }
    }

    return $data;
  }


  /**
   * Retrive products info from database in a specific category
   *
   * @access public
   * @param integer $category
   * @return string
   */
  public function get_in_category($category_id) {

    $data = array();

    $query = "SELECT id, name, price, image FROM " . $this->db_table . " WHERE category_id = ? ORDER BY name";

    if($stmt = $this->Database->prepare($query)) {
      $stmt->bind_param("i", $category_id);
      $stmt->execute();
      $stmt->store_result(); // ?????
      $stmt->bind_result($prod_id, $prod_name, $prod_price, $prod_img);

      while($stmt->fetch()){
        $data[] = array(
          "id"    => $prod_id,
          "name"  => $prod_name,
          "price"  => $prod_price, 
          "image"  => $prod_img
        );
      }
      $stmt->close();
    }
    return $data;
  }


  /**
   * Check if product exists before being added to Cart
   *
   * @param integer $id
   * @return boolean
   */
  public function product_exist($id){

    $query = "SELECT id FROM $this->db_table WHERE id = ?";

    if ($stmt = $this->Database->prepare($query)){
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($id);
      $stmt->fetch();

      if($stmt->num_rows > 0){
        $stmt->close();
        return TRUE;
      }
      $stmt->close();
      return FALSE;
    }
  }


  /*
      CREATE PAGE ELEMENTS
  */

  /**
   * Create product page items using data from db
   *
   * @access public
   * @param integer $cols  (optional) 
   * @param integer $category (optional) 
   * @return string
   */
  //TODO: instead of cols use css flexbox or grid
  public function create_product_items($cols = 4, $category = NULL){

    if($category != NULL){
      // products from specific category
      $products = $this->get_in_category($category);      

    } else {
      // All products
      $products = $this->get();
    }

    $data = "";

    // loop through each product 
    if(!empty($products)){
      $i = 1; //counter
      foreach($products as $product){
        $data .= "<li";
        if($i === $cols){
          $data .= " class= 'last'";
          $i = 0;
        }
        $data .= "><a href='" . SITE_PATH . "product.php?id=" . $product["id"] . "'>";
        $data .= "<img src='" . IMAGES_PATH . $product["image"] . "' alt='" . $product["name"] . "'><br>";
        $data .= "<strong>" . $product["name"] . "</strong></a><br>$" . $product["price"];
        $data .= "<br><a class='button_sml' href='" . SITE_PATH . "cart.php?id=" . $product["id"]. "'>Add to cart</a></li>";
        $i++;
      }
    }
    return $data;
  }

}