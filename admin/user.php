<?php 
$title_profile = "Edit User";
$home_active = false;
$event_active = false;
$admin_active = true;
$default_meta_description = "";
$default_meta_image = "";
$dir_type = "..";
include("../header.php");

//require_once("../config.php");
//require_once("auth.php");

$id = $_GET['user_id'];
//$id_session = $_SESSION["user"]["id"];

$sql = "SELECT * FROM users WHERE id='$id'";
//$sql_session = "SELECT * FROM users WHERE id='$id_session'";
$sql_event = "SELECT * FROM event WHERE user_id='$id'";
$sql_result = "SELECT 1 FROM users WHERE id='$id'";

$query = mysqli_query($link, $sql);
//$query_session = mysqli_query($link, $sql_session);
$query_event = mysqli_query($link, $sql_event);

$row = mysqli_fetch_array($query);
//$row_session = mysqli_fetch_array($query_session);
$row_event = mysqli_fetch_array($query_event);
$result_h = mysqli_query($link, $sql_result);
$result_c = mysqli_query($link, $sql_result);

//Include
 //$user_header = $id_session;
 $id_tagname = $id;

?>

<!--Main layout-->
<main> 
<div class="container">

<?php

if ($row_session['account'] != "moderator") {
//Tampilkan konten ini hanya jika akun user sudah terdaftar
if (mysqli_fetch_row($result_c)) {
echo '
<!-- Profil -->
		  <div class="card testimonial-card ">

		  <!-- Background color -->
		  <div class="card-up aqua-gradient "></div>

		  <!-- Avatar -->
		  <div class="avatar mx-auto white ">

		  <img src="../'.$row['profile_image'].'" class="rounded-circle" alt="'.$row['username'].' - avatar" id="profileImg">
					</div>

					<!-- Content -->
					<div class="card-body">
						<!-- Name -->
						<h4 class="card-title" id="name">'.$row["firstname"].' '.$row["lastname"].'</h4>';

//Tagname
include("../includes/tagname.php");

echo '
<hr>
<!-- Bio -->
<p><div class="md-form"><input type="text" id="quote" value="'.$row['bio'].'" class="form-control"></p></div>
			</div>
	</div>
<!-- Profil -->

<br /><br />

					<!-- Informasi akun -->
					<div class="card">
						<div class="card-body">
							Informasi Akun
							<br>
							<small class="font-weight-light">Ubah informasi akun pada pengguna ini</small>

							<hr>

							<div class="form-row">
								<div class="col">
									<!-- First name -->
									<div class="md-form">
										<input type="text" id="firstName" class="form-control" name="firstname" value="'.$row['firstname'].'">
										<label for="firstname">Nama Depan</label>
									</div>
								</div>
								<div class="col">
									<!-- Last name -->
									<div class="md-form">
										<input type="text" id="lastName" class="form-control" name="lastname" value="'.$row['lastname'].'">
										<label for="lastName">Nama Belakang</label>
									</div>
								</div>
							</div>

							<div class="md-form mt-0">
								<input type="email" id="email" name="email" value="'.$row['email'].'" class="form-control">
								<label for="email">E-mail</label>
							</div>

							<div class="md-form">
								<input type="text" id="username" name="username" value="'.$row['username'].'" class="form-control" disabled>
								<label for="username">Nama Pengguna (Tidak bisa diubah saat ini)</label>
							</div>

							<button type="button" class="btn btn-primary btn-sm" id="update1">Simpan</button>

						</div>
					</div>

					<br><br>


					<!-- Informasi pribadi -->
					<div class="card">
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

<br><br>

					<!-- Pengaturan -->
					<div class="card">
						<div class="card-body">
							Pengaturan Akun
							<br>
							<small class="font-weight-light">Ubah pengaturan akun pada pengguna ini</small>

							<hr>

	<select class="mdb-select md-form" id="activationStatus">
				<option value="" disabled selected>Aktifkan Akun</option>
				<option value="Y" '.str_replace("Y","selected",$row['active']).'>YA</option>
				<option value="N" '.str_replace("N","selected",$row['active']).'>Tidak</option>
			</select>

<hr>

			<select class="mdb-select md-form" id="choosePosition">
				<option value="" disabled selected>Pilih Jabatan</option>
				<option value="developer" '.str_replace("developer","selected",$row['account']).'>Developer</option>
				<option value="admin" '.str_replace("admin","selected",$row['account']).'>Admin</option>
				<option value="moderator" '.str_replace("moderator","selected",$row['account']).'>Moderator</option>
				<option value="member" '.str_replace("member","selected",$row['account']).'>Anggota</option>
			</select>

			<select class="mdb-select md-form" id="chooseRole">
				<option value="" disabled selected>Pilih Peran</option>
				<option value="0" '.str_replace("0","selected",$row_event['event']).'>Tidak ada</option>
				<option value="1" '.str_replace("1","selected",$row_event['event']).'>Juri</option>
				<option value="2" '.str_replace("2","selected",$row_event['event']).'>Perserta</option> 
			</select>

<button type="button" class="btn btn-primary btn-sm" id="update2">Simpan</button>

						</div>
					</div>
<br><br>
					<!-- Hapus akun -->
					<div class="card">
						<div class="card-body">
							Hapus Akun
							<br>
							<small class="font-weight-light">Hapus akun pada pengguna ini</small>

							<hr>

							<button type="button" class="btn btn-danger btn-sm" id="deleteAccount">Hapus akun</button>

						</div>
					</div>
	<!-- Hapus akun -->
';

//Jika akun user tidak terdaftar maka tampilkan konten ini
 } else {

echo '
					<div class="card">
						<div class="card-body">
						<p>Tidak ada informasi akun untuk user id ini - ['.$_GET['user_id'].']</p>
           <p class="font-weight-light">User id ini belum terdaftar di database MySQL atau akun ini telah dihapus permanen, jika ada pertanyaan silahkan hubungi developer untuk informasi lebih lanjut.</p>
            <p>- DENI LIANDI -</p>
							<hr>

							<a href="/admin/"><button type="button" class="btn btn-info btn-sm">Kembali ke panel admin</button></a>

						</div>
					</div>
';
}


 } else {
echo '
					<div class="card">
						<div class="card-body">
						<p>Tidak ada izin untuk mengakses laman ini</p>
           <p class="font-weight-light">Anda adalah moderator, hanya admin yang diizinkan untuk mengakses laman ini.</p>
            <p>- DENI LIANDI -</p>
							<hr>

							<a href="/admin/"><button type="button" class="btn btn-info btn-sm">Kembali ke panel admin</button></a>

						</div>
					</div>
</div>
';
}

?>
</div>
</main>
<!--/Main layout-->

<br /><br />
					
<?php

require_once("../footer.php");

?>

    <script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="../assets/bootstrap/js/popper.min.js"></script>
    <script type="text/javascript" src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../assets/bootstrap/js/mdb.min.js"></script>
   	<script type="text/javascript" src="../assets/js/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="../assets/bootstrap/js/addons/datatables.min.js"></script>


<script>
    // Material Select Initialization
    $(document).ready(function() {
    	$('.mdb-select').materialSelect();
    });

    //update
    $('#quote').on('input', function() {

    	var user_id = "<?php echo $_GET['user_id'] ?>"
    	var bio = this.value;

    	jQuery.ajax({
    		method: "POST",
    		data: {
         account: 'update',
    			user_id: user_id,
    			bio: bio,
    		},
    		url: "../includes/account.php",
    		cache: false,
    	});
    });


    //update 1
    $('#update1').on('click', function() {

    	loadingMsg();

    	var user_id = "<?php echo $_GET['user_id'] ?>"
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
    		url: "../includes/account.php",
    		cache: false,
    		success: function(response) {

    			successMsg('Informasi disimpan');
    			updateData1();
    		},

    		error: function(server, exception) {
    			errorServer(server, exception);
    		}
    	});
    });

    //update 2
    $('#update2').on('click', function() {

    	loadingMsg();

     var activationStatus = $('#activationStatus').val();
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
             activationStatus: activationStatus,
    					choosePosition: choosePosition,
    					chooseRole: chooseRole,
    				},
    				url: "../includes/account.php",
    				cache: false,
    				success: function(response) {

    					successMsg('Pengaturan disimpan');
    					updateData2();

    				},

    				error: function(server, exception) {
    					errorServer(server, exception);
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

//Server error handler
function errorServer(server, exception) {
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
    		url: "../includes/json.php?user_id=<?php echo $row['id'] ?>",
    		dataType: 'json',
    		success: function(data) {

    			$('#name').html(data[0] + ' ' + data[1]);
    		}
    	});
    }

    function updateData2() {
    	jQuery.ajax({
    		url: "../includes/json.php?user_id=<?php echo $row['id'] ?>",
    		dataType: 'json',
    		success: function(data) {

    			var hex = data[4],
    				bytes = [],
    				str;

    			for (var i = 0; i < hex.length - 1; i += 2) {
    				bytes.push(parseInt(hex.substr(i, 2), 16));
    			}

    			str = String.fromCharCode.apply(String, bytes);
    		 $('#tagname').html(str);
    		}
    	});
    }

    $('#deleteAccount').on('click', function() {

    	Swal.fire({
    		title: 'Hapus akun pengguna ini?',
    		text: "Tindakan ini tidak dapat diurungkan!",
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

      var user_id = "<?php echo $_GET['user_id'] ?>"

    				if (password) {
    					jQuery.ajax({
    						method: "POST",
    						data: {
                account: 'delete',
    	           user_id: user_id,
                 password: password,
    						},
    						url: "../includes/account.php",
    						cache: false,
    						success: function(password) {
loadingMsg();
    							if (password == 'true') {
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
    							errorServer(server, exception);
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
