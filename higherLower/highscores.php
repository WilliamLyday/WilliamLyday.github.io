<html>
  <body>
	<a href="game.php">Play a new game</a>
    <br>
	<a href="logout.php">Logout</a>
	<br>
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