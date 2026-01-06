<?php include_once('controllers/bsController.php');
session_start();
// Generate CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<?php

if ( isset($_POST['barang'])) {
	$sesi_sj = $_SESSION['sesi_detail_suratjalan'] = $_POST['barang'];
} else {
	if (isset($_SESSION['sesi_detail_suratjalan'])) {
		$sesi_sj = $_SESSION['sesi_detail_suratjalan'];
	} else {
		//echo 'Silahkan pilih barang terlebih dahulu';
		$sesi_sj = false;
	}
}

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
<div class="box-header" style="font-weight:bold"><?php if ($sesi_sj == false) {echo 'Last Transaction Out';} else {
	echo '<button id="goBack">Go Back</button>';
	}?></div>
<div class="box-body">
		
		<?php if ($sesi_sj == false) {?>
		<table width="100%"  class="table table-bordered table-hover">
		<thead class="btn-primary">
			<tr>
				<th>No </th>
				<th>Nama</th>
				<th>Jenis Kain</th>
				<th>Qty Keluar</th>
				<th>Qty Sisa</th>
			</tr>
			</thead>
		<tbody>
			<form action="bs-out-preview" method="post"  class="decimalForm" >
			<?php $no = 1; foreach($model->bs_out_last_detail() as $data) { ?>
			<tr>
				<td><?=$no++?></td>
				<td><?=$data['nama']?></td>
				<td><?=$data['jenis_kain']?></td>
				<td><b><?=$data['qty_keluar_detail']?></b></td>
				<td><?=$data['qty_sisa']?></td>
			</tr>
			<?php } ?>
			</tbody>
		</table>
		
		<?php } else { ?>
		
		
		
		<form action="bs-out-preview" method="post">
		<table width="100%"  class="table table-bordered table-hover">
		<thead class="btn-primary">
			<tr>
				<th>No </th>
				<th>Id Surat Jalan</th>
				<th>Tanggal Masuk</th>
				<th>Barang</th>
				<th>Jenis</th>
				<th>Lokasi Masuk</th>
				<th>Qty Masuk</th>
				<th>Qty Sisa</th>
				<th>Qty Keluar</th>
			</tr>
			</thead>
		<tbody>
			<form action="bs-out-preview" method="post"  class="decimalForm" >
			 <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    
			<?php $no = 1; foreach($model->bs_out_preview($sesi_sj) as $data) { ?>
			<tr>
				<td><?=$no++?></td>
				<td><?=str_pad($data['surat_jalan_id'], 6, '0', STR_PAD_LEFT)?></td>
				<td>
					<?php
					$tgl = formatDateTime($data['tanggal'], 'Y-m-d H:i:s');
					echo $tgl;
					?>
				
				</td>
				<td><?=$data['nama']?></td>
				<td><?=$data['jenis_kain']?></td>
				<td><?=$data['lokasi_masuk']?></td>
				<td><?=$data['qty_masuk']?></td>
				<td><?=$data['qty_sisa']?></td>
				<td>
				 <input  placeholder="Max <?=$data['qty_sisa']?>" required  class="numeric-input" data-max="<?=$data['qty_sisa']?>" type="text" name="qty_keluar[<?=$data['id']?>/<?=$data['qty_sisa']?>]/<?=$data['qty_keluar']?>]" value="<?=$data['qty_sisa']?>" readonly="readonly">
				 <span class="error-message"></span>
				 
				</td>
			</tr>
			<?php } ?>
			</tbody>
		</table>
		
		<input type="submit" value="save" name="save_out"  class="btn btn-primary" onclick="return confirmBeforeSubmit()">
		</form>
		<?php } ?>

</div>
</div>
</div>
</div>



 <script>
        function confirmBeforeSubmit() {
            // Show a confirmation dialog before submitting the form
            var confirmed = confirm('Apakah kamu yakin ingin disimpan , silahkan cek terlebih dahulu qty keluar. Jika Yakin klik OK');

            // Return true if the user clicks "OK" (confirm), and false otherwise
            return confirmed;
        }
    </script>



<script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get all elements with the specified class
            var numericInputs = document.querySelectorAll('.numeric-input');

            // Function to validate the input
            function validateInput(input) {
                // Get the input value
                var inputValue = input.value.trim();

                // Get the maximum value from the data-max attribute
                var max = parseFloat(input.dataset.max);

                // Validate if the input is a number or a decimal
                if (/^\d*\.?\d*$/.test(inputValue)) {
                    // Check if the value is greater than 0 and less than or equal to the maximum
                    var numericValue = parseFloat(inputValue);
                    if (numericValue > 0 && numericValue <= max) {
                        // Replace commas with dots for decimals
                        inputValue = inputValue.replace(',', '.');

                        // Update the input value
                        input.value = inputValue;
                    } else {
                        // If the value is not within the allowed range, reset the input value
                        input.value = '';
                        alert('Please enter a number between 0 and ' + max + '.');
                    }
                } else {
                    // If the input is not a number or decimal, reset the input value
                    input.value = '';
                    alert('Please enter a valid number or decimal using dot (.)');
                }
            }

            // Attach an event listener to each input field
            numericInputs.forEach(function (input) {
                var timeout;

                input.addEventListener('input', function () {
                    // Clear previous timeout
                    clearTimeout(timeout);

                    // Set a new timeout
                    timeout = setTimeout(function () {
                        // Validate the input after the delay
                        validateInput(input);
                    }, 1000);
                });
            });
        });
</script>

<script>
        // Add event listener for the popstate event
        window.addEventListener('popstate', function(event) {
            // This code will be executed when the user navigates through the history
            alert('Navigated through history!');
            console.log(event);
        });

        // Add event listener for a button click to simulate navigating
        document.getElementById('goBack').addEventListener('click', function() {
            // Simulate navigating back in history
            history.back();
        });
    </script>
	


