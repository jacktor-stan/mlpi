<?php

require_once("../config.php");

if (isset($_GET['user_id'])) {
$id = $_GET['user_id'];

$sql = "SELECT * FROM users WHERE id='$id'";
$sql_event = "SELECT * FROM event WHERE user_id='$id'";

$query = mysqli_query($link, $sql);
$query_event = mysqli_query($link, $sql_event);

$row = mysqli_fetch_array($query);
$row_event = mysqli_fetch_array($query_event);

			//developer - jury
			if ($row['account'] == "developer" && $row_event['event'] == 1) {
			$html1 = '<p><span class="badge" style="background: #00897B;">DEVELOPER</span> <span class="badge" style="background: #FF455A;">JURI</span></p>';
			} else if ($row['account'] == "developer" && $row_event['event'] == "0") {
			$html1 = '<p><span class="badge" style="background: #00897B;">DEVELOPER</span></p>';
			}

			//admin - jury
			if ($row['account'] == "admin" && $row_event['event'] == 1) {
			$html1 = '<p><span class="badge" style="background: #00897B;">ADMIN</span> <span class="badge" style="background: #FF455A;">JURI</span></p>';
			} else if ($row['account'] == "admin" && $row_event['event'] == "0") {
			$html1 = '<p><span class="badge" style="background: #00897B;">ADMIN</span></p>';
			}

			//moderator - jury
			if ($row['account'] == "moderator" && $row_event['event'] == 1) {
			$html1 = '<p><span class="badge" style="background: #00897B;">MODERATOR</span> <span class="badge" style="background: #FF455A;">JURI</span></p>';
			} else if ($row['account'] == "moderator" && $row_event['event'] == "0") {
			$html1 = '<p><span class="badge" style="background: #00897B;">MODERATOR</span></p>';
			}

			//developer - perserta
			if ($row['account'] == "developer" && $row_event['event'] == 2) {
			$html1 = '<p><span class="badge" style="background: #00897B;">DEVELOPER</span> <span class="badge" style="background: #FF455A;">PERSERTA</span></p>';
			}

			//admin - perserta
			if ($row['account'] == "admin" && $row_event['event'] == 2) {
			$html1 = '<p><span class="badge" style="background: #00897B;">ADMIN</span> <span class="badge" style="background: #FF455A;">PERSERTA</span></p>';
			}

			//moderator - perserta
			if ($row['account'] == "moderator" && $row_event['event'] == 2) {
			$html1 = '<p><span class="badge" style="background: #00897B;">MODERATOR</span> <span class="badge" style="background: #FF455A;">PERSERTA</span></p>';
			}

			//anggota - perserta
			if ($row['account'] == "member" && $row_event['event'] == 2) {
			$html1 = '<p><span class="badge" style="background: #00897B;">ANGGOTA</span> <span class="badge" style="background: #FF455A;">PERSERTA</span></p>';
			} else if ($row['account'] == "member" && $row_event['event'] == "0") {
		 $html1 = '<p><span class="badge" style="background: #00897B;">ANGGOTA</span></p>';
			}

$array = array($row['firstname'],$row['lastname'],$row['username'],$row['email'],bin2hex($html1));
echo json_encode($array);
}

?>