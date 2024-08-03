<?php

session_start();
 unset($_SESSION["user"]);

if(isset($_COOKIE['login']))
{
$time = time();
setcookie("login", $time - 3600);
}
  if(session_destroy()) {
     header("Location: index.php");
}

?>