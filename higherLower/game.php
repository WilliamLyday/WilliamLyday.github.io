<?php session_start(); ?>
 
<!DOCTYPE html>
<html>
<body>
	<a href="highscores.php">View the all time top scores</a>
	<br>	
	<a href="logout.php">Logout</a>
	<br><br>

	<?php
		if(isset($_SESSION["user"])) {
			echo "Logged in as user: " . $_SESSION["user"] . "<br>";		
	  	} else {
			echo "not currently logged in!<br>";
	  	}
	?>
	
	<p>Welcome to higher/lower, a number guessing game<br>
	  where the user tries to guess the randomly generated<br>
	  number between 1 and 100 in as few guesses as possible<br></p>
	  
	<form action="" method="POST">
	<input type="text" name="numvalue"/><br><br>  
	<input type="submit" name="submit" value="Guess"/><br><br>
	</form>
	
	<?php
		if(!isset($_SESSION["score"])){
			$score = 0;
			$answer = rand(1,100);
			
			$_SESSION["score"] = $score;
			$_SESSION["answer"] = $answer;
		}
		
		//on submit button press
		if(isset($_POST['submit'])){
			$guess = $_POST["numvalue"];
			$_SESSION["score"]++;
			echo "Current Score: " . $_SESSION["score"] . "<br>";
			//echo "Answer: " . $_SESSION["answer"] . "<br>";
			
			if($_SESSION["answer"] > $guess){
				echo "Your guess: " . $guess . ", the answer is higher<br><br>";
			} 
			elseif($_SESSION["answer"] < $guess){
				echo "Your guess: " . $guess . ", the answer is lower<br><br>";
			} 
			else{
				echo "You got it right!<br><br>";  
			
				//insert into highscores if logged in
				 if(isset($_SESSION["user"])){

					$servername = "sql204.epizy.com";
					$username = "epiz_30809345";
					$password = "nics1ZAZtnZre";
					$dbname = "epiz_30809345_assignment1";
		  
					// Create connection
					$conn = new mysqli($servername, $username, $password, $dbname);
					if ($conn->connect_error){
						die("Connection failed: " . $conn->connect_error);
					}
					
					$tempscore = $_SESSION["score"];
					$tempuser = $_SESSION["user"];
					
					$sql = "INSERT INTO Highscores (Username, Score) VALUES ('$tempuser', '$tempscore')";
					
					if ($conn->query($sql) === TRUE){
						echo "successfully saved score for " . $_SESSION["user"] . "<br><br>";
					} else{
						echo "Error: " . $sql . "<br>" . $conn->error;
					}
					$conn->close();
				} else{
					echo "You must be logged in to save your score!<br><br>";
				}

				//always zero out var for fresh game
				$_SESSION["score"] = null;
				$_SESSION["answer"] = null;
			}
		}
		
		//on newgame button press
		if(isset($_POST['newgame'])){
			$_SESSION["score"] = null;
			$_SESSION["answer"] = null;

			echo "<script> window.location.assign('game.php'); </script>";
		}
	 ?>

	<form action="game.php" method="post">
		<input type="submit" name="newgame" value="Play a new game!"/>
	</form>

	<p>The top ten highest scores!</p>
	<?php
		// server side code
		$servername = "sql204.epizy.com";
		$username = "epiz_30809345";
		$password = "nics1ZAZtnZre";
		$dbname = "epiz_30809345_assignment1";
      
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error){
			die("Connection failed: " . $conn->connect_error);
		}
		  		  
		$sql = "SELECT Id, Username, Score FROM Highscores ORDER BY Score LIMIT 10 ";
		$result = $conn->query($sql);
		  
		if ($result->num_rows > 0){
			while ($row = $result->fetch_assoc()){
				echo $row["Username"] . " " . $row["Score"] . "<br>";
			}
		} else{
			echo "Got no results. :( Login, and play!";
		}
		$conn->close();
	
	?>
</body>
</html>