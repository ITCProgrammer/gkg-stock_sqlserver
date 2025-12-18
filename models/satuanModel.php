<?php
include_once '../config/koneksi.php';
include_once '../controllers/satuanclass.php';
// instance objek
$satuan   = new Satuan();
$db       = new Database();
// koneksi ke MySQL via method
$db->connectMySQLi();

$page = $_GET['page'];
// ## SATUAN
if($page == "input-satuan"){
$ket=str_replace("'","''",$_POST['ket']);
$satu=str_replace("'","''",$_POST['satuan']);
$satuan->input_satuan($satu,$ket);
header("location:../satuan");
}
elseif($page == "update-satuan"){
$ket=str_replace("'","''",$_POST['ket']);
$satu=str_replace("'","''",$_POST['satuan']);
$satuan->update_satuan($_POST['id'],$satu,$ket);
 	header("location:../satuan");
}
// ## SATUAN-DELETE
elseif($page == "hapussatuan"){
$satuan->hapus_satuan($_GET['id']);
 	header("location:../satuan");
}
