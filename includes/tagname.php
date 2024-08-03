<?php
$sql_session_tag = "SELECT * FROM users WHERE id='$id_tagname'";
$sql_event_tag = "SELECT * FROM event WHERE user_id='$id_tagname'";

$query_session_tag = mysqli_query($link, $sql_session_tag);
$query_event_tag = mysqli_query($link, $sql_event_tag);

$row_session_tag = mysqli_fetch_array($query_session_tag);
$row_event_tag = mysqli_fetch_array($query_event_tag);

//developer - jury
if ($row_session_tag['account'] == "developer" && $row_event_tag['event'] == 1) {
  echo '<p><div id="tagname"><span class="badge" style="background: #00897B;">DEVELOPER</span> <span class="badge" style="background: #FF455A;">JURI</span></div></p>';
 } else if ($row_session_tag['account'] == "developer" && $row_event_tag['event'] == "0") {
  echo '<p><div id="tagname"><span class="badge" style="background: #00897B;">DEVELOPER</span></div></p>';
 }

//admin - jury
if ($row_session_tag['account'] == "admin" && $row_event_tag['event'] == 1) {
  echo '<p><div id="tagname"><span class="badge" style="background: #00897B;">ADMIN</span> <span class="badge" style="background: #FF455A;">JURI</span></div></p>';
 } else if ($row_session_tag['account'] == "admin" && $row_event_tag['event'] == "0") {
  echo '<p><div id="tagname"><span class="badge" style="background: #00897B;">ADMIN</span></div></p>';
 }

//moderator - jury
if ($row_session_tag['account'] == "moderator" && $row_event_tag['event'] == 1) {
  echo '<p><div id="tagname"><span class="badge" style="background: #00897B;">MODERATOR</span> <span class="badge" style="background: #FF455A;">JURI</span></div></p>';
 } else if ($row_session_tag['account'] == "moderator" && $row_event_tag['event'] == "0") {
  echo '<p><div id="tagname"><span class="badge" style="background: #00897B;">MODERATOR</span></div></p>';
 }

//developer - perserta
if ($row_session_tag['account'] == "developer" && $row_event_tag['event'] == 2) {
  echo '<p><div id="tagname"><span class="badge" style="background: #00897B;">DEVELOPER</span> <span class="badge" style="background: #FF455A;">PERSERTA</span></div></p>';
 }

//admin - perserta
if ($row_session_tag['account'] == "admin" && $row_event['event'] == 2) {
  echo '<p><div id="tagname"><span class="badge" style="background: #00897B;">ADMIN</span> <span class="badge" style="background: #FF455A;">PERSERTA</span></div></p>';
 }

//moderator - perserta
if ($row_session_tag['account'] == "moderator" && $row_event_tag['event'] == 2) {
  echo '<p><div id="tagname"><span class="badge" style="background: #00897B;">MODERATOR</span> <span class="badge" style="background: #FF455A;">PERSERTA</span></div></p>';
 }

//anggota - perserta
if ($row_session_tag['account'] == "member" && $row_event_tag['event'] == 2) {
  echo '<p><div id="tagname"><span class="badge" style="background: #00897B;">ANGGOTA</span> <span class="badge" style="background: #FF455A;">PERSERTA</span></div></p>';
 } else if ($row_session_tag['account'] == "member" && $row_event_tag['event'] == "0") {
  echo '<p><div id="tagname"><span class="badge" style="background: #00897B;">ANGGOTA</span></div></p>';
 }
?>