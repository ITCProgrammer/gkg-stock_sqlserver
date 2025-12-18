<?php
error_reporting(0);
session_start();
include_once '../../config/koneksi.php';
include_once '../../controllers/permohonanclass.php';

// instance objek db dan user
$permohonan = new Permohonan();
$db = new Database();

// koneksi ke MySQL via method
$db->connectMySQLi();
$modal_id=$_GET['id'];
?>
          <div class="modal-dialog modal-lg" style="width: 90%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Detail Bon Permohonan </h4><br>
						<a href="views/pages/cetak/bpp-html.php?idsub=<?php echo $_SESSION['subQC']; ?>&id=<?php echo $modal_id; ?>" class="btn btn-danger pull-right" target="_blank">Cetak</a><br>
                    </div>
              <div class="modal-body">			  	  
  				<table id="tbl3" class="table table-bordered table-hover display" width="100%">
  <thead class="bg-blue">
     <tr>
        <th width="40"><div align="center">No</div></th>
        <th width="265"><div align="center">Kode</div></th>
        <th width="133"><div align="center">Nama</div></th>
  	   <th width="115"><div align="center">Jumlah</div></th>
        <th width="116"><div align="center">Satuan</div></th>
  	   <th width="125"><div align="center">Stock</div></th>
        </tr>
  </thead>
  <tbody>
    <?php
  foreach($permohonan->show_detail($modal_id) as $r){
  		$no++;
  		$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
  	  	?>
       <tr bgcolor="<?php echo $bgcolor; ?>">
       <td align="center"><?php echo $no; ?></td>
       <td align="center"><?php echo $r['kode']; ?></td>
       <td align="center"><?php echo $r['nama']; ?></td>
       <td align="right"><?php echo $r['jml_mohon']; ?></td>
       <td align="center"><?php echo $r['satuan']; ?></td>
       <td align="center"><?php echo $r['jumlah']; ?></td>
       </tr>
     <?php
     $totalin=$totalin+$r['jml_mohon'];
   } ?>
     </tbody>
     <tfoot class="bg-blue">
       <tr>
       <td align="center">&nbsp;</td>
       <td align="center">&nbsp;</td>
       <td align="center"><strong>Total</strong></td>
       <td align="right"><strong><?php echo number_format($totalin,"2",".",""); ?></strong></td>
       <td align="center">&nbsp;</td>
       <td align="center">&nbsp;</td>
       </tr>
     </tfoot>
  </table>

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
