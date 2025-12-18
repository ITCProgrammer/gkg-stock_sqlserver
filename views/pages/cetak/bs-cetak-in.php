<?php 
	include_once('../../../config/koneksi.php');
	include_once('../../../models/bsModel.php');
	$model = new Bs;
	$action = isset($_GET['action']) ? $_GET['action'] : null;
?>

<?php 
if (isset($_POST['update'])) {
	foreach ($_POST['qty_masuk'] as $key=>$data_update) {
		$model->bs_update_in($key,$data_update);
	}
	header("Location: bs-cetak-in.php?id=$_GET[id]");
	exit;
	
}

if (isset($_POST['post_delete'])) {
	
	$model->bs_delete_in($_POST['delete_name']);
	header("Location: bs-cetak-in.php?id=$_GET[id]&action=delete");
	exit;
}
?>

<style>
body, table {
	font-family: arial;
	font-size: 12px;
	color:#000
}

.table-report {
	 border-collapse: collapse;
     width: 100%;
}
.table-report td, .table-report th {
    border: thin  solid #414a4c;
    padding: 1px;
	text-align:center
	
	
}
</style>

<?php if ($action=='edit') {?>
<form action="" method="post">
<?php } ?>
<table width="100%"  class="table-report">
<thead>
<tr>
<th>No</th>
<th>Id Surat Jalan</th>
<th>Tanggal Masuk</th>
<th>Barang</th>
<th>Jenis Kain</th>
<th>Lokasi Masuk</th>

<th>Qty Masuk</th>
<?php if ($action=='edit') {?>
<th width=5px>Edit</th>
<?php }?>
<?php if ($action=='delete') {?>
<th></th>
<?php } ?>
<th>Qty Keluar</th>
<th>Qty Sisa</th>
</tr>
</thead>
<tbody>
<?php $no = 1; $sum_qty_masuk = 0;  $sum_qty_keluar = 0; $sum_qty_sisa = 0; foreach($model->bs_in_detail($_GET['id']) as $data) { ?>
<tr>
<td><?=$no++?></td>
<td><?=str_pad($data['surat_jalan_id'], 6, '0', STR_PAD_LEFT)?></td>
<td><?=$data['tanggal']?></td>
<td><?=$data['nama']?></td>
<td><?=$data['jenis_kain']?></td>
<td><?=$data['lokasi_masuk']; ?></td>
<td><?=$data['qty_masuk']; $sum_qty_masuk += $data['qty_masuk']; ?></td>
<?php if ($action=='edit') {?>
<th><input type="text" name="qty_masuk[<?=$data['id']?>]" value="<?=$data['qty_masuk'];?>" style="width:70px;" required pattern="^[1-9]\d*(\.\d+)?$" title="Enter a valid number or decimal greater than zero using dot (.)" ></th>
<?php } ?>
<?php if ($action=='delete') {?>
<th>
<form action="" method="post">
	<input type="hidden" name="delete_name" value="<?=$data['id'];?>">
	<input type="submit" value="Delete" name="post_delete" style="background: none; border: none; color: red; text-decoration: underline; cursor: pointer; padding: 0; font-size: inherit;">
</form>
</th>
<?php }?>
<td><?=$data['qty_keluar']; $sum_qty_keluar += $data['qty_keluar'];?></td>
<td><?=$data['qty_sisa']; $sum_qty_sisa += $data['qty_sisa'];?></td>
</tr>
<?php } ?>
<tr>
<td colspan=6></td>
<td><?=$sum_qty_masuk?></td>
<?php if ($action=='edit') {?>
<th><input type="submit" value="update" name="update" style="background-color: #4CAF50; color: white; padding: 3px 6px; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;"  ></th>
<?php }?>
<?php if ($action=='delete') {?>
<th></th>
<?php } ?>

<td><?=$sum_qty_keluar?></td>
<td><?=$sum_qty_sisa?></td>
</tr>
</tbody>
</table>
<?php if ($action=='edit') {?>
</form>
<?php } ?>




