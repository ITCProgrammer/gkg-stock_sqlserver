<?php include_once('controllers/bsController.php');?>



<div class="row">
  <div class="col-xs-12">
    <div class="box">
<div class="box-header">
	<?php if ($_SESSION['lvlQC']==2) {?>
   <a href="#" data-toggle="modal" data-target="#DataStock" class="btn btn-success"><i class="fa fa-plus-circle"></i>  In</a>
	<?php  }?>
   
   
   
      </div>
      <div class="box-body">
	  
<?php 
$bs_suratjalan_array = $model->bs_suratjalan_array('out');
?>
<table width="100%" id="example1" class="table table-bordered table-hover">
<thead class="btn-primary">
	<tr>
		<th>No</th>
		<th>Id Surat Jalan</th>
		<th>Tanggal</th>
		<th>Qty Masuk</th>
		<th>Roll</th>
		<th>Qty Keluar</th>
		<th>Roll</th>
		<th>Qty Sisa</th>
		<th>Roll</th>
		<th style="text-align:center">Action</th>
	</tr>
</thead>
<tbody>
	<?php 
	$roll_masuk  = $model->sj_roll_masuk();
	$roll_keluar  = $model->sj_roll_keluar();
	
	
	$no = 1; foreach($model->bs_suratjalan() as $data) { 
	if (array_key_exists($data['id'],$bs_suratjalan_array)) {
		$keluar = $bs_suratjalan_array[$data['id']];
	} else {
		$keluar  = 0 ; 
	}
	?>
		<tr>
		<td><?=$no++?></td>
		<td><?=str_pad($data['id'], 6, '0', STR_PAD_LEFT)?></td>
		<td><?=$data['tanggal']?></td>
		<td><?=$data['qty_masuk']?></td>
		<td><?php 
				if (array_key_exists($data['id'],$roll_masuk)) {
				echo $rol_m = $roll_masuk[$data['id']];
			} else { echo $rol_m = 0 ;}?>
		</td>
		<td><?=$keluar?></td>
		<td><?php 
				if (array_key_exists($data['id'],$roll_keluar)) {
				echo $rol_k = $roll_keluar[$data['id']];
			} else { echo $rol_k  = 0 ;}?>
		</td>
		<td><?=$data['qty_masuk']-$keluar ?></td>
		<td><?php echo $rol_m - $rol_k?></td>
		<td style="text-align:center">
		
		<a target="blank" href="views/pages/cetak/bs-cetak-in.php?id=<?=$data['id']?>">Detail</a>
		<?php if ($_SESSION['lvlQC']==2) {?>
		&nbsp;|&nbsp;
		<a target="blank" href="views/pages/cetak/bs-cetak-in.php?id=<?=$data['id']?>&action=edit">Edit</a>
		&nbsp;|&nbsp;
		<a target="blank" href="views/pages/cetak/bs-cetak-in.php?id=<?=$data['id']?>&action=delete">Delete</a>
		<?php  } ?>
		
		</td>
		</tr>
	<?php } ?>
</tbody>
</table>

</div>
</div>
</div>

<div class="modal fade" id="DataStock">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="bs-input" enctype="multipart/form-data" onsubmit="return toSubmit();">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
              </div>
              <div class="modal-body">
                  
                  <div class="form-group">
                  <label for="kode" class="col-md-3 control-label">Barang BS</label>
                  <div class="col-md-6">
                    <select class="form-control select2" name="preview_barang_bs" style="width: 100%;">
                      <option value=""> </option>
                      <?php foreach($model->bs_barang() as $data) {  ?>
                      <option value="<?php echo $data['id'];?>#<?php echo $data['nama'];?> /<?php echo $data['jenis_kain'];?>" > <?php echo $data['nama'];?> /<?php echo $data['jenis_kain'];?> </option>
                      <?php } ?>
                    </select>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="jumlah" class="col-md-3 control-label">Jumlah Row</label>
                  <div class="col-md-2">
                  <input type="number" class="form-control" name="preview_jumlah_row"  >
                  <span class="help-block with-errors"></span>
                  </div>
                  </div> 
				  
				     <div class="form-group">
                  <label for="kode" class="col-md-3 control-label">Lokasi</label>
				  
				<div class="col-md-3">
					<input type="text" class="form-control" name="preview_lokasi_bs" id="preview_lokasi_bs" min="7" max="7" maxlength="7" required>
                    <!-- <select class="form-control select2" name="preview_lokasi_bs" style="width: 100%;">
                      <option value=""> </option>
                      <?php foreach($model->lokasi_list() as $data) {  ?>
                      <option value="<?=$data?>" > <?=$data?> </option>
                      <?php } ?>
                    </select> -->
                  <span class="help-block with-errors"></span>
                  </div>	
				  </div>



				  
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <input type="submit" value="Next" name="input_preview" class="btn btn-success ">
              </div>
            </form>
            </div>
            <!-- /.modal-content -->
  </div>
          <!-- /.modal-dialog -->
</div>

<script>
	function toSubmit(){
    //   alert('I will not submit');

	let lokasibs = document.getElementById('preview_lokasi_bs').value
	if(lokasibs.length > 7) {
		alert('karakter lokasi lebih dari 7');
	} else if(lokasibs.length < 7) {
		alert('karakter lokasi kurang dari 7');
	} else {
		return true;
	}
      return false;
   }
</script>