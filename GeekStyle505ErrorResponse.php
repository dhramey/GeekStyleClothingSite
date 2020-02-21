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
			flex-direction: column;
			justify-content: center;
			margin: 100px 0 400px 0;
		}
		
		main h1 {
			font-size: 2.5em;
			margin-bottom: var(--margin-2);
		}
		
		main h2 {
			margin-bottom: var(--margin-3);
		}
		
		main div {
			align-items: center;
			display: flex;
			flex-direction: row;
			justify-content: center;
		}
		
		.SpecialButton {
			font-size: 1.5em;
			margin: 0 20px;
			padding: 15px 30px;
			text-align: center;
		}
		
		#MrFrowns {
			color: var(--color-2);
			font-size: 10em;
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
			<p id="MrFrowns">&#9785;</p>
			<h1>505 ERROR</h1>
			<h2>I'm sorry! Looks like something didn't work quite right. Please try again later!</h2>
			<div>
				<a class="BorderButton2 SpecialButton" href="./GeekStyleIndex.php">Home</a>
				<a class="BorderButton2 SpecialButton" href="./GeekStyleContact.php">Contact</a>
			</div>
		</main>

		<?php include "GeekStyleFooter.php"; ?>
	</div>

</body>
</html>