<?php
include_once '../config/koneksi.php';
include_once '../controllers/permohonanclass.php';
// instance objek
$permohonan   	= new Permohonan();
$db       		= new Database();
// koneksi ke MySQL via method
$db->connectMySQLi();

$page = $_GET['page'];
// ############################################ MODULE PERMOHONAN ###########################################################

// ## PERMOHONAN
if($page == "input-permohonan"){
$note=str_replace("'","''",$_POST['note']);	
$permohonan->input_permohonan($_POST['documentno'],$_POST['tgl_mohon'],$_POST['dept'],$note,$_POST['idsub']);
 	header("location:../permohonan");
}
elseif($page == "add-detail-permohonan"){
$permohonan->add_detail_permohonan($_POST['id'],$_POST['kode'],$_POST['jumlah']);
 	header("location:../permohonan");
}
elseif($page == "update-permohonan"){
$note=str_replace("'","''",$_POST['note']);		
$permohonan->update_permohonan($_POST['id'],$_POST['tgl_mohon'],$note);
 	header("location:../permohonan");
}
// ## PERMOHONAN-DELETE
elseif($page == "hapuspermohonan"){
$permohonan->hapus_permohonan($_GET['id']);
 	header("location:../permohonan");
}
