<?php
include_once('../../../config/koneksi.php');
include_once('../../../models/bsModel.php');

$model  = new Bs();
$action = isset($_GET['action']) ? $_GET['action'] : null;

$id = (int)preg_replace('/\D+/', '', $_GET['id'] ?? '0');

// helper tanggal 
function fmtDate($v) {
  if ($v instanceof DateTime) return $v->format('Y-m-d H:i:s');
  return (string)$v;
}

if (isset($_POST['update'])) {
  if (isset($_POST['qty_masuk']) && is_array($_POST['qty_masuk'])) {
    foreach ($_POST['qty_masuk'] as $key => $data_update) {
      $key = (int)preg_replace('/\D+/', '', (string)$key);
      $val = str_replace(',', '.', (string)$data_update);
      if ($key > 0 && is_numeric($val)) {
        $model->bs_update_in($key, $val);
      }
    }
  }
  header("Location: bs-cetak-in.php?id={$id}");
  exit;
}

if (isset($_POST['post_delete'])) {
  $del = (int)preg_replace('/\D+/', '', $_POST['delete_name'] ?? '0');
  if ($del > 0) {
    $model->bs_delete_in($del);
  }
  header("Location: bs-cetak-in.php?id={$id}&action=delete");
  exit;
}
?>

<style>
body, table {
  font-family: arial;
  font-size: 12px;
  color:#000
}
.table-report {
  border-collapse: collapse;
  width: 100%;
}
.table-report td, .table-report th {
  border: thin solid #414a4c;
  padding: 1px;
  text-align:center
}
</style>

<?php if ($action == 'edit') { ?>
<form action="" method="post">
<?php } ?>

<table width="100%" class="table-report">
  <thead>
    <tr>
      <th>No</th>
      <th>Id Surat Jalan</th>
      <th>Tanggal Masuk</th>
      <th>Barang</th>
      <th>Jenis Kain</th>
      <th>Lokasi Masuk</th>
      <th>Qty Masuk</th>

      <?php if ($action == 'edit') { ?>
        <th width="5px">Edit</th>
      <?php } ?>

      <?php if ($action == 'delete') { ?>
        <th></th>
      <?php } ?>

      <th>Qty Keluar</th>
      <th>Qty Sisa</th>
    </tr>
  </thead>

  <tbody>
    <?php
    $no = 1;
    $sum_qty_masuk = 0;
    $sum_qty_keluar = 0;
    $sum_qty_sisa = 0;

    $rows = $model->bs_in_detail($id);

    if (!is_array($rows) || count($rows) == 0) {
      echo "<tr><td colspan='11'>Data kosong</td></tr>";
    } else {
      foreach ($rows as $data) {
        $tgl = fmtDate($data['tanggal'] ?? '');

        $qty_masuk = number_format((float) ($data['qty_masuk'] ?? 0), 2, '.', '');
        $qty_keluar = number_format((float) ($data['qty_keluar'] ?? 0), 2, '.', '');
        $qty_sisa = number_format((float) ($data['qty_sisa'] ?? 0), 2, '.', '');

        $sum_qty_masuk += $qty_masuk;
        $sum_qty_keluar += $qty_keluar;
        $sum_qty_sisa += $qty_sisa;
    ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= str_pad((int)($data['surat_jalan_id'] ?? 0), 6, '0', STR_PAD_LEFT) ?></td>
        <td><?= $tgl ?></td>
        <td><?= $data['nama'] ?? '' ?></td>
        <td><?= $data['jenis_kain'] ?? '' ?></td>
        <td><?= $data['lokasi_masuk'] ?? '' ?></td>

        <td><?= $qty_masuk ?></td>

        <?php if ($action == 'edit') { ?>
          <td>
            <input type="text"
                   name="qty_masuk[<?= (int)($data['id'] ?? 0) ?>]"
                   value="<?= $qty_masuk ?>"
                   style="width:70px;"
                   required
                   pattern="^[1-9]\d*(\.\d+)?$"
                   title="Enter a valid number or decimal greater than zero using dot (.)">
          </td>
        <?php } ?>

        <?php if ($action == 'delete') { ?>
          <td>
            <form action="" method="post" style="margin:0;">
              <input type="hidden" name="delete_name" value="<?= (int)($data['id'] ?? 0) ?>">
              <input type="submit" value="Delete" name="post_delete"
                     style="background:none;border:none;color:red;text-decoration:underline;cursor:pointer;padding:0;font-size:inherit;">
            </form>
          </td>
        <?php } ?>

        <td><?= $qty_keluar ?></td>
        <td><?= $qty_sisa ?></td>
      </tr>
    <?php
      }
    }
    ?>

    <tr>
      <td colspan="6"></td>
      <td><?= number_format($sum_qty_masuk, 2, '.', '') ?></td>

      <?php if ($action == 'edit') { ?>
        <td>
          <input type="submit" value="update" name="update"
                 style="background-color:#4CAF50;color:white;padding:3px 6px;border:none;border-radius:4px;cursor:pointer;font-size:12px;">
        </td>
      <?php } ?>

      <?php if ($action == 'delete') { ?>
        <td></td>
      <?php } ?>
        <td><?= number_format($sum_qty_keluar, 2, '.', '') ?></td>
        <td><?= number_format($sum_qty_sisa, 2, '.', '') ?></td>
    </tr>
  </tbody>
</table>

<?php if ($action == 'edit') { ?>
</form>
<?php } ?>
