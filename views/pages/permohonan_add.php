<?php
error_reporting(0);
session_start();
include_once '../../config/koneksi.php';
include_once '../../controllers/permohonanclass.php';
include_once('../../controllers/barangclass.php');

// instance objek db dan user
$permohonan = new Permohonan();
$barang   	= new Barang();
$db 		= new Database(); 

// koneksi ke MySQL via method
$db->connectMySQLi();
$modal_id=$_GET['id'];
foreach($permohonan->edit_permohonan($modal_id) as $r){
?>
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="add-detail-permohonan/" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Detail Data Bon Permohonan</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id" value="<?php echo $r['id'];?>">
				  <div class="form-group">
                <label for="kode" class="col-md-3 control-label">Kode</label>
                <div class="col-md-8">
                  <select class="form-control select2t" name="kode" style="width: 100%;">
					<option value="">Pilih</option>  
                    <?php  foreach($barang->tampil_databarang($_SESSION['subQC']) as $rowd1){ ?>
                      <option value="<?php echo $rowd1['id'];?>" ><?php echo $rowd1['kode']." | ".$rowd1['nama'];?></option>
                      <?php } ?>
                  </select>
                <span class="help-block with-errors"></span>
                </div>
                </div>
                <div class="form-group">
                <label for="jumlah" class="col-md-3 control-label">Jumlah</label>
                <div class="col-md-2">
                <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="0.00" step="0.01" min="0" lang="en" >
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
