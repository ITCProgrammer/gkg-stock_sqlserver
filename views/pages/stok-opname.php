<?php
error_reporting(0);
session_start();

$opname   = new Opname();
$db       = new Database();
$idsub    = $_SESSION['subQC'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>stok-opname</title>
  </head>

  <body>
<?php
$Awal	= isset($_POST['awal']) ? $_POST['awal'] : '';
$Akhir= isset($_POST['akhir']) ? $_POST['akhir'] : '';
$Note	= isset($_POST['note']) ? $_POST['note'] : '';
$tglstkak = $opname->ambilTgl($idsub);
?>
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title"> Tanggal Stok OPNAME</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form method="post" enctype="multipart/form-data" name="form1" class="form-horizontal" id="form1" action="input-opname/">
        <div class="box-body">
          <input type="hidden" name="idsub" value="<?php echo $_SESSION['subQC'];?>">
          <input type="hidden" name="userid" value="<?php echo $_SESSION['userQC'];?>">
          <div class="form-group">
            <div class="col-sm-3">
              <div class="input-group date">
                <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                <input name="awal" type="text" class="form-control pull-right" id="datepicker" placeholder="Tanggal Awal" value="<?php echo $Awal; ?>" autocomplete="off" required/>
              </div>
            </div>
            <!-- /.input group -->
          </div>
          <div class="form-group">
            <div class="col-sm-3">
              <div class="input-group date">
                <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                <input name="akhir" type="text" class="form-control pull-right" id="datepicker1" placeholder="Tanggal Akhir" value="<?php echo $Akhir;  ?>" autocomplete="off" required/>
              </div>
            </div>
            <!-- /.input group -->
          </div>
          <div class="form-group">
            <div class="col-sm-6">
              <textarea class="form-control" name="note" id="note" placeholder="Note"></textarea>
            </div>

            <!-- /.input group -->
          </div>
          <div class="form-group">
          <div class="col-sm-3">
            <i>Tgl Terakhir Stock: <b><?php echo $tglstkak; ?></b></i>
          </div>
        </div>
          <div class="form-group">
          <div class="col-sm-3">
            <button type="submit" class="btn btn-info">OK</button>
          </div>
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
          <thead class="btn-success">
            <tr>
              <th width="31">No</th>
              <th width="160">Tgl Awal</th>
              <th width="160">Tgl Akhir</th>
              <th width="169">Stok Awal</th>
              <th width="169">Stok IN</th>
              <th width="169">Stok Out</th>
              <th width="169">Stok Akhir</th>
              <th width="169">Note</th>
              <th width="169">UserId</th>
              <th width="169">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $col=0;
    $no=1;
    foreach($opname->tampildata($idsub) as $rowd){
        $bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
    ?>
            <tr bgcolor="<?php echo $bgcolor; ?>">
              <td align="center">
                <?php echo $no; ?>
              </td>
              <td align="center">
                <?php echo $rowd['tgl_awal']; ?>
              </td>
              <td align="center">
                <?php echo $rowd['tgl_akhir']; ?>
              </td>
              <td align="right">
                <?php echo $rowd['stokawal']; ?>
              </td>
              <td align="right">
                <?php echo $rowd['stokin']; ?>
              </td>
              <td align="right">
                <?php echo $rowd['stokout']; ?>
              </td>
              <td align="right">
                <?php echo $rowd['stokakhir']; ?>
              </td>
              <td align="left">
                <?php echo $rowd['note']; ?>
              </td>
              <td align="center">
                <?php echo $rowd['userid']; ?>
              </td>
              <td align="center">
                <div class="btn-group">
                  <a href="cetak/lapstockopname/<?php echo $rowd['tgl_awal']; ?>/<?php echo $rowd['tgl_akhir']; ?>/<?php echo $_SESSION['subQC']; ?>"
                    target="_blank" class="btn btn-primary btn-sm <?php if($_SESSION['lvlQC']==3){echo "disabled"; } ?>"><i class="fa fa-print"></i> </a>
                  <a href="#" class="btn btn-danger btn-sm <?php if($_SESSION['lvlQC']==3 OR $tglstkak != $rowd['tgl_akhir'] ){echo "disabled"; } ?>" onclick="confirm_delete('./hapusopname-<?php echo $rowd['id'] ?>/');"><i class="fa fa-trash"></i> </a>
                </div>
              </td>
            </tr>
            <?php $no++; } ?>
          </tbody>
        </table>

      </div>
    </div>

    <!-- Modal Popup untuk delete-->
    <div class="modal fade" id="modal_delete_opname" tabindex="-1" >
      <div class="modal-dialog modal-sm" >
        <div class="modal-content" style="margin-top:100px;">
          <div class="modal-header">
            <button type="button" class="close"  data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
          </div>

          <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
            <a href="#" class="btn btn-danger" id="delete_link">Delete</a>
            <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
        function confirm_delete(delete_url)
        {
          $('#modal_delete_opname').modal('show', {backdrop: 'static'});
          document.getElementById('delete_link').setAttribute('href' , delete_url);
        }

    </script>
  </body>

</html>
