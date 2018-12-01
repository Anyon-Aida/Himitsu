<html>
<head>
<meta charset="utf-8">
<style>
	body{
		background-color: black;
		max-width: 100%;
		max-height: 100%;
		margin: 20px;
		padding: 20px;
		font-size: 20px;
		color: white;
	}
</style>
</head>
<body>
	<?php
		require "global.php";

		$id = $_GET["id"];
		echo "id = $id";
		/*$q = "UPDATE users SET activated = '1' WHERE id='$id'";
		$success = mysqli_query($db,$q);*/
		if(true)
		{
			echo "Sikeres aktiválás";
			echo "<br><br><a href='index.php'>Bejelentkezés</a>";
		} 
		else 
		{
			echo "Sikertelen aktiválás";
			echo "<br><br><a href='regin.php'>Újra</a>";
		}
	?>
</body>
</html>