<?php
	session_cache_limiter('none');
	session_start();

	include("connectPDO.php");

	try {
		if (isset($_SESSION['ValidUser']) && $_SESSION['ValidUser'] === true && $_SESSION['AdminFlag'] == Y) {
			$sql = "SELECT ";
				$sql .= "Prod_ID, ";
				$sql .= "Prod_Image, ";
				$sql .= "Prod_Subtype, ";
				$sql .= "Prod_Brand, ";
				$sql .= "Prod_Color, ";
				$sql .= "Prod_Material, ";
				$sql .= "Prod_Price, ";
				$sql .= "Prod_Quantity ";
			$sql .= "FROM GeekStyle_Products";		
		}
		else {
			$sql = "SELECT ";
				$sql .= "Prod_ID, ";
				$sql .= "Prod_Image, ";
				$sql .= "Prod_Subtype, ";
				$sql .= "Prod_Brand, ";
				$sql .= "Prod_Color, ";
				$sql .= "Prod_Material, ";
				$sql .= "Prod_Price, ";
				$sql .= "Prod_Quantity ";
			$sql .= "FROM GeekStyle_Products ";
			$sql .= "WHERE Prod_Quantity > 0";
		}


		$stmt = $conn->prepare($sql);

		$stmt->execute();
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		
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
			align-items: flex-start;
			display: flex;
			flex-direction: row;
			height: 100%;
			margin: 40px 50px 100px 50px;
		}

		.ProductsInfoBox {
			display: flex;
			flex-direction: column;
			font-size: 1.1em;
			position: sticky;
			top: 175px;
			width: 20%;
		}
		.ProductsInfoBox button {
			font-family: var(--font-family-1);
		}	
		.SpecialButton {
			font-size: 1.25em;
			margin-bottom: var(--margin-2);
		}
		
		#ProductsMenuBox {
			align-items: flex-start;
			display: none;
			flex-direction: column;
			margin-bottom: var(--margin-2);
		}
		#ProductsMenuBox button {
			background-color: var(--color-neutral-3);
			border: none;
			cursor: pointer;
			font-size: 1em;
			margin-bottom: var(--margin-1);
		}
		#HimMenu, #HerMenu, #KidsMenu {
			align-items: flex-start;
			display: none;
			flex-direction: column;
			font-size: .8em;
			margin-bottom: var(--margin-1);
		}
		#HimMenu button, #HerMenu button, #KidsMenu button {
			margin: 0 0 5px 40px;
		}
		
		#RefineProductsBox {
			align-items: flex-start;
			display: none;
			flex-direction: column;
		}
		#RefineProductsBox button {
			background-color: var(--color-neutral-3);
			border: none;
			cursor: pointer;
			font-size: .85em;
			font-weight: bold;
		}
		#SubtypeBox, #SizeBox, #ColorBox, #PriceBox {
			align-items: flex-end;
			border-bottom: solid thin var(--color-neutral-1);
			display: flex;
			flex-direction: column;
			font-size: .75em;
			margin-bottom: var(--margin-1);
			padding-bottom: var(--margin-2);
			width: 100%;
		}
		
		.ProductsBox {
			display: grid;
			grid-column-gap: var(--margin-3);
			grid-row-gap: var(--margin-3);
			grid-template-columns: 1fr 1fr 1fr;
			grid-auto-rows: 500px;
			height: 100%;
			margin: 0 var(--margin-3);
			width: 80%;
		}
		.SingleProductBox {
			overflow: hidden;
		}
		.SingleProductBox img {
			height: 75%;
			object-fit: cover;
			width: 100%;
		}
		.SingleProductBox a:hover {
			text-decoration: underline;
		}
		.ProductName {
			font-size: 1.2em;
			margin: var(--margin-2) var(--margin-1);
		}
		.ProductPrice {
			margin: var(--margin-1);
		}
		
		.ProductControlBox {
			display: flex;
			flex-direction: row;
			justify-content: flex-end;
		}
		.ProductControlBox a {
			margin-left: var(--margin-1);
		}
				
		@media only screen and (min-width: 480px) and (max-width: 767px) {
		}
		@media only screen and (min-width: 768px) {
		}
	</style>
	
	<script src="#"></script>
	<script>
		
		function setupJavascript() {
			
			document.querySelector("#ProductsMenuButton").onclick = function() {
				var x = document.querySelector("#ProductsMenuBox");
				if (x.style.display === "none" || x.style.display === "") {
					x.style.display = "flex";
				} else {
					x.style.display = "none";
				}
			};
			
			document.querySelector("#HimButton").onclick = function() {
				var x = document.querySelector("#HimMenu");
				if (x.style.display === "none" || x.style.display === "") {
					x.style.display = "flex";
				} else {
					x.style.display = "none";
				}
			};
			
			document.querySelector("#HerButton").onclick = function() {
				var x = document.querySelector("#HerMenu");
				if (x.style.display === "none" || x.style.display === "") {
					x.style.display = "flex";
				} else {
					x.style.display = "none";
				}
			};
			
			document.querySelector("#KidsButton").onclick = function() {
				var x = document.querySelector("#KidsMenu");
				if (x.style.display === "none" || x.style.display === "") {
					x.style.display = "flex";
				} else {
					x.style.display = "none";
				}
			};
			
			document.querySelector("#RefineProductsButton").onclick = function() {				
				var x = document.querySelector("#RefineProductsBox");
				if (x.style.display === "none" || x.style.display === "") {
					x.style.display = "flex";
				} else {
					x.style.display = "none";
				}
			};
			
			var elems = document.getElementsByClassName('ConfirmClick');
			var ConfirmFunction = function (e) {
				if (!confirm('Are you sure you want to delete this record?')) e.preventDefault();
			};
			for (var i = 0, l = elems.length; i < l; i++) {
				elems[i].addEventListener('click', ConfirmFunction, false);
			}

		}
		
	</script>
</head>

<body onload="setupJavascript();">
	
	<div class="PageBox">
		<?php include "GeekStyleHeader.php"; ?>

		<main>
			<div class="ProductsInfoBox">
				
				<div><button class="BorderButton2 SpecialButton" id="ProductsMenuButton">Menu</button></div>
				<div id="ProductsMenuBox">
					<button id="HimButton">HIM</button>
					<div id="HimMenu">
						<button href="javascript:void(0);">All</button>
						<button href="javascript:void(0);">New</button>
						<button href="javascript:void(0);">Tops</button>
						<button href="javascript:void(0);">Bottoms</button>
						<button href="javascript:void(0);">Shoes</button>
						<button href="javascript:void(0);">Accessories</button>
						<button href="javascript:void(0);">Sale</button>
					</div>
					<button id="HerButton">HER</button>
					<div id="HerMenu">
						<button href="javascript:void(0);">All</button>
						<button href="javascript:void(0);">New</button>
						<button href="javascript:void(0);">Tops</button>
						<button href="javascript:void(0);">Bottoms</button>
						<button href="javascript:void(0);">Shoes</button>
						<button href="javascript:void(0);">Accessories</button>
						<button href="javascript:void(0);">Sale</button>
					</div>
					<button id="KidsButton">KIDS</button>
					<div id="KidsMenu">
						<button href="javascript:void(0);">All</button>
						<button href="javascript:void(0);">New</button>
						<button href="javascript:void(0);">Tops</button>
						<button href="javascript:void(0);">Bottoms</button>
						<button href="javascript:void(0);">Shoes</button>
						<button href="javascript:void(0);">Accessories</button>
						<button href="javascript:void(0);">Sale</button>
					</div>
				</div>
				
				<div><button class="BorderButton2 SpecialButton" id="RefineProductsButton">Refine</button></div>
				<div id="RefineProductsBox">
					<button>Type</button>
					<div id="SubtypeBox">Squid</div>
					<button>Size</button>
					<div id="SizeBox">Squid</div>
					<button>Color</button>
					<div id="ColorBox">Squid</div>
					<button>Price</button>
					<div id="PriceBox">Squid</div>
				</div>
				
			</div>
			<div class="ProductsBox">
<!--
				<div class="SingleProductBox">
					<a href="javascript:void(0);">
						<img src="images/SuperBoy.jpg" />
					</a>
					<a href="javascript:void(0);">
						<p class="ProductName">Superboy</p>
					</a>
					<p class="ProductPrice">$9.99</p>
				</div>
-->				
				<?php
					while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
						echo "<div class='SingleProductBox'>";
							echo "<a href='javascript:void(0);'>";
								if ($data['Prod_Quantity'] < 1) {
									echo "<img src='images/SquidFriendNoShadow.png' />";
								}
								else {
									echo "<img src='images/products/" . $data['Prod_Image'] . "' />";
								}
							echo "</a>";
							echo "<a href='javascript:void(0);'>";
								echo "<p class='ProductName'>" . $data['Prod_Brand'] . " " . $data['Prod_Color'] . " " . $data['Prod_Material'] . " " . $data['Prod_Subtype'] . "</p>";
							echo "</a>";
							echo "<p class='ProductPrice'> $" . $data['Prod_Price'] . "</p>";

							if (isset($_SESSION['ValidUser']) && $_SESSION['ValidUser'] === true && $_SESSION['AdminFlag'] == Y) {
								echo "<div class='ProductControlBox'>";
									echo "<p><a class='BorderButton2' href='./GeekStyleProductControl.php?RecordID=" . $data['Prod_ID'] . "' style='text-decoration: none;'>Update</a><p>";
									echo "<p><a class='BorderButton1 ConfirmClick' href='./GeekStyleProductDelete.php?RecordID=" . $data['Prod_ID'] . "' style='text-decoration: none;'>Delete</a><p>";
								echo "</div>";			
							}
						echo "</div>";
					}
				?>
			</div>
		</main>

		<?php include "GeekStyleFooter.php"; ?>
	</div>	

</body>
</html>