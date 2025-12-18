<?php include_once('controllers/bsController.php');?>


<div class="row">
  <div class="col-xs-12">
    <div class="box">
<div class="box-header">
<!--
<a href="bs-barang" class="btn btn-success"><i class="fa fa-plus-circle"></i> Barang BS</a>
-->     
	 </div>
      <div class="box-body">

<table width="100%" id="example1" class="table table-bordered table-hover">
<thead class="btn-primary">
	<tr>
		<th width=10px>No</th>
		<th>Nama</th>
		<th>Jenis Kain</th>
		<th>Qty Masuk</th>
		<th>Roll</th>
		<th>Qty Keluar</th>
		<th>Roll</th>
		<th>Qty Sisa</th>
		<th>Roll</th>
	
	</tr>
</thead>
<tbody>
	<?php 
	
	$roll_masuk  = $model->roll_masuk('barang_bs_id');
	
	$roll_keluar  = $model->roll_keluar('id');
	$roll_sisa  = $model->roll_sisa('id');
	
	$out = $model->bs_barang_in_out('out');
	$no = 1; foreach($model->bs_barang() as $data) { 
	if (array_key_exists($data['id'],$out )) {
		$keluar = $out[$data['id']];
	} else {
		$keluar = 0;
	}
		
		
	?>
		<tr>
		<td><?=$no++?></td>
		<td>
	    <?php if ($data['nama']=='BS-A') {?>
		<a target="_blank" href="views/pages/cetak/bs-detail.php?id=<?=$data['id'];?>">
		<?=$data['nama']?>
		</a>
		<?php }  else {
			echo $data['nama'] ; 
		}?>
		</td>
	    <td><?=$data['jenis_kain']?></td>
		<td><?=$data['qty_masuk']?></td>
		<td><?php 
				if (array_key_exists($data['id'],$roll_masuk)) {
				echo $roll_m = $roll_masuk[$data['id']];
			} else { echo $roll_m = 0 ;}?>
		</td>
		<td><?=$keluar?></td>
		<td><?php 
				if (array_key_exists($data['id'],$roll_keluar)) {
				echo $roll_k = $roll_keluar[$data['id']];
			} else { echo  $roll_k = 0 ;} ?>
		</td>
		<td><?=$data['qty_masuk'] -  $keluar?></td>
		<td><?php echo $roll_m -  $roll_k  ?></td>
	</tr>
	<?php } ?>
</tbody>
</table>

</div>
</div>
</div>

