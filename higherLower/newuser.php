<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<body>
	<?php
		//connection info
		if(isset($_POST['username'])){
			$servername = "sql204.epizy.com";
			$username = "epiz_30809345";
			$password = "nics1ZAZtnZre";
			$dbname = "epiz_30809345_assignment1";
	  
			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
				if ($conn->connect_error){
					die("Connection failed: " . $conn->connect_error);
			}
			
			//user info
			$user = $_POST["username"];
			$pass = $_POST["password"];
			$salt = bin2hex(random_bytes(8));
			$hashedpassword = hash('sha256', $pass . '.' . $salt);
			$_SESSION["user"] = $user;
			
			$sql = "INSERT INTO Users (Username, Password, Salt) VALUES ('$user', '$hashedpassword', '$salt')";
			if ($conn->query($sql) === TRUE){
				echo "User: " . $user . " successfully created account<br>";
			} else {
				echo "Error: " . $conn->error . "<br>";
			}
			
			$conn->close();
		}
	?>
	<a href="game.php">Play HigherLower</a><br>
	<a href="highscores.php">View the all time high scores</a>
	
	<form action="" method="post">
			<p>Enter a new Username: <input type="text" name="username"/></p>
			<p>Enter a Password: <input type="text" name="password"/></p>
			<button type="submit">Create new account</button>
	</form>
</body>
</html>