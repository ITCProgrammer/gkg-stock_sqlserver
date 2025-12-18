<?php
include_once '../../config/koneksi.php';
include_once '../../controllers/usersclass.php';

// instance objek db dan user
$user = new User();
$db = new Database();

// koneksi ke MySQL via method
$db->connectMySQLi();
foreach($user->edit_user($_GET['id']) as $d){
?>
          <div class="modal-dialog ">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="update-user/" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit User</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id" value="<?php echo $d['id'];?>">
                  <div class="form-group">
                  <label for="username" class="col-md-3 control-label">Username</label>
                  <div class="col-md-6">
                  <input type="text" class="form-control" id="username" name="username" value="<?php echo $d['username'];?>"  required>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="username" class="col-md-3 control-label">Password</label>
                  <div class="col-md-6">
                  <input type="password" class="form-control" id="nama" name="password" required>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="username" class="col-md-3 control-label">Re-Password</label>
                  <div class="col-md-6">
                  <input type="password" class="form-control" id="nama" name="re_password" required>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="level" class="col-md-3 control-label">Level</label>
                  <div class="col-md-6">
                  <select name="level" class="form-control select2t" id="level" style="width: 100%" required>
                  	<option value="1" <?php if($d['level']=="1"){echo "SELECTED";}?>>SuperAdmin</option>
          <option value="2" <?php if($d['level']=="2"){echo "SELECTED";}?>>Admin</option>
          <option value="3" <?php if($d['level']=="3"){echo "SELECTED";}?>>Biasa</option>
                  </select>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="idsub" class="col-md-3 control-label">Sub Dept</label>
                  <div class="col-md-6">
                  <select name="idsub" class="form-control select2t" id="idsub" required>
                  	<option value="ATK" <?php if($d['sub_dept']=="ATK"){echo "SELECTED";}?>>ATK</option>
                    <option value="PACKING" <?php if($d['sub_dept']=="PACKING"){echo "SELECTED";}?>>PACKING</option>
                    <option value="TQ" <?php if($d['sub_dept']=="TQ"){echo "SELECTED";}?>>TQ</option>
					<option value="INSPECTION" <?php if($d['sub_dept']=="INSPECTION"){echo "SELECTED";}?>>INSPECTION</option>  
                  </select>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="jabatan" class="col-md-3 control-label">Jabatan</label>
                  <div class="col-md-6">
                  <select name="jabatan" class="form-control select2t" id="jabatan" style="width: 100%" required>
                  	<option value="Manager" <?php if($d['jabatan']=="Manager"){echo "SELECTED";}?>>Manager</option>
                  	<option value="Asst. Manager" <?php if($d['jabatan']=="Asst. Manager"){echo "SELECTED";}?>>Asst. Manager</option>
                  	<option value="Staff" <?php if($d['jabatan']=="Staff"){echo "SELECTED";}?>>Staff</option>
                  </select>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="thn" class="col-md-3 control-label">Tahun Mamber</label>
                  <div class="col-md-6">
					  
                  <select name="thn" class="form-control select2t" id="thn" required>
                <?php
                $thn_skr = date('Y');
                for ($x = $thn_skr; $x >= 2017; $x--) {
                ?>
        		<option value="<?php echo $x ?>" <?php if($x==$d['mamber']){echo "SELECTED";} ?>><?php echo $x ?></option>
       			<?php } ?>  
                </select>
                  
				  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="username" class="col-md-3 control-label">Status</label>
                  <div class="col-md-6">
                  <div class="radio">
                    <label>
                      <input type="radio" name="status" value="Aktif" id="status_0" <?php if($d['status']=="Aktif"){echo "checked";}?>>
                      Aktif
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="status" value="Non-Aktif" id="status_1" <?php if($d['status']=="Non-Aktif"){echo "checked";}?>>
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
          <?php } ?>
<script>
  $(function () {
 //Initialize Select2 Elements
 $('.select2t').select2()
})
</script>
