<?php
	$UpdateRecordID = $_GET['RecordID'];

	include("connectPDO.php");

	try {
		$sql = "DELETE FROM GeekStyle_Products WHERE Prod_ID=$UpdateRecordID";
		$conn->exec($sql);		
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
			flex-direction: column;
			justify-content: center;
			margin: 100px 0 400px 0;
		}
		
		main h1 {
			margin-bottom: var(--margin-3);
		}
		
		main h2 {
			margin-bottom: 30px;
		}
		
		.SpecialButton {
			font-size: 1.5em;
			padding: 15px 30px;
			text-align: center;
		}
		
		@media only screen and (min-width: 480px) and (max-width: 767px) {
		}
		@media only screen and (min-width: 768px) {
		}
	</style>
</head>
	
<body>

	<div class="PageBox">	
		<?php include "GeekStyleHeader.php"; ?>

		<main>
			<h1>Thanks for being awesome!</h1>
			<h2>Your entry has been DELETED.</h2>
			<a class="BorderButton2 SpecialButton" href="./GeekStyleProductDisplay.php"><p>Update/Delete <br/> Products</p></a>
		</main>

		<?php include "GeekStyleFooter.php"; ?>
	</div>

</body>
</html>	