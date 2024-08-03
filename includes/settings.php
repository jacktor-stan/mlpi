<?php 
 require_once("../config.php");
 //require_once("../auth.php");

// event.php
if (isset($_POST['settings'])) {
 $reg_event = $_POST['registerEvent'];
 $type = $_POST['type'];
 $event_title = $_POST['eventTitle'];
 $event_description = $_POST['eventDescription'];



// buka atau tutup pendaftaran event
 $sql_event = "UPDATE settings SET register='$reg_event' WHERE type='$type'";
 mysqli_query($link, $sql_event);


// judul dan deskripsi event
 $sql_et = "UPDATE settings SET event_title='$event_title' WHERE type='$type'";
 $sql_ed = "UPDATE settings SET event_description='$event_description' WHERE type='$type'";

 mysqli_query($link, $sql_et);
 mysqli_query($link, $sql_ed);
}

?>