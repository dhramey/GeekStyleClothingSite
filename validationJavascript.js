var ValidForm = "";

//Basic Number Validation
function BasicNumberValidation(InInputID, InErrorID) {
	document.querySelector(InErrorID).innerHTML = "";

	var InputValue = document.querySelector(InInputID).value;
	InputValue = InputValue.trim();

	if (!InputValue) {
		ValidForm = false;
		document.querySelector(InErrorID).innerHTML = "Please enter a number";
	}
	if (/undefined|null/i.test(InputValue)) {
		ValidForm = false;
		document.querySelector(InErrorID).innerHTML = "Cannont be Null or Undefined";
	}
	
	InputValue = parseFloat(InputValue);
	
	if (isNaN(InputValue) && !isFinite(InputValue)) {
		ValidForm = false;
		document.querySelector(InErrorID).innerHTML = "Please enter a number";		
	}
}

//Basic Text Validation
function BasicTextValidation(InNameID, InErrorID) {
	document.querySelector(InErrorID).innerHTML = "";

	var NameInput = document.querySelector(InNameID).value;
	NameInput = NameInput.trim();

	if (!NameInput) {
		ValidForm = false;
		document.querySelector(InErrorID).innerHTML = "Please enter text here";
	}
	if (/undefined|null/i.test(NameInput)) {
		ValidForm = false;
		document.querySelector(InErrorID).innerHTML = "Cannont be Null or Undefined";
	}
	if (/[<>']/.test(NameInput)) {
		ValidForm = false;
		document.querySelector(InErrorID).innerHTML = "Cannont contain symbols: < > ' ";
	}
}

//Drop Down Validation
function DropdownValidation (InSelectID, InErrorID) {
	document.querySelector(InErrorID).innerHTML = "";

	var SelectIndex = document.querySelector(InSelectID).selectedIndex;
	
	if(SelectIndex <= 0) {
		ValidForm = false;
		document.querySelector(InErrorID).innerHTML = "Please select an option";		
	}
}

//Email Validation
function EmailValidation(InEmailID, InErrorID) {
	document.querySelector(InErrorID).innerHTML = "";

	var EmailInput = document.querySelector(InEmailID).value;
	EmailInput = EmailInput.trim();

	if (!EmailInput) {
		ValidForm = false;
		document.querySelector(InErrorID).innerHTML = "Please enter your Email";
	}
	if (!(/(?!.*\.{2})^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i.test(EmailInput))) {
		ValidForm = false;
		document.querySelector(InErrorID).innerHTML = "Please enter a valid Email";	   
	}
}

//Email Confirmation Validation
function ConfirmEmailValidation(InConfirmEmailID, InOriginalEmailID, InErrorID) {
	document.querySelector(InErrorID).innerHTML = "";
	
	var ConfirmEmailInput = document.querySelector(InConfirmEmailID).value;
	ConfirmEmailInput = ConfirmEmailInput.trim();
	
	var OriginalEmailInput = document.querySelector(InOriginalEmailID).value;
	OriginalEmailInput = OriginalEmailInput.trim();
	
	if (ConfirmEmailInput !== OriginalEmailInput) {
		ValidForm = false;
		document.querySelector(InErrorID).innerHTML = "Email does not match";
	}
}

//Image Upload Validation
function ImageUploadValidation(InInputID, InErrorID) {
	document.querySelector(InErrorID).innerHTML = "";
	
	var ImageUploadInput = document.querySelector(InInputID).value;
	var FileExtension = ImageUploadInput.substring(ImageUploadInput.lastIndexOf('.') + 1).toLowerCase();
	
	if(!ImageUploadInput) {
		ValidForm = false;
		document.querySelector(InErrorID).innerHTML = "Please upload a file";		
	}
	else if (!(FileExtension == "jpg" || FileExtension == "jpeg" || FileExtension == "png")) {
		ValidForm = false;
		document.querySelector(InErrorID).innerHTML = "Please upload a correct file type";		
	}
}

//Inventory Validation
function InventoryValidation(InInputID, InErrorID) {
	document.querySelector(InErrorID).innerHTML = "";

	var InputValue = document.querySelector(InInputID).value;
	InputValue = InputValue.trim();

	if (!InputValue) {
		ValidForm = false;
		document.querySelector(InErrorID).innerHTML = "Please enter a number";
	}
	if (/undefined|null/i.test(InputValue)) {
		ValidForm = false;
		document.querySelector(InErrorID).innerHTML = "Cannont be Null or Undefined";
	}
	
	InputValue = parseFloat(InputValue);
	
	if (isNaN(InputValue) && !isFinite(InputValue)) {
		ValidForm = false;
		document.querySelector(InErrorID).innerHTML = "Please enter a number";		
	}
	if (InputValue < 0) {
		ValidForm = false;
		document.querySelector(InErrorID).innerHTML = "Please enter a positive number";		
	}
	if (!Number.isInteger(InputValue)) {
		ValidForm = false;
		document.querySelector(InErrorID).innerHTML = "Please enter a whole number";
	}
}

//Price Validation
function PriceValidation(InInputID, InErrorID) {
	document.querySelector(InErrorID).innerHTML = "";

	var InputValue = document.querySelector(InInputID).value;
	InputValue = InputValue.trim();

	if (!InputValue) {
		ValidForm = false;
		document.querySelector(InErrorID).innerHTML = "Please enter a number";
	}
	if (/undefined|null/i.test(InputValue)) {
		ValidForm = false;
		document.querySelector(InErrorID).innerHTML = "Cannont be Null or Undefined";
	}
	
	InputValue = parseFloat(InputValue);
	
	if (isNaN(InputValue) && !isFinite(InputValue)) {
		ValidForm = false;
		document.querySelector(InErrorID).innerHTML = "Please enter a number";		
	}
	if (InputValue < 0) {
		ValidForm = false;
		document.querySelector(InErrorID).innerHTML = "Please enter a positive number";		
	}
}

//Radio Button Validation **********IMPROVE THIS**********
function RadioButtonValidation(InInputName, InErrorID) {
//	alert("In function RadioButtonValidation();");
	
	document.querySelector(InErrorID).innerHTML = "";
	
	var RadioObject = document.querySelector("input" + InInputName + ":checked");

//	var RadioCheckedValue = document.querySelector(InInputName).value;
//	alert("The value of the checked radio button is: " + RadioCheckedValue);	
	
	if (RadioObject === null) {
		ValidForm = false;
		document.querySelector(InErrorID).innerHTML = "Please make a selection";
	}
}