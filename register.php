<?php
//Header config
$title = "MLPI - Masuk";
$fa_icon = "fas fa-login";
$home_active = false;
$event_active = false;
$admin_active = false;
$default_meta_description = "";
$default_meta_image = "";
$dir_type = "";
include("header.php");

 

if (isset($_POST['register'])) {

    // filter data yang diinputkan
    $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
    $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    // enkripsi password
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); 
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

//cek ketersediaan email dan username, jika tersedia diizinkan daftar
$query_e = "select count(*) as checkE from users where email='".$email."'";
$query_u = "select count(*) as checkU from users where username='".$username."'";

$result_e = mysqli_query($link, $query_e);
$result_u = mysqli_query($link, $query_u);

$row_e = mysqli_fetch_array($result_e);
$row_u = mysqli_fetch_array($result_u);

if (preg_match('/([a-zA-Z])/', $username) && preg_match('/^[0-9A-Za-z_]+$/', $username)) {
 $check2 = 0;
 } else {
 $check2 = 1;
}

$check = $row_e['checkE'].$row_u['checkU'].$check2;

if ($check == 000) {
    //Random num
    $profile_image = "images/avatar/profile_".rand(1,6).".png";
    $code = "MLPI-".rand(1000,5540);
  function get_token($long){
  $token = array(
   range(1,9),
   range('a','z'),
   range('A','Z')
  );

  $karakter = array();
  foreach($token as $key=>$val){
   foreach($val as $k=>$v){
    $karakter[] = $v;
   }
  }

  $token = null;
  for($i=1; $i<=$long; $i++){
   // mengambil array secara acak
   $token .= $karakter[rand($i, count($karakter) - 1)];
  }

  return $token;
 }

  $token = get_token(50);

    //Kirim html konfirmasi email
    include("include/email_confirmation.php");

    // menyiapkan query
    $sql = "INSERT INTO users (firstname, lastname, username, email, password, profile_image, code, token) 
            VALUES (:firstname, :lastname, :username, :email, :password, :profile_image, :code, :token)";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":firstname" => $firstname,
        ":lastname" => $lastname,
        ":username" => $username,
        ":password" => $password,
        ":email" => $email,
        ":profile_image" => $profile_image,
        ":code" => $code,
        ":token" => $token
    );

    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);

    // jika query simpan berhasil, maka user sudah terdaftar
    // maka alihkan ke halaman login
    if ($saved) {
        header("Location: incomplete_check.php?login=new_user");
   }

//Set cookies untuk sementara
setcookie("username", $username, time()+(10 * 365 * 24 * 60 * 60));
setcookie("password", $_POST["password"], time()+(10 * 365 * 24 * 60 * 60));
setcookie("firstname", "");
setcookie("lastname", "");
setcookie("email", "");
}

session_start();
if(isset($_SESSION["user"])) {
   header("Location: event.php");
 } else if (!$saved) {
   header("Location: register.php?reg=error");
//Set cookies untuk sementara jika error
setcookie("firstname", $_POST["firstname"], time()+(10 * 365 * 24 * 60 * 60));
setcookie("lastname", $_POST["lastname"], time()+(10 * 365 * 24 * 60 * 60));
setcookie("email", $_POST["email"], time()+(10 * 365 * 24 * 60 * 60));
setcookie("username", $username, time()+(10 * 365 * 24 * 60 * 60));
 }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>My Little Pony Indonesia - Daftar</title>
    <link rel="stylesheet" href="css/fontawesome/css/all.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mdb.min.css" rel="stylesheet">
 <link href="css/animate.css" rel="stylesheet">

</head>

<body class="fixed-sn white-skin">
    
    <!--Double navigation-->
      <header>
 <!--Navbar -->
<nav class="mb-1 navbar navbar-expand-lg navbar-dark stylish-color fixed-top">

  <a class="navbar-brand" href="#"><i class="fas fa-home"></i>&nbsp; MLPI - Daftar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
    aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="../">
          Beranda
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../event.php">
          Event MLPI</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true"
          aria-expanded="false">
          Daftar/Masuk</a>
        <div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">

 <a class="dropdown-item" href="register.php"><i class="fas fa-user-circle"></i>&nbsp; Daftar</a>
          <a class="dropdown-item" href="login.php"><i class="fas fa-sign-out-alt"></i>&nbsp; Masuk</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
<!--/.Navbar -->
    </header>
    <!--/.Double navigation-->
    
 <!--Main layout-->
 <div class="container">

<main>

<?php

//Jika user selesai aktivasi
if (isset($_GET["reg"]) == "error") {
echo '<div class="alert alert-danger"> 
   <font style="font-size: 14px;">Pendaftaran tidak bisa dilakukan, silahkan periksa kesalahan dibawah ini.</font>
  </div><br>';
}

?>


<div class="card">

    <h5 class="card-header info-color white-text text-center py-4">
        <strong>Formulir Pendaftaran</strong>
    </h5>

    <!--Card content-->
    <div class="card-body px-lg-5 pt-0">

        <!-- Form -->
        <form action="" method="POST" class="text-center" style="color: #757575;">

            <div class="form-row">
                <div class="col">
                    <!-- First name -->
                    <div class="md-form">
                        <input type="text" id="firstName" class="form-control" name="firstname" value="<?php if (isset($_GET["reg"]) == "error") echo $_COOKIE['firstname'] ?>" required>
                        <label for="firstName">Nama Depan</label>
                    </div>
                </div>
                <div class="col">
                    <!-- Last name -->
                    <div class="md-form">
                        <input type="text" id="lastName" class="form-control" name="lastname" value="<?php if (isset($_GET["reg"]) == "error") echo $_COOKIE['lastname'] ?>" required>
                        <label for="lastName">Nama Belakang</label>
                    </div>
                </div>
            </div>

            <!-- E-mail -->
            <div class="md-form mt-0">
                <input type="email" id="mail" class="form-control" name="email" value="<?php if (isset($_GET["reg"]) == "error") echo $_COOKIE['email'] ?>" required>
                <label for="email">E-mail</label>
                <small id="email_response" class="form-text mb-4"></small>
            </div>


  <!-- Username -->
            <div class="md-form">
                <input type="text" id="username" class="form-control" name="username" value="<?php if (isset($_GET["reg"]) == "error") echo $_COOKIE['username'] ?>" required>
                <label for="username">Nama Pengguna</label>
                <small id="uname_response" class="form-text mb-4"></small>
            </div>

            <!-- Password -->
            <div class="md-form">
                <input type="password" id="password" class="form-control" aria-describedby="password" name="password" required>
                <label for="password">Kata Sandi Baru</label>
                <small id="password-strength-status" class="form-text mb-4">
                    Setidaknya 8 karakter dan 1 digit
                </small>
            </div>

            <!-- Newsletter -->
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="participant">
                <label class="form-check-label" for="participant">Saya adalah perserta</label>
            </div> 

            <!-- Sign up button -->
            <div id="signup">
            <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit" name="register">Daftar</button>
          </div>

            <hr>

            <!-- Terms of service -->
            <p>Dengan mengklik
                <em>Daftar</em> anda setuju dengan
                <a href="" target="_blank">ketentuan layanan kami</a>

        </form>
        <!-- Form -->
    </div>

</div>
<!-- Material form register -->
  
     </main>
    </div>

<br /><br />
    <!--/Main layout-->


<?php
include ("footer.php");
?>
  
    <script type="text/javascript" src="javascript/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="javascript/popper.min.js"></script>
    <script type="text/javascript" src="javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="javascript/mdb.min.js"></script>

<script>

$(document).ready(function() {
//check email
checkEmail();
checkUsername();

//check email & username - keyup
   $("#mail").keyup(function(){
  checkEmail();
 });
   $("#username").keyup(function() {
checkUsername();
    });
 });

$(document).ready(function() {
 $("#password").keyup(function() {

   var password = $("#password").val().trim();
  if (password != '') {
    
$("#password-strength-status").show();
	var number = /([0-9])/;
	var alphabets = /([a-zA-Z])/;

	if ($('#password').val().length < 8) {
		$('#password-strength-status').html('<span class="text-warning">Lemah (minimal 8 karakter.)</span>');
    $("#password").addClass("invalid");
    $("#password").removeClass("valid");
    disableSignup();
	} else {  	
	    if ($('#password').val().match(number) && $('#password').val().match(alphabets)) {    
			$('#password-strength-status').html('<span class="text-success">Kuat</span>');
        } else {
			$('#password-strength-status').html('<span class="text-info">Sedang (harus menyertakan huruf dan angka.)</span>');
     $("#password").addClass("valid");
     $("#password").removeClass("invalid");
     enableSignup();
    } 
	 }
  } else {
   $("#password-strength-status").hide();
   $("#password").removeClass("valid");
   $("#password").removeClass("invalid");
  }

 });
});

function checkEmail() {
    var email = $("#mail").val().trim();

      if(email != '') {
         $("#email_response").show();
         $.ajax({
            url: 'libraries/email.php',
            type: 'post',
            data: {email:email},
            success: function(response) {

                if (response > 0){
                    $("#mail").addClass("invalid");
                    $("#mail").removeClass("valid");
                    $("#email_response").html("<span class='text-danger'>Email sudah digunakan</span>");
                    //disableSignup();
                } else {
                    $("#mail").removeClass("invalid");
                    $("#mail").addClass("valid");
                    $("#email_response").html("");
                    //enableSignup();
                }
                
             } 
          });
      } else {
         $("#email_response").hide();
         $("#mail").removeClass("valid");
         $("#mail").removeClass("invalid");
    }
}

function checkUsername() {
    var username = $("#username").val().trim();

      if (username != '') {
         $("#uname_response").show();
         
         $.ajax({
            url: 'libraries/username.php',
            type: 'post',
            data: {username:username},
            success: function(response) {

        if ($('#username').val().length > 3) {
                if (response == 0) {
                    $("#username").addClass("invalid");
                    $("#username").removeClass("valid");
                    $("#uname_response").html("<span class='text-danger'>Nama pengguna tidak tersedia</span>");
                    //disableSignup();
                } else if (response == 1) {
                    $("#username").removeClass("invalid");
                    $("#username").addClass("valid");
                    $("#uname_response").html("<span class='text-success'>Nama pengguna tersedia</span>");
                    //enableSignup();
                } else if (response == 2) {
                    $("#username").addClass("invalid");
                    $("#username").removeClass("valid");
                    $("#uname_response").html("<span class='text-warning'>Karakter ini tidak diizinkan</span>");
                     //disableSignup();
              } else {  
$("#uname_response").html("<span class='text-warning'>Nama pengguna wajib menggunakan kata</span>");
   disableSignup();
             }

            } else {
              $("#uname_response").html("<span class='text-warning'>Nama pengguna tidak boleh kurang dari 4 kata</span>");
              //disableSignup();
           }
          }
         });

      } else {
         $("#uname_response").hide();
         $("#username").removeClass("valid");
         $("#username").removeClass("invalid");
      }
 }

  //Tombol daftar
  function enableSignup() {
    $("#signup").html('<button id="signup" class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit" name="register">Daftar</button>');
  }

  function disableSignup() {
    $("#signup").html('<button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" disabled>Daftar</button>');
   checkEmail();
  }

    // SideNav Initialization
    $(".button-collapse").sideNav();
        
    new WOW().init();
  </script>
</body>

</html>
