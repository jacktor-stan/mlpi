<?php

 require_once("../config.php");
//require_once("../auth.php");
session_start();

 $id = $_SESSION["user"]["id"];
 $sql = "SELECT * FROM users WHERE id='$id'";
 $query = mysqli_query($link, $sql);
 $row = mysqli_fetch_array($query);

	//Check if the file is well uploaded
	if($_FILES['file']['error'] > 0) { 
     header("Location:../event.php?upload=error");
     exit; 
}
	
	//We won't use $_FILES['file']['type'] to check the file extension for security purpose
	
	//Set up valid image extensions
	$extsAllowed = array( 'jpg', 'jpeg', 'png' );
	
	//Extract extention from uploaded file
		//substr return ".jpg"
		//Strrchr return "jpg"
		
	$extUpload = strtolower(substr( strrchr($_FILES['file']['name'], '.'), 1) ) ;
	//Check if the uploaded file extension is allowed
	
	if (in_array($extUpload, $extsAllowed) ) { 
	
	//Upload the file on the server
  $random = rand(0,1000);
  $username = $row["username"];
  $name = $row["username"]."_event_".$random.".".strtolower(substr(strrchr($_FILES['file']['name'], '.'), 1));

//buat folder berdasarkan usernane
$dir = 'images/'.$username;
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

//pindahkan file ke folder berdasarkan usernane setelah diupload
	$result = move_uploaded_file($_FILES['file']['tmp_name'], "images/$username/$name");
	

	if ($result) {
   $format = strtolower(substr(strrchr($_FILES['file']['name'], '.'),1));
    header("Location:../event.php?upload=success");

/*
    $sql_11 = "UPDATE event SET message='Gambar anda sedang ditinjau oleh admin untuk penilaian' WHERE id='2'";
    mysqli_query($link, $sql_11);
*/

//update database "file"
 $sql_1 = "UPDATE event SET event_image='$name' WHERE user_id='$id'"; 
 mysqli_query($link, $sql_1);

$imgTitle = $_POST['imgTitle'];
$sql_2 = "UPDATE event SET image_title='$imgTitle' WHERE user_id='$id'"; 
 mysqli_query($link, $sql_2);

$imgDesc = $_POST['imgDesc'];
$sql_3 = "UPDATE event SET image_description='$imgDesc' WHERE user_id='$id'"; 
 mysqli_query($link, $sql_3);
   }
		
	} else { 
    header("Location:../event.php?upload=invalid");
 }
?>