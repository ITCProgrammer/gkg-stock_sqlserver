<?PHP
error_reporting(0);
session_start();
// instance objek
$barang = new Barang();
$db = new Database();
//$idsub =$_SESSION['subQC'];
$cek= $barang->jmlStock($idsub);
$min= "minimal";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Barang</title>
</head>

<body>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
<div class="box-header">
  <a href="#" data-toggle="modal" data-target="#DataStock" class="btn btn-success <?php if($_SESSION['lvlQC']==3){echo "disabled"; } ?>"><i class="fa fa-plus-circle"></i> Add</a>
  <?php if($cek>0){?><a href="cetak/lapbarang/<?php echo $_SESSION['subQC']; ?>/<?php echo $min; ?>" class="btn btn-danger pull-right" target="_blank">Cetak</a><?php } ?>
</div>
<div class="box-body">
<table width="100%" id="example1" class="table table-bordered table-hover">
 <thead class="btn-success">
  <tr>
    <th width="2%">No</th>
    <th width="9%">Kode</th>
    <th width="24%">Nama</th>
    <th width="12%">Jenis</th>
    <th width="9%">Harga</th>
    <th width="9%">Sisa</th>
    <th width="8%">Satuan</th>
    <th width="8%">Min</th>
    <th width="8%">Min-A</th>
    <th width="10%">Action</th>
  </tr>
  </thead>
  <tbody>
  <?php
$col=0;
$no=1;
foreach($barang->tampil_data($idsub,$min) as $rowd){
	 $bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
      ?>
  <tr bgcolor="<?php echo $bgcolor; ?>">
    <td><?php echo $no;?></td>
    <td><a href="#" class="open_detailinout" id="<?php echo $rowd['id'] ?>"><?php echo $rowd['kode'];?> <span class="label label-danger"><?php echo $rowd['jml'];?></span></a></td>
    <td align="left"><?php echo $rowd['nama'];?></td>
    <td align="center"><?php echo $rowd['jenis']; ?></td>
    <td align="right"><?php echo $rowd['harga'];?></td>
    <td align="right"><?php echo $rowd['jumlah'];?></td>
    <td align="right"><?php echo $rowd['satuan'];?></td>
    <td align="right"><?php echo $rowd['jumlah_min'];?></td>
    <td align="right"><?php echo $rowd['jumlah_min_a'];?></td>
    <td align="center"><div class="btn-group">
      <a href="#" class="btn btn-info btn-sm open_editbarang <?php if($_SESSION['lvlQC']==3 ){echo "disabled"; } ?>" id="<?php echo $rowd['id'] ?>"><i class="fa fa-edit"></i> </a>
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
                  <div class="form-group">
                  <label for="kode" class="col-md-3 control-label">Kode</label>
                  <div class="col-md-3">
                  <input type="text" class="form-control" id="kode" name="kode" onkeyup="this.value = this.value.toUpperCase()"  required>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="nama" class="col-md-3 control-label">Nama Barang</label>
                  <div class="col-md-8">
                  <input type="text" class="form-control" id="nama" name="nama" onkeyup="this.value = this.value.toUpperCase()" required>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="jenis" class="col-md-3 control-label">Jenis</label>
                  <div class="col-md-3">
                  <input type="text" class="form-control" id="jenis" name="jenis" onkeyup="this.value = this.value.toUpperCase()">
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="harga" class="col-md-3 control-label">Harga</label>
                  <div class="col-md-3">
                  <input type="number" class="form-control" id="harga" name="harga" placeholder="0">
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
              <div class="form-group">
                  <label for="satuan" class="col-md-3 control-label">Satuan</label>
                  <div class="col-md-2">
                  <select class="form-control" name="satuan">
                    <?php foreach($barang->tampil_satuan() as $rowd){ ?>
                  	<option value="<?php echo $rowd['satuan'];?>"><?php echo $rowd['satuan'];?></option>
                  	<?php } ?>
                  </select>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                <div class="form-group">
                      <label for="jml_min" class="col-md-3 control-label">Jumlah Minimal</label>
                      <div class="col-md-2">
                      <input type="text" class="form-control" id="jml_min" name="jml_min" value="" required  placeholder="0">
                      <span class="help-block with-errors"></span>
                      </div>
                  </div>
                  <div class="form-group">
                        <label for="jml_min_a" class="col-md-3 control-label">Jumlah Minimal Atas</label>
                        <div class="col-md-2">
                        <input type="text" class="form-control" id="jml_min_a" name="jml_min_a" value="" required  placeholder="0">
                        <span class="help-block with-errors"></span>
                        </div>
                    </div>
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
<div id="BarangEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

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
