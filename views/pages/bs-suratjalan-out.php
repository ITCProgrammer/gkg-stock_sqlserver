<?php include_once('controllers/bsController.php');?>


<div class="row">
  <div class="col-xs-12">
    <div class="box">
<div class="box-header">
<?php if ($_SESSION['lvlQC']==2) {?>
  <a href="bs-out" class="btn btn-success"><i class="fa fa-plus-circle"></i> Out</a>
<?php  } ?>
      </div>
      <div class="box-body">
<table width="100%" id="example1" class="table table-bordered table-hover">
<thead class="btn-primary">
	<tr>
		<th>No</th>
		<th>Id Surat Jalan</th>
		<th>Tanggal</th>
		<th>Qty Keluar</th>
	
		<th style="text-align:center">Action</th>
	</tr>
</thead>
<tbody>
	<?php $no = 1; foreach($model->bs_suratjalan_out() as $data) { ?>
		<tr>
		<td><?=$no++?></td>
		<td><?=str_pad($data['id'], 6, '0', STR_PAD_LEFT)?></td>
		<td><?=$data['tanggal']?></td>
		<td><?=$data['qty_keluar_detail']?></td>
		
		<td style="text-align:center"><a target="blank" href="views/pages/cetak/bs-cetak-out.php?id=<?=$data['id']?>">Detail</a>
		&nbsp;|&nbsp;
		<a target="blank" href="views/pages/cetak/bs-cetak-out.php?id=<?=$data['id']?>&action=delete">Delete</a>
		</td>
		</tr>
	<?php } ?>
</tbody>
</table>

</div>
</div>
</div>

