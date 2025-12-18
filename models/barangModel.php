<?php
include_once '../config/koneksi.php';
include_once '../controllers/barangclass.php';
// instance objek
$barang   = new Barang();
$db       = new Database();
// koneksi ke MySQL via method
$db->connectMySQLi();

$page = $_GET['page'];
// ############################################ MODULE STOCK #############################################################

// ## BARANG
if($page == "input-stock"){
$barang->input_barang($_POST['kode'],$_POST['nama'],$_POST['jenis'],
				   $_POST['harga'],$_POST['satuan'],$_POST['jml_min'],$_POST['jml_min_a'],$_POST['idsub']
				   ,$_POST['project'],$_POST['demand'],$_POST['mc'],$_POST['greige_lbr'],$_POST['greige_grm'],$_POST['kategori_bs']);
 	header("location:../barang");
}
elseif($page == "update-stock"){
$barang->update_barang($_POST['id'],$_POST['nama'],$_POST['jenis'],
				   $_POST['harga'],$_POST['satuan'],$_POST['jml_min'],$_POST['jml_min_a']
				   ,$_POST['project'],$_POST['demand'],$_POST['mc'],$_POST['greige_lbr'],$_POST['greige_grm'],$_POST['kategori_bs']
				   );
 	header("location:../barang");
}
// ## BARANG-DELETE
elseif($page == "hapusstock"){
$barang->hapus_barang($_GET['id']);
 	header("location:../barang");
}
