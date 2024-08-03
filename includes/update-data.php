<?php 
 require_once("../config.php");
 //require_once("../auth.php");
 session_start();


// event.php
if (isset($_POST['event'])) {
 $event = $_POST['event'];
 $id = $_SESSION["user"]["id"];
 $sql_event = "UPDATE event SET event='$event' WHERE user_id='$id'";
 mysqli_query($link, $sql_event);
}

//Kutipan
if (isset($_POST['quote'])) {
 $id = $_POST['user_id'];

 $quote = $_POST['quote'];

 $sql_quote = "UPDATE data SET quote='$quote' WHERE user_id='$id'";
 mysqli_query($link, $sql_quote);
}


// admin/user.php - update 1
if (isset($_POST['username'])) {
 $id = $_POST['user_id'];

 $firstname = $_POST['firstname'];
 $lastname = $_POST['lastname'];
 $email = $_POST['email'];
 $username = $_POST['username'];

 $sql_firstname = "UPDATE users SET firstname='$firstname' WHERE id='$id'";
 $sql_lastname = "UPDATE users SET lastname='$lastname' WHERE id='$id'";
 $sql_email = "UPDATE users SET email='$email' WHERE id='$id'";
 $sql_username = "UPDATE users SET username='$username' WHERE id='$id'";
 mysqli_query($link, $sql_firstname);
 mysqli_query($link, $sql_lastname);
 mysqli_query($link, $sql_email);
 mysqli_query($link, $sql_username);

}

// admin/user.php - update 2
if (isset($_POST['choosePosition'])) {
 $id = $_POST['user_id'];

 $choosePosition = $_POST['choosePosition'];
 $chooseRole = $_POST['chooseRole'];

 $sql_choosePosition = "UPDATE users SET account='$choosePosition' WHERE id='$id'";
 $sql_chooseRole = "UPDATE event SET event='$chooseRole' WHERE user_id='$id'";

 mysqli_query($link, $sql_choosePosition);
 mysqli_query($link, $sql_chooseRole);
}

?>