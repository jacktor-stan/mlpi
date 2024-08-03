<?php

 require_once("../config.php");
 require_once("../auth.php");

 $id = $_SESSION["user"]["id"];
 $sql = "SELECT * FROM users WHERE id='$id'";
 $query = mysqli_query($link, $sql);
 $row = mysqli_fetch_array($query);

//$_POST['page'] = "Test";
if (isset($_POST['page'])) {

echo $_POST['page'];

if ($_GET['action'] == "delete") {

$file = "../uploads/".$_GET['type']."/".$row['username']."/".$_GET['filename'];

 if (unlink("$file")) {


if ($_GET['event'] == "1") {
   $id = $_SESSION["user"]["id"];
   $sql = "UPDATE users_data SET event_image='' WHERE user_id='$id'";
   mysqli_query($link, $sql);
}


   header("Location:../event.php?remove_image=success");
  } else {
  // header("Location:../event.php?remove_image=error");
 }
}

}

?>

<html>
<body>

<form action="" method="post">
<button name="page" value="4567">OK</button>
</form>


</body>
</html>


