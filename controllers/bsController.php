<?php


include_once('models/bsModel.php');
$model = new Bs;

if (isset($_POST['Save'])) {
	
	$count_barang =  count($_POST['barang'])-1;
	
	$barang_array = $_POST['barang'];
	
	$qty_array = $_POST['qty'];
	$lokasi_array = $_POST['lokasi'];
	
	$project_array = $_POST['project'];
	$demand_array = $_POST['demand'];
	$mc_array = $_POST['mc'];
	$lbr_array = $_POST['lbr'];
	$grm_array = $_POST['grm'];
	
	/*
	echo '<pre>';
	//	print_r($barang_array);
	//	print_r($qty_array);
	//	print_r($lokasi_array);
		print_r($project);
	//	print_r($demand);
	//	print_r($mc);
	//	print_r($lbr);
	//	print_r($grm);
	echo '</pre>';
	*/

	
	
	
	
	$tanggal = date("Y-m-d H:i:s");
	$surat_jalan_id = $model->bs_input_sj($tanggal);
	for ($x = 0; $x <= $count_barang; $x++) {
		$barang_bs_id = $barang_array[$x];
		$qty_masuk    = $qty_array[$x];
		$lokasi_masuk = $lokasi_array[$x];
	
		$project = $project_array[$x];
		$demand = $demand_array[$x];
		$mc = $mc_array[$x];
		$lbr = $lbr_array[$x];
		$grm = $grm_array[$x];
		
		
		$model->bs_input_sj_detail($surat_jalan_id,$barang_bs_id,$qty_masuk,$lokasi_masuk,$project,$demand,$mc,$lbr,$grm);
	}
	
	echo '<div class="alert alert-success alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<h4><i class="icon fa fa-check"></i> Success! </h4>
		Details can be viewed by clicking here! <a target="blank" href="views/pages/cetak/bs-cetak-in.php?id='.$surat_jalan_id.'">bs-detail/'.$surat_jalan_id.'</a>
		</div>';
}

if (isset($_POST['qty_keluar']) and isset($_POST['save_out'])  	and  isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']   ) {
	

	
	$qty_keluar = $_POST['qty_keluar'];
	$out = $model->bs_input_sj_out();
	foreach ($qty_keluar as $key=>$data) {
			$exp = explode("/",$key);
			
			 //$model->bs_update_detail($exp[0],$exp[1],$data,$exp[2]);
			 $model->bs_update_detail_out($out,$exp[0],$data);
			
	}
	echo '<script>';
	echo 'window.onload = function () {';
	echo '    window.location.href = "bs-suratjalan-out";';
	echo '};';
	echo '</script>';
	

}

?>

