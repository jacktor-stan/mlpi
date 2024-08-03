<?php 
 require_once("../config.php");
 //require_once("../auth.php");

//Perbarui data
if ($_POST['account'] == "update") {
//Event
if ($_POST['event']) {
 $event = $_POST['event'];
 $id = $_SESSION["user"]["id"];
 $sql_event = "UPDATE users SET event='$event' WHERE id='$id'";
 mysqli_query($link, $sql_event);
}

//Bio
if ($_POST['bio']) {
 $user_id = $_POST['user_id'];
 $bio = $_POST['bio'];
 $sql_bio = "UPDATE users SET bio='$bio' WHERE id='$user_id'";
 mysqli_query($link, $sql_bio);
}

// admin/user.php - update 1
if ($_POST['email']) {
 $id = $_POST['user_id'];

 $firstname = $_POST['firstname'];
 $lastname = $_POST['lastname'];
 $email = $_POST['email'];
 //$username = $_POST['username'];

 $sql_firstname = "UPDATE users SET firstname='$firstname' WHERE id='$id'";
 $sql_lastname = "UPDATE users SET lastname='$lastname' WHERE id='$id'";
 $sql_email = "UPDATE users SET email='$email' WHERE id='$id'";
 //$sql_username = "UPDATE users SET username='$username' WHERE id='$id'";
 mysqli_query($link, $sql_firstname);
 mysqli_query($link, $sql_lastname);
 mysqli_query($link, $sql_email);
 //mysqli_query($link, $sql_username);

//username saat ini tidak bisa diganti, karena nantinya akan bermasalah dengan nama-nama data file di project ini
}

// admin/user.php - update 2
if ($_POST['choosePosition']) {
 $id = $_POST['user_id'];

 $activationStatus = $_POST['activationStatus'];
 $choosePosition = $_POST['choosePosition'];
 $chooseRole = $_POST['chooseRole'];

 $sql_activationStatus = "UPDATE users SET active='$activationStatus' WHERE id='$id'";
 $sql_choosePosition = "UPDATE users SET account='$choosePosition' WHERE id='$id'";
 $sql_chooseRole = "UPDATE event SET event='$chooseRole' WHERE user_id='$id'";

 mysqli_query($link, $sql_activationStatus);
 mysqli_query($link, $sql_choosePosition);
 mysqli_query($link, $sql_chooseRole);
 }
}

//Hapus akun pengguna
if ($_POST['account'] == "delete") {
if ($_POST['password']) {
$id = $_SESSION['user']['id'];
$user_id = $_POST['user_id'];

$sql = "SELECT * FROM users WHERE id='$id'";
$query = mysqli_query($link, $sql);
$row = mysqli_fetch_array($query);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

if (password_verify($password, $row["password"])) {
echo 'true';

//Lakukan penghapusan query pada tabel
$sql_del1 = "DELETE FROM users WHERE id='$user_id'"; 
$sql_del2 = "DELETE FROM event WHERE user_id='$user_id'"; 
mysqli_query($link, $sql_del1);
mysqli_query($link, $sql_del2);
  } else {
echo 'false';
 }
}
}

?>