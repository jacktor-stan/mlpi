<?php
//Header config
$title = "MLPI - Panel Admin";
$fa_icon = "fas fa-toolbox";
$home_active = false;
$event_active = false;
$admin_active = true;
$default_meta_description = "";
$default_meta_image = "";
$dir_type = "..";
include("../header.php");

 require_once("auth.php");
 
 $id_session = $_SESSION["user"]["id"];
 $sql_settings = "SELECT * FROM settings WHERE type='event'";
 $query_settings = mysqli_query($link, $sql_settings);
 $row_settings = mysqli_fetch_array($query_settings);

 $sql = "SELECT * FROM users";

 $query1 = mysqli_query($link, $sql);
 $query2 = mysqli_query($link, $sql);
 $query3 = mysqli_query($link, $sql);
 $query4 = mysqli_query($link, $sql);
 $query5 = mysqli_query($link, $sql);
 $query6 = mysqli_query($link, $sql);

//Include
 $user_header = $id_session;

?>
  

<!--Main layout-->
<div class="container">

<main>
<p><div class="alert alert-warning" style="border-radius: 0px;">
<i class="fas fa-exclamation-circle"></i> &nbsp; Beberapa fitur mungkin tidak berfungsi saat ini
</div></p><br />

					<!-- Pengaturan -->
					<div class="card">
						<div class="card-body">
							Pengaturan Event
							<br>
							<small class="font-weight-light">Kelola event, buka atau tutup pendaftaran event.</small>

							<hr>
<?php 

echo '
			<select class="mdb-select md-form" id="chooseRE">
				<option value="" disabled selected>Status Pendaftaran</option>
				<option value="N" '.str_replace("N","selected",$row_settings['register']).'>Tutup Pendaftaran</option>
				<option value="Y" '.str_replace("Y","selected",$row_settings['register']).'>Buka Pendaftaran</option>
			</select>

<p>
<input type="text" id="eventTitle" class="form-control" value="'.$row_settings['event_title'].'">
<br />
<textarea id="eventDescription" class="form-control">'.$row_settings['event_description'].'</textarea>
</p>';

?>

<button type="button" class="btn btn-primary btn-sm" id="updateCRE">Simpan</button>
						</div>
					</div>
<hr><br />

<!-- Tabs -->
<ul class="nav nav-pills mb-3" id="pills-event-image-tab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="pills-event-image-tab" data-toggle="pill" href="#pills-event-image" role="tab"
      aria-controls="pills-event-image"  aria-selected="true">Event Gambar</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-event-text-tab" data-toggle="pill" href="#pills-event-text" role="tab"
      aria-controls="pills-event-text" aria-selected="false">Event Teks</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-users-tab" data-toggle="pill" href="#pills-users" role="tab"
      aria-controls="pills-users" aria-selected="false">Akun Pengguna</a>
  </li>
</ul>



<hr>


<div class="tab-content" style="padding: 0px;" id="pills-tabContent">


<!-- Tab 1 -->
  <div class="tab-pane fade show active" id="pills-event-image" role="tabpanel" aria-labelledby="pills-event-image-tab">

<p><div class="alert alert-info" style="border-radius: 0px;">
<i class="fas fa-images"></i>&nbsp; Gambar yang telah diupload oleh peserta (<span id="img-count"></span>)
</div>
</p>

<!-- Grid column - Gambar -->
<div class="row">

<?php

//Konversi ukuran file
function filesize_formatted($path)
{
    $size = filesize($path);
    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}

$data = array();

while ($row3 = mysqli_fetch_array($query3)) {

//Ambil info gambar dari kueri image pada tabel users_data
$user_id = $row3['id'];
$sql_event = "SELECT * FROM event WHERE user_id='$user_id'";
$query_event = mysqli_query($link, $sql_event);
$row_event = mysqli_fetch_array($query_event);
$row_img = mysqli_fetch_array($query_event);

if ($row_event["event_image"] && $row_event["event"] == "2") {
$count_img[] = $row3; //menghitung jumlah gambar
$image_path = "../uploads/images/".$row3['username']."/". $row_event['event_image'];
list($width, $height) = getimagesize('' .$image_path);

 $account = $row3["account"];
 
 echo '
<div class="col-lg-4 col-md-6 mb-4">

<div class="card"> 
  <div class="view overlay">
    <img class="card-img-top" src="'.$image_path.'" alt="'.$row3["firstname"].' - '.$account.'"> 
 </div>

<!-- Card content -->
  <div class="card-body">

    <!-- Title -->
';

 if ($row_event["image_title"]) {
    echo '<h4 class="card-title">'.$row_event["image_title"].'</h4>';
 } else {
 echo '<h4 class="card-title">Tanpa Judul</h4>';
}

echo '
    <!-- Text -->
    <p class="card-text">Diupload oleh <b><a href="/profile.php?id='.$row3["id"].'">'.$row3["firstname"].' '.$row3["lastname"].'</a></b>, akun dengan <b>User ID '.$row3["id"].'</a></b>.</p>

<p class="card-text">Ukuran: '.$width.'×'.$height.' | Jenis: '.mime_content_type($image_path).' | File: '.filesize_formatted($image_path).'</p>

<hr>';

if ($row_event["image_description"]) {
 echo nl2br('<p class="card-text">'.$row_event['image_description'].'</p>');
 } else {
 echo '<p class="card-text">Tidak ada deskripsi.</p>';
}

echo'
<hr> 
    <!-- Button -->
    <a href="'.$image_path.'" class="btn btn-primary btn-sm"><i class="fas fa-download"></i>&nbsp; Download</a>  <a href="user.php?user_id='.$row3["id"].'" class="btn btn-info btn-sm"><i class="fas fa-cog"></i>&nbsp; Pengaturan</a>
  </div>
 </div>
</div>
';
 }
}

?>

</div>
<!--/Grid column - Gambar -->
</div>
<!--/Tab 1 -->


<!-- Tab 2 -->
  <div class="tab-pane fade" id="pills-event-text" role="tabpanel" aria-labelledby="pills-event-text-tab">

<div class="alert alert-info" style="border-radius: 0px;">
Segera Hadir, rencananya fitur ini digunakan untuk memantau event berupa teks misalnya membuat cerita.
</div>
</div>
<!--/Tab 2 -->


<!-- Tab 3 -->
  <div class="tab-pane fade" id="pills-users" role="tabpanel" aria-labelledby="pills-users-tab">

<!-- Tabel Pengelola -->
<p><b>Tabel data akun admin dan moderator</b></p>
<div class="table-responsive">

<?php

 echo '<table id="tableAdmin" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">';
 echo '<thead>';
 echo '<tr>';
 echo '<th>ID</th>';
 echo '<th>Nama</th>';
 echo '<th>Email</th>';
 echo '<th>Username</th>';
 echo '<th>Akun</th>';
 echo '<th>Pengaturan</th>';
 echo '</tr>';
 echo '</thead>';
 echo '<tbody>';

while ($row1 = mysqli_fetch_array($query6)) {
 $account = $row1["account"];

 if ($account != "member") {
 echo '<tr>';
 echo '<td>'.$row1["id"].'</td>';
 echo '<td>'.$row1["firstname"].' '.$row1["lastname"].'</td>';
 echo '<td>'.$row1["email"].'</td>';
 echo '<td>'.$row1["username"].'</td>';
 echo '<td>'.$row1["account"].'</td>';
 echo '<td><a href="user.php?user_id='.$row1["id"].'"><button class="btn btn-info btn-sm">Pengaturan</button></a></td>';
 echo '</tr>';
   }
  }
 echo '</tbody>';
 echo '</table>';
 

?>
</div>

<hr>

<!-- Tabel Pengguna -->
<p><b>Tabel data akun pengguna</b></p>
<div class="table-responsive">

<?php

 echo '<table id="tableUser" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">';
 echo '<thead>';
 echo '<tr>';
 echo '<th>ID</th>';
 echo '<th>Nama</th>';
 echo '<th>Email</th>';
 echo '<th>Username</th>';
 echo '<th>Akun</th>';
 echo '<th>Pengaturan</th>';
 echo '</tr>';
 echo '</thead>';
 echo '<tbody>';

while ($row1 = mysqli_fetch_array($query1)) {
 $account = $row1["account"];

 if ($account == "member") {
 echo '<tr>';
 echo '<td>'.$row1["id"].'</td>';
 echo '<td>'.$row1["firstname"].' '.$row1["lastname"].'</td>';
 echo '<td>'.$row1["email"].'</td>';
 echo '<td>'.$row1["username"].'</td>';
 echo '<td>'.$row1["account"].'</td>';
 echo '<td><a href="user.php?user_id='.$row1["id"].'"><button class="btn btn-info btn-sm">Pengaturan</button></a></td>';
 echo '</tr>';
   }
  }
 echo '</tbody>';
 echo '</table>';
 
?>
</div>

<hr>

<br /><br />

<div class="alert alert-info fade show" role="alert">
   Dibawah ini adalah tabel data perserta yang sudah mendaftar/berpartisipasi pada event kita, tidak termasuk data pengguna yang tidak berpartisipasi.
  </div>

<!-- Tabel Perserta -->
<p><b>Tabel data akun perserta terdaftar</b></p>
<div class="table-responsive">
<?php

 echo '<table id="tableUser-participants" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">';
 echo '<thead>';
 echo '<tr>';
 echo '<th>ID</th>';
 echo '<th>Nama</th>';
 echo '<th>Email</th>';
 echo '<th>Username</th>';
 echo '<th>Akun</th>';
 echo '<th>Pengaturan</th>';
 echo '</tr>';
 echo '</thead>';
 echo '<tbody>'; 

while ($row1 = mysqli_fetch_array($query5)) {
 $account = $row1["account"];
// $event = $row1["event"];

$id_e = $row1["id"];
$sql_e = "SELECT * FROM event WHERE user_id='$id_e'";
$query_e = mysqli_query($link, $sql_e);
$row_e = mysqli_fetch_array($query_e);

 if ($row_e['event'] == 2) { 
 echo '<tr>';
 echo '<td>'.$row1["id"].'</td>';
 echo '<td>'.$row1["firstname"].' '.$row1["lastname"].'</td>';
 echo '<td>'.$row1["email"].'</td>';
 echo '<td>'.$row1["username"].'</td>';
 echo '<td>'.$row1["account"].'</td>';
 echo '<td><a href="user.php?user_id='.$row1["id"].'"><button class="btn btn-info btn-sm">Pengaturan</button></a></td>';
 echo '</tr>';
   }
  }
 echo '</tbody>';
 echo '</table>';

?>

</div>

</div>
<!--/Tab 3 -->

</div>
<!--/Tabs -->

     </main>
    </div>

    <!--/Main layout-->

<br>

<?php
include("../footer.php");
?>

    <script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="../assets/bootstrap/js/popper.min.js"></script>
    <script type="text/javascript" src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/bootstrap/js/mdb.min.js"></script>
   	<script type="text/javascript" src="../assets/js/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="../assets/bootstrap/js/addons/datatables.min.js"></script>

<script>
$('#updateCRE').on('click', function() {

    	loadingMsg();

    			var registerEvent = $('#chooseRE').val();
         var eventTitle = $('#eventTitle').val();
         var eventDescription = $('#eventDescription').val();

    			jQuery.ajax({
    				method: "POST",
    				data: {
             settings: 'update',
             type: 'event',
    					registerEvent: registerEvent,
             eventTitle: eventTitle,
             eventDescription: eventDescription,
    				},
    				url: "../includes/settings.php",
    				cache: false,
    				success: function(response) {


    					successMsg('Pengaturan disimpan');
    					updateData2();

    				},

    				error: function(server, exception) {
    					if (server.status === 0) {
    						errorMsg('Not connect.n Verify Network.');
    					} else if (server.status == 404) {
    						errorMsg('404 Requested page not found.');
    					} else if (server.status == 500) {
    						errorMsg('500 Internal Server Error.');
    					} else if (exception === 'parsererror') {
    						errorMsg('Requested JSON parse failed.');
    					} else if (exception === 'timeout') {
    						errorMsg('Time out error.');
    					} else if (exception === 'abort') {
    						errorMsg('Ajax request aborted.');
    					} else {
    						errorMsg('Uncaught Error.n' + server.responseText);
    					}
    				}
    			});
   });


   function loadingMsg() {
    	Swal.fire({
    		text: 'Sedang dalam proses...',
        allowOutsideClick: 'false',
    		onBeforeOpen: () => {
    			Swal.showLoading();
    		},
    		onClose: () => {

    		}
    	});
    }

    function successMsg(msg) {
    	Swal.fire({
    		type: 'success',
    		title: msg,
    		showConfirmButton: false,
    		timer: 2000
    	});
    }

    function errorMsg(msg) {
    	Swal.fire({
    		type: 'error',
    		title: 'Kesalahan server',
    		text: msg,
    		showConfirmButton: true
    	});
    }
	
	
	
$("#img-count").html("<?php echo count($count_img) ?>");
    // Material Select Initialization
    $(document).ready(function() {
    	$('.mdb-select').materialSelect();
    });

         // SideNav Initialization
        $(".button-collapse").sideNav();
        new WOW().init();

$(document).ready(function () {
$('#tableAdmin').DataTable({
"scrollX": true,
"scrollY": 200,
"searching": false,
"paging": false,
"info": false,
});
$('.dataTables_length').addClass('bs-select');
});

$(document).ready(function () {
$('#tableUser').DataTable({
"scrollX": true,
"scrollY": 200,
});

$('#tableUser-participants').DataTable({
"scrollX": true,
"scrollY": 200,
});
$('.dataTables_length').addClass('bs-select');
});

  </script>
</body>

</html>
