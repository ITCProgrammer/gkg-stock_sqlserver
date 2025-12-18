<?php 
	include_once('../../../config/koneksi.php');
	include_once('../../../models/bsModel.php');
	$model = new Bs;
	$id = $_GET['id'];
	
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



<table width="100%"  class="table-report">
<thead class="btn-primary">
<tr>
<th>No</th>
<th>Id Surat Jalan</th>
<th>Tanggal Masuk</th>
<th>Barang</th>
<th>Qty Masuk</th>
<th>Qty Sisa</th>
<th>Lokasi Masuk</th>
<th>Jenis Kain</th>
<th>PO</th>
<th>Keterangan</th>
<th>Lbr</th>
<th>Grm</th>
</tr>
</thead>
<tbody>
<?php
$sum_qtymasuk = 0 ; 
$sum_qtykeluar = 0 ; 
$no = 1;$array = []; foreach($model->bs_detail($id) as $data) { 
if ($data['qty_sisa'] > 0 ) {
	$sum_qtymasuk += $data['qty_masuk'] ; 
	$sum_qtykeluar += $data['qty_sisa'] ; 
$array[] = 1?>
<tr>
<td><?=$no++?></td>
<td><?=str_pad($data['surat_jalan_id'], 6, '0', STR_PAD_LEFT)?></td>
<td><?=$data['tanggal']?></td>
<td><?=$data['nama']?></td>
<td><?=$data['qty_masuk']?></td>
<td><?=$data['qty_sisa']?></td>
<td><?=$data['lokasi_masuk']?></td>
<td><?=$data['project']?></td>
<td><?=$data['demand']?></td>
<td><?=$data['mc']?></td>
<td><?=$data['lbr']?></td>
<td><?=$data['grm']?></td>

</tr>
<?php } } ?>
<tr>
	<td colspan=4></td>
	<td ><?=$sum_qtymasuk?></td>
	<td ><b><?=$sum_qtykeluar?></b></td>
	<td colspan=7></td>
</tr>
</tbody>
</table>

