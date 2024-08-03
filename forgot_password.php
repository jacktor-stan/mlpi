<?php 
//Header config
$title = "MLPI - Lupa Kata Sandi";
$fa_icon = "fas fa-login";
$home_active = false;
$event_active = false;
$admin_active = false;
$default_meta_description = "";
$default_meta_image = "";
$dir_type = "";
include("header.php");

require_once("config.php");

if (isset($_POST['update'])) {

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);




    $sql = "SELECT * FROM users WHERE email=:email";
    $stmt = $db->prepare($sql); 
    
    // bind parameter ke query
    $params = array(
        ":email" => $email
    );

    $stmt->execute($params); 

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // jika user terdaftar
    if ($user) {

if (md5($token) == md5($user['token'])) {
$email_p = $user["email"];
$sql_p = "UPDATE users SET password='$password' WHERE email='$email_p'"; 
 
 if (mysqli_query($link, $sql_p)) {
   header("Location: login.php?resetpassword=success");
   } else {
   header("Location: ?resetpassword=failed");
   }
  


 } else {
  header("Location: ?resetpassword=token_error");
 }
}






/*
        // verifikasi password
        if (password_verify($password, $user["password"])) {
            // buat Session
            session_start();
            $_SESSION["user"] = $user;

            // login sukses, alihkan ke halaman timeline

              header("Location: incomplete_check.php");

        } else {
              header("Location: login.php?login=error&type=1");
        }
       }
      else {
         header("Location: login.php?login=error&type=2"); 
    }*/

 
}
  
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>My Little Pony Indonesia - Lupa Kata Sandi</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/fontawesome/css/all.css">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">
 <link href="css/animate.css" rel="stylesheet">

</head>

<body class="fixed-sn white-skin">
    
    <!--Double navigation-->
     <header>
 <!--Navbar -->
<nav class="mb-1 navbar navbar-expand-lg navbar-dark stylish-color fixed-top">

  <a class="navbar-brand" href="#"><i class="fas fa-home"></i>&nbsp; MLPI - Masuk</a>
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


<!-- Menampilkan pesan -->
<?php

if (isset($_GET["login"])) {
  $login_info = $_GET["login"];
  $type = $_GET["type"];

//Jika user baru terdaftar
if ($login_info == "new_user") {
echo '<div class="alert alert-info"> 
   <font style="font-size: 14px;">Pendaftaran akun selesai, anda harus masuk dulu.</font>
  </div><br>';
}

//Jika kata sandi salah
if ($login_info == "error" && $type == "1") {
echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
   <a href="#" class="close" data-dismiss="alert">&times;</a> 
   <b><i class="fa fa-times"></i> &nbsp;Masuk Gagal!</b><br>
   <font style="font-size: 14px;">Kata Sandi yang anda masukkan tidak benar, silahkan periksa lagi.</font>
  </div><br>';
}

//Jika email atau username tidak terdaftar
if ($login_info == "error" && $type == "2") {
echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
   <a href="#" class="close" data-dismiss="alert">&times;</a> 
   <b><i class="fa fa-times"></i> &nbsp;Masuk Gagal!</b><br><font style="font-size: 14px;">Email atau nama pengguna ini tidak terdaftar di database kami.</font>
  </div><br>';
 }
}

?>





<!-- Material form login -->
<div class="card">

  <h5 class="card-header info-color white-text text-center py-4">
    <strong>Reset kata sandi</strong>
  </h5>

  <!--Card content-->
  <div class="card-body px-lg-5 pt-0">


    <!-- Form -->
    <form method="POST" class="text-center" style="color: #757575;">

      <!-- Email -->
      <div class="md-form">
        <input type="email" id="email" class="form-control" name="email" required>
        <label for="username">E-mail (terdaftar)</label>
      </div>

        <!-- Token -->
      <div class="md-form">
        <input type="text" id="token" class="form-control" name="token" required>
        <label for="accesstoken">Kode Token</label>
      </div>

   <!-- Password baru -->
      <div class="md-form">
        <input type="password" id="password" class="form-control" name="password" required>
        <label for="password">Kata Sandi Baru</label>
      </div>


   <!-- Ulangi password -->
      <div class="md-form">
        <input type="password" id="reppassword" class="form-control" name="reppassword" required>
        <label for="reppassword">Ulangi Kata Sandi</label>
      </div>




 



     
      <!-- Sign in button -->
      <button class="btn btn-outline-info btn-block my-4 waves-effect z-depth-0" type="submit" name="update">Lanjutkan</button>






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

include('footer.php'); 

?>

    <!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="javascript/jquery-3.3.1.min.js"></script>

    <!-- Tooltips -->
    <script type="text/javascript" src="javascript/popper.min.js"></script>

    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="javascript/bootstrap.min.js"></script>

    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="javascript/mdb.min.js"></script>
    <script>

         // SideNav Initialization
        $(".button-collapse").sideNav();
        
        new WOW().init();


  </script>


<script>

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '{803345670031967}',
      cookie     : true,
      xfbml      : true,
      version    : '{api-version}'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>

</body>

</html>
