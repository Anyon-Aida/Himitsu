<html>
<head>
<title>Főoldal</title>
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link rel="stylesheet" type="text/css" href="../css/formatting.css">
<link rel="icon" href="../images/icon/himitsu.ico" type="image/x-icon"/>
<meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
<div class="nav">
	<ul>
		<li><a href="index.html">Karakterek</a></li>
		<li><a href="sites/tortenet.html">Történet</a></li>
		<li><a href="../letoltes/">Letöltés</a></li>
		<li><a href="sites/forum.html">Forum</a></li>
	</ul>
</div>
<font>Himitsu Legend Of History</font>
<?php
require "global.php";
if(isset($_GET["id"])){
	if($_GET["id"] > 0){
		$id = $_GET["id"];
	} else {
		$id = -1;
		echo "<h3>Cannot get userID, please relogin!</h3>";
	}
} else {
	$id = 1;
	echo "<h3>Cannot get userID, please relogin!</h3>";
}

$send = $id;
$rec = -1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$_SERVER["REQUEST_METHOD"] == "";
	$msg = htmlentities(trim($_POST["msg"]));
	if($msg != ""){
		$date = date("Y-m-d H:i:s");
		$q = "INSERT INTO chatmessages (sendID,recID,msg,date) VALUES('$send','$rec','$msg','$date')";
		if(!mysqli_query($db,$q)){
			echo "Cannot insert newest message:" . $msg . " at " . $date;
		}
	}
}

$q = "SELECT * FROM chatmessages"/* WHERE senderID='$send'"*/;
$rows = mysqli_query($db,$q);

?>
<form method="post" action=<?php echo "main.php?id=$id"; ?>>
	<div class="chatbox">
		<div class="chatlogs">
			<div class="chat friend">
				<?php
					if(mysqli_num_rows($rows) > 0){
						while($row = mysqli_fetch_assoc($rows)){
							$msg = $row["msg"];
							$sender = $row["sendID"];
							$q = "SELECT * FROM users WHERE id='$sender'";
							$res = mysqli_query($db,$q);
							$res = mysqli_fetch_assoc($res);
							if($res)
								$name = $res["username"];
							else
								$name = "Unknown";
							echo "<div class='user-photo'>$name</div><p class='chat-message'>$msg</p>";
						}
					} else {
						echo "<div class='user-photo'>System</div><p class='chat-message'>Nincs üzenetváltás</p>";
					}
				?>
			</div>
		</div>
		<div class="chat-form">
			<input type="text" name="msg" class="form-control" placeholder="Üzenet" focus="true"></input>
			<input type="submit" class="btn btn-default" name="submit" value="Küldés">
		</div>
		<?php echo "<a href='../Index.php?logout=$id' class='btn btn-default'>Kilépés</a>"?>
	</div>
</form>

<footer>
<div id="footer">&copy; 2018 Himitsu . Minden jog fentatrva.</div>
</footer>
</html>