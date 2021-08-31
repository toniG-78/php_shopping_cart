<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link rel="stylesheet" href="resources/css/style.css">
  <title> <? $this->get_data("page_title"); ?> </title>
</head>

<body class="">
	<div id="wrapper">
		<div class="secondarynav">
			<strong>0 items (0,00 €) in cart</strong> &nbsp;| &nbsp;
			<!-- Go to cart page -->
			<a href="<? echo SITE_PATH ?>cart.php">Cart</a>
		</div>
			
		<h1><? echo SITE_NAME; ?></h1>
			
		<!-- Create nav menu -->
	  <ul class="nav">
      <? $this->get_data("page_nav"); ?>
	  </ul>