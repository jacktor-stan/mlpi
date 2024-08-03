<?php

require_once("config.php");
//require_once("auth.php");

session_start();

$id_session = isset($_SESSION["user"]["id"]);
$username_cookie = isset($_COOKIE["login"]);


$sql = "SELECT * FROM users WHERE username=:username_cookie OR email=:username_cookie";
$stmt = $db->prepare($sql);

// bind parameter ke query
$params = array(
    ":username_cookie" => $username_cookie
);

$stmt->execute($params);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

echo $user['username_cookie']['username'];


$sql_session = "SELECT * FROM users WHERE id='$id_session'";
$sql_result = "SELECT 1 FROM event WHERE user_id='$id_session'";

$result = mysqli_query($link, $sql_result);


if (!isset($_GET['login'])) {
    //Insert id ke tabel data > user_id
    if (!mysqli_fetch_row($result)) {
        $sql_data = "INSERT INTO event (user_id) VALUES ($id_session)";
        mysqli_query($link, $sql_data);
    }

    if ($_SESSION['user']['active'] == "Y") {


        if (isset($_SESSION["user"]) or isset($_COOKIE["login"])) {
            header("Location: event.php");
        }
    } else {
        header("Location: activation.php");
    }
}



/*
if ($_GET['login'] == "new_user") {
if (isset($_COOKIE['username'])) {
$username = $_COOKIE['username'];
$password = $_COOKIE['password'];

//Buat session setelah mendaftar
 $sql = "SELECT * FROM users WHERE username=:username";
    $stmt = $db->prepare($sql); 
    
    // bind parameter ke query
    $params = array(
        ":username" => $username
    );

    $stmt->execute($params); 

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // jika user terdaftar 
    if ($user) {
        // verifikasi password
        if (password_verify($password, $user["password"])){
            // buat Session
            session_start();
            $_SESSION["user"] = $user;

            // login sukses, alihkan ke halaman timeline

              header("Location: incomplete_check.php");
              setcookie("username", "");
              setcookie("password", "");

        } else {
           //  header("Location: login.php?login=error&type=1");
        }
       }
      else {
         //header("Location: login.php?login=error&type=2"); 
    }
 }
}*/
