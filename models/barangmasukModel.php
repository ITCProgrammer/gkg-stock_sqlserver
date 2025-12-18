<?php
include_once '../config/koneksi.php';
include_once '../controllers/barangclass.php';
include_once '../controllers/barangmasukclass.php';
// instance objek
$barang   = new Barang();
$barangin = new BarangMasuk();
// koneksi ke MySQL via method
$db       = new Database();
$db->connectMySQLi();

$page = $_GET['page'];
// ## BARANG-IN
if($page == "input-stock-in"){
$note=str_replace("'","''",$_POST['note']);
$barangin->input_barang_in($_POST['kode'],$_POST['jumlah'],
				   $_POST['userid'],$note,$_POST['idsub']);
 	header("location:../stok-in");
}
elseif($page == "update-stock-in"){
$note=str_replace("'","''",$_POST['note']);
$jumlah=$barangin->show_data_injml($_POST['id']);
$id=$barangin->show_data_inid($_POST['id']);
$selisih=$jumlah-$_POST['jumlah'];
$barangin->update_barang_in($_POST['id'],$_POST['jumlah'],$note,$id,$selisih);
 	header("location:../stok-in");
}
// ## BARANG-IN-DELETE
elseif($page == "hapusstockin"){
$id=$barangin->show_data_inid($_GET['id']);
$jumlah=$barangin->show_data_injml($_GET['id']);
$barangin->hapus_barang_in($_GET['id'],$id,$jumlah);
 	header("location:../stok-in");
}
