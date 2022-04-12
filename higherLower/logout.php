<?php
	session_start();

	//remove all session variables
	session_unset();
	
	//destroy the session
	session_destroy();
?>

<!DOCTYPE html>
<html>
<body>
	<a href="landing.php">Go to the login page</a>
	<br>
	<a href="highscores.php">View the all time high scores</a>
	<br>  
	<p>Successfully logged out!</p>
</body>
</html>