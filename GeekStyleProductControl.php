<?php
	session_cache_limiter('none');
	session_start();

	if (!isset($_SESSION['ValidUser']) && !$_SESSION['ValidUser'] === true && $_SESSION['AdminFlag'] !== Y) {
		header("Location: ./GeekStyleIndex.php");
		exit();
	}

	$ValidForm = false;

	$ProductImage = "";
	$ProductGender = "";
	$ProductAge = "";
	$ProductType = "";
	$ProductSubtype = "";
	$ProductBrand = "";
	$ProductColor = "";
	$ProductMaterial = "";
	$ProductPrice = "";
	$ProductQuantity = "";

	$AddDate = "";
	$UpdateDate = "";

	$ProductImageError = "";
	$ProductGenderError = "";
	$ProductAgeError = "";
	$ProductTypeError = "";
	$ProductSubtypeError = "";
	$ProductBrandError = "";
	$ProductColorError = "";
	$ProductMaterialError = "";
	$ProductPriceError = "";
	$ProductQuantityError = "";

	$UpdateRecordID = $_GET['RecordID'];
	//$UpdateRecordID = 3;

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		if ($_POST['ProductName'] != '') {
			header("Location: ./GeekStyleIndex.php");
			exit();
		};
									
		$ValidForm = true;

		$ProductImage = $_FILES["ProductImage"]["name"];		
		$ProductGender = $_POST['ProductGender'];
		$ProductAge = $_POST['ProductAge'];
		$ProductType = $_POST['ProductType'];
		$ProductSubtype = $_POST['ProductSubtype'];
		$ProductBrand = $_POST['ProductBrand'];
		$ProductColor = $_POST['ProductColor'];
		$ProductMaterial = $_POST['ProductMaterial'];
		$ProductPrice = $_POST['ProductPrice'];
		$ProductQuantity = $_POST['ProductQuantity'];
		
		$AddDate = date("Y-m-d");
		$UpdateDate = date("Y-m-d");

		$ProductImageError = "";		
		$ProductGenderError = "";
		$ProductAgeError = "";
		$ProductTypeError = "";
		$ProductSubtypeError = "";
		$ProductBrandError = "";
		$ProductColorError = "";
		$ProductMaterialError = "";
		$ProductPriceError = "";
		$ProductQuantityError = "";
		
		//Run Validation
		include("validationClassPHP.php");
		$RunValidation = new validation();
		
		//Clean Inputs		
		$ProductPrice = $RunValidation->CleanNumberFloats($ProductPrice);
		$ProductQuantity = $RunValidation->CleanNumberIntegers($ProductQuantity);
		
		//Image Upload and Validation
		if (isset($_FILES["ProductImage"]) && $_FILES["ProductImage"]["error"] == 0) {
			$Allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
			$FileName = $_FILES["ProductImage"]["name"];
			$FileType = $_FILES["ProductImage"]["type"];
			$FileSize = $_FILES["ProductImage"]["size"];
			$FileExtension = pathinfo($FileName, PATHINFO_EXTENSION);
			$MaxFileSize = 5 * 1024 * 1024;
			
			if ($RunValidation->NotEmpty($FileName) ) {
				$ValidForm = false;
				$ProductImageError = "Please make a selection";
			}	
			if (!array_key_exists($FileExtension, $Allowed)) {
				$ValidForm = false;
				$ProductImageError = "Please select a valid file format";
			}
			elseif ($FileSize > $MaxFileSize) {
				$ValidForm = false;
				$ProductImageError = "File size is larger than the allowed limit";
			}
			elseif (in_array($FileType, $Allowed)) {
				if (file_exists("upload/" . $FileName)) {
					$ValidForm = false;
					$ProductImageError = $FileName . " already exists";
				}
			}
		}
				
		if ($RunValidation->NotEmpty($ProductGender) ) {
			$ValidForm = false;
			$ProductGenderError = "Please make a selection";
		}
		if ($RunValidation->NotEmpty($ProductAge) ) {
			$ValidForm = false;
			$ProductAgeError = "Please make a selection";
		}
		if ($RunValidation->NotEmpty($ProductType) ) {
			$ValidForm = false;
			$ProductTypeError = "Please make a selection";
		}
		if ($RunValidation->NotEmpty($ProductSubtype) ) {
			$ValidForm = false;
			$ProductSubtypeError = "Please make a selection";
		}
		if ($RunValidation->NotEmpty($ProductBrand) ) {
			$ValidForm = false;
			$ProductBrandError = "Please make a selection";
		}
		if ($RunValidation->NotEmpty($ProductColor) ) {
			$ValidForm = false;
			$ProductColorError = "Please make a selection";
		}
		if ($RunValidation->NotEmpty($ProductMaterial) ) {
			$ValidForm = false;
			$ProductMaterialError = "Please make a selection";
		}
		if ($RunValidation->PriceValidation($ProductPrice) ) {
			$ValidForm = false;
			$ProductPriceError = "Please enter a positive number";
		}
		if ($RunValidation->InventoryValidation($ProductQuantity) ) {
			$ValidForm = false;
			$ProductQuantityError = "Please enter a positive number";
		}		
		
		//Insert Data into Database
		if ($ValidForm) {

			include("connectPDO.php");
			
			//Upload Image file to correct folder location
			move_uploaded_file($_FILES["ProductImage"]["tmp_name"], "images/products/" . $FileName);
			
			if ($UpdateRecordID > 0) {
//				echo "In Update Record IF with record ID: $UpdateRecordID <br/>";	
				try {
					$sql = "UPDATE GeekStyle_Products SET ";
						$sql .= "Prod_Image=:Prod_Image, ";
						$sql .= "Prod_Gender=:Prod_Gender, ";
						$sql .= "Prod_Age=:Prod_Age, ";
						$sql .= "Prod_Type=:Prod_Type, ";
						$sql .= "Prod_Subtype=:Prod_Subtype, ";
						$sql .= "Prod_Brand=:Prod_Brand, ";
						$sql .= "Prod_Color=:Prod_Color, ";
						$sql .= "Prod_Material=:Prod_Material, ";
						$sql .= "Prod_Price=:Prod_Price, ";
						$sql .= "Prod_Quantity=:Prod_Quantity, ";
						$sql .= "Update_Date=:Update_Date ";
					$sql .= "WHERE Prod_ID=:Prod_ID";
					
					$stmt = $conn->prepare($sql);
					
					$stmt->bindParam(':Prod_Image', $ProductImage);
					$stmt->bindParam(':Prod_Gender', $ProductGender);
					$stmt->bindParam(':Prod_Age', $ProductAge);
					$stmt->bindParam(':Prod_Type', $ProductType);
					$stmt->bindParam(':Prod_Subtype', $ProductSubtype);
					$stmt->bindParam(':Prod_Brand', $ProductBrand);
					$stmt->bindParam(':Prod_Color', $ProductColor);
					$stmt->bindParam(':Prod_Material', $ProductMaterial);
					$stmt->bindParam(':Prod_Price', $ProductPrice);
					$stmt->bindParam(':Prod_Quantity', $ProductQuantity);
					$stmt->bindParam(':Update_Date', $UpdateDate);
					$stmt->bindParam(':Prod_ID', $UpdateRecordID);					
					
					$stmt->execute();
				}
				catch(PDOException $e) {
//					echo "Error: " . $e->getMessage();
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
			}
			else {
//				echo "In Insert Record ELSE with record ID: $UpdateRecordID <br/>";
				try {

					$sql = "INSERT INTO GeekStyle_Products (";
						$sql .= "Prod_Image, ";
						$sql .= "Prod_Gender, ";
						$sql .= "Prod_Age, ";
						$sql .= "Prod_Type, ";
						$sql .= "Prod_Subtype, ";
						$sql .= "Prod_Brand, ";
						$sql .= "Prod_Color, ";
						$sql .= "Prod_Material, ";
						$sql .= "Prod_Price, ";
						$sql .= "Prod_Quantity, ";
						$sql .= "Add_Date ";
					$sql .= ") ";
					$sql .= "VALUES (";
						$sql .= ":Prod_Image, ";
						$sql .= ":Prod_Gender, ";
						$sql .= ":Prod_Age, ";
						$sql .= ":Prod_Type, ";
						$sql .= ":Prod_Subtype, ";
						$sql .= ":Prod_Brand, ";
						$sql .= ":Prod_Color, ";
						$sql .= ":Prod_Material, ";
						$sql .= ":Prod_Price, ";
						$sql .= ":Prod_Quantity, ";
						$sql .= ":Add_Date";
					$sql .= ")";

					$stmt = $conn->prepare($sql);

					$stmt->bindParam(':Prod_Image', $ProductImage);
					$stmt->bindParam(':Prod_Gender', $ProductGender);
					$stmt->bindParam(':Prod_Age', $ProductAge);
					$stmt->bindParam(':Prod_Type', $ProductType);
					$stmt->bindParam(':Prod_Subtype', $ProductSubtype);
					$stmt->bindParam(':Prod_Brand', $ProductBrand);
					$stmt->bindParam(':Prod_Color', $ProductColor);
					$stmt->bindParam(':Prod_Material', $ProductMaterial);
					$stmt->bindParam(':Prod_Price', $ProductPrice);
					$stmt->bindParam(':Prod_Quantity', $ProductQuantity);
					$stmt->bindParam(':Add_Date', $AddDate);

					$stmt->execute();

				}
				catch(PDOException $e) {
//					echo "Error: " . $e->getMessage();
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
			}
		}
	}
	elseif ($UpdateRecordID > 0) {	
//		echo "In Show Record ELSEIF with record ID: $UpdateRecordID <br/>";
		include("connectPDO.php");
		
		try {
			
			$sql = "SELECT ";
				$sql .= "Prod_Image, ";
				$sql .= "Prod_Gender, ";
				$sql .= "Prod_Age, ";
				$sql .= "Prod_Type, ";
				$sql .= "Prod_Subtype, ";
				$sql .= "Prod_Brand, ";
				$sql .= "Prod_Color, ";
				$sql .= "Prod_Material, ";
				$sql .= "Prod_Price, ";
				$sql .= "Prod_Quantity ";
			$sql .= "FROM GeekStyle_Products ";
			$sql .= "WHERE Prod_ID=:Prod_ID";	
			
			$stmt = $conn->prepare($sql);
			
			$stmt->bindParam(':Prod_ID', $UpdateRecordID);
			
			$stmt->execute();
			
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
		
			$ProductImage = $row['Prod_Image'];
			$ProductGender = $row['Prod_Gender'];
			$ProductAge = $row['Prod_Age'];
			$ProductType = $row['Prod_Type'];
			$ProductSubtype = $row['Prod_Subtype'];
			$ProductBrand = $row['Prod_Brand'];
			$ProductColor = $row['Prod_Color'];
			$ProductMaterial = $row['Prod_Material'];
			$ProductPrice = $row['Prod_Price'];
			$ProductQuantity = $row['Prod_Quantity'];

		}
		catch(PDOException $e) {
//			echo "Error: " . $e->getMessage();
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
			display: flex;
			justify-content: center;
			margin: 60px 120px;
		}
		
		.FormSubmittedBox {
			text-align: center;
		}
		.FormSubmittedBox h1, .FormSubmittedBox h3 {
			margin-bottom: var(--margin-3);
		}
		.FormSubmittedBox a {
			font-size: 1.75em;
		}
		
		h1 {
			margin-bottom: var(--margin-1);
		}
		
		form {
			border: solid medium var(--color-1);
			display: flex;
			flex-direction: column;
			padding: 20px;
		}	
		form > div {
			margin: 20px;
		}
		form > div:last-of-type {
			margin-bottom: var(--margin-3);
		}
		form > div > div {
			margin-right: var(--margin-3);
		}
		form h3 {
			margin-bottom: 7.5px;
		}
		form label {
			color: var(--color-2);
			margin-right: 1px;
		}
		
		form input {
			margin-right: var(--margin-2);
		}
		form select {
			margin-right: var(--margin-2);
		}
		
		.FlexBox {
			display: flex;
			flex-direction: row;
		}
		
		#ProductNameBox {
			display: none;
		}
		
		.SpecialButton {
			font-size: 1.5em;
			margin-left: auto;
			padding: 10px 20px;
		}
				
		@media only screen and (min-width: 480px) and (max-width: 767px) {
		}
		@media only screen and (min-width: 768px) {
		}
	</style>
	
	<script src="validationJavascript.js"></script>
	<script>
		
		function setupJavascript() {
			
			document.querySelector("#SubmitButton").onclick = function() {
				ValidForm = true;		
				
				RadioButtonValidation("[name='ProductGender']", "#ProductGenderError");
				RadioButtonValidation("[name='ProductAge']", "#ProductAgeError");
				RadioButtonValidation("[name='ProductBrand']", "#ProductBrandError");
				
				ImageUploadValidation("#ProductImage", "#ProductImageError");
				
				DropdownValidation("#ProductType", "#ProductTypeError");
				DropdownValidation("#ProductSubtype", "#ProductSubtypeError");
				DropdownValidation("#ProductColor", "#ProductColorError");
				DropdownValidation("#ProductMaterial", "#ProductMaterialError");
				
				PriceValidation("#ProductPrice", "#ProductPriceError");
				InventoryValidation("#ProductQuantity", "#ProductQuantityError");
								
				if(ValidForm) {
					alert("Valid form will be submitted");
					document.querySelector("#ProductEntryAndUpdateForm").submit();
				}
				else {
					alert("Invalid form. Please fix any fields with error messages.");
				}
			};
		}
		
	</script>
</head>

<body onload="setupJavascript();">
	
	<div class="PageBox">
		<?php include "GeekStyleHeader.php"; ?>

		<main>
<?php
if ($ValidForm) {
?>
			<div class="FormSubmittedBox">
				<h1>Thanks for being awesome!</h1>
				<h3>Your entry has been ADDED.</h3>
				<p><a class="BorderButton2" href="./GeekStyleProductDisplay.php">Products</a></p>
			</div>		
<?php
}
elseif ($ValidForm && isset($_GET['RecordID'])) {
?>		
			<div class="FormSubmittedBox">
				<h1>Thanks for being awesome!</h1>
				<h3>Your entry has been UPDATED.</h3>
				<p><a class="BorderButton2" href="./GeekStyleProductDisplay.php">Products</a></p>
			</div>		
<?php
}
else {
?>			
			<div>			
<?php
if ($UpdateRecordID > 0) {
?>
				<h1>Update Product</h1>
<?php
}
else {
?>
				<h1>Add Product</h1>
<?php
}
?>
				<form id="ProductEntryAndUpdateForm" enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?RecordID=$UpdateRecordID"; ?>">
					<div class="FlexBox">
						<div>
							<h3>Target Gender: * <br/><span class="ErrorDisplay" id="ProductGenderError"><?php echo $ProductGenderError; ?></span></h3>
							<label for="ProductGenderHer">For Her</label>
							<input type="radio" name="ProductGender" id="ProductGenderHer" value="GenderHer" <?php if (isset($ProductGender) && $ProductGender=="GenderHer") echo "checked";?> />
							<label for="ProductGenderHim"> For Him </label>
							<input type="radio" name="ProductGender" id="ProductGenderHim" value="GenderHim" <?php if (isset($ProductGender) && $ProductGender=="GenderHim") echo "checked";?> />
						</div>
						<div>
							<h3>Target Age: * <br/><span class="ErrorDisplay" id="ProductAgeError"><?php echo $ProductAgeError; ?></span></h3>
							<label for="ProductAgeAdult">For Adults</label>
							<input type="radio" name="ProductAge" id="ProductAgeAdult" value="AgeAdult" <?php if (isset($ProductAge) && $ProductAge=="AgeAdult") echo "checked";?> />
							<label for="ProductAgeKid"> For Kids </label>
							<input type="radio" name="ProductAge" id="ProductAgeKid" value="AgeKid" <?php if (isset($ProductAge) && $ProductAge=="AgeKid") echo "checked";?> />
						</div>
					</div>
					<div id="ProductNameBox">
						<h3>Product Name: * <span class="ErrorDisplay" id="ProductNameError"><?php echo $ProductNameError; ?></span></h3>
						<label for="ProductName">Name</label>
						<input type="text" id="ProductName" name="ProductName" value="<?php echo $ProductName; ?>" />
					</div>
					<div>
						<h3>Add an Image * <span class="ErrorDisplay" id="ProductImageError"><?php echo $ProductImageError; ?></span></h3>
						<label for="ProductImage">Image File</label>			
						<input type="file" name="ProductImage" id="ProductImage" />
						<p>(Only .jpg, .jpeg, .png formats allowed to a max size of 5 MB)</p>
					</div>
					<div>
						<h3>Clothing Type:</h3>
						<div class="FlexBox">
							<div>
								<label for="ProductType">Main Type <span class="ErrorDisplay" id="ProductTypeError"><?php echo $ProductTypeError; ?></span></label>
								<select name="ProductType" id="ProductType">
									<option value="">Please select an option...</option>
									<option value="TypeTop" <?php if (isset($ProductType) && $ProductType=="TypeTop") echo "selected";?>>Top</option>
									<option value="TypeBottom" <?php if (isset($ProductType) && $ProductType=="TypeBottom") echo "selected";?>>Bottom</option>
									<option value="TypeShoe" <?php if (isset($ProductType) && $ProductType=="TypeShoe") echo "selected";?>>Shoe</option>
									<option value="TypeAccessory" <?php if (isset($ProductType) && $ProductType=="TypeAccessory") echo "selected";?>>Accessory</option>
								</select>
							</div>
							<div>		
								<label for="ProductSubtype">Subtype <span class="ErrorDisplay" id="ProductSubtypeError"><?php echo $ProductSubtypeError; ?></span></label>
								<select name="ProductSubtype" id="ProductSubtype">
									<option value="">Please select an option...</option>
									<option value="Bag" <?php if (isset($ProductSubtype) && $ProductSubtype=="Bag") echo "selected";?>>Bag</option>
									<option value="Cape" <?php if (isset($ProductSubtype) && $ProductSubtype=="Cape") echo "selected";?>>Cape</option>
									<option value="Graphic Tee" <?php if (isset($ProductSubtype) && $ProductSubtype=="Graphic Tee") echo "selected";?>>Graphic T-Shirt</option>
									<option value="Jacket" <?php if (isset($ProductSubtype) && $ProductSubtype=="Jacket") echo "selected";?>>Jacket</option>
									<option value="Jeans" <?php if (isset($ProductSubtype) && $ProductSubtype=="Jeans") echo "selected";?>>Jeans</option>
									<option value="Scarf" <?php if (isset($ProductSubtype) && $ProductSubtype=="Scarf") echo "selected";?>>Scarf</option>
									<option value="Slacks" <?php if (isset($ProductSubtype) && $ProductSubtype=="Slacks") echo "selected";?>>Slacks</option>
									<option value="Suit Coat" <?php if (isset($ProductSubtype) && $ProductSubtype=="Suit Coat") echo "selected";?>>Suit Coat</option>
									<option value="Suspenders" <?php if (isset($ProductSubtype) && $ProductSubtype=="Suspenders") echo "selected";?>>Suspenders</option>
									<option value="Sweater" <?php if (isset($ProductSubtype) && $ProductSubtype=="Sweater") echo "selected";?>>Sweater</option>
								</select>
							</div>
						</div>
					</div>
					<div>
						<h3>Brand Name: * <span class="ErrorDisplay" id="ProductBrandError"><?php echo $ProductBrandError; ?></span></h3>
						<label for="BrandAisling"> Aisling </label>
						<input type="radio" name="ProductBrand" id="BrandAisling" value="Aisling" <?php if (isset($ProductBrand) && $ProductBrand=="Aisling") echo "checked";?> />
						<label for="BrandKilig" > Kilig </label>
						<input type="radio" name="ProductBrand" id="BrandKilig" value="Kilig" <?php if (isset($ProductBrand) && $ProductBrand=="Kilig") echo "checked";?> />
						<label for="BrandMagari"> Magari </label>
						<input type="radio" name="ProductBrand" id="BrandMagari" value="Magari" <?php if (isset($ProductBrand) && $ProductBrand=="Magari") echo "checked";?> />
						<label for="BrandRetro"> Retro </label>
						<input type="radio" name="ProductBrand" id="BrandRetro" value="Retro" <?php if (isset($ProductBrand) && $ProductBrand=="Retro") echo "checked";?> />
						<label for="BrandZiba"> Ziba </label>
						<input type="radio" name="ProductBrand" id="BrandZiba" value="Ziba" <?php if (isset($ProductBrand) && $ProductBrand=="Ziba") echo "checked";?> />
					</div>
					<div>
						<h3>Clothing Color: * <span class="ErrorDisplay" id="ProductColorError"><?php echo $ProductColorError; ?></span></h3>
						<label for="ProductColor">Please choose the defining color</label>
						<select name="ProductColor" id="ProductColor">
							<option value="">Please select an option...</option>
							<option value="Black" <?php if (isset($ProductColor) && $ProductColor=="Black") echo "selected";?>>Black</option>
							<option value="Blue" <?php if (isset($ProductColor) && $ProductColor=="Blue") echo "selected";?>>Blue</option>
							<option value="Brown" <?php if (isset($ProductColor) && $ProductColor=="Brown") echo "selected";?>>Brown</option>
							<option value="Cream" <?php if (isset($ProductColor) && $ProductColor=="Cream") echo "selected";?>>Cream</option>
							<option value="Gold" <?php if (isset($ProductColor) && $ProductColor=="Gold") echo "selected";?>>Gold</option>
							<option value="Green" <?php if (isset($ProductColor) && $ProductColor=="Green") echo "selected";?>>Green</option>
							<option value="Grey" <?php if (isset($ProductColor) && $ProductColor=="Grey") echo "selected";?>>Grey</option>
							<option value="Multi" <?php if (isset($ProductColor) && $ProductColor=="Multi") echo "selected";?>>Multi</option>
							<option value="Nude" <?php if (isset($ProductColor) && $ProductColor=="Nude") echo "selected";?>>Nude</option>
							<option value="Orange" <?php if (isset($ProductColor) && $ProductColor=="Orange") echo "selected";?>>Orange</option>
							<option value="Pink" <?php if (isset($ProductColor) && $ProductColor=="Pink") echo "selected";?>>Pink</option>
							<option value="Purple" <?php if (isset($ProductColor) && $ProductColor=="Purple") echo "selected";?>>Purple</option>
							<option value="Red" <?php if (isset($ProductColor) && $ProductColor=="Red") echo "selected";?>>Red</option>
							<option value="Silver" <?php if (isset($ProductColor) && $ProductColor=="Silver") echo "selected";?>>Silver</option>
							<option value="White" <?php if (isset($ProductColor) && $ProductColor=="White") echo "selected";?>>White</option>
							<option value="Yellow" <?php if (isset($ProductColor) && $ProductColor=="Yellow") echo "selected";?>>Yellow</option>
						</select>
					</div>
					<div>
						<h3>Clothing Material: * <span class="ErrorDisplay" id="ProductMaterialError"><?php echo $ProductMaterialError; ?></span></h3>
						<label for="ProductMaterial">Main material</label>
						<select name="ProductMaterial" id="ProductMaterial">
							<option value="">Please select an option...</option>
							<option value="Cotton" <?php if (isset($ProductMaterial) && $ProductMaterial=="Cotton") echo "selected";?>>Cotton</option>
							<option value="Denim" <?php if (isset($ProductMaterial) && $ProductMaterial=="Denim") echo "selected";?>>Denim</option>
							<option value="FauxFur" <?php if (isset($ProductMaterial) && $ProductMaterial=="FauxFur") echo "selected";?>>Faux Fur</option>
							<option value="Leather" <?php if (isset($ProductMaterial) && $ProductMaterial=="Leather") echo "selected";?>>Leather</option>
							<option value="Nylon" <?php if (isset($ProductMaterial) && $ProductMaterial=="Nylon") echo "selected";?>>Nylon</option>
							<option value="Polyester" <?php if (isset($ProductMaterial) && $ProductMaterial=="Polyester") echo "selected";?>>Polyester</option>
							<option value="Silk" <?php if (isset($ProductMaterial) && $ProductMaterial=="Silk") echo "selected";?>>Silk</option>
							<option value="Wool" <?php if (isset($ProductMaterial) && $ProductMaterial=="Wool") echo "selected";?>>Wool</option>
						</select>
					</div>
					<div class="FlexBox">
						<div>
							<h3>Product Price: * <span class="ErrorDisplay" id="ProductPriceError"><?php echo $ProductPriceError; ?></span></h3>						
							<label for="ProductPrice">Cost $</label>
							<input type="number" name="ProductPrice" id="ProductPrice" step="0.05" max="2500" value="<?php echo $ProductPrice; ?>" />
							<p>(Must be in increments of $.05)</p>
						</div>
						<div>
							<h3>Product Quantity: * <span class="ErrorDisplay" id="ProductQuantityError"><?php echo $ProductQuantityError; ?></span></h3>
							<label for="ProductQuantity">Inventory</label>
							<input type="number" name="ProductQuantity" id="ProductQuantity" min="0" max="500" value="<?php echo $ProductQuantity; ?>" />
						</div>
					</div>
<?php
if ($UpdateRecordID > 0) {
?>
					<input class="BorderButton4 SpecialButton" type="button" name="SubmitButton" id="SubmitButton" value="Update" />
<?php
}
else {
?>
					<input class="BorderButton4 SpecialButton" type="button" name="SubmitButton" id="SubmitButton" value="Submit" />
<?php
}
?>
				</form>
			</div>
<?php
}
?>
		</main>

		<?php include "GeekStyleFooter.php"; ?>
	</div>	

</body>
</html>