<?php
include_once '../../../config/koneksi.php';
include_once '../../../controllers/permohonanclass.php';

$permohonan = new Permohonan();
$db = new Database();
$idsub=$_GET['idsub'];
$id=$_GET['id'];

//$sql=mysql_query("SELECT *, date_format(tgl_mohon, '%d %M %Y') as tglmohon FROM tbl_permohonan WHERE id='$_GET[id]'");
//$d=mysql_fetch_array($sql);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Form BPP</title>
<link href="./styles_cetak.css" rel="stylesheet" type="text/css">	
<style>
du
{
    text-decoration-line: underline;
    text-decoration-style: double;
}

input{
text-align:center;
border:hidden;
}
.table-list2 {
	clear: both;
	text-align: left;
	border-collapse: collapse;
	margin: 0px 0px 10px 0px;
	background:#fff;	
}
.table-list2 td {
	color: #333;
	font-size:7px;
	border-color: #fff;
	border-collapse: collapse;
	vertical-align: center;
	padding: 1px 3px;
	border-bottom:1px #000000 solid;
	border-top:1px #000000 solid;
	border-left:1px #000000 solid;
	border-right:1px #000000 solid;

	
}

.noborder{
	color: #333;
	font-size:12px;
	border-color: #FFF;
	border-collapse: collapse;
	vertical-align: center;
	padding: 3px 5px;
	
	}
#nocetak {
	display:none;
	}

</style>
</head>

<body>
<?php foreach($permohonan->tampil_permohonan($id) as $rowd){ ?>	
<table style="width:7.8in;">
  <tbody>
    <tr>
      <td width="610">&nbsp;</td>
      <td width="127"><table width="100%">
        <tbody>
          <tr>
            <td width="39%">No. Form</td>
            <td width="61%">: 18-01</td>
          </tr>
          <tr>
            <td>No. Revisi</td>
            <td>: 02</td>
          </tr>
          <tr>
            <td>Tgl. Terbit</td>
            <td>: 18 Agustus 2010</td>
          </tr>
        </tbody>
      </table></td>
    </tr>
  </tbody>
</table>
<table style="width:7.8in;">
  <tbody>
    <tr>
      <td width="75%"><font size="-1"><u>PT. INDO TAICHEN TEXTILE INDUSTRY</u></font></td>
      <td width="7%" height="34">&nbsp;</td>
      <td width="18%" rowspan="3"><table width="100%" border="0" class="table-list2">
        <tbody>
          <tr>
            <td colspan="2" align="center">JENIS PERMOHONAN</td>
            </tr>
          <tr>
            <td width="25%">&nbsp;</td>
            <td width="75%"> OBAT DYEING</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>BAHAN BAKU</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>ALAT ELEKTRONIK</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>ALAT KANTOR</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>ALAT PRODUKSI</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>KALIBRASI</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>LAIN-LAIN</td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td align="right"><font size="+1">
        <du><strong>BON PERMOHONAN PEMBELIAN</strong></du>
      </font></td>
      <td height="44" align="right"><font size="+1">
      <du></du></font></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" class="table-list1">
        <tbody>
          <tr style="height:0.25in;">
            <td width="42%">TGL. PERMINTAAN BARANG DATANG :</td>
            <td width="24%">&nbsp;</td>
            <td width="34%" style="border-bottom:0px #000000 solid;
	border-top:0px #000000 solid;
	border-left:0px #000000 solid;
	border-right:0px #000000 solid;">&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
	
<table width="100%" border="0" class="table-list1" style="width:7.8in;">
  <tbody>
    <tr style="height:0.25in;">
      <td colspan="2">BAGIAN DARI PEMOHON</td>
      <td colspan="2"><?php if($rowd['dept']!=""){ echo $rowd['dept']." (".$rowd['sub_dept'].")";}?></td>
      <td width="18%" align="center" valign="middle">Tgl. PERMOHONAN</td>
      <td colspan="2"><?php echo $rowd['tglmohon'];?></td>
    </tr>
    <tr style="height:0.25in;">
      <td colspan="2">NAMA SUPPLIER</td>
      <td colspan="2">&nbsp;</td>
      <td align="center" valign="middle">Pembayaran:</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr align="center" valign="middle">
      <td width="3%">NO.</td>
      <td colspan="2">NAMA BARANG</td>
      <td width="16%">JUMLAH</td>
      <td>HARGA<br>
      SATUAN</td>
      <td width="19%">TOTAL HARGA</td>
      <td width="11%">STOCK</td>
    </tr>
	<?php 
	  $no=1;
	  foreach($permohonan->tampil_permohonan_detail($id) as $row){
	?>	  
    <tr style="height:0.25in;">
      <td align="center" valign="top"><?php echo $no; ?></td>
      <td colspan="2" align="left" valign="top"><?php echo $row['nama'];?></td>
      <td align="center" valign="top"><?php echo $row['jumlah']." ".$row['satuan'];?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center" valign="middle"><?php echo $row['stok']." ".$row['satuan'];?></td>
    </tr>
	  <?php $no++;} ?>
	  <?php for($i=1;$i<=8-$no;$i++){?>
    <tr style="height:0.25in;">
      <td align="center">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	  <?php } ?>    
  </tbody>
</table>
<table width="100%" border="0" class="table-list1" style="width:7.8in;">
  <tbody>
    <tr align="center">
      <td width="34%">CATATAN</td>
      <td width="16%">DISETUJUI</td>
      <td width="13%">KEPALA<br>
      PEMBELIAN</td>
      <td width="12%">DIREKTUR<br>
      TERKAIT        <br></td>
      <td width="13%">KEPALA<br>
      DEPARTEMEN</td>
      <td width="12%">PEMOHON</td>
    </tr>
    <tr style="height:0.7in;">
      <td align="left" valign="top"><?php echo $rowd['note'];?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
<table width="100%" style="width:7.8in;">
  <tbody>
    <tr>
      <td>Putih : Untuk Pembayaran</td>
      <td align="center">Kuning : Untuk Arsip Pembelian</td>
      <td align="right">Merah : Untuk Departemen Pemohon</td>
    </tr>
  </tbody>
</table>
<?php } ?>
</body>
</html>
