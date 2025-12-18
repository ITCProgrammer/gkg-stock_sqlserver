<?php
include_once '../../config/koneksi.php';
include_once '../../controllers/satuanClass.php';

// instance objek db dan user
$satuan = new Satuan();
$db     = new Database();

// koneksi ke MySQL via method
$db->connectMySQLi();
$id1=$_GET['id'];
foreach($satuan->edit_satuan($id1) as $d){
?>
          <div class="modal-dialog ">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="update-satuan/" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Satuan</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id" value="<?php echo $d['id'];?>">
                  <div class="form-group">
                  <label for="satuan" class="col-md-3 control-label">Satuan</label>
                  <div class="col-md-6">
                  <input type="text" class="form-control" id="satuan" name="satuan" value="<?php echo $d['satuan'];?>" placeholder="Satuan" required>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="ket" class="col-md-3 control-label">Keterangan</label>
                  <div class="col-md-6">
                  <textarea name="ket" class="form-control" id="ket" placeholder="Keterangan"><?php echo $d['ket'];?></textarea>
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
