<?php
//Header config
$title = "MLPI - Event";
$fa_icon = "fas fa-calendar-alt";
$home_active = false;
$event_active = true;
$admin_active = false;
$default_meta_description = "";
$default_meta_image = "";
$dir_type = "";
include("header.php");

require_once("auth.php");

//$id_session = $_SESSION["id"];

$sql_all = "SELECT * FROM users";
$sql_event_all = "SELECT * FROM event";
$sql_session = "SELECT * FROM users WHERE id='$id_session'";
$sql_event = "SELECT * FROM event WHERE user_id='$id_session'";
$sql_settings = "SELECT * FROM settings WHERE type='event'";

$query_table = mysqli_query($link, $sql_all);
$query_session = mysqli_query($link, $sql_session);
$query_event = mysqli_query($link, $sql_event);
$query_settings = mysqli_query($link, $sql_settings);

$row_session = mysqli_fetch_array($query_session);
$row_event = mysqli_fetch_array($query_event);
$row_settings = mysqli_fetch_array($query_settings);

//Include
$user_header = $id_session;
$id_tagname = $id_session;

//Hapus file gambar
if (isset($_GET['delete']) == "event_image") {
  $file = "uploads/images/" . $row_session['username'] . "/" . $row_event['event_image'];

  if (unlink("$file")) {
    $sql = "UPDATE event SET event_image='' WHERE user_id='$id_session'";
    mysqli_query($link, $sql);

    $sql_2 = "UPDATE event SET image_title='' WHERE user_id='$id_session'";
    mysqli_query($link, $sql_2);

    $sql_3 = "UPDATE event SET image_description='' WHERE user_id='$id_session'";
    mysqli_query($link, $sql_3);

    $sql_4 = "UPDATE event SET event='0' WHERE user_id='$id_session'";
    mysqli_query($link, $sql_4);

    header("Location:?remove_image=success");
  } else {
    header("Location:?remove_image=error");
  }
}
?>



<!--Main layout-->
<main>

  <!--Main container-->
  <div class="container">

    <!-- Card -->
    <div class="card testimonial-card">

      <!-- Background color -->
      <div class="card-up aqua-gradient"></div>

      <!-- Avatar -->
      <div class="avatar mx-auto white">

        <img src="<?php echo $row_session['profile_image'] ?>" class="rounded-circle" alt="<?php echo $row_session['username'] ?> - avatar" id="profileImg">
      </div>

      <!-- Content -->
      <div class="card-body">
        <!-- Name -->
        <h4 class="card-title"><?php echo $row_session["firstname"] . ' ' . $row_session["lastname"]; ?></h4>


        <?php

        include("includes/tagname.php");

        ?>
        <hr>
        <!-- Bio -->
        <p><?php echo $row_session['bio'] ?></p>
      </div>

    </div>
    <!-- Card -->

    <!-- Config, pesan dan kesalahan -->
    <?php

    //Get URL info
    if (isset($_GET['event'])) {
      $event = $_GET['event'];
    } else {
      $event = "";
    }

    if (isset($_GET['upload'])) {
      $upload = $_GET['upload'];
    } else {
      $upload = "";
    }

    if (isset($_GET['remove_image'])) {
      $remove_image = $_GET['remove_image'];
    } else {
      $remove_image = "";
    }




    //Pesan pendaftaran event 
    if ($event == "register_success") {

      echo '<p><div class="alert alert-info alert-dismissible fade show" role="alert"> 
   <a href="#" class="close" data-dismiss="alert">&times;</a> 
   <b><i class="fa fa-check"></i> &nbsp;Pendaftaran Selesai</b><br><font style="font-size: 11.5px;">Anda sekarang sudah berpartisipasi dalam mengikuti event ini</font>
  </div></p>';
    }

    //menampilkan pesan kesalahan upload
    if ($upload == "success") {
      echo '<p><div class="alert alert-success alert-dismissible fade show" role="alert"> 
   <a href="#" class="close" data-dismiss="alert">&times;</a> 
   <b><i class="fa fa-check"></i> &nbsp;File berhasil diupload</b><br><font style="font-size: 11.5px;">File gambar anda telah berhasil di upload, namun kami perlu memeriksanya terlebih dahulu.</font>
  </div></p>';
    }

    if ($upload == "invalid") {
      echo '<p><div class="alert alert-warning alert-dismissible fade show" role="alert"> 
   <a href="#" class="close" data-dismiss="alert">&times;</a> 
   <i class="mdi mdi-alert-warning"></i> <b>File gambar tidak valid</b><br><font style="font-size: 11.5px;">File yang anda upload bukan gambar atau tidak diizinkan oleh admin, silahkan upload kembali file gambar anda, hubungi admin jika ini memang kesalahan.</font>  
  </div></p>';
    }

    if ($upload == "error") {
      echo '<p><div class="alert alert-danger alert-dismissible fade show" role="alert"> 
   <a href="#" class="close" data-dismiss="alert">&times;</a> 
   <i class="mdi mdi-alert-error"></i> <b>File gambar gagal diupload</b><br><font style="font-size: 11.5px;">kesalahan saat meng-upload file gambar.</font>  
  </div></p>';
    }

    //menampilkan pesan kesalahan hapus file gambar
    if ($remove_image == "success") {
      echo '<p><div class="alert alert-info alert-dismissible fade show" role="alert"> 
   <a href="#" class="close" data-dismiss="alert">&times;</a> 
   <b><i class="mdi mdi-action-delete"></i> &nbsp;File gambar anda telah dihapus</b><br><font style="font-size: 11.5px;"><p>File gambar yang telah anda upload sebelumnya sudah dihapus pada akun ini secara permanen, untuk melanjutkan event ini silahkan upload kembali gambar anda</font></p>
  </div></p>';
    }

    if ($remove_image == "error") {
      echo '<p><div class="alert alert-danger alert-dismissible fade show" role="alert"> 
   <a href="#" class="close" data-dismiss="alert">&times;</a> 
   <b><i class="fas fa-times"></i> &nbsp;File gambar anda gagal dihapus</b><br><font style="font-size: 11.5px;"><p>File gambar yang telah anda upload sebelumnya gagal dihapus!</p></font>
  </div></p>';
    }

    ?>
    <!--/config, pesan dan kesalahan -->

    <!-- Gambar untuk event -->
    <p>
      <center><img class="img-thumbnail img-thumbnail1 animated fadeIn" id="ShowImg" src="uploads/images/<?php echo $row_session["username"] . '/' . $row_event["event_image"] ?>" title="My Little Pony Indonesia - <?php echo $row_session["username"] ?>" width="200"></center>
    </p>
    <!--/gambar untuk event -->

    <!-- Form untuk pendaftaran event dan upload gambar -->
    <div class="card">
      <div class="card-body" style="font-size: 13px;">





        <?php
        echo '
<p class="card-title"><b>' . $row_settings['event_title'] . '</b></p>
<p class="card-title">' . nl2br($row_settings['event_description']) . '</p>


<hr>';




        //Jika nilai kueri event di tabel users dengan nilai 2 berarti user telah terdaftar di event dan siap untuk upload gambar

        if ($row_event['event'] == 2) {

          //sembunyikan form upload jika nilai kueri image di tabel users_data tersedia
          if (!$row_event['event_image']) {
            echo '<p>Silahkan upload gambar anda, file yang melanggar hak cipta dapat menyebabkan anda diskualifikasi:</p> 

<p>Format gambar yang diizinkan: JPEG, JPG dan PNG.
<span class="text-muted"><br>
Batas maksimal ukuran file adalah 5MB.</span>
</p>

<form action="uploads/upload-process.php" method="post" enctype="multipart/form-data">
 <div class="file-field md-form">
    <div class="btn btn-primary btn-sm float-left">
      <span>Pilih file</span>
      <input type="file" name="file" onchange="readURL(this);">
    </div>
    <div class="file-path-wrapper">
      <input class="file-path" type="text" placeholder="Upload file gambar anda" disabled>
    </div>
  </div>

  <hr>

<p class="text-muted">Beberapa informasi yang perlu dilengkapi</p>

<p><input type="text" name="imgTitle" placeholder="Judul" required></p>
<textarea cols="50" rows="5" name="imgDesc" placeholder="Deskripsi"></textarea>

<hr>

  <button type="submit" name="submit" class="btn btn-outline-primary waves-effect btn-sm btn-block"><i class="mdi mdi-file-file-upload"></i> UPLOAD</button>
</form>';
          }

          //Jika user telah berhasil upload gambar dan kueri image di tabel users_data di update
          if ($row_event['event_image']) {
            echo '<p>Gambar anda saat ini sedang kami tinjau untuk penilaian, pemenang akan diumumkan melalui website dan grup</p>

<button onclick="removeImage()" class="btn btn-outline-danger waves-effect btn-sm btn-block" data-toggle="modal" data-target="#removeImg">HAPUS GAMBAR ANDA SAAT INI</button>';
          }
        } else {

          //Sebaliknya jika user belum terdaftar di event






          if ($row_settings['register'] == "Y") {




            echo '<p>Untuk mengikuti event ini silahkan klik tombol "Mendaftar Event" dibawah ini</p>';

            if ($row_event['event_image']) {
              echo '<p><b>Perhatian:</b> Anda sebelumnya telah upload gambar tersebut namun anda tidak terdaftar di event ini, gambar tersebut tidak akan kami beri penilaian sampai anda telah mendaftar event ini kembali.</p>';
            }

            echo '<button class="btn btn-outline-primary waves-effect btn-sm btn-block" data-toggle="modal" data-target="#registerEvent">Mendaftar Event</button>';
          } else {
            echo '<p class="card-title">Sayangnya pendaftaran sudah ditutup!<br /><br />Nantikan event berikutnya ya.</p>';
          }
        }







        ?>

      </div>
    </div>
    <!--/form untuk pendaftaran event dan upload gambar -->

    <?php

    //Modal untuk konfirmasi pendaftaran event
    if ($row_event['event'] != 2) {
      echo '
<div class="modal fade" id="registerEvent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Mendaftar Event Ini?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Anda akan ikut serta pada event ini, untuk melanjutkan ini silahkan klik "Lanjutkan"
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="registerEvent();">Lanjutkan</button>
      </div>
    </div>
  </div>
</div>
';
    }

    //Modal untuk hapus gambar
    if ($row_event['event_image']) {
      echo '
<div class="modal fade" id="removeImg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel2">Hapus Gambar?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
Hapus gambar anda saat ini, fitur ini hanya dimaksudkan untuk jika anda salah upload file gambar, setelah anda menghapus file gambar ini silahkan upload kembali gambar anda.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
 <a href="event.php?delete=event_image"><button type="button" value="event_image" class="btn btn-primary btn-sm">Hapus</button></a>
      </div>
    </div>
  </div>
</div>
';
    }

    ?>

    <hr>

    <!-- Tabel Perserta -->
    <p><b>Tabel akun perserta terdaftar</b></p>
    <div class="table-responsive">
      <?php

      echo '<table id="tableUser-participants" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">';
      echo '<thead>';
      echo '<tr>';
      echo '<th>No</th>';
      echo '<th>Nama</th>';
      echo '<th>Nama Pengguna</th>';
      echo '</tr>';
      echo '</thead>';
      echo '<tbody>';

      $counter = 1; //memberi penomoran untuk tabel

      while ($row1 = mysqli_fetch_array($query_table)) {
        $row_id = $row1["id"];

        $sql_event_t = "SELECT * FROM event WHERE user_id='$row_id'";
        $query_event_t = mysqli_query($link, $sql_event_t);
        $row_event_t = mysqli_fetch_array($query_event_t);

        //hanya menampilkan user yang telah mendaftar event saja "nilai di tabel event pada kueri event 1"
        if ($row_event_t['event'] == 2) {
          echo '<tr>';
          echo '<td>' . $counter . '</td>';
          echo '<td><a href="profile.php?user_id=' . $row1['username'] . '">' . $row1["firstname"] . ' ' . $row1["lastname"] . '</a></td>';
          echo '<td>' . $row1["username"] . '</td>';
          echo '</tr>';
          $counter++;
        }
      }
      echo '</tbody>';
      echo '</table>';

      ?>

    </div>

    <hr>





  </div>

</main>
<!--/Main layout-->


<br><br>


<?php
//Footer
include("footer.php");
?>
</body>



<script type="text/javascript" src="/assets/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/assets/bootstrap/js/popper.min.js"></script>
<script type="text/javascript" src="/assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/bootstrap/js/mdb.min.js"></script>
<script type="text/javascript" src="/assets/bootstrap/js/addons/datatables.min.js"></script>
<script type="text/javascript" src="/assets/js/sweetalert2.all.min.js"></script>

<script>
  //Untuk pendaftaran event
  function registerEvent() {

    jQuery.ajax({
      type: "POST",
      data: {
        event: '2',
      },
      url: "includes/update-data.php",
      cache: false,
      success: function(response) {
        location.href = "event.php?event=register_success";
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

  //Jika user telah memilih file gambar maka tampilkan pratinjau gambar sebelum di upload
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#ShowImg').attr('src', e.target.result)
          .attr('title', 'My Little Pony Indonesia - Pratinjau gambar');

        //Jika gambar belum dipilih atau gambar rusak maka tampilkan gambar default
        document.getElementById("ShowImg")
          .addEventListener("error", function() {
            $("#ShowImg")
              .attr('src', 'images/mlp-indonesia.png')
              .attr('title', 'My Little Pony Indonesia - Tidak ada gambar');
          }, false);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  //Jika file gambar yang telah diupload user rusak atau link tidak valid maka tampilkan gambar default
  document.getElementById("ShowImg").addEventListener("error", function() {
    $("#ShowImg")
      .attr('src', 'images/mlp-indonesia.png')
      .attr('title', 'My Little Pony Indonesia - Tidak ada gambar');
  }, false);

  //Jika kueri image di tabel users_data kosong maka tampilkan gambar default

  if ("<?php echo $row_event["event_image"] ?>" == "") {
    $("#ShowImg")
      .attr('src', 'images/mlp-indonesia.png')
      .attr('title', 'My Little Pony Indonesia - Tidak ada gambar');
  }




  //Mengatur tabel perserta
  $(document).ready(function() {
    $('#tableUser-participants').DataTable({
      "scrollX": true,
      "scrollY": 150,
      "searching": false,
      "paging": false,
      "info": false,
    });
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
</script>

</html>