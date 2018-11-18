<?php
session_start();

$db = mysqli_connect("localhost","root","","chat");
if(!$db) exit("Can't connect to database");

?>
