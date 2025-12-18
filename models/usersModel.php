<?php
include_once '../config/koneksi.php';
include_once '../controllers/usersClass.php';
// instance objek
$user     = new User();
$db       = new Database();
// koneksi ke MySQL via method
$db->connectMySQLi();

$page = $_GET['page'];
// ############################################ MODULE USER ############################################################
// ## USER-LOGIN
if($page == "login"){

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $login=$user->cek_login($_POST['username'], $_POST['password'], $_POST['sub']);
  if($login) {
    // login sukses, arahkan ke file home
    header("location:../home");
  }
  else {
  // login gagal, beri peringatan dan kembali ke file index.php
  header("location:../login_error.php");
  //header("location:../index");

  }
}
}

// ## CHANGE PASSWORD
elseif($page == "change-password"){
$password=md5($_POST['password']);
$user->change_password($_POST['id'],$password);
 	header("location:../home");
}

// ## USER-INPUT
elseif($page == "input-user"){
$password=md5($_POST['password']);
$user->input_user($_POST['username'],$password,
				  $_POST['level'],$_POST['status'],
				  $_POST['thn'],$_POST['jabatan'],$_POST['idsub']);
 	header("location:../user");
}

// ## USER-UPDATE
elseif($page == "update-user"){
$password=md5($_POST['password']);
$user->update_user($_POST['id'],$_POST['username'],
				   $password,$_POST['level'],$_POST['status'],
				   $_POST['thn'],$_POST['jabatan'],$_POST['idsub']);
 	header("location:../user");
}


// ## USER-DELETE
elseif($page == "hapus-user"){
$user->hapus_user($_GET['id']);
 	header("location:../user");
}
// ############################################ END MODULE USER ############################################################
