<?php
include_once '../../config/koneksi.php';
include_once '../../controllers/usersclass.php';

// instance objek db dan user
$user = new User();
$db = new Database();
$iduser = $_SESSION['idQC'];
// koneksi ke MySQL via method
$db->connectMySQLi();
$modal_id=$_GET['id'];
foreach($user->edit_user($modal_id) as $d){
?>
          <div class="modal-dialog ">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="change-password/" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Change Password</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id" value="<?php echo $d['id'];?>">
                  <div class="form-group">
                  <label for="password" class="col-md-3 control-label">Password</label>
                  <div class="col-md-6">
                  <input type="password" class="form-control" id="password" name="password" required>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="re_password" class="col-md-3 control-label">Re-Password</label>
                  <div class="col-md-6">
                  <input type="password" class="form-control" id="re_password" name="re_password" required>
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
