<?PHP
session_start();
$db= new database();
$satuan= new Satuan();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>satuan</title>
</head>

<body>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
<div class="box-header">
  <a href="#" data-toggle="modal" data-target="#DataSatuan" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add</a>
      </div>
      <div class="box-body">
<table width="100%" class="table table-bordered table-hover display nowrap">
 <thead class="btn-primary">
  <tr>
    <th width="5%">No</th>
    <th width="57%">Satuan</th>
    <th width="15%">Keterangan</th>
    <th width="10%">Action</th>
  </tr>
  </thead>
  <tbody>
  <?php
	  $col=0;
	  $no=1;
  foreach($satuan->tampil_data() as $d){
			$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
		 ?>
  <tr bgcolor="<?php echo $bgcolor; ?>">
    <td align="center"><?php echo $no;?></td>
    <td><?php echo $d['satuan'];?></td>
    <td align="center"><?php echo $d['ket'];?></td>
    <td align="center"><div class="btn-group"><a href="#" id='<?php echo $d['id'] ?>' class="btn btn-info btn-sm satuan_edit"><i class="fa fa-edit"></i> </a><a href="#" class="btn btn-danger btn-sm
      <?php if($_SESSION['lvlQC']=='3'){ echo "disabled"; } ?>" onclick="confirm_delete('./hapussatuan-<?php echo $d['id'] ?>/');"
    ><i class="fa fa-trash"></i> </a></div></td>

  </tr>
  <?php
  $no++;} ?>
  </tbody>
</table>
<div class="modal fade" id="DataSatuan">
          <div class="modal-dialog ">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="input-satuan/" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Data Satuan</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id">
                  <div class="form-group">
                  <label for="satuan" class="col-md-3 control-label">Satuan</label>
                  <div class="col-md-6">
                  <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Satuan" required>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="ket" class="col-md-3 control-label">Keterangan</label>
                  <div class="col-md-6">
                  <textarea name="ket" class="form-control" id="ket" placeholder="Keterangan"></textarea>
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
<div class="modal fade" id="modal_delete" tabindex="-1" >
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
<!-- Modal Popup untuk Edit-->
<div id="SatuanEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

</div>
</body>
<script type="text/javascript">
    function confirm_delete(delete_url)
    {
      $('#modal_delete').modal('show', {backdrop: 'static'});
      document.getElementById('delete_link').setAttribute('href' , delete_url);
    }

</script>
</html>
