<?php
error_reporting(1);
session_start();

include_once('controllers/kartustokClass.php');
$model = new Kartustok;



$opname   = new Opname();
$db       = new Database();
$idsub    = $_SESSION['subQC'];



?>



    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title"> Search</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form target="blank" method="get"  class="form-horizontal" id="form1" action="cetak/lapkartustok">
        <div class="box-body">
          
          <div class="form-group">
            <div class="col-sm-3">
              <div class="input-group date">
                <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                <input name="awal" type="date" class="form-control pull-right" id="awal" placeholder="Tanggal Awal" value="<?php echo $Awal; ?>" autocomplete="off" required/>
              </div>
            </div>
			
			<div class="col-sm-3">
              <div class="input-group date">
                <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                <input name="akhir" type="date" class="form-control pull-right" id="akhir" placeholder="Tanggal Akhir" value="<?php echo $Akhir;  ?>" autocomplete="off" required/>
              </div>
            </div>
			  <div class="col-md-6">
                    <select class="form-control select2" name="kode" style="width: 100%;" required >
                      <option value="">Select Barang</option>
                    	<?php  foreach($model->tampil_databarang() as $rowd1){ ?>
                      <option value="<?php echo $rowd1['id'];?>" ><?php echo $rowd1['nama'];?> 
					  
					  <?php if($rowd1['jenis']!='' and  $rowd1['jenis']!='-') { echo '/'.$rowd1['jenis'];}?></option>
                      <?php } ?>
                    </select>
                  <span class="help-block with-errors"></span>
                  </div>
            <!-- /.input group -->
          </div>
     
        
      
          <div class="form-group">
          <div class="col-sm-3">
            <button type="submit" class="btn btn-info" onclick="submitForm()">VIEW</button>
          </div>
        </div>
      </div>
        <!-- /.box-body -->
     
        <!-- /.box-footer -->
      </form>
    </div>
   
