<?php 
include_once('controllers/bsController.php');
include ('../../helpers.php');
?>

<?php
function fmtDate($v) {
  if ($v instanceof DateTime) return $v->format('Y-m-d H:i:s');
  return (string)$v;
}
?>

<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <?php if (($_SESSION['lvlQC'] ?? 0) == 2) { ?>
          <a href="bs-out" class="btn btn-success"><i class="fa fa-plus-circle"></i> Out</a>
        <?php } ?>
      </div>

      <div class="box-body">
        <table width="100%" id="example1" class="table table-bordered table-hover">
          <thead class="btn-primary">
            <tr>
              <th>No</th>
              <th>Id Surat Jalan</th>
              <th>Tanggal</th>
              <th>Qty Keluar</th>
              <th style="text-align:center">Action</th>
            </tr>
          </thead>

          <tbody>
          <?php
          $no = 1;
          $rows = $model->bs_suratjalan_out();

          if (!is_array($rows) || count($rows) == 0) {
            echo "<tr><td colspan='5' align='center'>Data kosong</td></tr>";
          } else {
            foreach ($rows as $data) {
              // print_r(formatDateTime($data['tanggal'],'Y-m-d H:i:s'));
              $id = (int)($data['id'] ?? 0);
              $tgl = fmtDate($data['tanggal'] ?? '');
              $qty = number_format((float) ($data['qty_keluar_detail'] ?? 0), 2, '.', '');
          ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= str_pad($id, 6, '0', STR_PAD_LEFT) ?></td>
              <td><?= $tgl ?></td>
              <td><?= $qty ?></td>
              <td style="text-align:center">
                <a target="blank" href="views/pages/cetak/bs-cetak-out.php?id=<?= $id ?>">Detail</a>
                &nbsp;|&nbsp;
                <a target="blank" href="views/pages/cetak/bs-cetak-out.php?id=<?= $id ?>&action=delete">Delete</a>
              </td>
            </tr>
          <?php
            }
          }
          ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>


