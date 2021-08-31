<?php include_once('includes/public_header.php') ?>

<div id="content">
  <!-- Show messages to the user -->
	<ul class="alerts">
		<? $this->get_alerts(); ?>
	</ul>

  <img class="product_image" src="<? $this->get_data("product_image"); ?>" alt="<? $this->get_data("product_name"); ?>">

	<h2><? $this->get_data("product_name"); ?></h2>
  
	<div class="price">
    <? $this->get_data("product_price"); ?> 
	</div>

  <div class="description">
    <? $this->get_data("product_desc"); ?> 
	</div>

  <a class="button" href="<? echo SITE_PATH ?>cart.php?id=<? $this->get_data('product_id') ?>">Add to cart</a>

</div>

<?php include_once('includes/public_footer.php') ?>