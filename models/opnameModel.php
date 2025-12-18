<?php
include_once '../config/koneksi.php';
include_once '../controllers/opnameclass.php';
// instance objek
$opname   = new Opname();
$db       = new Database();
// koneksi ke MySQL via method
$db->connectMySQLi();

$page = $_GET['page'];
// ## OPNAME
if($page == "input-opname"){
$idsub=$_POST['idsub'];
$awal=$_POST['awal'];
$akhir=$_POST['akhir'];
$note=str_replace("'","''",$_POST['note']);
$userid=$_POST['userid'];
$opname->input_opname($idsub,$awal,$akhir,$note,$userid);
header("location:../stok-opname");
}
// ## OPNAME-DELETE
elseif($page == "hapusopname"){
$opname->hapus_opname($_GET['id']);
 	header("location:../stok-opname");
}
