<!DOCTYPE html>
<html>
<head>
	<title> Daniel Ramey Designs - GeekStyle </title>
    	<!--
		Author: Daniel Ramey
		Date Created: 2019
    	-->

	<meta name="description" content="Daniel Ramey Designs is a web presence reflecting the art and works of Daniel Ramey.
		It is an amalgam of sketches, computer graphics, and projects created over the past couple of years.
		Thank you for looking!" />

	<meta name="keywords" content="Daniel Ramey, homepage, art, graphics,
		web design, sketches, photoshop, illustrator, indesign html, css" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
	<link rel="stylesheet" type="text/css" href="css/HeaderStyle.css">
	<link rel="stylesheet" type="text/css" href="css/FooterStyle.css">
	<link rel="stylesheet" type="text/css" href="css/MasterStyle.css">

	<link rel="stylesheet" href="#">
	
	<style>
		main {
			align-items: center;
			display: flex;
			justify-content: center;
			margin: 100px 0 400px 0;
		}
		
		.SpecialButton {
			align-items: center;
			border-width: thick;
			display: flex;
			font-size: 1.8em;
			font-weight: bold;
			height: 300px;
			justify-content: center;
			margin: 0 100px;
			text-align: center;
			width: 300px;
		}
				
		@media only screen and (min-width: 480px) and (max-width: 767px) {
		}
		@media only screen and (min-width: 768px) {
		}
	</style>
	
	<script src="#"></script>
	<script>		
	</script>
</head>

<body onload="setupJavascript();">
	
	<div class="PageBox">
		<?php include "GeekStyleHeader.php"; ?>

		<main>
			<a class="BorderButton1 SpecialButton" href="./GeekStyleProductDisplay.php">
				<div>Update/Delete <br/> Products</div>
			</a>
			<a class="BorderButton1 SpecialButton" href="./GeekStyleProductControl.php">
				<div>Add New <br/> Product</div>
			</a>
		</main>

		<?php include "GeekStyleFooter.php"; ?>	
	</div>
	
</body>
</html>