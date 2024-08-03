<?php

require_once("../config.php");

$username = mysqli_real_escape_string($link, $_POST['username']);
$sql = "select * from users where username = '$username'";
$query = mysqli_query($link, $sql);
$num = mysqli_num_rows($query);

if (preg_match('/([a-zA-Z])/', $username)) {
if (preg_match('/^[0-9A-Za-z_]+$/', $username)) {

if ($num == 0) {
	echo "1";
 } else{
	echo "0";
  }
 } else {
  echo "2";
}

 } else {
 echo "3";
}