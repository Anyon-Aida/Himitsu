<?php
require "global.php";

$send = $_GET["send"];
$rec  = $_GET["rec"];
$last = $_GET["last"];

if($last == "all"){
	$q = "SELECT * FROM chatmessages, users WHERE users.id=chatmessages.sendID AND chatmessages.recID='$rec' ORDER BY chatmessages.id ASC";
	$rows = mysqli_query($db,$q);
	if(mysqli_affected_rows($db) > 0){
		while($row = mysqli_fetch_assoc($rows)){
			if($row["username"] == "Dalin") $row["username"] = "Admin";
			elseif($row["username"] == "Admin") $row["username"] = "Dalin";

			if($row["sendID"] == $send){
				echo '<div class="elem elem-self">
					<div class="photo photo-self">' . $row["username"] . '</div>
					<div class="msg msg-self">
						<p class="msgline">' . $row["msg"] . '</p>
					</div>
				</div>';
			} else {
				echo '<div class="elem elem-friend">
					<div class="photo photo-friend">' . $row["username"] . '</div>
					<div class="msg msg-friend">
						<p class="msgline">' . $row["msg"] . '</p>
					</div>
				</div>';
			}
		}
	} else {
		echo "nomsg";
	}
} else {
	$q = "SELECT * FROM chatmessages WHERE recID='$rec' ORDER BY id DESC LIMIT 1";
	$res = mysqli_query($db,$q);
	if(mysqli_affected_rows($db) > 0){
		echo mysqli_fetch_assoc($res)["id"];
	} else {
		echo "nomsg";
	}
}

?>