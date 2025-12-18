<?php
error_reporting(0);
session_start();
include_once '../../config/koneksi.php';
include_once '../../controllers/barangclass.php';
include_once '../../controllers/barangmasukclass.php';
include_once '../../controllers/barangkeluarclass.php';

// instance objek db dan user
$barang = new Barang();
$barangin = new BarangMasuk();
$barangout= new BarangKeluar();
$db = new Database();

// koneksi ke MySQL via method
$db->connectMySQLi();
$modal_id=$_GET['id'];
?>
          <div class="modal-dialog modal-lg" style="width: 90%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Detail In-Out </h4>
                    </div>
              <div class="modal-body">
  				<!-- Custom Tabs -->
  				<div class="nav-tabs-custom">
  					<ul class="nav nav-tabs">
  						<li class="active"><a href="#tab_1" data-toggle="tab">Barang In</a></li>
  						<li><a href="#tab_2" data-toggle="tab">Barang Out</a></li>
  					</ul>
  					<div class="tab-content">
  						<div class="tab-pane active" id="tab_1">
                <table id="tbl3" class="table table-bordered table-hover display" width="100%">
  <thead class="bg-blue">
     <tr>
        <th width="40"><div align="center">No</div></th>
        <th width="120"><div align="center">Tanggal</div></th>
        <th width="265"><div align="center">Kode</div></th>
        <th width="133"><div align="center">Jenis</div></th>
  	   <th width="115"><div align="center">Jumlah</div></th>
        <th width="116"><div align="center">Satuan</div></th>
  	   <th width="133"><div align="center">Total Harga</div></th>
        <th width="125"><div align="center">Userid</div></th>
        <th width="126"><div align="center">Note</div></th>
  	   </tr>
  </thead>
  <tbody>
    <?php
  foreach($barangin->show_detail($modal_id) as $r){
  		$no++;
  		$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
  	  	?>
       <tr bgcolor="<?php echo $bgcolor; ?>">
       <td align="center"><?php echo $no; ?></td>
       <td align="center"><?php echo $r['tanggal']; ?></td>
       <td align="center"><?php echo $r['kode']; ?></td>
       <td align="center"><?php echo $r['jenis']; ?></td>
       <td align="right"><?php echo $r['jml']; ?></td>
       <td align="center"><?php echo $r['satuan']; ?></td>
       <td align="right"><?php echo number_format($r['harga']*$r['jml'],"2",".",""); ?></td>
       <td align="center"><?php echo $r['userid']; ?></td>
       <td align="left"><?php echo $r['note']; ?></td>
       </tr>
     <?php
     $totalin=$totalin+$r['jml'];
     $tothrgin=$tothrgin+($r['harga']*$r['jml']);
   } ?>
     </tbody>
     <tfoot class="bg-blue">
       <tr>
       <td align="center">&nbsp;</td>
       <td align="center">&nbsp;</td>
       <td align="center">&nbsp;</td>
       <td align="center"><strong>Total</strong></td>
       <td align="right"><strong><?php echo number_format($totalin,"2",".",""); ?></strong></td>
       <td align="center">&nbsp;</td>
       <td align="right"><strong><?php echo number_format($tothrgin,"2",".",""); ?></strong></td>
       <td align="center">&nbsp;</td>
       <td align="left">&nbsp;</td>
       </tr>
     </tfoot>
  </table>
  						</div>
  						<!-- /.tab-pane -->
  						<div class="tab-pane" id="tab_2">
                <table id="tbl4" class="table table-bordered table-hover display" width="100%">
  <thead class="bg-red">
     <tr>
        <th width="40"><div align="center">No</div></th>
        <th width="120"><div align="center">Tanggal</div></th>
        <th width="265"><div align="center">Kode</div></th>
        <th width="133"><div align="center">Jenis</div></th>
  	    <th width="115"><div align="center">Jumlah</div></th>
        <th width="116"><div align="center">Satuan</div></th>
  	    <th width="133"><div align="center">Harga</div></th>
        <th width="125"><div align="center">Total</div></th>
        <th width="126"><div align="center">UserId</div></th>
        <th width="126"><div align="center">Note</div></th>
  	   </tr>
  </thead>
  <tbody>
    <?php

  foreach($barangout->show_detail($modal_id) as $r1){
  		$no1++;
  		$bgcolor1 = ($col1++ & 1) ? 'gainsboro' : 'antiquewhite';
  	  	?>
     <tr bgcolor="<?php echo $bgcolor1; ?>">
       <td align="center"><?php echo $no1; ?></td>
       <td align="center"><?php echo $r1['tanggal']; ?></td>
       <td align="center"><?php echo $r1['kode']; ?></td>
       <td align="center"><?php echo $r1['jenis']; ?></td>
       <td align="right"><?php echo $r1['jml']; ?></td>
       <td align="center"><?php echo $r1['satuan']; ?></td>
       <td align="right"><?php echo $r1['harga']; ?></td>
       <td align="right"><?php echo $r1['total_harga']; ?></td>
       <td align="center"><?php echo $r1['userid']; ?></td>
       <td align="center"><?php echo $r1['note']; ?></td>
       </tr>
     <?php
     $totalout=$totalout+$r1['jml'];
     $tothrgout=$tothrgout+$r1['total_harga'];
      } ?>
     </tbody>
     <tfoot class="bg-red">
        <tr>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td align="center"><strong>Total</strong></td>
           <td align="right"><strong><?php echo number_format($totalout,"2",".",""); ?></strong></td>
           <td align="center">&nbsp;</td>
           <td>&nbsp;</td>
           <td align="right"><strong><?php echo number_format($tothrgout,"2",".",""); ?></strong></td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
     	   </tr>
     </foot>
  </table>
  						</div>
  						<!-- /.tab-pane -->

  					</div>
  					<!-- /.tab-content -->
  				</div>
  				<!-- nav-tabs-custom -->

              </div>
                </div>
            </div>
        </div>
 <script type="text/javascript">
$(function (){
                $("#tbl3").dataTable();
            });
$(function (){
                $("#tbl4").dataTable();
            });
</script>
