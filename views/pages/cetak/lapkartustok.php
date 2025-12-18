<?php 
include_once('../../../config/koneksi.php');
include_once('../../../controllers/kartustokClass.php');
$model = new Kartustok;


?>


<style>
.report  {
  border-collapse: collapse;
    width: 100%;
}
.report , .report th, .report td {
  border: 1px solid black;
  text-align: center;
  font-family:arial;
  font-size:12px;
  padding:2px
}

.report_right , .report_right th, .report_right td {
  border: 0px 
 
}

.report tr{
	line-height: 20px
} 


</style>

<?php







$id_barang = $_GET['kode'];
$tgl_awal = $_GET['awal'];
$tgl_akhir = $_GET['akhir'];

$barang = $model->barang($id_barang);

$in = $model->group_by('tbl_barang_in',$id_barang,$tgl_awal,$tgl_akhir);
$out = $model->group_by('tbl_barang_out',$id_barang,$tgl_awal,$tgl_akhir);

$stok_awal = $model->stok_awal($id_barang,$tgl_awal);
$result = array_merge($in, $out);
$y = array_fill_keys(array_keys($result), 1);
ksort($y);

$note = $model->note('tbl_barang_out',$id_barang,$tgl_awal,$tgl_akhir);



?>

<?php 
if (count($in) < 1 and count($out) < 1) {
    echo 'Not Found';
    exit;
} else if (1==1) { // validasi tanggal
    
}
?>
<table class="report">
    <tr>
        <td width=10%> <img src="../dist/img/itti.png" alt="Logo Indotaichen"> </td>
        <td width=60% ><b><div style="font-size:20px">KARTU STOCK</div></b></td>
        <td width=30%>
            <table class="report_right">
                <tr>
                    <td>No Form</td>
                    <td style="text-align:left">: 19-08</td>
                </tr>
                <tr>
                    <td>No Revisi</td>
                    <td style="text-align:left">: 01</td>
                </tr>
                <tr>
                    <td>Tgl Terbit</td>
                    <td style="text-align:left">: 27 Februari 2006</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br>
<table class="report report_right">
    <tr>
        <td width=50% ></td>
        <td width=50%  style="text-align:left">Nama Barang : <b><?php echo $barang['nama']; ?></b></td>
    </tr>
	<tr>
        <td width=50% ></td>
        <td width=50%  style="text-align:left">Type/ Ukuran : <?php if($barang['jenis']!='' and $barang['jenis']!='-') {
			echo $barang['jenis'];
		} ; ?> </td>
    </tr>
</table>
<br>

<table class="report">
    <thead>
    <tr>
        <th>NAMA SUPPLIER</th>
        <th>STOCK AWAL</th>
        <th width=15%>TANGGAL MASUK</th>
        <th>JUMLAH</th>
        <th width=15%>TANGGAL KELUAR</th>
        <th>JUMLAH</th>
        <th>STOCK AKHIR</th>
        <th>KETERANGAN</th>
        <th>TANDA TANGAN PEMAKAI</th>
    </tr>
    </thead>
    <tbody>
    <?php 
	
	$max_row = 28;
	$count_y = count($y);
	$ulang = 0;
	if ($count_y <= $max_row) {
		$ulang = $max_row - $count_y ; 
	} 
	$no = 1 ; foreach ($y as $key=>$data) { 
         
    ?>
    <tr>
        <td></td>
        <td><?php if ($no==1) {
                    $stok_awal = $stok_awal;
                 } else {
                    $stok_awal = $stock_akhir;
                 };
             echo $stok_awal;?>
        </td>
        <td><?php if (array_key_exists($key,$in))  { echo  date("j F Y", strtotime($key)); }?></td>
        <td><?php if (array_key_exists($key,$in))  { echo  $jumlah_masuk = $model->formater($in[$key]); } else { $jumlah_masuk = 0; }?></td>
        <td><?php if (array_key_exists($key,$out)) { echo  date("j F Y", strtotime($key)); }?></td>
        <td><?php if (array_key_exists($key,$out)) { echo  $jumlah_keluar =  $model->formater($out[$key]); } else { $jumlah_keluar = 0;}?></td>
        <td><?php echo $stock_akhir =  ($stok_awal+$jumlah_masuk) -   $jumlah_keluar;  ?></td>
        <td></td>
        <td><?php if (array_key_exists($key,$note)) { 
					$no_ttd = 1;
					foreach ($note[$key] as $ttd) {
						
						if ($no_ttd >=2) {
							echo ', '.$ttd;
						} else {
							echo $ttd;
						}
					$no_ttd++;
					}
		
		} ?></td>
    </tr>
    <?php $no++; } ?>
	<?php for ($x = 1; $x <= $ulang; $x++) { ?>
		<tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
	<?php }?>
    </tbody>
</table>