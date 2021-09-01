<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link rel="stylesheet" href="resources/css/style.css">
  <title> <? $this->get_data("page_title"); ?> </title>
</head>

<body class="<? $this->get_data("page_class") ?>">

	<div id="wrapper">

		<div class="secondarynav">
			<strong>
				<?
					$items = $this->get_data("total_products", FALSE);
					$cost = $this->get_data("total_cost", FALSE);

					if ($items === 1) echo $items . " product (" . $cost . " €) in cart";
					else echo $items . " products (" . $cost . " €) in cart";
				?>
			</strong> &nbsp;| &nbsp;
			<!-- Go to cart page -->
			<a href="<? echo SITE_PATH ?>cart.php">Cart</a>
		</div>
			
		<h1><? echo SITE_NAME; ?></h1>
			
		<!-- Create nav menu -->
	  <ul class="nav">
      <? $this->get_data("page_nav"); ?>
	  </ul>