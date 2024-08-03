<?php
//Header config
$title_profile = "Profil";
$home_active = false;
$event_active = false;
$admin_active = false;
$default_meta_description = "";
$default_meta_image = "";
$dir_type = "";
include("header.php");

$id_session = $_SESSION["user"]["id"];
$username_session = $_SESSION["user"]["username"];

$id2 = $row_p['id'];
$sql_data = "SELECT * FROM users WHERE id='$id2'";
$sql_result = "SELECT 1 FROM users WHERE id='$id_p' OR username='$id_p'";

$query_session = mysqli_query($link, $sql_session);
$query_data = mysqli_query($link, $sql_data);

$row_session = mysqli_fetch_array($query_session);
$row_data = mysqli_fetch_array($query_data);
$result_h = mysqli_query($link, $sql_result);
$result_c = mysqli_query($link, $sql_result);

//Tagname
 $user_header = $id_session;
 $id_tagname = $id2;
?>

<!--Main layout-->
<main>
<div class="container">
<?php
//Tampilkan konten ini hanya jika akun user sudah terdaftar
if (mysqli_fetch_row($result_c)) {
	//Profil
echo '
		  <div class="card testimonial-card ">
		  <div class="card-up aqua-gradient "></div>

		  <!-- Avatar -->
		  <div class="avatar mx-auto white">
		  <img src="../'.$row_p['profile_image'].'" class="rounded-circle" alt="'.$row_p['username'].' - avatar" id="profileImg">
					</div>

					<!-- Content -->
					<div class="card-body">
						<!-- Name -->
						<h4 class="card-title" id="name">'.$row_p["firstname"].' '.$row_p["lastname"].'</h4>';

include("includes/tagname.php");

echo '<hr>';

if ($id_session == $id2) {
echo '<p><div class="md-form"><input type="text" id="quote" value="'.$row_data['bio'].'" class="form-control"></p></div>';
 } else {
 echo '<p>'.$row_data['bio'].'</p>';
}

echo '
		</div>
	</div>
<br /><br />';

if (isset($_GET['account']) == "settings" && $id_session == $id2) {
	//Informasi akun"
	echo '<div class="card">
	<div class="card-body">
		Informasi Akun
		<br>
		<small class="font-weight-light">Ubah informasi akun pada pengguna ini</small>

		<hr>

		<div class="form-row">
			<div class="col">
				<!-- First name -->
				<div class="md-form">
					<input type="text" id="firstName" class="form-control" name="firstname" value="'.$row_p['firstname'].'">
					<label for="firstname">Nama Depan</label>
				</div>
			</div>
			<div class="col">
				<!-- Last name -->
				<div class="md-form">
					<input type="text" id="lastName" class="form-control" name="lastname" value="'.$row_p['lastname'].'">
					<label for="lastName">Nama Belakang</label>
				</div>
			</div>
		</div>

		<div class="md-form mt-0">
			<input type="email" id="email" name="email" value="'.$row_p['email'].'" class="form-control">
			<label for="email">E-mail</label>
		</div>

		<div class="md-form">
			<input type="text" id="username" name="username" value="'.$row_p['username'].'" class="form-control" disabled>
			<label for="username">Nama Pengguna (tidak bisa diubah saat ini)</label>
		</div>
		<button type="button" class="btn btn-primary btn-sm" id="update1">Simpan</button>
	</div>
</div>
<br><br>';

    //Informasi pribadi
	echo '<div class="card">
	<div class="card-body">
		Informasi Pribadi
		<br>
		<small class="font-weight-light">Ubah informasi akun pada pengguna ini</small>
		<hr>
		<div class="md-form">
			<input type="password" id="password" value="" class="form-control">
			<label for="name">Kata Sandi (akan dienkripsi hash)</label>
		</div>
	</div>
</div>				
<br><br>';

	//Hapus akun
	echo '<div class="card">
	<div class="card-body">
		Hapus Akun
		<br>
		<small class="font-weight-light">Hapus akun anda secara permanen, saat ini tidak tersedia</small>
		<hr>
		<button type="button" class="btn btn-danger btn-sm" id="deleteAccount" disabled>Hapus akun</button>
	</div>
</div>';

//Jika tidak membuka pengaturan profil, maka tampilkan konten ini
 } else {
echo '<!-- Grid column - Gambar -->
<div class="row">

</div>';
 }
} ?>

</div>
<!--/Grid column - Gambar -->

</div>
</main>
<!--/Main layout-->

<br /><br />
				
<?php

require_once("footer.php");

?>

<script type="text/javascript" src="/assets/bootstrap/js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="/assets/bootstrap/js/popper.min.js"></script>
<script type="text/javascript" src="/assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/bootstrap/js/mdb.min.js"></script>
<script type="text/javascript" src="/assets/bootstrap/js/addons/datatables.min.js"></script>
<script type="text/javascript" src="/assets/js/sweetalert2.all.min.js"></script>


<script>
    // Material Select Initialization
    $(document).ready(function() {
    	$('.mdb-select').materialSelect();
    });

    //update
    $('#quote').on('input', function() {

    	var user_id = "<?php echo $id_session ?>"
    	var bio = this.value;

    	jQuery.ajax({
    		method: "POST",
    		data: {
         account: 'update',
    			user_id: user_id,
    			bio: bio,
    		},
    		url: "includes/account.php",
    		cache: false,
    	});
    });


    //update 1
    $('#update1').on('click', function() {

    	loadingMsg();

    	var user_id = "<?php echo $id_session ?>"
    	var firstname = $('#firstName').val();
    	var lastname = $('#lastName').val();
    	var email = $('#email').val();
    	var username = $('#username').val();

    	jQuery.ajax({
    		method: "POST",
    		data: {
         account: 'update',
    			user_id: user_id,
    			firstname: firstname,
    			lastname: lastname,
    			email: email,
    			//username: username,
    		},
    		url: "includes/account.php",
    		cache: false,
    		success: function(response) {

    			successMsg('Informasi disimpan');
    			updateData1();
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


    //update 2
    $('#update2').on('click', function() {

    	loadingMsg();

    	var choosePosition = $('#choosePosition').val();
    	var chooseRole = $('#chooseRole').val();

    	if (choosePosition == "member" && chooseRole == 1) {
    		Swal.fire({
    			type: 'warning',
    			// title: 'Kesalahan',
    			text: 'Anggota tidak bisa dijadikan juri'
    		});
    	} else {

    		if ("<?php echo $row_session['account'] ?>" != "developer") {
    			var dev = "developer";
    		} else {
    			var dev = "";
    		}

    		if ($('#choosePosition').val() != dev) {
    			var user_id = "<?php echo $_GET['user_id'] ?>"
    			var choosePosition = $('#choosePosition').val();
    			var chooseRole = $('#chooseRole').val();

    			jQuery.ajax({
    				method: "POST",
    				data: {
             account: 'update',
    					user_id: user_id,
    					choosePosition: choosePosition,
    					chooseRole: chooseRole,
    				},
    				url: "includes/account.php",
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
    		} else {

    			Swal.fire({
    				type: 'error',
    				title: 'Akses Ditolak',
    				text: 'Anda tidak memiliki izin ini!',
    				footer: '<a href="#">Mengapa saya memiliki masalah ini?</a>'
    			});
    		}
    	}
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

    function updateData1() {
    	jQuery.ajax({
    		url: "includes/json.php?user_id=<?php echo $id_session ?>",
    		dataType: 'json',
    		success: function(data) {

    			$('#name').html(data[0] + ' ' + data[1]);
    		}
    	});
    }

    function updateData2() {
    	jQuery.ajax({
    		url: "includes/json.php?user_id=<?php echo $id_session ?>",
    		dataType: 'json',
    		success: function(data) {

    			var hex = data[4],
    				bytes = [],
    				str;

    			for (var i = 0; i < hex.length - 1; i += 2) {
    				bytes.push(parseInt(hex.substr(i, 2), 16));
    			}

    			str = String.fromCharCode.apply(String, bytes);
    		 $('#account').html(str);
    		}
    	});
    }

    $('#deleteAccount').on('click', function() {

    	Swal.fire({
    		title: 'Peringatan',
    		text: "Tindakan ini tidak dapat diurungkan!, semua data akun termasuk file yang telah diupload akan dihapus secara permanen",
    		type: 'warning',
    		showCancelButton: true,
    		confirmButtonColor: '#3085d6',
    		cancelButtonColor: '#d33',
    		confirmButtonText: 'Ya',
    		cancelButtonText: 'Batal'
    	}).then((result) => {

    		if (result.value) {
    		
        password();
    		}
    	})
    });

function password(msg) {
	(async function() {
    				const {
    					value: password
    				} = await Swal.fire({
    					title: 'Konfirmasi',
             text: msg,
    					input: 'password',
    					inputPlaceholder: 'Masukkan kata sandi anda...',
             confirmButtonText: 'OKE',
             cancelButtonText: 'Batal',
             showCancelButton: true,
             cancelButtonColor: '#d33',
    					inputAttributes: {
    						autocapitalize: 'off',
    						autocorrect: 'off'
    					}
    				})

      var user_id = "<?php echo $id_session ?>"

    				if (password) {
    					jQuery.ajax({
    						method: "POST",
    						data: {
                account: 'delete',
    	           user_id: user_id,
                 password: password,
    						},
    						url: "includes/account.php",
    						cache: false,
    						success: function(password) {
               loadingMsg();
    							if (password == 'true') {

<!--

              jQuery.ajax({
    						method: "GET",
    						url: "libraries/account.php?user_id="+user_id,
    						cache: false,
    						success: function(data) {}
});
-->


    								setTimeout('location.href = "/admin/"', 3000);
    							} else {
    								Swal.fire({
    									type: 'error',
    									title: 'Kata Sandi Salah',
    									text: 'Pastikan kata sandi yang dimasukan sudah benar.',
    									showConfirmButton: true
    								});
    							}
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
    				} else if (password == '') { 
setTimeout('password("Mohon masukkan kata sandi anda")', 1000); 
            }
    			})()
 }

</script>
  </body>

</html>
