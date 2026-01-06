<?php 
include_once('controllers/bsController.php');
include_once('../helpers.php');
function formatDateTime($date, $format = "Y-m-d H:i:s")
{
    if (empty($date)) {
        return '';
    }

    if ($date instanceof DateTime) {
        return $date->format($format);
    }

    try {
        return (new DateTime($date))->format($format);
    } catch (Exception $e) {
        return '';
    }

}
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header"></div>
            <div class="box-body">

                <form action="bs-out-preview" method="post">
                    <table width="100%" class="table table-bordered table-hover"  id="example1">
                        <thead class="btn-primary">
                            <tr>
                                <th></th>
                                <th>Id Surat Jalan</th>
                                <th>Tanggal Masuk</th>
                                <th>Barang</th>
                                <th>Jenis Kain</th>
                                <th>PO</th>
                                <th>Keterangan</th>
                                <th>Qty Masuk</th>
                                <th>Qty Sisa</th>
                                <th>Lokasi Masuk</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
// print_r($model->bs_out());/
                            $no = 1;
                            $array = [];
                            foreach ($model->bs_out() as $data) {
                                if ($data['qty_sisa'] > 0) {

                                    $array[] = 1;
                                        ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="barang[]" value="<?= $data['id'] ?>">
                                        </td>
                                        <td><?= str_pad($data['surat_jalan_id'], 6, '0', STR_PAD_LEFT) ?></td>
                                        <td><?php
                                        // print_r($data['tanggal']);
                                            $tgl = formatDateTime($data['tanggal'], 'Y-m-d H:i:s');
                                            echo $tgl;
                                            ?></td>
                                        <td><?= $data['nama'] ?></td>
                                        <td><?= $data['jenis_kain'] ?></td>
                                        <td><?= $data['demand'] ?></td>
                                        <td><?= $data['mc'] ?></td>
                                        <td><?= $data['qty_masuk'] ?></td>
                                        <td><?= $data['qty_sisa'] ?></td>
                                        <td>
                                            <a data-pk="<?php echo $data['id']; ?>"
                                                data-value="<?php echo $data['lokasi_masuk']; ?>"
                                                class="ubah_lokasi" href="javascript:void(0)">
                                                <?php echo $data['lokasi_masuk']; ?>
                                            </a>
                                        </td>

                                    </tr>
                                <?php }
                            } ?>
                        </tbody>
                    </table>

                    <br>
                    <?php if (count($array) < 1) {
                        $disabled = 'disabled';
                    } else {
                        $disabled = '';

                    } ?>
                    <input <?= $disabled ?> type="submit" value="preview" name="preview" class="btn btn-primary"
                        onclick="return validateCheckbox()">
                </form>


            </div>
        </div>
    </div>
</div>

<script>
    function checkAll(source) {
        var checkboxes = document.getElementsByName('barang[]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = source.checked;
        }
    }
</script>

<script>
    function validateCheckbox() {
        // Get all checkboxes with the name "barang[]"
        var checkboxes = document.querySelectorAll('input[name="barang[]"]');

        // Check if at least one checkbox is checked
        var atLeastOneChecked = Array.from(checkboxes).some(function (checkbox) {
            return checkbox.checked;
        });

        // Display an alert if no checkbox is checked
        if (!atLeastOneChecked) {
            alert('Please select at least one checkbox.');
            return false; // Prevent form submission
        }

        // Continue with form submission if at least one checkbox is checked
        return true;
    }
</script>

<?php
if (isset($_POST['preview'])) {
    $_SESSION['sesi_detail_suratjalan'] = $_POST['barang'];
    echo '<pre>';

    print_r($_SESSION['sesi_detail_suratjalan']);
    echo '</pre>';
}

?>