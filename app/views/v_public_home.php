<?php include_once('includes/public_header.php') ?>

<div id="content">
	<h2>All Products</h2>
  
  <!-- Show messages to the user -->
	<ul class="alerts">
		<? $this->get_alerts(); ?>
	</ul>

	<ul class="products">
    <? $this->get_data("product_items"); ?>
	</ul>
</div>

<?php include_once('includes/public_footer.php') ?>