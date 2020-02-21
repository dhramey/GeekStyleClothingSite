<?php
	class validation {
	
		public function __construct() {
			//empty constructor with no functionality
		}
		
		public function CleanSpecialCharacters($InValue) {
			$InValue = htmlspecialchars($InValue);
			$InValue = filter_var($InValue, FILTER_SANITIZE_SPECIAL_CHARS);
			return $InValue;
		}
		public function CleanNumberIntegers($InValue) {
			$InValue = filter_var($InValue, FILTER_SANITIZE_NUMBER_INT);
			return $InValue;
		}
		public function CleanNumberFloats($InValue) {
			$InValue = filter_var($InValue, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
			return $InValue;
		}		
		
		
		//check if value is not spaces, "", 0, 0.0, "0", null, false, array()
		public function NotEmpty($InValue) {
			$InValue = trim($InValue);
			if( empty($InValue) ) {
				return true;
			}
		}
		
		public function NotNullOrUndefined($InValue) {
			if(preg_match("/undefined|null/i", $InValue) ) {
				return true;
			}
		}

		public function IsNumber($InValue) {
			$InValue = trim($InValue);
			
			if( !$InValue == "" && !is_numeric($InValue) ) {
				return true;
			}
		}
		public function InventoryValidation($InValue) {
			$InValue = trim($InValue);
			$InValue = filter_var($InValue, FILTER_VALIDATE_INT);
			if($InValue < 0 || !is_numeric($InValue)) {
				return true;
			}
		}
		public function PriceValidation($InValue) {
			$InValue = trim($InValue);
			$InValue = filter_var($InValue, FILTER_VALIDATE_FLOAT);
			if($InValue <= 0 || !is_numeric($InValue)) {
				return true;
			}
		}
		
		public function ValidatePhoneCharacters($InValue) {
			if( preg_match("/[-\(\)]/", $InValue) ) {
				return true;
			}
		}
		
		public function ValidatePhoneLength($InValue) {
			if( strlen($InValue) > 0 && strlen($InValue) < 10 ) {
				return true;
			}
		}
	
		public function ValidateEmail($InEmail) {			
			$InEmail = filter_var($InEmail, FILTER_SANITIZE_EMAIL);	//clean entered value
			$InEmail = filter_var($InEmail, FILTER_VALIDATE_EMAIL);	//validate format
			if(!$InEmail) {
				return true;
			}
		}
		
		public function ConfirmEmail($InConfirmEmail, $InOriginalEmail) {
			$InConfirmEmail = trim($InConfirmEmail);
			$InOriginalEmail = trim($InOriginalEmail);

			if ($InConfirmEmail !== $InOriginalEmail) {
				return true;
			}
		}
		
		public function SelectionRequired($InValue) {
			if(!$InValue) {
				return true;
			}
		}
		
		public function CharacterLengthLessThan200($InValue) {
			if( strlen($InValue) > 200 ) {
				return true;
			}
		}
	}
?>