<?php

require "global.php";
if(!isset($_COOKIE["userid"])) 
{
	echo "Cookie named 'userid' is not set!";
}
else 
{
	$id = $_COOKIE["userid"];
}

$q = "UPDATE users SET active='0' WHERE id='$id'";
$res = mysqli_query($db,$q);
if(mysqli_affected_rows($db) > 0){
    echo "Sikeresen kijelentkeztél!";
} else {
    echo mysqli_error($db);
}
header("Location:../Index.php");
?>