<?php
error_reporting(0);
session_start();

$barang = new Barang();
$barangin = new BarangMasuk();
$db = new Database();

$db->connectMySQLi();

$idsub = $_SESSION['subQC'] ?? '';
?>

<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>lapsok-in</title>
</head>

<body>
  <?php
  $Awal = isset($_POST['awal']) ? $_POST['awal'] : '';
  $Akhir = isset($_POST['akhir']) ? $_POST['akhir'] : '';
  $Kode = isset($_POST['kode']) ? $_POST['kode'] : '';

  // init variabel
  $cek = 0;
  if ($Awal != '' && $Akhir != '' && $idsub != '') {
    $cek = $barangin->cektgl($Awal, $Akhir, $idsub);
  }
  ?>

  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Filter Detail Barang Masuk</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse">
          <i class="fa fa-minus"></i>
        </button>
      </div>
    </div>

    <form method="post" enctype="multipart/form-data" name="form1" class="form-horizontal" id="form1">
      <div class="box-body">
        <div class="form-group">
          <div class="col-sm-3">
            <div class="input-group date">
              <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
              <input name="awal" type="date" class="form-control pull-right" id="awal" placeholder="Tanggal Awal"
                value="<?php echo $Awal; ?>" autocomplete="off" />
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-3">
            <div class="input-group date">
              <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
              <input name="akhir" type="date" class="form-control pull-right" id="akhir"
                placeholder="Tanggal Akhir" value="<?php echo $Akhir; ?>" autocomplete="off" />
            </div>
          </div>

          <button type="submit" class="btn btn-info">Search</button>
        </div>

        <div class="col-sm-2"></div>
      </div>

      <div class="box-footer"></div>
    </form>
  </div>

  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Details Data</h3>

      <?php if ($cek > 0) { ?>
        <a href="cetak/lapstokin/<?php echo $Awal; ?>/<?php echo $Akhir; ?>/<?php echo $_SESSION['subQC']; ?>"
          class="btn btn-danger pull-right" target="_blank">Cetak</a>
      <?php } ?>
    </div>

    <div class="box-body">
      <table id="example2" class="table table-bordered table-hover display nowrap" width="100%">
        <thead class="btn-success">
          <tr>
            <th width="31">No</th>
            <th width="160">Tanggal</th>
            <th width="160">Kode</th>
            <th width="216">Nama</th>
            <th width="220">Jenis</th>
            <th width="269">Jumlah</th>
            <th width="169">Satuan</th>
            <th width="169">Harga</th>
            <th width="169">Note</th>
            <th width="169">UserID</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $no = 1;
          $col = 0;

          // jangan query kalau tanggal belum diisi
          if ($Awal != '' && $Akhir != '' && $idsub != '') {
            $rows = $barangin->tampildatain_tgl($Awal, $Akhir, $idsub);

            if (!is_array($rows) || count($rows) == 0) {
              echo "<tr><td colspan='10' align='center'>Data kosong</td></tr>";
            } else {
              foreach ($rows as $row) {
                $bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';

                $tgl = $row['tanggal'] ?? '';
                if ($tgl instanceof DateTime) {
                  $tgl = $tgl->format('Y-m-d');
                }
                ?>
                <tr bgcolor="<?php echo $bgcolor; ?>">
                  <td align="center"><?php echo $no; ?></td>
                  <td align="center"><?php echo $tgl; ?></td>
                  <td align="center"><?php echo $row['kode'] ?? ''; ?></td>
                  <td align="left"><?php echo $row['nama'] ?? ''; ?></td>
                  <td align="center"><?php echo $row['jenis'] ?? ''; ?></td>
                  <td align="right"><?php echo $row['jumlah'] ?? 0; ?></td>
                  <td align="center"><?php echo $row['satuan'] ?? ''; ?></td>
                  <td align="right"><?php echo $row['harga'] ?? 0; ?></td>
                  <td align="left"><?php echo $row['note'] ?? ''; ?></td>
                  <td align="center"><?php echo $row['userid'] ?? ''; ?></td>
                </tr>
                <?php
                $no++;
              }
            }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

</body>

</html>