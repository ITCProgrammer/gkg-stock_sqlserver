<?PHP
session_start();
include"koneksi.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>user</title>
</head>

<body>
  <?php
$Awal	= isset($_POST['awal']) ? $_POST['awal'] : '';
$Akhir	= isset($_POST['akhir']) ? $_POST['akhir'] : '';
$Kode	= isset($_POST['kode']) ? $_POST['kode'] : '';
?>
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title"> Filter Detail Benang Masuk</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form method="post" enctype="multipart/form-data" name="form1" class="form-horizontal" id="form1">
      <div class="box-body">
        <!-- Date range -->
        <div class="form-group">
          <div class="col-sm-3">
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right" id="reservation">
          </div>
        </div>
        <a href="" class="btn btn-info">Search</a>
          <!-- /.input group -->
        </div>
        <div class="col-sm-2">

        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">

      </div>
      <!-- /.box-footer -->
    </form>
  </div>
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Details Data</h3>
    </div>
    <div class="box-body">

      <table id="example2" class="table table-bordered table-hover display nowrap" width="100%">
        <thead class="btn-warning">
          <tr>
            <th width="31">No</th>
            <th width="160">Tgl Pend</th>
            <th width="160">Kode Benang Internal</th>
            <th width="216">Kode Benang Fasilitas</th>
            <th width="220">Deskripsi</th>
            <th width="269">Satuan</th>
            <th width="169">Qty</th>
          </tr>
        </thead>
        <tbody>
          <?php
	$no=1;
	$col=1;
	$kd=$_POST[kode];
	$kd1=$_POST[kode]."-";
	if($_POST[kode]!=""){
		$kode=" AND (a.kd_benang_in='$kd' or a.kd_benang_in LIKE '$kd1%' )";}
	else{
		$kode= " ";};
	$qry=mysql_query("SELECT a.*,b.tgl_pend FROM tbl_exim_import_detail a
	INNER JOIN tbl_exim_import b ON a.id_import=b.id
	WHERE b.tgl_pend BETWEEN '$_POST[awal]' AND '$_POST[akhir]' $kode
	ORDER BY a.kd_benang_in ASC");
	while($row=mysql_fetch_array($qry)){
		$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
  ?>
          <tr bgcolor="<?php echo $bgcolor; ?>">
            <td>
              <?php echo $no; ?>
            </td>
            <td>
              <?php echo $row[tgl_pend]; ?>
            </td>
            <td>
              <?php echo $row[kd_benang_in]; ?>
            </td>
            <td>
              <?php echo $row[kd_benang_fs]; ?>
            </td>
            <td>
              <?php echo $row[deskripsi]; ?>
            </td>
            <td>
              <?php echo $row[satuan]; ?>
            </td>
            <td>
              <?php echo $row[qty]; ?>
            </td>
          </tr>
          <?php $no++; } ?>
        </tbody>
      </table>

    </div>
  </div>
</body>

</html>
