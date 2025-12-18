<?php
include_once '../../config/koneksi.php';
include_once '../../controllers/barangclass.php';
include_once '../../controllers/barangmasukclass.php';

// instance objek db dan user
$barang   = new Barang();
$barangin = new BarangMasuk();
$db       = new Database();

// koneksi ke MySQL via method
$db->connectMySQLi();
$modal_id=$_GET['id'];
foreach($barangin->edit_barang_in($modal_id) as $r){
?>
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="update-stock-in/" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Data Barang In</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id" value="<?php echo $r['id'];?>">
                  <div class="form-group">
                  <label for="jumlah" class="col-md-3 control-label">Jumlah</label>
                  <div class="col-md-2">
                  <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="0.00" step="0.01" min="0" lang="en" value="<?php echo $r['jumlah']; ?>" >
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="note" class="col-md-3 control-label">Note</label>
                  <div class="col-md-8">
                  <textarea name="note" rows="8" cols="80" class="form-control" id="note"><?php echo $r['note']; ?></textarea>
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

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true,
	  format: 'yyyy-mm-dd',
      todayHighlight: true,
    }),
	//Date picker
    $('#datepicker1').datepicker({
      autoclose: true,
	  format: 'yyyy-mm-dd',
      todayHighlight: true,
    }),
	//Date picker
    $('#datepicker2').datepicker({
      autoclose: true,
	  format: 'yyyy-mm-dd',
      todayHighlight: true,
    }),
	//Date picker
    $('#datepicker3').datepicker({
      autoclose: true,
	  format: 'yyyy-mm-dd',
      todayHighlight: true,
    })
</script>
