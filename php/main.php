<html>
<head>
<title>Főoldal</title>
<link rel="stylesheet" type="text/css" href="../css/main.css">
<link rel="icon" href="../images/icon/himitsu.ico" type="image/x-icon"/>
<meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
<div class="nav">
	<ul>
		<li><a href="index.html">Karakterek</a></li>
		<li><a href="sites/tortenet.html">Történet</a></li>
		<li><a href="sites/letoltes.html">Letöltés</a></li>
		<li><a href="sites/forum.html">Forum</a></li>
	</ul>
</div>
<div class="a">
<font>Himitsu Legend Of History</font>
</div>

<div>
	<p>
		<?php
			require "global.php";
			if(!isset($_COOKIE["userid"])) {
					echo "Cookie named 'userid' is not set!";
				} else {
					$id = $_COOKIE["userid"];
					$q = "SELECT * FROM users WHERE id='$id'";
					$res = mysqli_query($db,$q);
					$res = mysqli_fetch_assoc($res);
					$user = $res["username"];
				}
			echo "Üdvözöllek: $user";
			echo "<a href='logout.php?logout=$id' class='btn btn-default'>Kilépés</a>";
		?>
	</p>
</div>

<footer>
<div id="footer">&copy; 2018 Himitsu . Minden jog fentatrva.</div>
</footer>
</html>