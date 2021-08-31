<?php include("includes/public_header.php"); ?>

<div id="content">
	<h2>Shopping Cart</h2>
	
	<ul class="alerts">
		<?php $this->get_alerts(); ?>
	</ul>
	
	<form action="" method="post">
		<ul class="cart">
			<?php $this->get_data('cart_items'); ?>
		</ul>
	
		<div class="buttons_row" style="margin-top: 2rem;">

    	<!-- emptied the cart and reload  -->
			<a class="button_alt" href="?empty">Empty Cart</a>

			<!-- update the cart and reload  -->
			<input type="submit" name="update" class="button_alt" value="Update Cart">
		</div>
	
	</form>
	
	<?php
	$items = $this->get_data('cart_total_items', FALSE);
	if ($items > 0) { ?>

	<?php } ?>

			<form action="" method="post">
			<div class="submit_row">
				<input type="submit" name="submit" class="button" value="Pay with PayPal">
			</div>
		</form>
	
</div>

<?php include("includes/public_footer.php"); ?>