<?php
	session_cache_limiter('none');
	session_start();

	echo "<div id='top'></div>";

	echo "<header>";
		echo "<div class='HeaderBox'>";
			echo "<div class='HeaderSearch'>";
				echo "<label for='SearchBox'>Search</label>";
				echo "<input type='search' id='SearchBox' name='SearchBox' />";
			echo "</div>";

			echo "<div class='HeaderTitle'>";
				echo "<a href='./GeekStyleIndex.php'>";
					echo "<h1>GeekStyle</h1>";
				echo "</a>";
			echo "</div>";

			echo "<div class='HeaderIcons'>";

				if (isset($_SESSION['ValidUser']) && $_SESSION['ValidUser'] === true && $_SESSION['AdminFlag'] === Y) {
					echo "<div class='HeaderUserName'>Hi &nbsp;" . $_SESSION['UserName'] . " Admin</div>";
					echo "<a href='./GeekStyleLogout.php' style='border:solid thin black; font-size: .4em; padding: 3px;'>Logout</a>";
				}
				elseif (isset($_SESSION['ValidUser']) && $_SESSION['ValidUser'] === true) {
					echo "<div class='HeaderUserName'>Hi &nbsp;" . $_SESSION['UserName'] . "</div>";
					echo "<a href='./GeekStyleLogout.php' style='border:solid thin black; font-size: .4em; padding: 3px;'>Logout</a>";
				}

				echo "<a href='./GeekStyleLogin.php' style='font-size: .95em;'> &#9786; </a>";
				echo "<a href='javascript:void(0);'> &#10084; </a>";
				echo "<a href='javascript:void(0);'> &#8852; </a>";
			echo "</div>";

			echo "<div class='HeaderDesign'>";
				echo "<div>&nbsp;</div>";
				echo "<div>&nbsp;</div>";
			echo "</div>";
		echo "</div>";

		if (isset($_SESSION['ValidUser']) && $_SESSION['ValidUser'] === true && $_SESSION['AdminFlag'] == Y) {
			echo "<div class='AdminBox'>";
				echo "<h2>You have ADMIN Super Powers!</h2>";
				echo "<a class='BorderButton3' href='./GeekStyleProductDisplay.php'>Products</a>";
				echo "<a class='BorderButton3' href='./GeekStyleProductControl.php'>Add</a>";
			echo "</div>";
		}
	echo "</header>";
?>