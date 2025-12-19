<?php
//error_reporting(0);
session_start();

// instance objek
$barang = new Barang();
$barangin = new BarangMasuk();
$db = new Database();

// FIX: pastikan idsub ada
$idsub = $_SESSION['subQC'] ?? '';
?>

<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Barang</title>
</head>

<body>
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <a href="#" data-toggle="modal" data-target="#DataStock" class="btn btn-success">
            <i class="fa fa-plus-circle"></i> Add
          </a>
        </div>

        <div class="box-body">
          <table width="100%" id="example1" class="table table-bordered table-hover">
            <thead class="btn-success">
              <tr>
                <th width="2%">No</th>
                <th width="9%">Tgl</th>
                <th width="9%">Kode</th>
                <th width="27%">Nama</th>
                <th width="18%">Jenis</th>
                <th width="9%">Jumlah</th>
                <th width="9%">Satuan</th>
                <th width="9%">UserID</th>
                <th width="20%">Action</th>
              </tr>
            </thead>

            <tbody>
              <?php
              $col = 0;
              $no = 1;

              $dataIn = $barangin->tampil_data_in($idsub);

              if ($dataIn === false) {
                echo "<tr><td colspan='9'>";
                echo "<b>Error query tampil_data_in</b><br>";
                $err = $barangin->last_error ?? (function_exists('sqlsrv_errors') ? sqlsrv_errors() : []);
                echo "<pre>" . print_r($err, true) . "</pre>";
                echo "</td></tr>";
              } elseif (empty($dataIn)) {
                echo "<tr><td colspan='9' align='center'>Data kosong</td></tr>";
              } else {
                foreach ($dataIn as $rowd) {
                  $bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';

                  // FIX: tanggal dari sqlsrv bisa berupa DateTime object
                  $tgl = $rowd['tanggal'] ?? '';
                  if ($tgl instanceof DateTime) {
                    $tgl = $tgl->format('Y-m-d');
                  }
                  ?>
                  <tr bgcolor="<?php echo $bgcolor; ?>">
                    <td><?php echo $no; ?></td>
                    <td align="left"><?php echo $tgl; ?></td>
                    <td>
                      <a href="#" class="open_detailinout" id="<?php echo $rowd['idb']; ?>">
                        <?php echo $rowd['kode']; ?> <span class="label label-danger"></span>
                      </a>
                    </td>
                    <td align="left"><?php echo $rowd['nama']; ?></td>
                    <td align="center"><?php echo $rowd['jenis']; ?></td>
                    <td align="right"><?php echo $rowd['jumlah']; ?></td>
                    <td align="center"><?php echo $rowd['satuan']; ?></td>
                    <td align="center"><?php echo $rowd['userid']; ?></td>
                    <td align="center">
                      <div class="btn-group">
                        <a href="#"
                          class="btn btn-info btn-sm open_editstokin <?php if (($_SESSION['lvlQC'] ?? 0) == 3) {
                            echo "disabled";
                          } ?>"
                          id="<?php echo $rowd['id']; ?>">
                          <i class="fa fa-edit"></i>
                        </a>

                        <a href="#"
                          class="btn btn-danger btn-sm <?php if (($_SESSION['lvlQC'] ?? 0) == 3) {
                            echo "disabled";
                          } ?>"
                          onclick="confirm_delete1('./hapusstockin-<?php echo (int)$rowd['id']; ?>/');">
                          <i class="fa fa-trash"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                  <?php
                  $no++;
                }
              }
              ?>
            </tbody>
          </table>

          <div class="modal fade" id="DataStock">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post"
                  action="input-stock-in/" enctype="multipart/form-data">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Data Barang In</h4>
                  </div>

                  <div class="modal-body">
                    <input type="hidden" id="userid" name="userid" value="<?php echo $_SESSION['userQC'] ?? ''; ?>">
                    <input type="hidden" id="idsub" name="idsub" value="<?php echo $_SESSION['subQC'] ?? ''; ?>">

                    <div class="form-group">
                      <label for="kode" class="col-md-3 control-label">Kode</label>
                      <div class="col-md-8">
                        <select class="form-control select2" name="kode" style="width: 100%;">
                          <option value=""> </option>
                          <?php
                          $listBarang = $barang->tampil_databarang($idsub);
                          if (is_array($listBarang)) {
                            foreach ($listBarang as $rowd1) {
                              ?>
                              <option value="<?php echo $rowd1['id']; ?>">
                                <?php echo $rowd1['kode'] . " | " . $rowd1['nama']; ?>
                              </option>
                              <?php
                            }
                          }
                          ?>
                        </select>
                        <span class="help-block with-errors"></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="jumlah" class="col-md-3 control-label">Jumlah</label>
                      <div class="col-md-2">
                        <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="0.00"
                          step="0.01" min="0" lang="en">
                        <span class="help-block with-errors"></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="note" class="col-md-3 control-label">Note</label>
                      <div class="col-md-8">
                        <textarea name="note" rows="8" cols="80" class="form-control" id="note"></textarea>
                        <span class="help-block with-errors"></span>
                      </div>
                    </div>

                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Modal Popup untuk delete-->
          <div class="modal fade" id="modal_delete_barang" tabindex="-1">
            <div class="modal-dialog modal-sm">
              <div class="modal-content" style="margin-top:100px;">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
                </div>

                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                  <a href="#" class="btn btn-danger" id="delete_link1">Delete</a>
                  <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Popup untuk Edit-->
          <div id="StokInEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true"></div>
          <div id="DetailInOut" class="modal fade modal-3d-slit" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel" aria-hidden="true"></div>

        </div>
      </div>
    </div>
  </div>

  <!-- Javascript untuk popup modal Delete-->
  <script type="text/javascript">
    function confirm_delete1(delete_url) {
      $('#modal_delete_barang').modal('show', { backdrop: 'static' });
      document.getElementById('delete_link1').setAttribute('href', delete_url);
    }
  </script>

  <script type="text/javascript">
    function confirm_delete2(delete_url) {
      $('#modal_delete_barang1').modal('show', { backdrop: 'static' });
      document.getElementById('delete_link2').setAttribute('href', delete_url);
    }
  </script>
</body>

</html>