<?php

require_once("../config.php");

/* Get email */
$email = $_POST['email'];

/* Query */
$query = "select count(*) as cntUser from users where email='".$email."'";

$result = mysqli_query($link, $query);

$row = mysqli_fetch_array($result);

$count = $row['cntUser'];

echo $count;