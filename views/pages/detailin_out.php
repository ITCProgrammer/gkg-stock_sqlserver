<?php
error_reporting(0);
session_start();

include_once '../../config/koneksi.php';
include_once '../../controllers/barangclass.php';
include_once '../../controllers/barangmasukclass.php';
include_once '../../controllers/barangkeluarclass.php';

// instance objek
$barang = new Barang();
$barangin = new BarangMasuk();
$barangout = new BarangKeluar();
$db = new Database();

// FIX: gunakan koneksi SQL Server (hapus koneksi MySQL)
$db->connectMySQLi();

$dbg = isset($_GET['dbg']) && $_GET['dbg'] == '1';

// FIX id (biar aman)
$raw_modal_id = $_GET['id'] ?? '';
$modal_id = (int)preg_replace('/\D+/', '', (string)$raw_modal_id);

if ($dbg) {
  echo "<pre style='background:#111;color:#0f0;padding:10px;border-radius:6px;'>";
  echo "=== DEBUG VIEW DETAIL IN-OUT ===\n";
  echo "raw GET[id]  : " . print_r($raw_modal_id, true) . "\n";
  echo "clean modal_id: " . $modal_id . "\n";
  echo "session subQC : " . print_r($_SESSION['subQC'] ?? '(null)', true) . "\n";
  echo "session lvlQC : " . print_r($_SESSION['lvlQC'] ?? '(null)', true) . "\n";
  echo "</pre>";
}

// FIX: bersihkan id dari GET (hindari "133/")
$modal_id = (int) preg_replace('/\D+/', '', $_GET['id'] ?? '');

// init counter
$no = 0;
$col = 0;
$totalin = 0;
$tothrgin = 0;
$no1 = 0;
$col1 = 0;
$totalout = 0;
$tothrgout = 0;
?>

<div class="modal-dialog modal-lg" style="width: 90%">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <h4 class="modal-title" id="myModalLabel">Detail In-Out</h4>
    </div>

    <div class="modal-body">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_1" data-toggle="tab">Barang In</a></li>
          <li><a href="#tab_2" data-toggle="tab">Barang Out</a></li>
        </ul>

        <div class="tab-content">
          <!-- TAB BARANG IN -->
          <div class="tab-pane active" id="tab_1">
            <table id="tbl3" class="table table-bordered table-hover display" width="100%">
              <thead class="bg-blue">
                <tr>
                  <th width="40">
                    <div align="center">No</div>
                  </th>
                  <th width="120">
                    <div align="center">Tanggal</div>
                  </th>
                  <th width="265">
                    <div align="center">Kode</div>
                  </th>
                  <th width="133">
                    <div align="center">Jenis</div>
                  </th>
                  <th width="115">
                    <div align="center">Jumlah</div>
                  </th>
                  <th width="116">
                    <div align="center">Satuan</div>
                  </th>
                  <th width="133">
                    <div align="center">Total Harga</div>
                  </th>
                  <th width="125">
                    <div align="center">Userid</div>
                  </th>
                  <th width="126">
                    <div align="center">Note</div>
                  </th>
                </tr>
              </thead>
              <tbody>
               <?php
                $dataIn = $barangin->show_detail_barang_masuk($modal_id);

                if ($dbg) {
                  echo "<pre style='background:#111;color:#0f0;padding:10px;border-radius:6px;'>";
                  echo "=== DEBUG TAB BARANG IN ===\n";
                  echo "rows: " . (is_array($dataIn) ? count($dataIn) : 0) . "\n";
                  if (is_array($dataIn) && count($dataIn) > 0) {
                    echo "first row keys:\n";
                    echo print_r(array_keys($dataIn[0]), true) . "\n";
                    echo "first row sample:\n";
                    echo print_r($dataIn[0], true) . "\n";
                    if (isset($dataIn[0]['tanggal'])) {
                      echo "tanggal type: " . gettype($dataIn[0]['tanggal']) . "\n";
                      if ($dataIn[0]['tanggal'] instanceof DateTime) {
                        echo "tanggal formatted: " . $dataIn[0]['tanggal']->format('Y-m-d H:i:s') . "\n";
                      }
                    }
                  }
                  echo "</pre>";
                }

                if (is_array($dataIn) && count($dataIn) > 0) {
                  foreach ($dataIn as $r) {
                    $no++;
                    $bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
                    $jml = $r['jml'] ?? '';
                    // FIX tanggal DateTime biar tampil
                    $tgl = $r['tanggal'] ?? '';
                    if ($tgl instanceof DateTime)
                      $tgl = $tgl->format('Y-m-d');
                    ?>
                    <tr bgcolor="<?php echo $bgcolor; ?>">
                      <td align="center"><?php echo $no; ?></td>
                      <td align="center"><?php echo $tgl; ?></td>
                      <td align="center"><?php echo $r['kode'] ?? ''; ?></td>
                      <td align="center"><?php echo $r['jenis'] ?? ''; ?></td>
                      <td align="right"><?php echo number_format($jml, 2, ".", ""); ?></td>
                      <td align="center"><?php echo $r['satuan'] ?? ''; ?></td>
                      <td align="right"><?php echo number_format($total, 2, ".", ""); ?></td>
                      <td align="center"><?php echo $r['userid'] ?? ''; ?></td>
                      <td align="left"><?php echo $r['note'] ?? ''; ?></td>
                    </tr>
                    <?php
                    $totalin += $jml;
                    $tothrgin += $total;

                    }
                  } else {
                    echo "<tr><td colspan='9' align='center'>Data Barang In kosong</td></tr>";
                  }
                  ?>
              </tbody>

              <tfoot class="bg-blue">
                <tr>
                  <td align="center">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                  <td align="center"><strong>Total</strong></td>
                  <td align="right"><strong><?php echo number_format($totalin, 2, ".", ""); ?></strong></td>
                  <td align="center">&nbsp;</td>
                  <td align="right"><strong><?php echo number_format($tothrgin, 2, ".", ""); ?></strong></td>
                  <td align="center">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                </tr>
              </tfoot>
            </table>
          </div>

          <!-- TAB BARANG OUT -->
          <div class="tab-pane" id="tab_2">
            <table id="tbl4" class="table table-bordered table-hover display" width="100%">
              <thead class="bg-red">
                <tr>
                  <th width="40">
                    <div align="center">No</div>
                  </th>
                  <th width="120">
                    <div align="center">Tanggal</div>
                  </th>
                  <th width="265">
                    <div align="center">Kode</div>
                  </th>
                  <th width="133">
                    <div align="center">Jenis</div>
                  </th>
                  <th width="115">
                    <div align="center">Jumlah</div>
                  </th>
                  <th width="116">
                    <div align="center">Satuan</div>
                  </th>
                  <th width="133">
                    <div align="center">Harga</div>
                  </th>
                  <th width="125">
                    <div align="center">Total</div>
                  </th>
                  <th width="126">
                    <div align="center">UserId</div>
                  </th>
                  <th width="126">
                    <div align="center">Note</div>
                  </th>
                </tr>
              </thead>

              <tbody>
               <?php
                $dataOut = $barangout->show_detail_barang_keluar($modal_id);

                if ($dbg) {
                  echo "<pre style='background:#111;color:#0f0;padding:10px;border-radius:6px;'>";
                  echo "=== DEBUG TAB BARANG OUT ===\n";
                  echo "rows: " . (is_array($dataOut) ? count($dataOut) : 0) . "\n";
                  if (is_array($dataOut) && count($dataOut) > 0) {
                    echo "first row keys:\n";
                    echo print_r(array_keys($dataOut[0]), true) . "\n";
                    echo "first row sample:\n";
                    echo print_r($dataOut[0], true) . "\n";
                    if (isset($dataOut[0]['tanggal'])) {
                      echo "tanggal type: " . gettype($dataOut[0]['tanggal']) . "\n";
                      if ($dataOut[0]['tanggal'] instanceof DateTime) {
                        echo "tanggal formatted: " . $dataOut[0]['tanggal']->format('Y-m-d H:i:s') . "\n";
                      }
                    }
                  }
                  echo "</pre>";
                }

                if (is_array($dataOut) && count($dataOut) > 0) {
                  foreach ($dataOut as $r1) {
                    $no1++;
                    $bgcolor1 = ($col1++ & 1) ? 'gainsboro' : 'antiquewhite';
                   $jml1 = $r1['jml_out'] ?? '';
                    // FIX tanggal DateTime
                    $tgl1 = $r1['tanggal'] ?? '';
                    if ($tgl1 instanceof DateTime)
                      $tgl1 = $tgl1->format('Y-m-d');

                    // FIX total_harga NULL -> 0.00
                    $totalHarga = $r1['total_harga'];
                    $totalHarga = ($totalHarga === null || $totalHarga === '') ? 0 : (float) $totalHarga;
                    ?>
                    <tr bgcolor="<?php echo $bgcolor1; ?>">
                      <td align="center"><?php echo $no1; ?></td>
                      <td align="center"><?php echo $tgl1; ?></td>
                      <td align="center"><?php echo $r1['kode'] ?? ''; ?></td>
                      <td align="center"><?php echo $r1['jenis'] ?? ''; ?></td>
                      <td align="right"><?php echo number_format($jml1, 2, ".", ""); ?></td>
                      <td align="center"><?php echo $r1['satuan'] ?? ''; ?></td>
                      <td align="right"><?php echo number_format($harga1, 2, ".", ""); ?></td>
                      <td align="right"><?php echo number_format($totalHarga, 2, ".", ""); ?></td>
                      <td align="center"><?php echo $r1['userid'] ?? ''; ?></td>
                      <td align="center"><?php echo $r1['note'] ?? ''; ?></td>
                    </tr>
                    <?php
                    $totalout += $jml1;
                    $tothrgout += $total1;
                  }
                } else {
                  echo "<tr><td colspan='10' align='center'>Data Barang Out kosong</td></tr>";
                }
                ?>
              </tbody>

              <tfoot class="bg-red">
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="center"><strong>Total</strong></td>
                  <td align="right"><strong><?php echo number_format($totalout, 2, ".", ""); ?></strong></td>
                  <td align="center">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="right"><strong><?php echo number_format($tothrgout, 2, ".", ""); ?></strong></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </tfoot>
            </table>
          </div>

        </div><!-- /.tab-content -->
      </div><!-- /.nav-tabs-custom -->
    </div><!-- /.modal-body -->
  </div>
</div>

<script type="text/javascript">
  $(function () {
    $("#tbl3").dataTable();
    $("#tbl4").dataTable();
  });
</script>