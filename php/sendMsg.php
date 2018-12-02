<?php
require "global.php";

$msg = htmlentities($_GET["msg"]);
$send = $_GET["send"];
$rec = $_GET["rec"];
$date = date("Y-m-d H:i:s");

$q = "INSERT INTO chatmessages VALUES('','$send','$rec','$date','$msg')";
$res = mysqli_query($db,$q);
if($res){
	echo "ok";
} else {
	echo mysqli.mysql_error($db);
}

?>