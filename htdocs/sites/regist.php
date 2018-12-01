<html>
<head>
<title>Regisztráció</title>
<link rel="stylesheet" type="text/css" href="../css/regist.css">
<link rel="icon" href="../images/icon/himitsu.ico" type="image/x-icon"/>
<meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
<?php
require "../php/global.php";
// define variables and set to empty values
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
<div class="nav">
	<ul>
		<li><a href="../index.html">Főoldal</a></li>
		<li><a href="sites/tortenet.html">Történet</a></li>
		<li><a href="sites/letoltes.html">Karakterek</a></li>
		<li><a href="sites/forum.html">Forum</a></li>
		<li><a href="sites/forum.html">Letöltés</a></li>
	</ul>
</div>
<div class="a">
<font>Himitsu Legend Of History</font>
</div>
<div class="reg">
  <div class="container">
    <h1>Regisztráció</h1>
    <p>Töltse ki a mezőket a regisztrációhoz.</p>
    <hr>
	<form method="post" action="regist.php" style="border:1px solid #ccc">
		<label for="user"><b>Felhasználónév</b></label>
		<input type="text" name="name" maxlength="25" placeholder="Felhasználónév" value="<?php echo $name;?>">
		<span class="error"> <?php echo $nameerr;?></span>
		
		<label for="email"><b>Email</b></label>
		<input type="text" name="email" maxlength="50" placeholder="pelda@gmail.com" value="<?php echo $email;?>">
		<span class="error"> <?php echo $emailerr;?></span>
		
		<label for="pwd"><b>Jelszó</b></label>
		<input type="password" name="pw" maxlength="20" placeholder="Jelszó">
		<span class="error"><?php echo $pwerr;?></span>
		
		<label for="pwd"><b>Jelszó újra</b></label>
		<input type="password" name="pw2" maxlength="20" placeholder="Jelszó újra">
		<span class="error"><?php echo $pwerr;?></span>
    
   <!-- <label>
      <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
    </label> -->
    
   <!-- <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p> -->

    <div class="clearfix">
      <button onclick="window.location.href='../Index.php'" type="button" class="cancelbtn">Mégse</button>
	  <?php
			if($success){
				header("Location:../Index.php");
				/*"<a href='activate.php?id=$id'>Aktiválás</a>";
				$text = "Üdvözöllek $name!\n\nAz aktiválás befejezéséhez kattints ide:\n> www.valami.hu/activate.php?id=$id <";
				if(mail($email,"MSN Aktiválás",$text)){
					// siker
				} else {
					// nem siker
				}*/
			} else {
				echo "<button type='submit' onclick='window.location.href='../Index.php'' name='submit' class='signupbtn'>Regisztrálás</button>";
			}
		?>
    </div>
		
	</form>
  </div>
</div>
</body>
<footer>
<div id="footer">&copy; 2018 Himitsu . Minden jog fentatrva.</div>
</footer>
</html>