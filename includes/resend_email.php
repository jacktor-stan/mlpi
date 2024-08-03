<?php

require_once("../config.php");

if ($_POST['resend_email']) {
session_start();
$id_session = $_SESSION["user"]["id"];

 $sql_session = "SELECT * FROM users WHERE id='$id_session'";
 $query_session = mysqli_query($link, $sql_session);
 $row_session = mysqli_fetch_array($query_session);

$firstname =  $row_session['firstname'];
$lastname = $row_session['lastname'];
$email = $row_session['email'];
$token = $row_session['token'];
$code = "MLPI-".rand(1000,5540);
 
  function get_token($long){
  $token = array(
   range(1,9),
   range('a','z'),
   range('A','Z')
  );

  $karakter = array();
  foreach($token as $key=>$val){
   foreach($val as $k=>$v){
    $karakter[] = $v;
   }
  }

  $token = null;
  for($i=1; $i<=$long; $i++){
   // mengambil array secara acak
   $token .= $karakter[rand($i, count($karakter) - 1)];
  }

  return $token;
 }

  $token = get_token(50);

//Update query
$sql_code = "UPDATE users SET code='$code' WHERE id='$id_session'";
$sql_token = "UPDATE users SET token='$token' WHERE id='$id_session'";
mysqli_query($link, $sql_code);
mysqli_query($link, $sql_token);

    //Kirim html konfirmasi email
    include("../include/email_confirmation.php");
 }
?>