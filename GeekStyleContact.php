<?php
	session_cache_limiter('none');
	session_start();

	$ValidForm = false;

	$UserName = "";
	$UserEmail = "";
	$ConfirmEmail = "";
	$UserMessage = "";

	$UserNameError = "";
	$UserEmailError = "";
	$ConfirmEmailError = "";
	$UserMessageError = "";

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if ($_POST['UserMembership'] != '' || $_POST['UserSubject'] != '') {
			header("Location: ./GeekStyleIndex.php");
			exit();
		};
		
		$ValidForm = true;
		
		$UserName = $_POST['UserName'];
		$UserEmail = $_POST['UserEmail'];
		$ConfirmEmail = $_POST['ConfirmEmail'];
		$UserMessage = $_POST['UserMessage'];
		
		$UserNameError = "";
		$UserEmailError = "";
		$ConfirmEmailError = "";
		$UserMessageError = "";
		
		//Run Validation
		include("validationClassPHP.php");
		$RunValidation = new validation();
		
		//Clean Text Input
		$UserName = $RunValidation->CleanSpecialCharacters($UserName);
		$UserMessage = $RunValidation->CleanSpecialCharacters($UserMessage);
		
		//UserName Validation
		if ($RunValidation->NotEmpty($UserName) ) {
			$ValidForm = false;
			$UserNameError = "Please enter text here";
		}
		if ($RunValidation->NotNullOrUndefined($UserName) ) {
			$ValidForm = false;
			$UserNameError = "Invalid entry, please enter text here";
		}
		
		//UserEmail Validation
		if ($RunValidation->NotEmpty($UserEmail) ) {
			$ValidForm = false;
			$UserEmailError = "Please enter email";
		}
		if ($RunValidation->ValidateEmail($UserEmail) ) {
			$ValidForm = false;
			$UserEmailError = "Invalid entry, please enter email";
		}
		
		//ConfirmEmail Validation
		if ($RunValidation->NotEmpty($ConfirmEmail) ) {
			$ValidForm = false;
			$ConfirmEmailError = "Please enter email";
		}
		if ($RunValidation->ValidateEmail($ConfirmEmail) ) {
			$ValidForm = false;
			$ConfirmEmailError = "Invalid entry, please enter email";
		}
		if ($RunValidation->ConfirmEmail($ConfirmEmail, $UserEmail) ) {
			$ValidForm = false;
			$ConfirmEmailError = "Email does not match";
		}		
		
		//UserMessage Validation
		if ($RunValidation->NotEmpty($UserMessage) ) {
			$ValidForm = false;
			$UserMessageError = "Please enter text here";
		}
		if ($RunValidation->NotNullOrUndefined($UserMessage) ) {
			$ValidForm = false;
			$UserMessageError = "Invalid entry, please enter text here";
		}
		
		//Send Email to Company
		include("emailerClass.php");
		
		if ($ValidForm) {
			$ContactUsEmail = new Emailer();

			$ContactUsEmail->set_sentToAddress("d.h.ramey@isunet.net");
			$ContactUsEmail->set_sentFromAddress("web@dramey.info");
			$ContactUsEmail->set_subjectLine("GeekStyle Customer Message");	
			$ContactUsEmail->set_emailMessage($UserMessage);
			$ContactUsEmail->set_sentFromName($UserName);
			
			$ContactUsEmail->sendEmail();		
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
			margin: 60px 120px;
		}
		
		.FormSubmittedBox {
			text-align: center;
		}
		.FormSubmittedBox h1, .FormSubmittedBox h2, .FormSubmittedBox h3 {
			margin-bottom: var(--margin-3);
		}
		.FormSubmittedBox a {
			font-size: 1.75em;
		}
		
		.ContactBox {
			align-items: center;
			background-color: var(--color-2);
			color: var(--color-neutral-2);
			display: flex;
			flex-direction: column;
			overflow: hidden;
			padding: 30px 0;
			position: relative;
		}
		.ContactFormBox {
			width: 50%;
			z-index: 1;
		}
		.ContactFormBox h1 {
			margin-bottom: var(--margin-3);
		}
		.ContactForm {
			display: flex;
			flex-direction: column;
		}
		.ContactForm label {
			font-size: 1.1em;
			margin-bottom: 5px;
		}
		.ContactForm input {
			font-size: .9em;
			margin-bottom: var(--margin-2);
			padding: 5px;
		}
		.ContactForm textarea {
			font-size: 1.1em;
			margin-bottom: var(--margin-3);
			padding: 5px;
		}
		.ContactForm #SubmitButton {
			align-self: flex-end;
			cursor: pointer;
			font-size: 1.25em;
			padding: 10px 40px;
			text-align: center;
		}
		.ContactForm #UserMembership, .ContactForm [for=UserSubject], .ContactForm #UserSubject {
			display: none;
		}
		
		.ContactBackgroundTopLeft, .ContactBackgroundBottomLeft, .ContactBackgroundTopRight, .ContactBackgroundBottomRight {
			background-color: var(--color-neutral-2);
			height: 100%;
			position: absolute;
			width: 200px;			
		}
		.ContactBackgroundTopLeft {
			left: -200px;
			top: 0;
			transform: skewX(-20deg);
		}
		.ContactBackgroundBottomLeft {
			bottom: 0;
			left: -200px;
			transform: skewX(20deg);
		}
		.ContactBackgroundTopRight {
			right: -200px;
			top: 0;
			transform: skewX(20deg);		
		}
		.ContactBackgroundBottomRight {
			bottom: 0;
			right: -200px;
			transform: skewX(-20deg);			
		}
		
		.ErrorDisplay {
			color: var(--color-neutral-1);
		}
				
		@media only screen and (min-width: 480px) and (max-width: 767px) {
		}
		@media only screen and (min-width: 768px) {
		}
	</style>
	
	<script src="validationJavascript.js"></script>
	<script>
		
		function setupJavascript() {			
			document.querySelector("#UserName").onblur = function() {
				BasicTextValidation("#UserName", "#UserNameError");
			};
			document.querySelector("#UserEmail").onblur = function() {
				EmailValidation("#UserEmail", "#UserEmailError");
			};
			document.querySelector("#ConfirmEmail").onblur = function() {
				ConfirmEmailValidation("#ConfirmEmail", "#UserEmail", "#ConfirmEmailError");
			};
			document.querySelector("#UserMessage").onblur = function() {
				BasicTextValidation("#UserMessage", "#UserMessageError");
			};
			
			document.querySelector("#SubmitButton").onclick = function() {
				ValidForm = true;
				
				BasicTextValidation("#UserName", "#UserNameError");
				EmailValidation("#UserEmail", "#UserEmailError");
				ConfirmEmailValidation("#ConfirmEmail", "#UserEmail", "#ConfirmEmailError");
				BasicTextValidation("#UserMessage", "#UserMessageError");
				
				if(ValidForm) {
					alert("Valid form will be submitted");	
					document.querySelector("#ContactFormID").submit();
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
if($ValidForm) {
?>
			<div class="FormSubmittedBox">
				<h1>Thanks for being awesome!</h1>
				<h3>
					We appreciate you taking the time to contact us and will be in touch shortly. <br/>
					A follow-up will be sent to: <?php echo $UserEmail ?>
				</h3>
				<h2>Have a lovely day!</h2>
				<h4><a class="BorderButton2" href="./GeekStyleIndex.php">Home</a></h4>
			</div>
<?php
}
else {
?>	
			<div class="ContactBox">
				<div class="ContactFormBox">
					<h1>Contact Us</h1>
					<form class="ContactForm" id="ContactFormID" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">

						<label for="UserName">Name * 
							<span class="ErrorDisplay" id="UserNameError"><?php echo $UserNameError; ?></span>
						</label>
						<input  type="text" id="UserName" name="UserName" value="<?php echo $UserName; ?>" />

						<div id="UserMembership">
							<label for="UserMembership">Are you a member? * <span class="ErrorDisplay" id="UserMembershipError"></span></label> <br/>
							<input  type="radio" name="UserMembership" value="YesMember" /> Yes
							<input  type="radio" name="UserMembership" value="NotMember" /> No
						</div>

						<label for="UserEmail">Email * 
							<span class="ErrorDisplay" id="UserEmailError"><?php echo $UserEmailError; ?></span>
						</label>
						<input type="email" id="UserEmail" name="UserEmail" value="<?php echo $UserEmail; ?>" />

						<label for="ConfirmEmail">Confirm Email * 
							<span class="ErrorDisplay" id="ConfirmEmailError"><?php echo $ConfirmEmailError; ?></span>
						</label>
						<input type="email" id="ConfirmEmail" name="ConfirmEmail" value="<?php echo $ConfirmEmail; ?>" />

						<label for="UserSubject">Subject * <span class="ErrorDisplay" id="UserSubjectError"></span></label>
						<input type="text" id="UserSubject" name="UserSubject" />

						<label for="UserMessage">Message * 
							<span class="ErrorDisplay" id="UserMessageError"><?php echo $UserMessageError; ?></span>
						</label>
						<textarea id="UserMessage" name="UserMessage" cols="40" rows="5" maxlength="2000"><?php echo $UserMessage; ?></textarea>

						<input class="BorderButton3" type="button" id="SubmitButton" name="SubmitButton" value="Submit" />
					</form>
				</div>
				<div class="ContactBackgroundTopLeft">&nbsp;</div>
				<div class="ContactBackgroundBottomLeft">&nbsp;</div>
				<div class="ContactBackgroundTopRight">&nbsp;</div>
				<div class="ContactBackgroundBottomRight">&nbsp;</div>
			</div>
<?php
}
?>
		</main>

		<?php include "GeekStyleFooter.php"; ?>
	</div>

</body>
</html>