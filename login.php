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

//session_start();

//Cek session login, jika ada alihkan user untuk masuk
if (isset($_SESSION["user"]) OR isset($_COOKIE['login'])) {
  header("Location: check.php");
}








if (isset($_POST['login'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);


    if (isset($_POST['remember']))
    {
       //$time = time();
       //setcookie('login',$username, $time + 3600);
    }

    
    $sql = "SELECT * FROM users WHERE username=:username OR email=:email";
    $stmt = $db->prepare($sql); 
    
    // bind parameter ke query
    $params = array(
        ":username" => $username,
        ":email" => $username
    );

    $stmt->execute($params); 

    $user = $stmt->fetch(PDO::FETCH_ASSOC);



    // jika user terdaftar
    if ($user) {
        // verifikasi password
        if (password_verify($password, $user["password"])){
            $_SESSION["user"] = $user;
            // login sukses, alihkan ke halaman yang dituju
              header("Location: check.php");

              session_start();

        } else {
              header("Location: login.php?login=error&type=1");
        }
       }
      else {
         header("Location: login.php?login=error&type=2"); 
    }

 } 
?>

	

  
    <!--Main layout-->
    
 <div class="container">

<main>


<!-- Menampilkan pesan -->
<?php

//Jika user selesai aktivasi
if (isset($_GET["activation"]) == "success") {
echo '<div class="alert alert-info"> 
   <font style="font-size: 14px;">Akun anda telah berhasil diaktifkan, silahkan login dulu</font>
  </div><br>';
}

//Reset password berhasil
if (isset($_GET["resetpassword"]) == "success") {
echo '<div class="alert alert-info"> 
   <font style="font-size: 14px;">Kata sandi akun anda telah berhasil diubah, silahkan login.</font>
  </div><br>';
}

//Jika kata sandi salah
if (isset($_GET["login"]) == "error" && $_GET["type"] == "1") {
echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
   <a href="#" class="close" data-dismiss="alert">&times;</a> 
   <b><i class="fa fa-times"></i> &nbsp;Masuk Gagal!</b><br>
   <font style="font-size: 14px;">Kata Sandi atau email yang anda masukkan tidak benar, silahkan periksa lagi.</font>
  </div><br>';
}

//Jika email atau username tidak terdaftar
if (isset($_GET['login']) == "error" && $_GET['type'] == "2") {
echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
   <a href="#" class="close" data-dismiss="alert">&times;</a> 
   <b><i class="fa fa-times"></i> &nbsp;Masuk Gagal!</b><br><font style="font-size: 14px;">Email atau nama pengguna ini tidak terdaftar di database kami.</font>
  </div><br>';
}

?>



<!-- Material form login -->
<div class="card">

  <h5 class="card-header info-color white-text text-center py-4">
    <strong>Masuk</strong>
  </h5>

  <!--Card content-->
  <div class="card-body px-lg-5 pt-0">


    <!-- Form -->
    <form method="POST" class="text-center" style="color: #757575;">

      <!-- Email -->
      <div class="md-form">
        <input type="text" id="username" class="form-control" name="username" value="" required>
        <label for="username">Username Atau E-mail</label>
      </div>

      <!-- Password -->
      <div class="md-form">
        <input type="password" id="password" class="form-control" name="password" value="" required>
			
			
        <label for="password">Kata Sandi</label>
      </div>

      <div class="d-flex justify-content-around">
        <div>
          <!-- Remember me -->
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="materialLoginFormRemember" name="remember">
            <label class="form-check-input" for="materialLoginFormRemember">Tetap masuk</label>
          </div>
        </div>
        <div>
          <!-- Forgot password -->
          <a href="forgot_password.php">Lupa kata sandi?</a>
        </div>
      </div>

      <!-- Sign in button -->
      <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit" name="login">Masuk</button>



      <!-- Register -->
      <p>Belum terdaftar?
        <a href="register.php">Daftar</a>
      </p>

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

    <script type="text/javascript" src="javascript/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="javascript/popper.min.js"></script>
    <script type="text/javascript" src="javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="javascript/mdb.min.js"></script>
    <script>

         // SideNav Initialization
        $(".button-collapse").sideNav();
        new WOW().init();
  </script>

</body>

</html>
