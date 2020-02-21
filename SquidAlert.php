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
			height: 100vh;
			overflow: hidden;
			position: relative;
		}
		
		.SpecialSquid {
			cursor: pointer;
		}
		
		.Squid1, .Squid3, .Squid5, .Squid7 {
			animation-name: moveItRight;
			animation-duration: 15s;
			animation-iteration-count: infinite;
			animation-timing-function: linear;
			height: 105px;
			left: -105px;
			object-fit: contain;
			position: absolute;
			top: -10vh;	
			width: 105px;
		}
		.Squid2, .Squid4, .Squid6 {
			animation-name: moveItLeft;
			animation-duration: 15s;
			animation-iteration-count: infinite;
			animation-timing-function: linear;
			height: 105px;
			right: -105px;
			object-fit: contain;
			position: absolute;
			top: 10vh;			
			width: 105px;
		}
		.Squid3 {
			top: 30vh;			
		}
		.Squid4 {
			top: 50vh;			
		}
		.Squid5 {
			top: 70vh;			
		}
		.Squid6 {
			top: 90vh;			
		}
		.Squid7 {
			top: 110vh;			
		}
		
		.Delay1 {
			animation-delay: 0;
		}
		.Delay2 {
			animation-delay: 1.5s;
		}
		.Delay3 {
			animation-delay: 3s;
		}
		.Delay4 {
			animation-delay: 4.5s;
		}
		.Delay5 {
			animation-delay: 6s;
		}
		.Delay6 {
			animation-delay: 7.5s;
		}
		.Delay7 {
			animation-delay: 9s;
		}
		.Delay8 {
			animation-delay: 10.5s;
		}
		.Delay9 {
			animation-delay: 12s;
		}
		.Delay10 {
			animation-delay: 13.5s;
		}		
		
		@keyframes moveItRight {
			from {
				transform: translateX(0px);
			}
			to {
				transform: translateX(110vw);
			}		
		}
		
		@keyframes moveItLeft {
			from {
				transform: translateX(0px);
			}
			to {
				transform: translateX(-110vw);
			}		
		}
				
		@media only screen and (min-width: 480px) and (max-width: 767px) {
		}
		@media only screen and (min-width: 768px) {
		}
	</style>
	
	<script src="#"></script>
	<script>
		
		document.querySelector(".SpecialSquid").onclick = function () {
			location.href = './GeekStyleIndex.php';
		};
		
	</script>
</head>

<body onload="setupJavascript();">
<!--
	<div class="PageBox">
		<?php include "GeekStyleHeader.php"; ?>
-->

		<main>
			<img class="Squid1 Delay1" src="images/SquidFriendNoShadow.png" />
			<img class="Squid1 Delay2" src="images/SquidFriendNoShadow.png" />
			<img class="Squid1 Delay3" src="images/SquidFriendNoShadow.png" />
			<img class="Squid1 Delay4" src="images/SquidFriendNoShadow.png" />
			<img class="Squid1 Delay5" src="images/SquidFriendNoShadow.png" />
			<img class="Squid1 Delay6" src="images/SquidFriendNoShadow.png" />
			<img class="Squid1 Delay7" src="images/SquidFriendNoShadow.png" />
			<img class="Squid1 Delay8" src="images/SquidFriendNoShadow.png" />
			<img class="Squid1 Delay9" src="images/SquidFriendNoShadow.png" />
			<img class="Squid1 Delay10" src="images/SquidFriendNoShadow.png" />
			
			<img class="Squid2 Delay1" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid2 Delay2" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid2 Delay3" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid2 Delay4" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid2 Delay5" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid2 Delay6" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid2 Delay7" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid2 Delay8" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid2 Delay9" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid2 Delay10" src="images/SquidFriendNoShadowFlip.png" />

			<img class="Squid3 Delay1" src="images/SquidFriendNoShadow.png" />
			<img class="Squid3 Delay2" src="images/SquidFriendNoShadow.png" />
			<img onclick="location.href='GeekStyleIndex.php'" class="SpecialSquid Squid3 Delay3" src="images/SquidFriendNoShadowColor.png" />
			<img class="Squid3 Delay4" src="images/SquidFriendNoShadow.png" />
			<img class="Squid3 Delay5" src="images/SquidFriendNoShadow.png" />
			<img class="Squid3 Delay6" src="images/SquidFriendNoShadow.png" />
			<img class="Squid3 Delay7" src="images/SquidFriendNoShadow.png" />
			<img class="Squid3 Delay8" src="images/SquidFriendNoShadow.png" />
			<img class="Squid3 Delay9" src="images/SquidFriendNoShadow.png" />
			<img class="Squid3 Delay10" src="images/SquidFriendNoShadow.png" />
			
			<img class="Squid4 Delay1" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid4 Delay2" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid4 Delay3" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid4 Delay4" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid4 Delay5" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid4 Delay6" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid4 Delay7" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid4 Delay8" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid4 Delay9" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid4 Delay10" src="images/SquidFriendNoShadowFlip.png" />
			
			<img class="Squid5 Delay1" src="images/SquidFriendNoShadow.png" />
			<img class="Squid5 Delay2" src="images/SquidFriendNoShadow.png" />
			<img class="Squid5 Delay3" src="images/SquidFriendNoShadow.png" />
			<img class="Squid5 Delay4" src="images/SquidFriendNoShadow.png" />
			<img class="Squid5 Delay5" src="images/SquidFriendNoShadow.png" />
			<img class="Squid5 Delay6" src="images/SquidFriendNoShadow.png" />
			<img class="Squid5 Delay7" src="images/SquidFriendNoShadow.png" />
			<img class="Squid5 Delay8" src="images/SquidFriendNoShadow.png" />
			<img class="Squid5 Delay9" src="images/SquidFriendNoShadow.png" />
			<img class="Squid5 Delay10" src="images/SquidFriendNoShadow.png" />
			
			<img class="Squid6 Delay1" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid6 Delay2" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid6 Delay3" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid6 Delay4" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid6 Delay5" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid6 Delay6" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid6 Delay7" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid6 Delay8" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid6 Delay9" src="images/SquidFriendNoShadowFlip.png" />
			<img class="Squid6 Delay10" src="images/SquidFriendNoShadowFlip.png" />

			<img class="Squid7 Delay1" src="images/SquidFriendNoShadow.png" />
			<img class="Squid7 Delay2" src="images/SquidFriendNoShadow.png" />
			<img class="Squid7 Delay3" src="images/SquidFriendNoShadow.png" />
			<img class="Squid7 Delay4" src="images/SquidFriendNoShadow.png" />
			<img class="Squid7 Delay5" src="images/SquidFriendNoShadow.png" />
			<img class="Squid7 Delay6" src="images/SquidFriendNoShadow.png" />
			<img class="Squid7 Delay7" src="images/SquidFriendNoShadow.png" />
			<img class="Squid7 Delay8" src="images/SquidFriendNoShadow.png" />
			<img class="Squid7 Delay9" src="images/SquidFriendNoShadow.png" />
			<img class="Squid7 Delay10" src="images/SquidFriendNoShadow.png" />
		</main>

<!--
		<?php include "GeekStyleFooter.php"; ?>
	</div>	
-->
</body>
</html>