<?php 
	include_once('../../../config/koneksi.php');
	include_once('../../../models/bsModel.php');
	$model = new Bs;
	$action = isset($_GET['action']) ? $_GET['action'] : null;
?>

<?php 

if (isset($_POST['post_delete'])) {

	$model->bs_delete_out($_POST['delete_name']);
	header("Location: bs-cetak-out.php?id=$_GET[id]&action=delete");
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
<th>Id Surat Jalan Keluar</th>
<th>Tanggal Keluar</th>
<th>Barang</th>
<th>Jenis Kain</th>
<th>Qty Keluar</th>
<?php if ($action=='edit') {?>
<th width=5px>Edit</th>
<?php }?>
<?php if ($action=='delete') {?>
<th></th>
<?php } ?>

</tr>
</thead>
<tbody>
<?php $no = 1; $sum_qty_keluar = 0; foreach($model->bs_in_detail_out($_GET['id']) as $data) { ?>
<tr>
<td><?=$no++?></td>
<td><?=str_pad($data['id'], 6, '0', STR_PAD_LEFT)?></td>
<td><?=$data['tanggal']?></td>
<td><?=$data['nama']?></td>
<td><?=$data['jenis_kain']?></td>
<td><?=$data['qty_keluar_detail']; $sum_qty_keluar+=  $data['qty_keluar_detail']?></td>

<?php if ($action=='edit') {?>
<th><input type="text" name="qty_masuk[<?=$data['idout_detail']?>]" value="<?=$data['qty_keluar_detail'];?>" style="width:70px;" required pattern="^[1-9]\d*(\.\d+)?$" title="Enter a valid number or decimal greater than zero using dot (.)" ></th>
<?php } ?>
<?php if ($action=='delete') {?>
<th>
<form action="" method="post">
	<input type="hidden" name="delete_name" value="<?=$data['idout_detail'];?>">
	<input type="submit" value="Delete" name="post_delete" style="background: none; border: none; color: red; text-decoration: underline; cursor: pointer; padding: 0; font-size: inherit;">
</form>
</th>
<?php }?>
</tr>
<?php } ?>

<tr>
<td colspan=5></td>
<td><?=$sum_qty_keluar?></td>
<?php if ($action=='edit') {?>
<th><input type="submit" value="update" name="update" style="background-color: #4CAF50; color: white; padding: 3px 6px; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;"  ></th>
<?php }?>
<?php if ($action=='delete') {?>
<th></th>
<?php } ?>
</tr>

</tbody>
</table>

<?php if ($action=='edit') {?>
</form>
<?php } ?>