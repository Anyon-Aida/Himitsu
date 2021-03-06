<html>
<head>
<title>Főoldal</title>
<link rel="stylesheet" type="text/css" href="css/main.css">
<link rel="icon" href="images/icon/himitsu.ico" type="image/x-icon"/>
<meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>

<?php
//Belépés
require "php/global.php";

$err = "";
$id = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
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
						header("Location:php/main.php?id=$id");
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

//Regisztráció
$name = $email = $pw = $pw2 = "";
$nameerr = $emailerr = $pwerr = "";
$id = 0;
$success = FALSE;

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$success = FALSE;
	if (strlen($_POST["name"]) < 4) {
			$nameerr = "3 betűnél hosszabb név kell";
	} else {
		$name = test_input($_POST["name"]);
		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z0-9 ]*$/",$name)) {
			$nameerr = "Csak betűk és szóközök megengedettek"; 
		}
		$q = "SELECT * FROM users WHERE username='$name'";
		$dbname = mysqli_fetch_assoc(mysqli_query($db,$q))["username"];
		if($dbname){
			$nameerr = "Már van ilyen felhasználó";
		}
	}
	if (empty($_POST["email"])) {
		$emailerr = "E-mail szükséges";
	} else {
		$email = test_input($_POST["email"]);
		// check if e-mail address is well-formed
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailerr = "Nem valós e-mail cím";
		}
	}
	if (strlen($_POST["pw"]) < 4) {
		$pwerr = "3 betűnél hosszabb jelszó kell";
	} else {
		$pw = test_input($_POST["pw"]);
		$pw2 = $_POST["pw2"];
		// check if e-mail address is well-formed
		if ($pw !== htmlspecialchars($pw)) {
			$pwerr = "Nem megfelelő jelszó";
		}
		if (!($pw == $pw2)){
			$pwerr = "Nem egyeznek a jelszavak";
		}
	}
	
	if( $nameerr == "" and $emailerr == "" and $pwerr == "" and !($name == "" or $email == "" or $pw == "" or $pw2 == "") ){
		$date = date("Y-m-d H:i:s");
		$success = mysqli_query($db,"INSERT INTO users VALUES ('','$name','$pw','$email','$date','','0')");
		$row = mysqli_query($db,"SELECT * FROM users WHERE username='$name'");
		$row = mysqli_fetch_assoc($row);
		if($success){
			if($row["pass"] == $pw AND $row["regDate"] == $date){
			echo "Sikeres regisztrálás";
			$success = TRUE;
			$id = $row["id"];
			} else {
				echo "Nem megfelelő adatok<br>pw:" . $pw . " date:" . $date . " id:" . $id;
			}
		} else {
			echo "Sikertelen regisztrálás<br>:" . mysqli_error($db);
		}
	}
}
?>
<ul class="nav">
	<li><a href="index.html">Karakterek</a></li>
	<li><a href="sites/tortenet.html">Történet</a></li>
	<li><a href="sites/letoltes.html">Letöltés</a></li>
	<li><a href="sites/forum.html">Forum</a></li>
</ul>
<div class="a">
<font>Himitsu Legend Of History</font>
</div>
<div class="b">
	<div class="login">

	<button onclick="loginBtnClicked()" style="width:auto; background-color: transparent;" > <img src="images/icon/himitsubeje.png"> </button>

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
			  <button type="button" onclick="close_login()" class="cancelbtn">Mégse</button>
			  <!-- <span class="psw">Forgot <a href="#">password?</a></span> -->
			  <button type="button" onclick="registerBtnClicked()" class="regbtn">Regisztráció</button>
			</div>
		  </form>
		</div>
		
		<div id="id02" class="modal">
		<form class="modal-content animate" method="post" action="Index.php">
			<div class="imgcontainer">
			  <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
			  <img src="images/others/himitsupnglogo.png" alt="Avatar" class="avatar">
			</div>
			<div class="container">
				<form method="post" action="regist.php" style="border:1px solid #ccc">
					<label for="user"><b>Felhasználónév</b></label>
					<input type="text" class="form-control" id="name" name="name" maxlength="25" placeholder="Felhasználónév" value="<?php echo $name;?>" required>
					<span class="error"> <?php echo $nameerr;?></span>
					
					<label for="email"><b>Email</b></label>
					<input type="text" class="form-control" id="email" name="email" maxlength="50" placeholder="pelda@gmail.com" value="<?php echo $email;?>" required>
					<span class="error"> <?php echo $emailerr;?></span>
					
					<label for="pw"><b>Jelszó</b></label>
					<input type="password" class="form-control" id="pwd" name="pw" maxlength="20" placeholder="Jelszó" required>
					<span class="error"><?php echo $pwerr;?></span>
					
					<label for="pw"><b>Jelszó újra</b></label>
					<input type="password" class="form-control" id="pwd" name="pw2" maxlength="20" placeholder="Jelszó újra" required>
					<span class="error"><?php echo $pwerr;?></span>

					<div class="clearfix">
					  <button type="button" onclick="close_register()" class="cancelbtn">Mégse</button>
					  <?php
							if($success){
								header("Location:Index.php");
								/*"<a href='activate.php?id=$id'>Aktiválás</a>";
								$text = "Üdvözöllek $name!\n\nAz aktiválás befejezéséhez kattints ide:\n> www.valami.hu/activate.php?id=$id <";
								if(mail($email,"MSN Aktiválás",$text)){
									// siker
								} else {
									// nem siker
								}*/
							} else {
								echo "<button type='submit' onclick='window.location.href='Index.php'' name='submit' class='signupbtn'>Regisztrálás</button>";
							}
						?>
					</div>
				</form>
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
<script src="js/script.js">
</script>

</body>
<footer>
<div id="footer">&copy; 2018 Himitsu . Minden jog fentatrva.</div>
</footer>
</html>