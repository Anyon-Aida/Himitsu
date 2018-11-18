<?php

require "global.php";

$id = $_GET["id"];

$q = "UPDATE users SET active='0' WHERE id='$id'";
$res = mysqli_query($db,$q);
if(mysqli_affected_rows($db) > 0){
    echo "success";
} else {
    echo mysqli_error($db);
}

?>