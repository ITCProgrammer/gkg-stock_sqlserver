<?PHP
session_start();
$db= new database();
$user= new User();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>user</title>
</head>

<body>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
<div class="box-header">
  <a href="#" data-toggle="modal" data-target="#DataUser" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add</a>
      </div>
      <div class="box-body">
<table width="100%" class="table table-bordered table-hover display nowrap">
 <thead class="btn-primary">
  <tr>
    <th width="5%">No</th>
    <th width="42%">UserName</th>
    <th width="15%">Level</th>
    <th width="13%">Status</th>
    <th width="15%">Sub Dept</th>
    <th width="10%">Action</th>
  </tr>
  </thead>
  <tbody>
  <?php
	  $col=0;
	  $no=1;
  foreach($user->tampil_data() as $d){
			$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
		 ?>
  <tr bgcolor="<?php echo $bgcolor; ?>">
    <td align="center"><?php echo $no;?></td>
    <td><?php echo $d['username'];?></td>
    <td align="center"><?php if($d['level']=='1'){echo"SuperAdmin";}else if($d['level']=='2'){echo"Admin";}else{echo"Biasa";} ;?></td>
    <td align="center"><?php echo $d['status'];?></td>
    <td align="center"><?php echo $d['sub_dept'];?></td>
    <td align="center"><div class="btn-group"><a href="#" id='<?php echo $d['id'] ?>' class="btn btn-info btn-sm user_edit"><i class="fa fa-edit"></i> </a><a href="#" class="btn btn-danger btn-sm
      <?php if($_SESSION['lvlQC']=='3'){ echo "disabled"; } ?>" onclick="confirm_delete('./hapus-user-<?php echo $d['id'] ?>/');"
    ><i class="fa fa-trash"></i> </a></div></td>

  </tr>
  <?php
  $no++;} ?>
  </tbody>
</table>
<div class="modal fade" id="DataUser">
          <div class="modal-dialog  modal-lg">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="input-user/" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Data User</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id">
                  <div class="form-group">
                  <label for="username" class="col-md-3 control-label">Username</label>
                  <div class="col-md-6">
                  <input type="text" class="form-control" id="username" name="username" required>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="password" class="col-md-3 control-label">Password</label>
                  <div class="col-md-6">
                  <input type="password" class="form-control" id="nama" name="password" required>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="re_password" class="col-md-3 control-label">Re-Password</label>
                  <div class="col-md-6">
                  <input type="password" class="form-control" id="nama" name="re_password" required>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="idsub" class="col-md-3 control-label">Sub Dept</label>
                  <div class="col-md-6">
                  <select name="idsub" class="form-control select2" id="idsub" required>
                  	<option value="ATK">ATK</option>
                    <option value="PACKING">PACKING</option>
                    <option value="TQ">TQ</option>
					<option value="INSPECTION">INSPECTION</option>  
                  </select>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="level" class="col-md-3 control-label">Level</label>
                  <div class="col-md-6">
                  <select name="level" class="form-control select2" id="level" style="width: 100%" required>
                  	<option value="1">SuperAdmin</option>
                  	<option value="2">Admin</option>
                  	<option value="3">Biasa</option>
                  </select>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="jabatan" class="col-md-3 control-label">Jabatan</label>
                  <div class="col-md-6">
                  <select name="jabatan" class="form-control select2" id="jabatan" style="width: 100%" required>
                  	<option value="Manager">Manager</option>
                  	<option value="Asst. Manager">Asst. Manager</option>
                  	<option value="Staff">Staff</option>
                  </select>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="thn" class="col-md-3 control-label">Tahun Mamber</label>
                  <div class="col-md-6">
                  <select name="thn" class="form-control select2" id="thn" required>
                  	<?php
                $thn_skr = date('Y');
                for ($x = $thn_skr; $x >= 2017; $x--) {
                ?>
        <option value="<?php echo $x ?>" <?php if($Thn2!=""){if($Thn2==$x){echo "SELECTED";}}else{if($x==$thn_skr){echo "SELECTED";}} ?>><?php echo $x ?></option>
        <?php
                }
   ?>
                  </select>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="status" class="col-md-3 control-label">Status</label>
                  <div class="col-md-6">
                  <div class="radio">
                    <label>
                      <input type="radio" name="status" value="Aktif" id="status_0" checked>
                      Aktif
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="status" value="Non-Aktif" id="status_1">
                      Non-Aktif
                    </label>
                  </div>
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
<div class="modal fade" id="modal_delete" >
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
<div id="UserEdit" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
