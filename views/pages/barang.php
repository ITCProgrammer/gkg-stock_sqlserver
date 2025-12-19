<?PHP
error_reporting(0);
session_start();
// instance objek
$barang = new Barang();
$db = new Database();
//$idsub =$_SESSION['subQC'];
$cek= $barang->jmlStock($idsub);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Barang</title>	
	<style>           	
    		.blink_me {
      			animation: blinker 1s linear infinite;
    		}

    		.blink_me1 {
      			animation: blinker 7s linear infinite;
    	}
      </style>
</head>

<body>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
<div class="box-header">
  <a href="#" data-toggle="modal" data-target="#DataStock" class="btn btn-success <?php if($_SESSION['lvlQC']==3){echo "disabled"; } ?>"><i class="fa fa-plus-circle"></i> Add</a>
  <?php if($cek>0){?><a href="cetak/lapbarang/<?php echo $_SESSION['subQC']; ?>/" class="btn btn-danger pull-right" target="_blank">Cetak</a><?php } ?>
</div>
<div class="box-body">
<table width="100%" id="example4" class="table table-bordered table-hover">
 <thead class="btn-success">
  <tr>
    <th width="2%">No</th>
    <th width="9%">Kode</th>
    <th width="24%">Nama</th>
    <th width="12%">Jenis</th>
    <th >Harga</th>
    <th >Sisa</th>
    <th >Satuan</th>
    <th >Min</th>
    <th>Min-A</th>
	
    <th width=15% style="text-align:center">Action</th>
  </tr>
  </thead>
  <tbody>
  <?php
$col=0;
$no=1;
foreach($barang->tampil_data($idsub,$min) as $rowd){
	 $bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
	if($rowd['jumlah']>=$rowd['jumlah_min'] and $rowd['jumlah']<=$rowd['jumlah_min_a'] ){
		$stt="YA1";
	}else if($rowd['jumlah']<$rowd['jumlah_min']){
		$stt="YA";	
	}else{
		$stt="TIDAK";
	}
	 
      ?>
  <tr bgcolor="<?php echo $bgcolor; ?>">
    <td><?php echo $no;?></td>
    <td><a href="#" class="open_detailinout" id="<?php echo $rowd['id'] ?>"><?php echo $rowd['kode'];?> <span class="label label-danger"><?php echo $rowd['jml'];?></span></a></td>
    <td align="left"><?php echo $rowd['nama'];?></td>
    <td align="center"><?php echo $rowd['jenis']; ?><?php if($stt=="YA"){ ?><br><i class='fa fa-warning text-yellow  blink_me'></i> <span class='label label-danger'>Harus Ditambah</span><?php } ?><?php if($stt=="YA1"){ ?><br><i class='fa fa-warning text-yellow  blink_me'></i> <span class='label label-warning'>Stok Hampir Habis</span><?php } ?></td>
    <td align="right"><?php echo $rowd['harga'];?></td>
    <td align="right"><?= number_format($rowd['jumlah'], 2, '.', '') ?></td>
    <td align="right"><?php echo $rowd['satuan'];?></td>
    <td align="right"><?php echo $rowd['jumlah_min'];?></td>
    <td align="right"><?php echo $rowd['jumlah_min_a'];?></td>
    <td align="center"><div class="btn-group">
	 <?php 
	 if( $_SESSION['lvlQC'] <= 2 or  $_SESSION['subQC']=='BS' ) {
		 if ($_SESSION['lvlQC']==3) {
				$akses_edit = 'disabled';
		 } else {
				$akses_edit = '';
		 }
		
	 } else {
		 $akses_edit = 'disabled';
	 };?>
	  <a  href="#" class="btn btn-default btn-sm open_detailbarang"  id="<?php echo $rowd['id'] ?>"><i class="fa fa-file text-yellow"></i> </a>
	  <a  href="#" class="btn btn-info btn-sm open_editbarang <?=$akses_edit?>" id="<?php echo $rowd['id'] ?>"><i class="fa fa-edit"></i> </a>
	  <a href="#" class="btn btn-danger btn-sm <?php if($_SESSION['lvlQC']==3 or $rowd['idb']!=""){echo "disabled"; } ?>" onclick="confirm_delete1('./hapusstock-<?php echo $rowd['id'] ?>/');"><i class="fa fa-trash"></i> </a></div>
    </td>
  </tr>
  <?php
  $no++;} ?>
  </tbody>
</table>

<div class="modal fade" id="DataStock">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="input-stock/" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Data Barang</h4>
              </div>
              <div class="modal-body">
			  <input type="hidden" id="id" name="id">
              <input type="hidden" id="idsub" name="idsub" value="<?php echo $_SESSION['subQC'];?>">
			  <table width=100%>
				<tr>
				<?php if($_SESSION['subQC']=='BS') {$width='50%';} else { $width='100%';}?>
					<td width=<?=$width?> valign="top">
					<div class="form-group">
					  <label for="kode" class="col-md-4 control-label">Kode</label>
					  <div class="col-md-6">
					  <input type="text" class="form-control" id="kode" name="kode" onkeyup="this.value = this.value.toUpperCase()"  required>
					  <span class="help-block with-errors"></span>
					  </div>  				  
                  </div>
                  <div class="form-group">
					  <label for="nama" class="col-md-4 control-label">Nama Barang</label>
					  <div class="col-md-6">
					  <input type="text" class="form-control" id="nama" name="nama" onkeyup="this.value = this.value.toUpperCase()" required>
					  <span class="help-block with-errors"></span>
					  </div>
                  </div>
                  <div class="form-group">
					  <label for="jenis" class="col-md-4 control-label">Jenis</label>
					  <div class="col-md-6">
					  <input type="text" class="form-control" id="jenis" name="jenis" onkeyup="this.value = this.value.toUpperCase()">
					  <span class="help-block with-errors"></span>
					  </div>
                  </div>
                  <div class="form-group">
					  <label for="harga" class="col-md-4 control-label">Harga</label>
					  <div class="col-md-6">
					  <input type="number" class="form-control" id="harga" name="harga" placeholder="0">
					  <span class="help-block with-errors"></span>
					  </div>
                  </div>
				<div class="form-group">
					  <label for="satuan" class="col-md-4 control-label">Satuan</label>
					  <div class="col-md-6">
					  <select class="form-control select2" name="satuan">
						<?php foreach($barang->tampil_satuan() as $rowd){
						?>
						<option value="<?php echo $rowd['satuan'];?>"><?php echo $rowd['satuan'];?></option>
						<?php } ?>
					  </select>
					  <span class="help-block with-errors"></span>
					  </div>
                  </div>
                <div class="form-group">
                      <label for="jml_min" class="col-md-4 control-label">Jumlah Minimal</label>
                      <div class="col-md-6">
                      <input type="text" class="form-control" id="jml_min" name="jml_min" value="" required  placeholder="0">
                      <span class="help-block with-errors"></span>
                      </div>
                  </div>
                  <div class="form-group">
                        <label for="jml_min_a" class="col-md-4 control-label">Jumlah Minimal Atas</label>
                        <div class="col-md-6">
                        <input type="text" class="form-control" id="jml_min_a" name="jml_min_a" value="" required  placeholder="0">
                        <span class="help-block with-errors"></span>
                        </div>
                    </div>
					</td>
					<?php if($_SESSION['subQC']=='BS' ) {?>
					<td width=50% valign="top">
					
						<div class="form-group">
					  <label for="project" class="col-md-4 control-label">Project</label>
					  <div class="col-md-6">
					  <input type="text" class="form-control"  name="project"  >
					  <span class="help-block with-errors"></span>
					  </div>  				  
                  </div>
                  <div class="form-group">
					  <label for="demand" class="col-md-4 control-label">Demand</label>
					  <div class="col-md-6">
					  <input type="text" class="form-control"  name="demand"  >
					  <span class="help-block with-errors"></span>
					  </div>
                  </div>
                  <div class="form-group">
					  <label for="mc" class="col-md-4 control-label">MC</label>
					  <div class="col-md-6">
					  <input type="text" class="form-control"  name="mc"  >
					  <span class="help-block with-errors"></span>
					  </div>
                  </div>
                
				<div class="form-group">
					  <label for="greige_lbr" class="col-md-4 control-label">Lbr</label>
					  <div class="col-md-6">
					  <input type="text" class="form-control"  name="greige_lbr"  >
					  <span class="help-block with-errors"></span>
					  </div>
                  </div>
                <div class="form-group">
					  <label for="greige_grm" class="col-md-4 control-label">Grm</label>
					  <div class="col-md-6">
					  <input type="text" class="form-control"  name="greige_grm"  >
					  <span class="help-block with-errors"></span>
					  </div>
                  </div>
                  <div class="form-group">
                        <label for="kategori_bs" class="col-md-4 control-label">Kategori Bs</label>
                        <div class="col-md-6">
                        <input type="text" class="form-control"  name="kategori_bs" >
                        <span class="help-block with-errors"></span>
                        </div>
                    </div>
					
					</td>
					<?php } ?>
				</tr>
			  </table>
			  
			  
                  
				  
                 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" >Save</button>
              </div>
            </form>
            </div>
            <!-- /.modal-content -->
  </div>
          <!-- /.modal-dialog -->
</div>
<!-- Modal Popup untuk delete-->
<div class="modal fade" id="modal_delete_barang" tabindex="-1" >
  <div class="modal-dialog modal-sm" >
    <div class="modal-content" style="margin-top:100px;">
      <div class="modal-header">
        <button type="button" class="close"  data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
      </div>

      <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
        <a href="#" class="btn btn-danger" id="delete_link1">Delete</a>
        <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Popup untuk Edit-->
<div id="BarangEdit" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

</div>
<div id="DetailInOut" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
</div>
</body>
<!-- Javascript untuk popup modal Delete-->
<script type="text/javascript">
    function confirm_delete1(delete_url)
    {
      $('#modal_delete_barang').modal('show', {backdrop: 'static'});
      document.getElementById('delete_link1').setAttribute('href' , delete_url);
    }

</script>
<script type="text/javascript">
    function confirm_delete2(delete_url)
    {
      $('#modal_delete_barang1').modal('show', {backdrop: 'static'});
      document.getElementById('delete_link2').setAttribute('href' , delete_url);
    }

</script>
</html>
