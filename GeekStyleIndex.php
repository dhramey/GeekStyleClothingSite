<?php
	session_cache_limiter('none');
	session_start();

	include("connectPDO.php");

	try {
		//Get PhotoSpread Image
		$sql = "SELECT ";
			$sql .= "Prod_Image ";
		$sql .= "FROM GeekStyle_Products ";
		$sql .= "WHERE Prod_Quantity > 0 ";
		$sql .= "LIMIT 1";

		$stmt = $conn->prepare($sql);

		$stmt->execute();
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data=$stmt->fetch(PDO::FETCH_ASSOC);
		
		$PhotoSpreadImage = $data['Prod_Image'];
		
		//Get ProductTop Image
		$sql1 = "SELECT ";
			$sql1 .= "Prod_Image ";
		$sql1 .= "FROM GeekStyle_Products ";
		$sql1 .= "WHERE Prod_Type='TypeTop' ";
		$sql1 .= "ORDER BY Add_Date DESC ";
		$sql1 .= "LIMIT 1";
		
		$stmt = $conn->prepare($sql1);

		$stmt->execute();
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data=$stmt->fetch(PDO::FETCH_ASSOC);
		
		$ProductTopImage = $data['Prod_Image'];
		
		//Get ProductBottom Image
		$sql2 = "SELECT ";
			$sql2 .= "Prod_Image ";
		$sql2 .= "FROM GeekStyle_Products ";
		$sql2 .= "WHERE Prod_Type='TypeBottom' ";
		$sql2 .= "ORDER BY Add_Date DESC ";
		$sql2 .= "LIMIT 1";
		
		$stmt = $conn->prepare($sql2);

		$stmt->execute();
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data=$stmt->fetch(PDO::FETCH_ASSOC);
		
		$ProductBottomImage = $data['Prod_Image'];
		
		//Get ProductAccessory Image
		$sql3 = "SELECT ";
			$sql3 .= "Prod_Image ";
		$sql3 .= "FROM GeekStyle_Products ";
		$sql3 .= "WHERE Prod_Type='TypeAccessory' ";
		$sql3 .= "ORDER BY Add_Date DESC ";
		$sql3 .= "LIMIT 1";
		
		$stmt = $conn->prepare($sql3);

		$stmt->execute();
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data=$stmt->fetch(PDO::FETCH_ASSOC);
		
		$ProductAccessoryImage = $data['Prod_Image'];
		
    }
	catch(PDOException $e) {
//		echo "Error: " . $e->getMessage();
		$ErrorMessage = "I'm sorry! Looks like something didn't work quite right. Please try again later!";

		//Delivers a developer defined error message to error log
		$ErrorReport = error_log($e->getMessage());
		$ErrorLine = error_log($e->getLine());
		$ErrorBacktrace = error_log(var_dump(debug_backtrace()));

		//Send Error Message Email
		include("emailerClass.php");
		$ErrorEmail = new Emailer();
			$ErrorEmail->set_sentToAddress("d.h.ramey@isunetnet");
			$ErrorEmail->set_sentFromAddress("web@dramey.info");
			$ErrorEmail->set_subjectLine("GeekStyle Error Occurred");
			$ErrorEmail->set_emailMessage(
				"Error on line: $ErrorLine \r\n \r\n Error Details: $ErrorReport \r\n \r\n Error Backtrace: $ErrorBacktrace \r\n \r\n"
			);
		$ErrorEmail->sendEmail();

		//Direct User to Error Page
		header('Location: ./GeekStyle505ErrorResponse.php');
		exit();
	}
?>


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
			flex: 1;
			flex-direction: column;
			justify-content: center;
			margin: var(--margin-3) 0;
		}
		
		.SpecialButton {
			padding: 20px;
			text-align: center;
		}
		
		#MrSmiles {
			color: var(--color-neutral-1);
			font-size: 10em;
			margin: 100px;
		}
		
		.PhotoSpread {
			background-color: var(--color-1);
			font-family: var(--font-family-2);
			height: 400px;
			overflow: hidden;
			position: relative;
			width: 100%;
		}
		.PhotoSpread img {
			height: 100%;
			object-fit: cover;
			object-position: 50% 35%;
			width: 100%;
		}
		.PhotoSpreadButton {
			bottom: var(--margin-2);
			font-size: 5em;
			left: var(--margin-3);
			padding: 20px;
			position: absolute;
		}
		
		.ProductSpread {
			background-color: var(--color-2);
			font-family: var(--font-family-2);
			height: 400px;
			margin-bottom: 100px;
			width: 100%;
		}
		.ProductSpread h1 {
			margin: var(--margin-2) 0;
			text-align: center;
		}
		.CategorySpread {
			display: flex;
			flex-direction: row;
			height: 70%;
			justify-content: space-around;
			width: 100%;
		}
		.CategoryBox {
			background-color: var(--color-neutral-2);
			height: 100%;
			overflow: hidden;
			width: 20%;
		}
		.CategoryBox:hover {
			background-color: var(--color-neutral-1);
			color: var(--color-neutral-2);
			transition: 300ms;
		}
		.CategoryBox div {
			height: 100%;
		}
		.CategoryBox img {
			height: 80%;
			object-fit: cover;
			width: 100%;
		}
		.CategoryBox h2 {
			margin: var(--margin-1);
			text-align: center;
		}
		
		.BlogSpread {
			background-color: var(--color-1);
			font-family: var(--font-family-2);
			height: 400px;
			overflow: hidden;
			position: relative;
			width: 100%;			
		}
		.BlogSpread img {
			height: 100%;
			object-fit: cover;
			width: 40%;
		}
		.BlogSpreadButton {
			bottom: var(--margin-2);
			font-size: 5em;
			right: 100px;
			padding: 20px;
			position: absolute;
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
<!--		<h1>WELCOME TO GEEKSTYLE</h1>			-->
			
			<div class="PhotoSpread">
				<a class="SolidButton1 PhotoSpreadButton" href="GeekStyleProductDisplay.php">Sweet Geeky Fashions</a>
			 	<img src="images/products/<?php echo $PhotoSpreadImage; ?>" />
			</div>
			
			<h1 id="MrSmiles">&#9786;</h1>
			
			<div class="ProductSpread">
				<h1>Shop By Category</h1>
				<div class="CategorySpread">
					<a class="CategoryBox" href="#">
						<div>
							<img src="images/products/<?php echo $ProductTopImage; ?>" />
							<h2>Tops</h2>
						</div>
					</a>
					<a class="CategoryBox" href="#">
						<div>
							<img src="images/products/<?php echo $ProductBottomImage; ?>" />
							<h2>Bottoms</h2>
						</div>
					</a>
					<a class="CategoryBox" href="#">
						<div>
							<img src="images/products/<?php echo $ProductAccessoryImage; ?>" />
							<h2>Accessories</h2>
						</div>
					</a>
				</div>
			</div>
			
			<div class="BlogSpread">
			 	<img src="images/SquidFriend.png" />
				<a href="./SquidAlert.php" class="BorderButton4 BlogSpreadButton" >ALERT THE SQUIDS!</a>
			</div>
			
<!--		<a class="BorderButton2 SpecialButton" href="./GeekStyleProductDisplay.php"><h2>Sweet Geeky Fashions</h2></a>-->
		</main>

		<?php include "GeekStyleFooter.php"; ?>
	</div>

</body>
</html>