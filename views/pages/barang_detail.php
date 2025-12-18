<?php
include_once '../../config/koneksi.php';
include_once '../../controllers/barangclass.php';
session_start();

// instance objek db dan user
$barang = new Barang();
$db = new Database();

// koneksi ke MySQL via method
$db->connectMySQLi();
$modal_id=$_GET['id'];
foreach($barang->edit_barang($modal_id) as $r){
?>

          <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="update-stock/" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detail Data Barang</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id" value="<?php echo $r['id'];?>">
				  
				  
				  <table width=100%>
					<tr>
						
						<td  valign="top">
								<div class="form-group">
                  <label for="nama" class="col-md-4 control-label">Nama</label>
                  <div class="col-md-8">
                  <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $r['nama']; ?>" onkeyup="this.value = this.value.toUpperCase()" required >
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="jenis" class="col-md-4 control-label">Jenis</label>
                  <div class="col-md-3">
                  <input type="text" class="form-control" id="jenis" name="jenis" value="<?php echo $r['jenis']; ?>" onkeyup="this.value = this.value.toUpperCase()" required >
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="harga" class="col-md-4 control-label">Harga</label>
                  <div class="col-md-3">
                  <input type="text" class="form-control" id="harga" name="harga" value="<?php echo $r['harga']; ?>" required  placeholder="0">
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
              <div class="form-group">
                  <label for="satuan" class="col-md-4 control-label">Satuan</label>
                  <div class="col-md-2">
                 
				   <input type="text" class="form-control"  value="<?php echo $r['satuan']; ?>" required  placeholder="0">
                  
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
              <div class="form-group">
                  <label for="jml_min" class="col-md-4 control-label">Jumlah Minimal</label>
                  <div class="col-md-2">
                  <input type="text" class="form-control" id="jml_min" name="jml_min" value="<?php echo $r['jumlah_min']; ?>" required  placeholder="0">
                  <span class="help-block with-errors"></span>
                  </div>
              </div>
              <div class="form-group">
                  <label for="jml_min_a" class="col-md-4 control-label">Jumlah Minimal Atas</label>
                  <div class="col-md-2">
                  <input type="text" class="form-control" id="jml_min_a" name="jml_min_a" value="<?php echo $r['jumlah_min_a']; ?>" required  placeholder="0">
                  <span class="help-block with-errors"></span>
                  </div>
              </div>
						</td>
				
						<td width=50% valign="top">
				<div class="form-group">
					  <label for="project" class="col-md-4 control-label">Project</label>
					  <div class="col-md-6">
					  <input type="text" class="form-control"  name="project"   value="<?php echo $r['project']; ?>">
					  <span class="help-block with-errors"></span>
					  </div>  				  
                  </div>
                  <div class="form-group">
					  <label for="demand" class="col-md-4 control-label">Demand</label>
					  <div class="col-md-6">
					  <input type="text" class="form-control"  name="demand"   value="<?php echo $r['demand']; ?>">
					  <span class="help-block with-errors"></span>
					  </div>
                  </div>
                  <div class="form-group">
					  <label for="mc" class="col-md-4 control-label">MC</label>
					  <div class="col-md-6">
					  <input type="text" class="form-control"  name="mc"  value="<?php echo $r['mc']; ?>" >
					  <span class="help-block with-errors"></span>
					  </div>
                  </div> 
                
				<div class="form-group">
					  <label for="greige_lbr" class="col-md-4 control-label">Lbr</label>
					  <div class="col-md-6">
					  <input type="text" class="form-control"  name="greige_lbr"   value="<?php echo $r['greige_lbr']; ?>">
					  <span class="help-block with-errors"></span>
					  </div>
                  </div>
                <div class="form-group">
					  <label for="greige_grm" class="col-md-4 control-label">Grm</label>
					  <div class="col-md-6">
					  <input type="text" class="form-control"  name="greige_grm"   value="<?php echo $r['greige_grm']; ?>">
					  <span class="help-block with-errors"></span>
					  </div>
                  </div>
                  <div class="form-group">
                        <label for="kategori_bs" class="col-md-4 control-label">Kategori Bs</label>
                        <div class="col-md-6">
                        <input type="text" class="form-control"  name="kategori_bs"  value="<?php echo $r['kategori_bs']; ?>">
                        <span class="help-block with-errors"></span>
                        </div>
                    </div>
						</td>
				
					</tr>
				</table>
				  
                  
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
<script>
  $(function () {
 //Initialize Select2 Elements
 $('.select2t').select2()
})
</script>
