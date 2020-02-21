<?php
	session_cache_limiter('none');
	session_start();

	include("connectPDO.php");

	//Check if User is already Logged In
	if (isset($_SESSION['ValidUser']) && $_SESSION['ValidUser'] === true && $_SESSION['AdminFlag'] === Y) {
		header("Location: ./GeekStyleAdminFunctions.php");
		exit();
	}
	elseif (isset($_SESSION['ValidUser']) && $_SESSION['ValidUser'] === true) {
		header("Location: ./GeekStyleIndex.php");
		exit();
	}
	else {
		//Check if User has account and log them in
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			try {
				$InUserEmail = $_POST['UserEmail'];
				$InUserPassword = $_POST['UserPassword'];
				
				//Run Validation
				include("validationClassPHP.php");
				$RunValidation = new validation();

				//Clean Text Input
				$InUserEmail = $RunValidation->CleanSpecialCharacters($InUserEmail);
				$InUserPassword = $RunValidation->CleanSpecialCharacters($InUserPassword);
				
				//Check Database for User
				$sql = "SELECT User_Name, User_Email, User_Password, User_Admin_Flag FROM GeekStyle_Users WHERE User_Email = :UserEmail AND User_Password = :UserPassword";			

				$query = $conn->prepare($sql);

				$query->bindParam(":UserEmail", $InUserEmail);
				$query->bindParam(":UserPassword", $InUserPassword);

				$query->execute();
				
				$query->setFetchMode(PDO::FETCH_ASSOC);

			}
			catch(PDOException $e) {
//				echo "Error: " . $e->getMessage();
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
			
			if ($query->rowCount() == 1) {
				$_SESSION['ValidUser'] = true;
				
				while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
					$_SESSION['UserName'] = $data['User_Name'];
					$_SESSION['AdminFlag'] = $data['User_Admin_Flag'];
				}
				if (isset($_SESSION['ValidUser']) && $_SESSION['ValidUser'] === true && $_SESSION['AdminFlag'] === Y) {
					header("Location: ./GeekStyleAdminFunctions.php");
					exit();
				}
				else {
					header("Location: ./GeekStyleIndex.php");
					exit();
				}		
			}
			else {
				$_SESSION['ValidUser'] = false;
				$LoginError =
					"<div class='LoginErrorBox'>
						Sorry, there was a problem with your username or password. Please try again!
					</div>";
			}
			
			$query = null;
			$connection = null;
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
			margin: 100px 120px;
		}
		
		.LoginErrorBox {
			border: solid medium var(--color-2);
			color: var(--color-2);
			padding: 15px;
			margin-bottom: 20px;
		}
		
		.LoginBox {
			background-color: var(--color-2);
			color: var(--color-neutral-1);
			display: flex;
			flex-direction: row;
			overflow: hidden;
			padding: 50px 0;
			position: relative;
		}
		.LoginBox h2 {
			letter-spacing: 1.5px;
			margin-bottom: var(--margin-3);
		}
		
		.SignInFormBox {
			align-items: center;
			display: flex;
			color: var(--color-neutral-2);
			flex-basis: 50%;
			flex-direction: column;
			z-index: 1;
		}
		.SignInForm {
			align-items: center;
			display: flex;
			flex-direction: column;
		}
		.SignInForm label {
			font-size: 1.1em;
			margin-bottom: var(--margin-1);
		}
		.SignInForm input {
			font-size: .9em;
			margin-bottom: var(--margin-2);
			padding: 10px;
			width: 300px;
		}
		.SignInForm input:nth-of-type(2) {
			margin-bottom: var(--margin-3);
		}

		.NewUserBox {
			align-items: center;
			display: flex;
			flex-direction: column;
			flex-basis: 50%;
			z-index: 1;
		}
		
		.LoginBoxBackground {
			background-color: var(--color-1);
			bottom: 0;
			height: 100%;
			position: absolute;
			right: -100px;
			transform: skewX(-20deg);
			width: 60%;
		}
		
		.SpecialButton, input.SpecialButton {
			cursor: pointer;
			font-family: var(--font-family-1);
			font-size: 1.3em;
			padding: 20px;
			text-align: center;
			width: 225px;
		}
				
		@media only screen and (min-width: 480px) and (max-width: 767px) {
		}
		@media only screen and (min-width: 768px) {
		}
	</style>
	
	<script src="validationJavascript.js"></script>
	<script>
		
		function setupJavascript() {
			
			document.querySelector("#UserEmail").onblur = function() {
				EmailValidation("#UserEmail", "#UserEmailError");
			};
			
			document.querySelector("#SubmitButton").onclick = function() {
				ValidForm = true;
				
				EmailValidation("#UserEmail", "#UserEmailError");
				
				if(ValidForm) {
					document.querySelector("#SignInFormID").submit();
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
			<span><?php echo $LoginError; ?></span>

			<div class="LoginBox">
				<div class="SignInFormBox">
					<h2>Well hi there!</h2>
					<form class="SignInForm" id="SignInFormID" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
						<label for="UserEmail">E-mail please</label>
						<span class="ErrorDisplay" id="UserEmailError"></span>
						<input type="email" id="UserEmail" name="UserEmail" />

						<label for="UserPassword">Password please</label>
						<input type="password" id="UserPassword" name="UserPassword" />

						<input class="BorderButton3 SpecialButton" type="submit" id="SubmitButton" name="SubmitButton" value="Sign in time &#9786;" />
					</form>
				</div>
				<div class="NewUserBox">
					<h2>Join the Squids</h2>
					<a class="BorderButton4 SpecialButton" href="javascript:void(0);">
						<div>Create Account &#9786;</div>
					</a>
				</div>
				<div class="LoginBoxBackground">&nbsp;</div>
			</div>
		</main>

		<?php include "GeekStyleFooter.php"; ?>
	</div>	

</body>
</html>