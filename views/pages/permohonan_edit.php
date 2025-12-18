<?php
include_once '../../config/koneksi.php';
include_once '../../controllers/permohonanclass.php';

// instance objek db dan user
$permohonan = new Permohonan();
$db 		= new Database();

// koneksi ke MySQL via method
$db->connectMySQLi();
$modal_id=$_GET['id'];
foreach($permohonan->edit_permohonan($modal_id) as $r){
?>
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="update-permohonan/" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Data Bon Permohonan</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id" value="<?php echo $r['id'];?>">
				  <div class="form-group">
                  <label for="jenis" class="col-md-3 control-label">Tgl Permohonan</label>
                  <div class="col-md-3">
                  <div class="input-group date">
                  <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                  <input name="tgl_mohon" type="text" class="form-control pull-right" id="datepicker1" placeholder="yyyy-mm-dd" value="<?php echo $r['tgl_mohon']; ?>" autocomplete="off" required/>
                  </div>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="note" class="col-md-3 control-label">Note</label>
                  <div class="col-md-8">
                  <textarea class="form-control" id="note" name="note"><?php echo $r['note']; ?></textarea>	  
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
