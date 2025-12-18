<?php
include_once '../config/koneksi.php';
include_once '../controllers/barangClass.php';
include_once '../controllers/barangkeluarClass.php';
// instance objek
$barang   = new Barang();
$barangout= new BarangKeluar();
// koneksi ke MySQL via method
$db       = new Database();
$db->connectMySQLi();

$page = $_GET['page'];
// ## BARANG-OUT
if($page == "input-stock-out"){
$note=str_replace("'","''",$_POST['note']);
$harga=$barang->ambilHarga($_POST['kode']);
$total=$_POST['jumlah']*$harga;
$barangout->input_barang_out($_POST['kode'],$_POST['jumlah'],
				   $_POST['userid'],$note,$total,$_POST['idsub']);
 	header("location:../stok-out");
}
elseif($page == "update-stock-out"){
$note=str_replace("'","''",$_POST['note']);
$jumlah=$barangout->show_data_outjml($_POST['id']);
$id=$barangout->show_data_outid($_POST['id']);
$selisih=$jumlah-$_POST['jumlah'];
$barangout->update_barang_out($_POST['id'],$_POST['jumlah'],$note,$id,$selisih);
 	header("location:../stok-out");
}
// ## BARANG-OUT-DELETE
elseif($page == "hapusstockout"){
$id=$barangout->show_data_outid($_GET['id']);
$jumlah=$barangout->show_data_outjml($_GET['id']);
$barangout->hapus_barang_out($_GET['id'],$id,$jumlah);
 	header("location:../stok-out");
}
