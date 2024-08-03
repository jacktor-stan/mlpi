<?php 

require_once("config.php");

session_start();
 $id_session = $_SESSION["user"]["id"];
 $sql_session = "SELECT * FROM users WHERE id='$id_session'";
 $query_session = mysqli_query($link, $sql_session);
 $row_session = mysqli_fetch_array($query_session);

if (isset($_POST['update'])) {
    $code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING);

if ($row_session['code'] == str_replace(' ', '', $code)) {
$sql_p = "UPDATE users SET active='Y' WHERE id='$id_session'"; 
mysqli_query($link, $sql_p);
  header("Location: event.php");
  } else {
   header("Location: ?activation=failed");
 }
  
}

//Vertifikasi email via link url
 $email_g = $_GET['email'];
 $token_g = $_GET['auth'];
 $sql_g = "SELECT * FROM users WHERE email='$email_g' AND token='$token_g'";
 $query_g = mysqli_query($link, $sql_g);
 $row_g = mysqli_fetch_array($query_g);

if (isset($email_g) && isset($email_g)) {
if (md5($row_g['token']) == md5($_GET['auth'])) {
$sql_g = "UPDATE users SET active='Y' WHERE email='$email_g' AND token='$token_g'";
mysqli_query($link, $sql_g);

  header("Location: login.php?activation=success");
  } else {
    header("Location: activation.php?token=error");
 }
}


if ($row_session['active'] == "Y") {
 if (isset($_SESSION["user"])) {
  header("Location: event.php");
 }
}

//Include
 $user_header = $id_session;
  
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>My Little Pony Indonesia - Konfirmasi Email</title>

    <link rel="stylesheet" href="css/fontawesome/css/all.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mdb.min.css" rel="stylesheet">
    <link href="css/sweetalert2.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">

</head>

<body class="fixed-sn white-skin">
    
    
<?php
//Header
$header_title = "Konfirmasi Email";
$fa_icon = "fas fa-calendar-alt";
include("include/header.php");
?>
    
 <div class="container">

<main>


<!-- Menampilkan pesan -->
<?php


if (isset($_GET["activation"]) OR isset($_GET["token"])) {
//Jika kode tidak valid
if ($_GET["activation"] == "failed") {
echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
   <a href="#" class="close" data-dismiss="alert">&times;</a> 
   <b><i class="fa fa-times"></i> &nbsp; Vertifikasi Gagal!</b><br>
   <font style="font-size: 14px;">Kode yang dimasukan tidak valid</font>
  </div><br>';
}

//Jika url token tidak valid
if ($_GET["token"] == "error") {
echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
   <a href="#" class="close" data-dismiss="alert">&times;</a> 
   <b><i class="fa fa-times"></i> &nbsp; Vertifikasi Gagal!</b><br>
   <font style="font-size: 14px;">Kesalahan token autentikasi, hubungi admin untuk mendapatkan bantuan</font>
  </div><br>';
 }
}

?>


<!-- Material form login -->
<div class="card">

  <h5 class="card-header info-color white-text text-center py-4">
    <strong>Konfirmasi Email Anda</strong>
  </h5>

  <!--Card content-->
  <div class="card-body px-lg-5 pt-0">

<br>

<p class="card-text">Masukkan kode verifikasi yang telah kami kirimkan kepada <?php echo $_SESSION['user']['email']; ?></p>

<p class="card-text">Periksa juga kotak spam email anda jika email tidak muncul</p>

<p class="card-text">Belum menerima kode? <span id="resend">Kirim Ulang</span></p>



    <!-- Form -->
    <form method="POST" class="text-center" style="color: #757575;">

      <!-- Email -->
      <div class="md-form">
        <input type="text" id="code" class="form-control" name="code" placeholder="MLPI-" required>
        <label for="code">Kode Vertifikasi</label>
      </div>

   


     
      <!-- Sign in button -->
      <button class="btn btn-outline-info btn-block my-4 waves-effect z-depth-0" type="submit" name="update">Konfirmasi</button>






    </form>
    <!-- Form -->

  </div>

</div>
<!-- Material form login -->





     </main>
    </div>

<br /><br />
    <!--/Main layout-->


<!-- Konten footer -->
<?php 
include("include/footer.php"); 
?>

    <script type="text/javascript" src="javascript/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="javascript/popper.min.js"></script>
    <script type="text/javascript" src="javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="javascript/mdb.min.js"></script>
    	<script type="text/javascript" src="../javascript/sweetalert2.all.min.js"></script>


    <script>

         // SideNav Initialization
        $(".button-collapse").sideNav();
        
        new WOW().init();


  </script>


<script>


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

function loadingMsg() {
    	Swal.fire({
    		text: 'Mengirim ulang email...',
        allowOutsideClick: 'false',
    		onBeforeOpen: () => {
    			Swal.showLoading();
    		},
    		onClose: () => {

    		}
    	});
    }


$("#resend").html('<a href="#" onclick="resend()">Kirim Ulang</a>');

//update 1
function resend() {
document.getElementById("resend").innerHTML = 'Kirim Ulang Lagi (<span id="waktu"></span>)';
var waktu = 50;
setInterval(function() {
waktu--;
if (waktu < 0) {
 } else{
document.getElementById("waktu").innerHTML = waktu;
}
}, 1000);


setTimeout(function() {
  $("#resend").html('<a href="#" onclick="resend()">Kirim Ulang</a>');
 }, '50000');

loadingMsg();

    	var firstname = "<?php echo $row_session['firstname'] ?>";
    	var lastname = "<?php echo $row_session['lastname'] ?>";
    	var email = "<?php echo $row_session['email'] ?>";

    	jQuery.ajax({
    		method: "POST",
    		data: {
         resend_email: 'resend_email',
    			firstname: firstname,
    			lastname: lastname,
    			email: email,
    		},
    		url: "../libraries/resend_email.php",
    		cache: false,
    		success: function(response) {

    			successMsg('Email telah dikirim ulang');
    			//updateData1();
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
    }
</script>

</body>

</html>
