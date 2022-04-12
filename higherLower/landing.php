<?php session_start(); ?>

<!DOCTYPE html>
<html>
<body>
	<?php
		//user info
		$user = $_POST["username"];
		$pass = $_POST["password"];

		//connection info
		if(isset($_POST['username'])){
			
			$servername = "sql204.epizy.com";
			$username = "epiz_30809345";
			$password = "nics1ZAZtnZre";
			$dbname = "epiz_30809345_assignment1";
	  
			//connect to db
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			
			$sql = "SELECT Username, Password, Salt FROM Users WHERE Username = '$user'";
			$result = $conn->query($sql);	

			if ($result->num_rows == 0){
				echo "No user with that name!<br>";
			}
			elseif ($result->num_rows == 1){
				$temp = $result->fetch_assoc();
				$correcthashpass = $temp["Password"] == hash('sha256', $pass . '.' . $temp["Salt"]);

				if(!$correcthashpass){
					echo "Incorrect password entered!<br>";
				} else {
					$_SESSION["user"] = $user;
					echo "<script> window.location.assign('game.php'); </script>";
				}
			}
			
			$conn->close();
		}	
	?>
	
	<a href="newuser.php">New? Create a new account!</a>
	<br>
	<a href="highscores.php">View the top 10 all time high scores</a>
	<br>
  
	<form action="" method="post">
		<p>Username: <input type="text" name="username"/></p>
		<p>Password: <input type="password" name="password"/></p>
		<button type="submit">Login!</button>
	</form>
</body>
</html>