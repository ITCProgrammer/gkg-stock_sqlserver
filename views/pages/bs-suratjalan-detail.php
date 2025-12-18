<?php include_once('controllers/bsController.php');
echo '<pre>';
	print_r($_GET);
echo '</pre>';
exit ;  	
?>

<div class="row">
<div class="col-xs-12">
<div class="box">
<div class="box-header" style="font-weight:bold"></div>
<div class="box-body">
		
		<table width="100%"  class="table table-bordered table-hover">
		<thead class="btn-primary">
		<tr>
		<th>No </th>
		<th>Id Surat Jalan</th>
		<th>Tanggal Masuk</th>
		<th>Barang</th>
		<th>Lokasi Masuk</th>
		<th>Qty Masuk</th>
		<th>Qty Sisa</th>
		</tr>
		</thead>
		<tbody>
		<?php $no = 1; foreach($model->bs_in_detail('60') as $data) { ?>
		<tr>
		<td><?=$no++?></td>
		<td><?=str_pad($data['surat_jalan_id'], 6, '0', STR_PAD_LEFT)?></td>
		<td><?=$data['tanggal']?></td>
		<td><?=$data['nama']?></td>
		<td><?=$data['lokasi_masuk']?></td>
		<td><?=$data['qty_masuk']?></td>
		<td><?=$data['qty_sisa']?></td>
		</tr>
		<?php } ?>
		</tbody>
		</table>

</div>
</div>
</div>
</div>
