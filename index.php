<?php
//Header config
$title = "MLPI Project";
//$header_title = $title;
$fa_icon = "fas fa-home";
$home_active = true;
$event_active = false;
$admin_active = false;
$default_meta_description = "";
$default_meta_image = "";
$dir_type = "";
include("header.php");
?>
    
  <main>
    <div class="container">

      <div class="row">
        <div class="col-md-7 mb-4">
          <div class="view overlay z-depth-1-half">
            <img src="images/mlp.jpg" class="card-img-top" alt="">
            <div class="mask rgba-white-light"></div>
          </div>
        </div>

        <div class="col-md-5 mb-4">
          <h2>My Little Pony Indonesia</h2> 
          <hr>
          <p>Selamat datang di website MLPI, ini adalah project sederhana kami silahkan mendaftar untuk mendapatkan informasi MLP, artikel blog atau untuk mengikuti event kami.</p>
<p>Saat ini hanya digunakan sebagai event</p>

<?php
if (isset($user_session)) {
    echo '<a href="event.php" class="btn btn-indigo"><i class="fas fa-calendar-alt"></i>&nbsp; Event MLPI</a>';
  } else {
    echo '<a href="register.php" class="btn btn-indigo">Daftar Sekarang</a>';
}
?>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-4 col-md-12 mb-4">

          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Pemberitahuan</h4>
              <p class="card-text">Ini adalah website untuk pembelajaran mengenai sistem CRUD (Create, Read, Update, Delete) 
                dan sistem login dan register sederhana, pada tahun 2018 pernah digunakan untuk mengadakan event menggambar bersama staff lainnya
              <p class="card-text">Jika mau melanjutkan pengembangan silahkan</p>
<p class="card-text">INFO: INI ADALAH ARSIP, WEBSITE INI MASIH MENGGUNAKAN PHP 7 DAN MASIH MENGGUNAKAN TEKNOLOGI LAMA</P>
<hr>
 <p class="card-text">Hubung admin <a href="mailto:support@jacktor.com">support@jacktor.com</a> jika ada informasi yang ingin disampaikan mengenai web ini.</p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card">
            <div class="view overlay">
              <img src="" class="card-img-top"
                alt="">
              <a href="#">
                <div class="mask rgba-white-slight"></div>
              </a>
            </div>

            <div class="card-body">
              <h4 class="card-title">Event MLPI</h4>
 <p class="card-text">Ikuti event yang kami selenggarakan secara gratis oleh admin MLPI</p>  <p class="card-text"><b>Apa saja event yang akan kami adakan nanti?</b><br>Menggambar/Art digital, membuat cerita dan lainnya.</p>
 
 <p class="card-text"><b>Siapa saja yang boleh ikut serta event tersebut?</b>
<br>
Semua anggota yang sudah mendaftar dan hanya anggota dari MLPI dan ISMLP.
</p>
              <a href="event.php" class="btn btn-indigo">Ikut Serta</a>
            </div>
          </div>
        </div>
     
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card">
            <div class="view overlay">
              <img src="" class="card-img-top"
                alt="">
              <a href="#">
                <div class="mask rgba-white-slight"></div>
              </a>
            </div>

            <div class="card-body">
              <h4 class="card-title">Kuis MLPI</h4>
              <p class="card-text">Ikuti kuis dari MLPI dan jawab beberapa pertanyaan tentang MLPI, saat ini tidak tersedia.</p>
             <button class="btn btn-indigo" disabled>Segera Hadir</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </main>

<?php
include("footer.php");
?>


<script type="text/javascript" src="/assets/bootstrap/js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="/assets/bootstrap/js/popper.min.js"></script>
<script type="text/javascript" src="/assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/bootstrap/js/mdb.min.js"></script>
<script type="text/javascript" src="/assets/bootstrap/js/addons/datatables.min.js"></script>
<script type="text/javascript" src="/assets/js/sweetalert2.all.min.js"></script>