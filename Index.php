<html>
<head>
<title>Főoldal</title>
<link rel="stylesheet" type="text/css" href="css/main.css">
<link rel="icon" href="images/icon/himitsu.ico" type="image/x-icon"/>
<link rel="stylesheet" href="css/style.css">
<meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>

<?php

require "php/global.php";

$err = "";
$id = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = $_POST["name"];
	$pass = $_POST["pw"];
	$q = "SELECT * FROM users WHERE username='$name'";
	$res = mysqli_query($db,$q);
	$res = mysqli_fetch_assoc($res);
	$id = $res["id"];

	if($res){
		if($res['pass'] == $pass){
			if(true){
				$date = date("Y-m-d H:i:s");
				$q = "UPDATE users SET lastLogin='$date', active='1' WHERE username='$name'";
				$res = mysqli_query($db,$q);
				if($res){
					$q = "SELECT * FROM users WHERE username='$name'";
					$res = mysqli_query($db,$q);
					$res = mysqli_fetch_assoc($res);
					$id = $res["id"];
					if($id > 0){
						setcookie("userid",$id,time() + 3600,"/");
						header("Location:php/main.php");
						exit();
					} else {
						$err = "badID";
					}
				} else {
					$err = "lastLoginUpdateFailed";
				}
			} else {
				$err = "notActivated";
			}
		} else {
			$err = "wrongPw";
		}
	} else {
		$err = "noUser";
	}
}
?>
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
<div class="b">
	<div class="login">

	<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Bejelentkezés</button>

		<div id="id01" class="modal">
		  <form class="modal-content animate" method="post" action="Index.php">
			<div class="imgcontainer">
			  <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
			  <img src="images/others/himitsupnglogo.png" alt="Avatar" class="avatar">
			</div>
			<div class="container">
			  <label for="user"><b>Felhasználónév</b></label>
			  <input type="text" class="form-control" id="name" placeholder="Felhasználónév" name="name" required>
			  <?php if($err == "noUser") echo "<p>Nincs ilyen felhasználó</p>"; ?>
			  
			  <label for="pw"><b>Jelszó</b></label>
			  <input type="password" class="form-control" id="pwd" placeholder="Jelszó" name="pw" required>
			  <?php if($err == "wrongPw") echo "<p>Nem megfelelő jelszó</p>"; ?>
				
				<div class="form-group">
				<?php
					if($err == "notActivated")
						echo "<a href='php/activate.php?id=$id'>Aktiválás</a>";
						/*$text = "Üdvözöllek $name!\n\nAz aktiválás befejezéséhez kattints ide:\n> www.valami.hu/activate.php?id=$id <";
						if(mail($email,"MSN Aktiválás",$text)){
							// siker
						} else {
							// nem siker
						}*/
					else 
						echo "<button type='submit' class='btn btn-default'>Bejelentkezés</button>";
					if($err == "lastLoginUpdateFailed" OR $err == "badID"){
						echo "<p>Nem sikerült frissíteni az adatbázist " . $err . "</p>";
					}
				?>
				</div>
			  
			  <label>
				<input type="checkbox" checked="checked" name="remember"> Emlékezzen rám
			  </label>
			</div>

			<div class="container" style="background-color:#f1f1f1">
			  <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Mégse</button>
			  <!-- <span class="psw">Forgot <a href="#">password?</a></span> -->
			  <button type="button" onclick="window.location.href='sites/regist.php'" class="regbtn">Regisztráció</button>
			</div>
		  </form>
		</div>
	</div>
</div>
<script>
var modal = document.getElementById('id01');


window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</body>
<footer>
<div id="footer">&copy; 2018 Himitsu . Minden jog fentatrva.</div>
</footer>
</html>