<?php
	class Emailer {

		private $emailMessage;
		private $sentFromAddress;
		private $sentFromName;
		private $sentToAddress;
		private $subjectLine;
	
		public function __construct() {
		}
		
		// SETTERS
		public function set_emailMessage($inEmailMessage) {
			$this->emailMessage = $inEmailMessage;
		}
		public function set_sentFromAddress($inSentFromAddress) {
			$this->sentFromAddress = $inSentFromAddress;
		}
		public function set_sentFromName($inSentFromName) {
			$this->sentFromName = $inSentFromName;
		}
		public function set_sentToAddress($inSentToAddress) {
			$this->sentToAddress = $inSentToAddress;
		}
		public function set_subjectLine($inSubjectLine) {
			$this->subjectLine = $inSubjectLine;
		}
		
		//GETTERS
		public function get_emailMessage() {
			return $this->emailMessage;
		}
		public function get_sentFromAddress() {
			return $this->sentFromAddress;
		}
		public function get_sentFromName() {
			return $this->sentFromName;
		}
		public function get_sentToAddress() {
			return $this->sentToAddress;
		}
		public function get_subjectLine() {
			return $this->subjectLine;
		}
		
		//Send Email
		public function sendEmail() {
			$to = $this->sentToAddress;
			$subject = $this->subjectLine;
			
			$message = "GeekStyle Message: \r\n \r\n" . $this->emailMessage;
			$message = wordwrap($message, 70, "\r\n");
			
			$headers = "From: " . $this->sentFromAddress . "\r\n";

			return mail($to, $subject, $message, $headers);
			
//			if($result) {
//				echo "<b> Mail sent successfully </b>";
//				$emailAlert = "Your Email was successfully sent";
//				echo "<script type='text/javascript'>alert('$emailAlert');</script>";
//			}
//			else {
//				echo "<b> Mail not sent </b>";
//			}
		}
	}
?>