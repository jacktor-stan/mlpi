<?php

if ($dir_type == "..") {
  require_once($dir_type . "/config.php");
} else {
  require_once("config.php");
}

session_start();

if (isset($_SESSION["user"]["id"])) {
  $id_session = $_SESSION["user"]["id"];
} else {
  $id_session = null;
}

$sql_session = "SELECT * FROM users WHERE id='$id_session'";
$query_session = mysqli_query($link, $sql_session);
$row_session = mysqli_fetch_array($query_session);

//Include
$user_header = $id_session;


/*Meta config*/
//description
if ("" == $default_meta_description) {
  $meta_description = "Terhubung dengan teman";
} else {
  $meta_description = $default_meta_description;
}

//image
if ("" == $default_meta_image) {
  $meta_image = "/images/mlp.jpg";
} else {
  $meta_image = $default_meta_image;
}

/*Header config*/
//Untuk laman profil dan edit user pada panel admin
if (strpos($_SERVER['REQUEST_URI'], "profile.php") or strpos($_SERVER['REQUEST_URI'], "user.php")) {
  if (isset($_GET['user_id'])) {
    $id_p = $_GET['user_id'];
  } else {
    $id_p = $_SESSION["user"]["id"];
  }
  $sql_p = "SELECT * FROM users WHERE id='$id_p' OR username='$id_p'";
  $query_p = mysqli_query($link, $sql_p);
  $row_p = mysqli_fetch_array($query_p);

  $title = $row_p['firstname'] . " " . $row_p['lastname'] . " - " . $title_profile;

  if ($id_session == $row_p['id']) {
    $header_title_val = "Profil Saya";
    $fa_icon = "fas fa-user-circle";
  } else {
    $header_title_val = $row_p['firstname'] . " " . $row_p['lastname'];
    $fa_icon = "fas fa-user-circle";
  }
} else {
  $header_title_val = $title;
}

?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="theme-color" content="#33b5e5">
  <title><?php echo $title; ?></title>

  <!-- Start Meta Seo Tag -->
  <meta property="og:title" content="<?php echo $title; ?>" />
  <meta property="og:type" content="article" />
  <meta property="og:description" content="<?php echo $meta_description ?>" />
  <meta property="og:image" content="<?php echo $meta_image ?>" />
  <meta property="og:url" content="https://mlpi.jacktor.com" />
  <meta property="og:site_name" content="<?php echo $title; ?>" />
  <meta property="fb:app_id" content="803345670031967" />
  <meta property="fb:admins" content="100005318683221" />
  <!-- End Meta Seo Tag -->


  <link rel="icon" type="image/png" href="<?php echo $dir_type ?>/images/favicon-196x196.png" sizes="196x196" />
  <link rel="icon" type="image/png" href="<?php echo $dir_type ?>/images/favicon-96x96.png" sizes="96x96" />
  <link rel="icon" type="image/png" href="<?php echo $dir_type ?>/images/favicon-32x32.png" sizes="32x32" />
  <link rel="icon" type="image/png" href="<?php echo $dir_type ?>/images/favicon-16x16.png" sizes="16x16" />
  <link rel="icon" type="image/png" href="<?php echo $dir_type ?>/images/favicon-128.png" sizes="128x128" />

  <link href="<?php echo $dir_type ?>/assets/fontawesome/css/all.min.css" rel="stylesheet">
  <link href="<?php echo $dir_type ?>/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo $dir_type ?>/assets/bootstrap/css/mdb.min.css" rel="stylesheet">
  <link href="<?php echo $dir_type ?>/assets/bootstrap/css/addons/datatables.min.css" rel="stylesheet">
  <link href="<?php echo $dir_type ?>/assets/css/sweetalert2.min.css" rel="stylesheet">
  <link href="<?php echo $dir_type ?>/assets/css/animate.css" rel="stylesheet">
  <link href="<?php echo $dir_type ?>/assets/css/custom.css" rel="stylesheet">

  <?php //include("includes/analytics.php"); 
  ?>
</head>

<body class="fixed-sn white-skin">
  <header>
    <nav class="mb-1 navbar navbar-expand-lg navbar-dark stylish-color fixed-top">

      <?php

      echo '<a class="navbar-brand" href="/"><i class="' . $fa_icon . '"></i>&nbsp; ' . $header_title_val . '</a>

 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
    aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent-4">

    <ul class="navbar-nav ml-auto">';

      if ($home_active) {
        echo '<li class="nav-item active">
        <a class="nav-link" href="../">
          Beranda
 <span class="sr-only">(current)</span>
        </a>
      </li>';
      } else {
        echo '<li class="nav-item">
        <a class="nav-link" href="../">
          Beranda
        </a>
      </li>';
      }




      if ($event_active) {
        echo '<li class="nav-item active">
        <a class="nav-link" href="/event.php">
          Event MLPI
  <span class="sr-only">(current)</span>
        </a>
      </li>';
      } else {
        echo '<li class="nav-item">
        <a class="nav-link" href="/event.php">
          Event MLPI</a>
      </li>';
      }

      if ($admin_active) {
        if (isset($row_session['account']) != "member" && isset($row_session)) {
          echo '<li class="nav-item active">
        <a class="nav-link" href="/admin/">
          Panel admin
 <span class="sr-only">(current)</span>
        </a>
      </li>';
        }
      } else {
        if (isset($row_session['account']) != "member" && isset($row_session)) {
          echo '<li class="nav-item">
        <a class="nav-link" href="/admin/">
          Panel admin</a>
      </li>';
        }
      }

      echo '<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true"
          aria-expanded="false">';

      if (isset($user_header)) {
        echo 'Profil Saya';
      } else {
        echo 'Daftar/Masuk';
      }

      echo '</a>
        <div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">';

      if (isset($user_header)) { ?>
        <a class="dropdown-item" href="/admin"><i class="fas fa-user-circle"></i>&nbsp; Admin</a>
        <a class="dropdown-item" href="/profile.php"><i class="fas fa-user-circle"></i>&nbsp; Akun Saya</a>
        <a class="dropdown-item" href="profile.php?account=settings"><i class="fas fa-cogs"></i>&nbsp; Pengaturan</a>
        <a class="dropdown-item" href="/logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp; Keluar</a>
      <?php } else { ?>
        <a class="dropdown-item" href="register.php"><i class="fas fa-user-circle"></i>&nbsp; Daftar</a>
        <a class="dropdown-item" href="/login.php"><i class="fas fa-sign-out-alt"></i>&nbsp; Masuk</a>
      <?php } ?>
      </div>
      </li>
      </ul>
      </div>
    </nav>
  </header>